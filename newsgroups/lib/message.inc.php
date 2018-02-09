<?php
/*
 *  NewsPortal: Functions for handling single messages
 *
 *  Copyright (C) 2002-2004 Florian Amrhein
 *  E-Mail: newsportal@florian-amrhein.de
 *  Web: http://florian-amrhein.de
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

function message_parse($rawmessage) {
  global $attachment_delete_alternative,$attachment_uudecode,$www_charset;
  global $iconv_enable;
  // Read the header of the message:
  $count_rawmessage=count($rawmessage);
  $message = new messageType;
  $rawheader=array();
  $i=0;
  while ($rawmessage[$i] != "") {
    $rawheader[]=$rawmessage[$i];
    $i++;
  }
  // Parse the Header:
  $message->header=parse_header($rawheader);
  // Now we know if the message is a mime-multipart message:
  $content_type=explode("/",$message->header->content_type[0]);
  if ($content_type[0]=="multipart") {
    $message->header->content_type=array();
    // We have multible bodies, so we explode the message into its parts
    $boundary="--".$message->header->content_type_boundary;
    // lets find the first part
    while($rawmessage[$i] != $boundary)
      $i++;
    $i++;
    $part=array();
    while($i<=$count_rawmessage) {
      if (($rawmessage[$i]==$boundary) || ($i==$count_rawmessage-1) ||
          ($rawmessage[$i]==$boundary.'--')) {
        $partmessage=message_parse($part);
        // merge the content-types of the message with those of the part
        for ($o=0; $o<count($partmessage->header->content_type); $o++) {
          $message->header->content_type[]=
            $partmessage->header->content_type[$o];
          $message->header->content_type_charset[]=
            $partmessage->header->content_type_charset[$o];
          $message->header->content_type_name[]=
            $partmessage->header->content_type_name[$o];
          $message->header->content_type_format[]=
            $partmessage->header->content_type_format[$o];
          $message->body[]=$partmessage->body[$o];
        }
        $part=array();
      } else {
        if ($i<$count_rawmessage)
          $part[]=$rawmessage[$i];
      }
      if ($rawmessage[$i]==$boundary.'--') break;
      $i++;
    }
    // Is this a multipart/alternative multipart-message? Do we have to
    // delete all non plain/text parts?
    if (($attachment_delete_alternative) &&
        ($content_type[1]=="alternative")) {
      $plaintext=false;
      for ($o=0; $o<count($message->header->content_type); $o++) {
        if ($message->header->content_type[$o]=="text/plain")
          $plaintext=true; // we found at least one text/plain
      }
      if ($plaintext) {    // now we can delete the other parts
        for ($o=0; $o<count($message->header->content_type); $o++) {
          if ($message->header->content_type[$o]!="text/plain") {
            unset($message->header->content_type[$o]);
            unset($message->header->content_type_name[$o]);
            unset($message->header->content_type_charset[$o]);
            unset($message->header->content_type_format[$o]);
            unset($message->body[$o]);
          }
        }
      }
    }
  } else {
    // No mime-attachments in the message:
    $body="";
    $uueatt=0; // as default we have no uuencoded attachments
    for($i++;$i<$count_rawmessage; $i++) {
      // do we have an inlay uuencoded file?
      if ((strtolower(substr($rawmessage[$i],0,5))!="begin") ||
          ($attachment_uudecode==false)) {
        $body.=$rawmessage[$i]."\n";
      // yes, it seems, we have!
      } else {
        $old_i=$i;
        $uue_infoline_raw=$rawmessage[$i];
        $uue_infoline=explode(" ",$uue_infoline_raw);
        $uue_data="";
        $i++;
        while($rawmessage[$i]!="end") {
          if (strlen(trim($rawmessage[$i])) > 2)
            $uue_data.=$rawmessage[$i]."\n";
          $i++;
        }
        // now write the data in an attachment
        $uueatt++;
        $message->body[$uueatt]=uudecode($uue_data);
        $message->header->content_type_name[$uueatt]="";
        for ($o=2; $o<count($uue_infoline); $o++)
          $message->header->content_type_name[$uueatt].=$uue_infoline[$o];
        $message->header->content_type[$uueatt]=
          get_mimetype_by_filename($message->header->content_type_name[$uueatt]);
      }
    }
    //if ($message->header->content_type[0]=="text/plain") {
    $body=decode_body($body,$message->header->content_transfer_encoding);
    $body=recode_charset($body,
                         $message->header->content_type_charset[0],
                         $www_charset);
    if ($body=="") $body=" ";
    //}
    $message->body[0]=$body;
  }
    if (!isset($message->header->content_type_charset))
      $message->header->content_type_charset=array($www_charset);
    if (!isset($message->header->content_type_name))
      $message->header->content_type_name=array("unnamed");
    if (!isset($message->header->content_type_format))
      $message->header->content_type_format=array("fixed");
  for ($o=0; $o<count($message->body); $o++) {
    if (!isset($message->header->content_type_charset[$o]))
      $message->header->content_type_charset[$o]=$www_charset;
    if (!isset($message->header->content_type_name[$o]))
      $message->header->content_type_name[$o]="unnamed";
    if (!isset($message->header->content_type_format[$o]))
      $message->header->content_type_format[$o]="fixed";
  }
  return $message;
}


/*
 * read an article from the newsserver or the spool-directory
 *
 * $id: the Message-ID of an article
 * $bodynum: the number of the attachment:
 *          -1: return only the header without any bodies or attachments.
 *           0: the body
 *           1: the first attachment...
 *
 * The function returns an article as an messageType or false if the article
 * doesn't exists on the newsserver or doesn't contain the given
 * attachment.
 */
function message_read($id,$bodynum=0,$group="") {
  global $cache_articles,$spooldir,$text_error,$ns;
  if (!testGroup($group)) {
    echo $text_error["read_access_denied"];
    return;
  }
  $message = new messageType;
  if ((isset($cache_articles)) && ($cache_articles == true)) {
    // Try to load a cached article
    if ((preg_match('/^[0-9]+$/',$id)) && ($group != ''))
      $filename=$group.'_'.$id;
    else
      $filename=base64_encode($id);
    $cachefilename_header=$spooldir."/".$filename.'.header';
    $cachefilename_body=$spooldir."/".$filename.'.body';
    if (file_exists($cachefilename_header)) {
      $cachefile=fopen($cachefilename_header,"r");
      $message->header=unserialize(fread($cachefile,filesize($cachefilename_header)));
      fclose($cachefile);
    } else {
      unset($message->header);
    }
    // Is a non-existing attachment of an article requested?
    if ((isset($message->header)) &&
        ($bodynum!= -1) &&
        (!isset($message->header->content_type[$bodynum])))
      return false;
    if ((file_exists($cachefilename_body.$bodynum)) &&
        ($bodynum != -1)) {
      $cachefile=fopen($cachefilename_body.$bodynum,"r");
      $message->body[$bodynum]=
        fread($cachefile,filesize($cachefilename_body.$bodynum));
      fclose($cachefile);
    }
  }
  if ((!isset($message->header)) ||
      ((!isset($message->body[$bodynum])) &&
       ($bodynum != -1))) {
    if (!isset($ns)) {
      $ns=nntp_open();
    }
    if ($group != "") {
      fputs($ns,"GROUP ".$group."\r\n");
      $line=line_read($ns);
    }
    fputs($ns,'ARTICLE '.$id."\r\n");
    $line=line_read($ns);
    if (substr($line,0,3) != "220") {
      // requested article doesn't exist on the newsserver. Now we
      // should check, if the thread stored in the spool-directory
      // also doesnt't contain that article...
      thread_cache_removearticle($group,$id);
      return false;
    }
    $rawmessage=array();
    $line=line_read($ns);
    while(strcmp($line,".") != 0) {
      $rawmessage[]=$line;
      $line=line_read($ns);
    }
    $message=message_parse($rawmessage);
    if (preg_match('/^[0-9]+$/',$id)) $message->header->number=$id;
    // write header, body and attachments to the cache
    if ((isset($cache_articles)) && ($cache_articles == true)) {
      $cachefile=fopen($cachefilename_header,"w");
      if ($cachefile) {
        fputs($cachefile,serialize($message->header));
      }
      fclose($cachefile);
      for ($i=0; $i<count($message->header->content_type); $i++) {
        if (isset($message->body[$i])) {
          $cachefile=fopen($cachefilename_body.$i,"w");
          fwrite($cachefile,$message->body[$i]);
          fclose($cachefile);
        }
      }
    }
  }
  return $message;
}

function textwrap($text, $wrap=80, $break="\n",$maxlen=false){
  $len = strlen($text);
  if ($len > $wrap) {
    $h = '';        // massaged text
    $lastWhite = 0; // position of last whitespace char
    $lastChar = 0;  // position of last char
    $lastBreak = 0; // position of last break
    // while there is text to process
    while ($lastChar < $len && (($maxlen==false) || (strlen($h)<$maxlen))) {
      $char = substr($text, $lastChar, 1); // get the next character
      // if we are beyond the wrap boundry and there is a place to break
      if (($lastChar - $lastBreak > $wrap) && ($lastWhite > $lastBreak)) {
        $h .= substr($text, $lastBreak, ($lastWhite - $lastBreak)) . $break;
        $lastChar = $lastWhite + 1;
        $lastBreak = $lastChar;
      }
      // You may wish to include other characters as valid whitespace...
      if ($char == ' ' || $char == chr(13) || $char == chr(10)) {
        $lastWhite = $lastChar; // note the position of the last whitespace
      }
      $lastChar = $lastChar + 1; // advance the last character position by one
    }
    $h .= substr($text, $lastBreak); // build line
  } else {
    $h = $text; // in this case everything can fit on one line
  }
  return $h;
}
/*
 * Displays a (Sub)-Thread. Is used in article.php
 *
 * $id:    Message-ID (not number!) of an article in the thread
 * $group: name of the newsgroup
 */
function message_thread($id,$group,$thread,$highlightids=false) {
  $current=$id;
  // set the highlightid, if not set
  if(!$highlightids)
    $highlightids=array($current);
  flush();
  // find the first article in the subthread of $id
  while(isset($thread[$id]->references)) {
    foreach($thread[$id]->references as $reference) {
      if((trim($reference)!='') && (isset($thread[$reference]))) {
        $id=$reference;
        continue 2;
      }
    }
    break;
  }
  $liste=array();
  $liste[]=$id;
  $tmp=0;
  thread_show_head();
  echo thread_show_recursive($thread,$liste,1,"",$group,0,100,$tmp,$highlightids);
  thread_show_tail();
}

/*
 * Print the header of a message to the webpage
 *
 * $head: the header of the message as an headerType
 * $group: the name of the newsgroup, is needed for the links to post.php3
 *         and the header.
 */
function show_header($head,$group) {
  global $article_show,$text_header,$file_article,$attachment_show;
  global $file_attachment,$anonym_address;
  echo '<div class="np_article_header">';
  if ($article_show["Subject"]) echo $text_header["subject"].htmlspecialchars($head->subject)."<br>";
  if ($article_show["From"]) {
    echo $text_header["from"];
    if($head->from==$anonym_address) {
      // this is the anonymous address, so only show the name
      echo htmlspecialchars($head->name);
    } else {
      if($article_show["From_link"])
        echo '<a href="mailto:'.htmlspecialchars($head->from).'">';
      if(isset($article_show["From_rewrite"]))
        echo preg_replace('/' . $article_show["From_rewrite"][0] . '/i',
                           $article_show["From_rewrite"][1],
                           htmlspecialchars($head->from));
      else
        echo htmlspecialchars($head->from);
      if($article_show["From_link"])
        echo '</a>';
      if ($head->name != "") echo ' ('.htmlspecialchars($head->name).')';
    }
    echo "<br>";
  }
  if ($article_show["Newsgroups"]) 
    echo $text_header["newsgroups"].htmlspecialchars(str_replace(',',', ',$head->newsgroups))."<br>\n";
  if (isset($head->followup) && ($article_show["Followup"]) && ($head->followup != "")) 
    echo $text_header["followup"].htmlspecialchars($head->followup)."<br>\n";
  if ((isset($head->organization)) && ($article_show["Organization"]) &&
     ($head->organization != ""))
    echo $text_header["organization"].
         html_parse(htmlspecialchars($head->organization))."<br>\n";
  if ($article_show["Date"])
    echo $text_header["date"].date($text_header["date_format"],$head->date)."<br>\n";
  if ($article_show["Message-ID"])
    echo $text_header["message-id"].htmlspecialchars($head->id)."<br>\n";
  if (($article_show["References"]) && (isset($head->references[0]))) {
    echo $text_header["references"];
    for ($i=0; $i<=count($head->references)-1; $i++) {
      $ref=$head->references[$i];
      echo ' '.'<a href="'.$file_article.'?group='.urlencode($group).
           '&id='.urlencode($ref).'">'.($i+1).'</a>';
    }
    echo "<br>";
  }
  if (isset($head->user_agent)) {
    if ((isset($article_show["User-Agent"])) &&
       ($article_show["User-Agent"])) {
      echo $text_header["user-agent"].htmlspecialchars($head->user_agent)."<br>\n";
    } else {
      echo "<!-- User-Agent: ".htmlspecialchars($head->user_agent)." -->\n";
    }
  }
  if ((isset($attachment_show)) && ($attachment_show==true) &&
      (isset($head->content_type[1]))) {
    echo $text_header["attachments"];
    for ($i=1; $i<count($head->content_type); $i++) {
      echo '<a href="'.$file_attachment.'?group='.urlencode($group).'&'.
           'id='.urlencode($head->number).'&'.
           'attachment='.$i.'">'.
           $head->content_type_name[$i].'</a> ('.
           $head->content_type[$i].')';
      if ($i<count($head->content_type)-1) echo ', ';
    }
  }
  echo '</div>';
}

/*
 * decodes a body. Splits the content of $body into an array of several
 * lines, respecting the special decoding issues of format=flowed
 * articles. Each returned line consists of two fields: text and
 * the quote depth (depth)
 */
function decode_textbody($body,$format="fixed") {
  $body=explode("\n",$body);
  $nbody=array();
  $depth=0;
  $paragraph=""; // empty paragraph
  $lastline="";
  for($i=0; $i<count($body)+1; $i++) {
    // calculate the quote depth of the actual line
    $ndepth=0;
    $tdepth=0;
    for($j=0; $j<=strlen($body[$i]); $j++) {
      $tdepth=$j;
      if($body[$i][$j]=='>') {
        $ndepth++;
      } else {
        if(($body[$i][$j]!=' ') || ($body[$i][$j-1]==' ') || ($j==0)) {
          break;
        }
      }
    }
    // generate a new paragraph?
    if(($i>0) && (($ndepth!=$depth) || $format!="flowed" ||
       ($paragraph[strlen($paragraph)-1]!=' ')) || ($i==count($body))) {
      $tmp->text=$lastline=$paragraph;
      $tmp->depth=$depth;
      $paragraph="";
      if(phpversion()>=5)
        $nbody[]=clone($tmp);
      else
        $nbody[]=$tmp;
    }
    if($body[$i]=="-- " && $format=="flowed") $body[$i]="--";
    $paragraph.=substr($body[$i],$tdepth);
    $depth=$ndepth;
  }
  return $nbody;
}

/*
 * replaces multiple spaces in texts by &nbsp;es and convert special-chars
 * to their entities
 */
function text2html($text) {
  return preg_replace('/^ /',"&nbsp;",
         str_replace("  ","&nbsp; ",
         str_replace("  ","&nbsp; ",
         str_replace("\n","<br>",
         htmlspecialchars($text)))));
}


/*
 * print an article to the webpage
 *
 * $group: The name of the newsgroup
 * $id: the ID of the article inside the group or the message-id
 * $attachment: The number of the attachment of the article.
 *              0 means the normal textbody.
 */
function message_show($group,$id,$attachment=0,$article_data=false,$maxlen=false) {
  global $file_article,$file_article_full;
  global $text_header,$text_article,$article_showthread;
  global $block_xnoarchive,$article_graphicquotes;
  if ($article_data == false)
    $article_data=message_read($id,$attachment,$group);
  $head=$article_data->header;
  $body=$article_data->body[$attachment];
  if ($head) {
    if (($block_xnoarchive) && (isset($head->xnoarchive)) &&
        ($head->xnoarchive=="yes")) {
      echo $text_article["block-xnoarchive"];
    } else
    if (($head->content_type[$attachment]=="text/plain") &&
        ($attachment==0)) {
      show_header($head,$group);
      $body=decode_textbody($body,
             $article_data->header->content_type_format[$attachment]);
      $depth=0;
      echo '<div class="np_article_body">';
      $currentlen=0; // needed if $maxlen is set
      for ($i=0; $i<=count($body) && 
                 (($currentlen<$maxlen) || ($maxlen==false)); $i++) {
        // HTMLized Quotings instead of boring > ?
        if($article_graphicquotes) {
          // HTMLized Quotings
          for($j=$depth; $j<$body[$i]->depth; $j++)
            echo '<blockquote class="np_article_quote">';
          for($j=$body[$i]->depth; $j<$depth; $j++)
            echo '</blockquote>';
          $t=html_parse(text2html($body[$i]->text)).'<br>';
          echo $t;
          $currentlen+=strlen($t);
          echo "\n";
          $depth=$body[$i]->depth;
        } else {
          // Boring old Quotings with >
          if($body[$i]->depth==0) {
            if(trim($body[$i]->text)=='')
              $t="<br>\n";
            else
              $t=html_parse(text2html($body[$i]->text))."<br>\n";
          } else {
            $t='<i>'.str_repeat('&gt;',$body[$i]->depth).' '.
              html_parse(text2html(
                 textwrap($body[$i]->text,72-$body[$i]->depth,
                  "\n".str_repeat('>',$body[$i]->depth).' '))).
              "</i><br>\n";
          }
          echo $t;
          $currentlen+=strlen($t);
        }
      }
      echo '</div>';
      if($maxlen!=false && $currentlen>=$maxlen) {
        echo '<br><a href="'.$file_article_full.'?id='.$id.'&group='.
             $group.'">'.$text_article["full_article"].'</a>';
      }
    } else {
      echo $body;
    }
  }
}

/*
 * Shows the little menu on article-flat.php where you can select the
 * different pages with the articles on it
 */
function articleflat_pageselect($group,$id,$article_count,$first) {
  global $articleflat_articles_per_page,$file_article,$file_framethread,$name;
  global $text_thread,$thread_show;
  $pages=ceil($article_count / $articleflat_articles_per_page);
  $return="";
  if ($article_count > $articleflat_articles_per_page)
    $return.= $text_thread["pages"];
    for ($i = 0; $i < $pages; $i++) {
      if ($first != $i*$articleflat_articles_per_page+1)
        $return.= '<a class="np_pages_unselected" href="'.
             $file_article.'?group='.$group.
             '&amp;id='.urlencode($id).
             '&amp;first='.($i*$articleflat_articles_per_page+1).'&amp;last='.
             ($i+1)*$articleflat_articles_per_page.'">';
      else
        $return.= '<span class="np_pages_selected">';
      $return.= $i+1;
      if ($i == $pages-1) {
        // $return.= $article_count;
      }
      if ($first != $i*$articleflat_articles_per_page+1)
        $return.= '</a>';
      else
        $return.= '</span>';
    }
  return $return;
}
