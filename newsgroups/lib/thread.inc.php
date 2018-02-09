<?php
/*
 *  NewsPortal: Functions for handling threads
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


/*
 * Shows the little menu on the thread.php where you can select the
 * different pages with the articles on it
 */
function thread_pageselect($group,$article_count,$first) {
  global $articles_per_page,$file_thread,$file_framethread,$name;
  global $text_thread,$thread_show;
  $pages=ceil($article_count / $articles_per_page);
  if ($article_count > $articles_per_page)
    echo $text_thread["pages"];
    for ($i = 0; $i < $pages; $i++) {
      // echo '[';
      if ($first != $i*$articles_per_page+1)
        echo '<a class="np_pages_unselected" href="'.
             $file_thread.'?group='.$group.
             '&amp;first='.($i*$articles_per_page+1).'&amp;last='.
             ($i+1)*$articles_per_page.'">';
      else
        ; //echo '<span class="np_pages_selected">';
      // echo ($i*$articles_per_page+1).'-';
      echo $i+1;
      if ($i == $pages-1) {
        // echo $article_count;
      } else {
        // echo ($i+1)*$articles_per_page;
      }
      if ($first != $i*$articles_per_page+1)
        echo '</a>';
      else
        ; //echo '</span>';
      // echo '] ';
    }
}

/*
 * Load a thread from disk
 *
 * $group: name of the newsgroup, is needed to create the filename
 * 
 * returns: an array of headerType containing the thread.
 */
function thread_cache_load($group) {
  global $spooldir,$compress_spoolfiles;
  $filename=$spooldir."/".$group."-data.dat";
  if (!file_exists($filename)) return false;
  if ($compress_spoolfiles) {
    $file=gzopen("$spooldir/$group-data.dat","r");
    $headers=unserialize(gzread($file,1000000));
    gzclose($file);
  } else {
    $file=fopen($filename,"r");
    $headers=unserialize(fread($file,filesize($filename)));
    fclose($file);
  }
  return($headers);
}


/*
 * Save the thread to disk
 *
 * $header: is an array of headerType containing the thread
 * $group: name of the newsgroup, is needed to create the filename
 */
function thread_cache_save($headers,$group) {
  global $spooldir,$compress_spoolfiles;
  if ($compress_spoolfiles) {
    $file=gzopen("$spooldir/$group-data.dat","w");
    gzputs($file,serialize($headers));
    gzclose($file);
  } else {
    $file=fopen("$spooldir/$group-data.dat","w");
    if($file===false) {
      die('The spool-directory is not writeable. Please change the user '.
          'permissions to give the webserver write-access to it.');
    }
    fputs($file,serialize($headers));
    fclose($file);
  }
}

/*
 * remove an article from the overview-file
 * is needed, when article has been canceled, the article is still
 * in the thread spool on disc and someone wants to read this article.
 * the message_read function can now call this function to remove
 * the article.
 */
function thread_cache_removearticle($group,$id) {
  $thread=thread_cache_load($group);
  if(!$thread) return false;
  $changed=false;
  foreach ($thread as $value) {
    if(($value->number==$id) || ($value->id==$id)) {
      // found to be deleted article
      // now lets rebuild the tree...
      if(isset($value->answers))
        foreach ($value->answers as $key => $answer) {
          $thread[$answer]->isAnswer=false;
        }
      if(isset($value->references))
        foreach ($value->references as $reference) {
          if(isset($thread[$reference]->answers)) {
            $search=array_search($value->id,$thread[$reference]->answers);
            if(!($search===false))
              unset($thread[$reference]->answers[$search]);
          }
        }
      unset($thread[$value->id]);
      $changed=true;
      break;
    }
  }
  if($changed) thread_cache_save($thread,$group);
}

/*
function readArticles(&$ns,$groupname,$articleList) {
  for($i = 0; $i <= count($articleList)-1 ; $i++) {
    $temp=read_header($ns,$articleList[$i]);
    $articles[$temp->id] = $temp;
  }
  return $articles;
}
*/

/*
 * interpret and decode one line of overview-data from the newsserver and
 * put it into an headerType
 *
 * $line: the data to be interpreted
 * $overviewformat: the format of an overview-line, given by
 *                  thread_overview_read()
 * $groupname: the name of the newsgroup
 *
 * returns: headerType containing the data
 */
function thread_overview_interpret($line,$overviewformat,$groupname) {
  $return="";
  $overviewfmt=explode("\t",$overviewformat);
  echo " ";                // keep the connection to the webbrowser alive
  flush();                 // while generating the message-tree
//  $over=explode("\t",$line,count($overviewfmt)-1);
  $over=explode("\t",$line);
  //$article=new headerType;
  for ($i=0; $i<count($overviewfmt)-1; $i++) {
    if ($overviewfmt[$i]=="Subject:") {
      $subject=preg_replace('/\[doctalk\]/i','',headerDecode($over[$i+1]));
      $article->isReply=splitSubject($subject);
      $article->subject=$subject;
    }
    if ($overviewfmt[$i]=="Date:") {
      $article->date=getTimestamp($over[$i+1]);
    }
    if ($overviewfmt[$i]=="From:") {
      $fromline=address_decode(headerDecode($over[$i+1]),"nirgendwo");
      $article->from=$fromline[0]["mailbox"]."@".$fromline[0]["host"];
      $article->username=$fromline[0]["mailbox"];
      if (!isset($fromline[0]["personal"])) {
        $article->name=$fromline[0]["mailbox"];
        if (strpos($article->name,'%')) {
          $article->name=substr($article->name,0,strpos($article->name,'%'));
        }
        $article->name=strtr($article->name,'_',' ');
      } else {
        $article->name=$fromline[0]["personal"];
      }
    }
    if ($overviewfmt[$i]=="Message-ID:") $article->id=$over[$i+1];
    if (($overviewfmt[$i]=="References:") && ($over[$i+1] != "")) {
      $article->references=explode(" ",$over[$i+1]);
    }
  }
  $article->number=$over[0];
  $article->isAnswer=false;
  return($article);
}

/*
 * read the overview-format from the newsserver. This data is used
 * by thread_overview_interpret
 */
function thread_overview_read(&$ns) {
  $overviewfmt=array();
  fputs($ns,"LIST overview.fmt\r\n");  // find out the format of the
  $tmp=line_read($ns);                 // xover-command
  if(substr($tmp,0,3)=="215") {
    $line=line_read($ns);
    while (strcmp($line,".") != 0) {
      // workaround for braindead CLNews newsserver
      if($line=="Author:")
        $overviewfmt[]="From:";
      else
        $overviewfmt[]=$line;
      $line=line_read($ns);
    }
  } else {
    // some stupid newsservers, like changi, don't send their overview
    // format
    // let's hope, that the format is like that from INN
    $overviewfmt=array("Subject:","From:","Date:","Message-ID:",
                          "References:","Bytes:");
  }
  $overviewformat=implode("\t",$overviewfmt);
  return $overviewformat;
}

function thread_mycompare($a,$b) {
    global $thread_sort_order,$thread_sort_type;
    if($thread_sort_type!="thread") {
      $r=($a->date<$b->date) ? -1 : 1;
      if ($a->date==$b->date) $r=0;
    } else {
      $r=($a->date_thread<$b->date_thread) ? -1 : 1;
      if ($a->date_thread==$b->date_thread) $r=0;
    }
    return $r*$thread_sort_order;
}

/*
 * this function loads the (missing parts of the) thread from the newsserver.
 * it also loads the thread from the disk cache to detect which parts
 * are missing and merges this data with the parts from the
 * newsserver.
 * if it detects that the newsserver made major changes in the groups,
 * for example if it expired parts of the group or reset its counters,
 * this function deletes the cached data and make a complete rebuild.
 *
 * $ns: handle of the connection to the newsserver
 * $groupname: name of the newsgroup
 * $poll: if set to 1, this function works in polling-mode, which
 *        means, that it also read every article from the newsserver.
 *        This makes only sense if the article cache is activated
 */
function thread_load_newsserver(&$ns,$groupname,$poll) {
  global $spooldir,$maxarticles,$maxfetch,$initialfetch,$maxarticles_extra;
  global $text_error,$text_thread,$compress_spoolfiles,$server;
  global $www_charset,$iconv_enable,$thread_show,$thread_sort_order;
  $idstring="0.36,".$server.",".$compress_spoolfiles.",".$maxarticles.",".
            $maxarticles_extra.",".$maxfetch.",".$initialfetch.",".
            $www_charset.','.$iconv_enable.','.$thread_show["replies"];
  $overviewformat=thread_overview_read($ns);
  $spoolfilename=$spooldir."/".$groupname."-data.dat";
  fputs($ns,"GROUP $groupname\r\n");   // select a group
  $groupinfo=explode(" ",line_read($ns));
  if (substr($groupinfo[0],0,1) != 2) {
    echo "<p>".$text_error["error:"]."</p>";
    echo "<p>".$text_thread["no_such_group"]."</p>";
    flush();
  } else {
    $infofilename=$spooldir."/".$groupname."-info.txt";
    // lets find out, in which mode wie want to read articles:
    // w: complete rebuild of the group-info file
    // a: add new articles to the group-info file
    // n: there are no new articles, no rebuild or actualisation
    $spoolopenmodus="n";
    // if the group-info file doesn't exist: create it
    if (!((file_exists($infofilename)) && (file_exists($spoolfilename)) &&
          (filesize($infofilename)>0) && (filesize($spoolfilename)>0))) {
      $spoolopenmodus="w";
    } else {
      $infofile=fopen($infofilename,"r");
      $oldid=fgets($infofile,100);
      if (trim($oldid) != $idstring) {
        echo "<!-- Database Error, rebuilding Database...-->\n";
        $spoolopenmodus="w";
      }
      $oldgroupinfo=explode(" ",trim(fgets($infofile,200)));
      fclose($infofile);
      if ($groupinfo[3] < $oldgroupinfo[1]) {
        $spoolopenmodus="w";
      }
      if ($maxarticles == 0) {
        if ($groupinfo[2] != $oldgroupinfo[0]) $spoolopenmodus="w";
      } else {
        if ($groupinfo[2] > $oldgroupinfo[0]) $spoolopenmodus="w";
      }
      // if the high watermark increased, add articles to the existing spool
      if (($spoolopenmodus == "n") && ($groupinfo[3] > $oldgroupinfo[1]))
        $spoolopenmodus="a";
    }
    if ($spoolopenmodus=="a") {
      $firstarticle=$oldgroupinfo[1]+1;
      $lastarticle=$groupinfo[3];
    }
    if ($spoolopenmodus=="w") {
      $firstarticle=$groupinfo[2];
      $lastarticle=$groupinfo[3];
    }
    if ($spoolopenmodus != "n") {
      if ($maxarticles != 0) {
        if ($spoolopenmodus == "w") {
          $firstarticle=$lastarticle-$maxarticles+1;
          if ($firstarticle < $groupinfo[2])
            $firstarticle=$groupinfo[2];
        } else {
          if ($lastarticle-$oldgroupinfo[0]+1 > $maxarticles + $maxarticles_extra) {
            $firstarticle=$lastarticle-$maxarticles+1;
            $spoolopenmodus="w";
          }
        }
      }
      if (($maxfetch!=0) && (($lastarticle-$firstarticle+1) > $maxfetch)) {
        if ($spoolopenmodus=="w") {
          $tofetch=($initialfetch != 0) ? $initialfetch : $maxfetch;
          $lastarticle=$firstarticle+$tofetch-1;
        } else {
          $lastarticle=$firstarticle+$maxfetch-1;
        }
      }
    }
    echo "<!--openmodus: ".$spoolopenmodus."-->\n";
    // load the old spool-file, if we do not have a complete rebuild
    if ($spoolopenmodus != "w") $headers=thread_cache_load($groupname);
    // read articles from the newsserver
    if ($spoolopenmodus != "n") {
      // order the article overviews from the newsserver
      fputs($ns,"XOVER ".$firstarticle."-".$lastarticle."\r\n");
      $tmp=line_read($ns);
      // have the server accepted our order?
      if (substr($tmp,0,3) == "224") {
        $line=line_read($ns);
        // read overview by overview until the data ends
        while ($line != ".") {
          // parse the output of the server...
          $article=thread_overview_interpret($line,$overviewformat,$groupname);
          // ... and save it in our data structure
          $article->threadsize++;
          $article->date_thread=$article->date;
          $headers[$article->id]=$article;
          // if we are in poll-mode: print status information and
          // decode the article itself, so it can be saved in the article
          // cache
          if($poll) {
            echo $article->number.", "; flush();
            message_read($article->number,0,$groupname);
          }
          // read the next line from the newsserver
          $line=line_read($ns);
        }
        // write information about the last article to the spool-directory
        $infofile=fopen($spooldir."/".urlencode($groupname)."-lastarticleinfo.dat","w");
        $lastarticleinfo->from=$article->from;
        $lastarticleinfo->date=$article->date;
        $lastarticleinfo->name=$article->name;
        fputs($infofile,serialize($lastarticleinfo));
        fclose($infofile);
      }
      // remove the old spoolfile
      if (file_exists($spoolfilename)) unlink($spoolfilename);
      if ((isset($headers)) && (count($headers)>0)) {
        //$infofile=fopen($infofilename,"w");
        //if ($spoolopenmodus=="a") $firstarticle=$oldgroupinfo[0];
        //fputs($infofile,$idstring."\n");
        //fputs($infofile,$firstarticle." ".$lastarticle."\r\n");
        //fclose($infofile);
        foreach($headers as $c) {
          if (($c->isAnswer == false) &&
             (isset($c->references))) {   // is the article an answer to an
                                          // other article?
            // try to find a matching article to one of the references
            $refmatch=false;
            foreach ($c->references as $reference) {
              if(isset($headers[$reference])) {
                $refmatch=$reference;
              }
            }
            // have we found an article, to which this article is an answer?
            if($refmatch!=false) {
              $c->isAnswer=true;
              $c->bestreference=$refmatch;
              $headers[$c->id]=$c;
              // the referenced article get the ID af this article as in
              // its answers-array
              $headers[$refmatch]->answers[]=$c->id;
              // propagate down the number of articles in this thread
              $d =& $headers[$c->bestreference];
              do {
                $d->threadsize+=$c->threadsize;
                $d->date_thread=max($c->date,$d->date_thread);
              } while(($headers[$d->bestreference]) && 
                        (isset($d->bestreference)) &&
                        ($d =& $headers[$d->bestreference]));
            }
          }
        }
        reset($headers);
        // sort the articles
        if (($thread_sort_order != 0) && (count($headers)>0))
          uasort($headers,'thread_mycompare');
        // Save the thread-informations
        thread_cache_save($headers,$groupname);
        // Save the info-file
        $infofile=fopen($infofilename,"w");
        if ($spoolopenmodus=="a") $firstarticle=$oldgroupinfo[0];
        fputs($infofile,$idstring."\n");
        fputs($infofile,$firstarticle." ".$lastarticle." ".count($headers)."\r\n");
        fclose($infofile);
      }
      // remove cached articles that are not in this group
      // (expired on the server or canceled)
      $dirhandle=opendir($spooldir);
      while ($cachefile = readdir($dirhandle)) {
        if(substr($cachefile,0,strlen($groupname)+1)==$groupname."_") {
          $num=preg_replace('/^(.*)_(.*)\.(.*)$/i','\2',$cachefile);
          if(($num<$firstarticle) || ($num>$lastarticle))
            unlink($spooldir.'/'.$cachefile);
        }
        // remove the html cache files of this group
        if((substr($cachefile,strlen($cachefile)-5)==".html") &&
           (substr($cachefile,0,strlen($groupname)+1)==$groupname."-"))
          unlink($spooldir.'/'.$cachefile);
      }
    }
    if(isset($headers))
      return $headers;
    return false;
    //return((isset($headers)) ? $headers : false);
  }
}  


/*
 * Read the Overview.
 * Format of the overview-file:
 *    message-id
 *    date
 *    subject
 *    author
 *    email
 *    references
 *
 * $groupname: name of the newsgroup
 * $readmode: if set to 0, this function only reads data from the 
 *            newsserver, if there exists no cached data for this group
 * $poll: polling mode, see description at thread_load_newsserver()
 */

function thread_load($groupname,$readmode = 1,$poll=false) {
  global $text_error, $maxarticles, $server, $port;
  global $spooldir,$thread_sort_order,$cache_thread;
  if (!testGroup($groupname)) {
    echo $text_error["read_access_denied"];
    return;
  }
  // first assume that we have to query the newsserver
  $query_ns=true;
  // name of the file that indicates by it's timestamp when the
  // last query of the newsserver was
  $cachefile=$spooldir.'/'.$groupname.'-cache.txt';
  // should we load the data only from cache if it's recent enough, or
  // do we have to query the newsserver every time?
  if($cache_thread>0) {
    if((file_exists($cachefile)) && 
       (filemtime($cachefile)+$cache_thread>time())) {
      // cached file exists and is new enough. so lets read it out.
      $articles=thread_cache_load($groupname);
      return $articles;
      $query_ns=false;
    }
  }
  // do we have to query the newsserver?
  if($query_ns) {
    // look if there is new data on the newsserver
    $ns=nntp_open($server,$port);
    if ($ns == false) return false;
    if (($ns!=false) && ($readmode > 0)) 
      $articles=thread_load_newsserver($ns,$groupname,$poll);
    if ((isset($articles)) && ($articles)) {

      // write the file which indicates the time of the last newsserver query
      $fp_cachefile=@fopen($cachefile,"w");
      if($fp_cachefile!==false) {
        fputs($fp_cachefile,"");
        fclose($fp_cachefile);
        return $articles;
      }
    } else {
      // uh, we didn't get articles from the newsservers...
      // for now, return false. but it would also make sense to get
      // the articles from the cache then...
      return false;
    }
    nntp_close($ns);
  }
}

/*
 * Remove re:, aw: etc. from a subject.
 *
 * $subject: a string containing the complete Subject
 *
 * The function removes the re:, aw: etc. from $subject end returns true
 * if it removed anything, and false if not.
 */
function splitSubject(&$subject) {
  $s=preg_replace('/^(odp:|aw:|re:|re\[2\]:| )+/i','',$subject);
  $return=($s != $subject);
  $subject=$s;
  return $return;
}

function str_change($str,$pos,$char) {
  return(substr($str,0,$pos).$char.substr($str,$pos+1,strlen($str)-$pos));
}

/*
 * calculate the graphic representation of the thread
 */
function thread_show_calculate($newtree,$depth,$num,$liste,$c) {
  global $thread_show;
  // displays the replies to an article?
  if(!$thread_show["replies"]) {
    // no
    if ((isset($c->answers[0])) && (count($c->answers)>0))
      $newtree.="o";
    else
      $newtree.="o";
  } else {
    // yes, display the replies
    if ((isset($c->answers[0])) && (count($c->answers)>0)) {
      $newtree.="*";
    } else {
      if ($depth == 1) {
        $newtree.="o";
      } else {
        $newtree.="-";
      }
    }
    if (($num == count($liste)-1) && ($depth>1)) {
      $newtree=str_change($newtree,$depth-2,"`");
    }
  }
  return($newtree);
}


/*
 * Format the message-tree
 * Zeichen im Baum:
 *  o : leerer Kasten            k1.gif
 *  * : Kasten mit Zeichen drin  k2.gif
 *  i : vertikale Linie          I.gif
 *  - : horizontale Linie        s.gif
 *  + : T-Stueck                 T.gif
 *  ` : Winkel                   L.gif
 */
function thread_show_treegraphic($newtree) {
  global $imgdir;
  $return="";
  for ($o=0 ; $o<strlen($newtree) ; $o++) {
    $return .= '<img src="'.$imgdir.'/';
    $k=substr($newtree,$o,1);
    $alt=$k;
    switch ($k) {
      case "o":
        $return .= 'k1.gif';
        break;
      case "*":
        $return .= 'k2.gif';
        break;
      case "i":
        $return .= 'I.gif';
        $alt='|';
        break;
      case "-":
        $return .= 's.gif';
        break;
      case "+":
        $return .= 'T.gif';
        break;
      case "`":
        $return .= 'L.gif';
        break;
      case ".":
        $return .= 'e.gif';
        $alt='&nbsp;';
        break;
      }
    $return .= '" alt="'.$alt.'" class="thread_image"';
    if (strcmp($k,".") == 0) $return .=(' width="12" height="9"');
    $return .= '>';
  }
  return($return);
}

function formatTreeText($tree) {
  $tree=str_replace("i","|",$tree);
  $tree=str_replace(".","&nbsp;",$tree);
  return($tree);
}

/*
 * format the subject inside the thread
 */
function thread_format_subject($c,$group,$highlightids=false) {
  global $file_article, $thread_maxSubject, $frame_article;
  if ($c->isReply) {
    $re="Re: ";
  } else {
    $re="";
  }
  // is the current article to be highlighted?
  if(($highlightids) &&
     ((in_array($c->id,$highlightids)) ||
      (in_array($c->number,$highlightids))))
    $highlight=true;
  else
    $highlight=false;
  if($highlight)
    $return='<b>';
  else {
    $return='<a ';
    if ((isset($frame_article)) && ($frame_article != ""))
      $return .= 'target="'.$frame_article.'" ';
    $return .= 'href="'.$file_article.
       '?id='.urlencode($c->number).'&group='.urlencode($group).'#'.
       urlencode($c->number).'">';
  }
  $return.=$re.htmlspecialchars(substr(trim($c->subject),0,$thread_maxSubject));
  if($highlight)
    $return.='</b>';
  else
    $return.='</a>';
  return($return);
}

/*
 * colorize the date inside the thread
 */
function thread_format_date_color($date) {
  global $age_count,$age_time,$age_color;
  $return="";
  $currentTime=time();
  if ($age_count > 0)
    for($t = $age_count; $t >= 1; $t--) {
      if ($currentTime - $date < $age_time[$t])
        $color = $age_color[$t];
    }
  if (isset($color))
    return $color;
  else
    return "";
}

/*
 * format the date inside the thread
 */
function thread_format_date($c) {
  global $age_count,$age_time,$age_color,$thread_show;
  $return="";
  $currentTime=time();
  $color="";
  // show the date of the individual article or of the latest article
  // in the thread?
  if($thread_show["lastdate"])
    $date=$c->date_thread;
  else
    $date=$c->date;
  if ($age_count > 0)
    for($t = $age_count; $t >= 1; $t--)
      if ($currentTime - $date < $age_time[$t]) $color = $age_color[$t];
  if ($color != "") $return .= '<font color="'.$color.'">';
  $return .= date("d.m.",$date);                 // format the date
  if ($color != "") $return .= '</font>';
  return($return);
}

/*
 * format the author inside the thread
 */
function thread_format_author($c) {
  global $thread_show,$anonym_address;
  // if the address the anonymous address, only return the name
  if($c->from==$anonym_address)
    return $c->name;
  $return="";
  if($thread_show["authorlink"])
    $return .= '<a href="mailto:'.trim($c->from).'">';
  if (trim($c->name)!="") { 
    $return .= htmlspecialchars(trim($c->name));
  } else {
    if (isset($c->username)) {
      $s = strpos($c->username,"%");
      if ($s != false) {
        $return .= htmlspecialchars(substr($c->username,0,$s));
      } else {
        $return .= htmlspecialchars($c->username);
      }
    }
  }
  if($thread_show["authorlink"])
    $return .= "</a>";
  return($return);
}

/*
 * Displays a part of the thread. This function is recursively called
 * It is used by thread_show
 */
function thread_show_recursive(&$headers,&$liste,$depth,$tree,$group,$article_first=0,$article_last=0,&$article_count,$highlight=false) {
  global $thread_treestyle;
  global $thread_show,$imgdir;
  global $file_article,$thread_maxSubject;
  global $age_count,$age_time,$age_color;
  global $frame_article;
  $output="";
  if ($thread_treestyle==3) $output.= "\n<UL>\n";
  for ($i = 0 ; $i<count($liste) ; $i++) {
    // CSS class for the actual line
    $lineclass="np_thread_line".(($article_count%2)+1);
    // read the first article
    $c=$headers[$liste[$i]]; 
    $article_count++; 
    // Render the graphical tree
    switch ($thread_treestyle) {
      case 4:  // thread
      case 5:  // thread, graphic
      case 6:  // thread, table
      case 7:  // thread, table, graphic
        $newtree=thread_show_calculate($tree,$depth,$i,$liste,$c);
    }
    if (($article_first == 0) ||
        (($article_count >= $article_first) &&
         ($article_count <= $article_last))) {
      switch ($thread_treestyle) {
        case 0: // simple list
          $output.= '<span class="np_thread_line_text">';
          if ($thread_show["date"]) $output.= thread_format_date($c)." ";
          if ($thread_show["subject"]) $output.= thread_format_subject($c,$group)." ";
          if ($thread_show["author"]) $output.= "(".thread_format_author($c).")";
          $output.= '</span>';
          $output.= "<br>\n";
          break;
        case 1: // html-auflistung, kein baum
          $output.= '<li><nobr><span class="np_thread_line_text">';
          if ($thread_show["date"])
            $output.= thread_format_date($c).': ';
          if ($thread_show["subject"])
            $output.= thread_format_subject($c,$group,$highlight).' ';
          if ($thread_show["author"])
            $output.= "<i>von ".thread_format_author($c)."</i>";
          $output.= '</span></nobr></li>';
          break;
        case 2:   // table
          $output.= '<tr>';
          if ($thread_show["date"]) {
            $output.= '<td><span class="np_thread_line_text">'.
                      thread_format_date($c).' </span></td>';
          }
          if ($thread_show["subject"]) {
            $output.= '<td nowrap="nowrap">'.
                 '<span class="np_thread_line_text">'.
                 thread_format_subject($c,$group,$highlight).
                 '</span></td>';
          }
          if ($thread_show["author"]) {
            $output.= '<td></td>'.
                      '<td nowrap="nowrap">'.
                      '<span class="np_thread_line_text">'.thread_format_author($c).
                      '</span></td>';
          }
          $output.= "</tr>\n";
          break;
        case 3: // html-tree
          $output.= '<li><nobr><span class="np_thread_line_text">';
          if ($thread_show["date"])
            $output.= thread_format_date($c)." ";
          if ($thread_show["subject"])
            $output.= thread_format_subject($c,$group,$highlight)." ";
          if ($thread_show["author"])
            $output.= "<i>(".thread_format_author($c).")</i>";
          $output.= "</span></nobr>";
          break;
        case 4:  // thread
          $output.= '<nobr><tt><span class="np_thread_line_text">';
          if ($thread_show["date"])
            $output.= thread_format_date($c)." ";
          $output.= formatTreeText($newtree)." ";
          if ($thread_show["subject"])
            $output.= thread_format_subject($c,$group,$highlight)." ";
          if ($thread_show["author"])
            $output.= "<i>(".thread_format_author($c).")</i>";
          $output.= '</span></tt></nobr><br>';
          break;
        case 5:  // thread, graphic
          $output.= '<table cellspacing="0"><tr>';
          if ($thread_show["date"])
            $output.= '<td nowrap="nowrap">'.
                      '<span class="np_thread_line_text">'.
                      thread_format_date($c).' </span></td>';
          $output.= '<td><span class="np_thread_line_text">'.
                    thread_show_treegraphic($newtree).'</span></td>';
          if ($thread_show["subject"])
            $output.= '<td nowrap="nowrap">'.
                      '<span class="np_thread_line_text">&nbsp;'.
                      thread_format_subject($c,$group,$highlight)." ";
          if ($thread_show["author"])
            $output.= '('.thread_format_author($c).')</span></td>';
          $output.= "</tr></table>";
          break;
        case 6:  // thread, table
          $output.= "<tr>";
          if ($thread_show["date"])
            $output.= '<td nowrap="nowrap"><tt>'.
                      '<span class="np_thread_line_text">'.
                      thread_format_date($c).' </span></tt></td>';
          $output.= '<td nowrap="nowrap"><tt>'.
                    '<span class="np_thread_line_text">'.
                    formatTreeText($newtree)." ";
          if ($thread_show["subject"]) {
            $output.= thread_format_subject($c,$group,$highlight)."</span></tt></td>";
            $output.= "<td></td>";
          }
          if ($thread_show["author"])
            $output.= '<td nowrap="nowrap"><tt>'.
                      '<span class="np_thread_line_text">'.
                      thread_format_author($c).'</span></tt></td>';
          $output.= "</tr>";
          break;
        case 7:  // thread, table, graphic
          $output.= '<tr class="'.$lineclass;
          $output.='">';
          if ($thread_show["date"])
            $output.= '<td class="'.$lineclass.'" nowrap="nowrap">'.
                      '<span class="np_thread_line_text">'.
                      thread_format_date($c)." ".
                      '</span></td>';
            $output.= '<td nowrap class="'.$lineclass.'">';
            $output.= thread_show_treegraphic($newtree);
            if ($thread_show["subject"])
              $output.= '<span class="np_thread_line_text">&nbsp;'.
                thread_format_subject($c,$group,$highlight).'</span>';
            $output.='</td>';
            if($thread_show["threadsize"])
              $output.= "<td>".$c->threadsize.'</td>';
            if ($thread_show["subject"]) $output.= "<td></td>";
            if ($thread_show["author"])
              $output.= '<td class="'.$lineclass.'" nowrap="nowrap">'.
                      '<span class="np_thread_line_text">'.
                      thread_format_author($c).'</span></td>';
            $output.= "</tr>";
            break;
      }
    }
    if ((isset($c->answers[0])) && (count($c->answers)>0) &&
        ($article_count<=$article_last)) {
      if ($thread_treestyle >= 4) {
        if (substr($newtree,$depth-2,1) == "+")
          $newtree=str_change($newtree,$depth-2,"i");
        $newtree=str_change($newtree,$depth-1,"+");
        $newtree=strtr($newtree,"`",".");
      }
      if (!isset($newtree)) $newtree="";
      if($thread_show["replies"]) {
        $output.=thread_show_recursive($headers,$c->answers,$depth+1,$newtree."",$group,
                   $article_first,$article_last,$article_count,$highlight);
      }
    }
    flush();
  }
  if ($thread_treestyle==3) $output.= "</UL>";
  return $output;
}


/*
 * Displays the Head (table tags, headlines etc.) of a thread
 */
function thread_show_head() {
  global $thread_show, $thread_showTable;
  global $text_thread,$thread_treestyle;
  if (($thread_treestyle==2) || ($thread_treestyle==6) ||
      ($thread_treestyle==7)) {
    echo '<table cellspacing="0" class="np_thread_table">';
    echo '<tr class="np_thread_head">'."\n";
    if ($thread_show["date"])
      echo '<td width="1%" class="np_thread_head">'.$text_thread["date"]."&nbsp;</td>";
    if ($thread_show["subject"])
      echo '<td class="np_thread_head">'.
           $text_thread["subject"]."</td>";
    if ($thread_show["threadsize"])
      echo '<td class="np_thread_head">'.
           $text_thread["threadsize"]."</td>";
    if ($thread_show["author"]) {
      echo '<td class="np_thread_head">&nbsp;&nbsp;</td>';
      echo '<td class="np_thread_head">'.$text_thread["author"]."</td>\n";
    }
    echo "</tr>\n";
  } else {
    if ($thread_treestyle==1) echo "<ul>\n";
  }
}

/*
 * Displays the tail (closing table tags, headlines etc.) of a thread
 */
function thread_show_tail() {
  global $thread_show, $thread_showTable;
  global $text_thread,$thread_treestyle;
  if (($thread_treestyle==2) || ($thread_treestyle==6) ||
      ($thread_treestyle==7)) {
    echo "</table>\n";
  } else {
    if ($thread_treestyle==1) echo "</ul>\n";
  }
}

/*
 * Shows a complete thread
 *
 * $headers: The thread to be displayed
 * $group:   name of the newsgroup
 * $article_first: Number of the first article to be displayed
 * $article_last: last article
 */
function thread_show(&$headers,$group,$article_first=0,$article_last=0) {
  global $spooldir,$text_thread;
  $article_count=0;
  if ($headers == false) {
    echo $text_thread["no_articles"];
  } else {
    // exists a cached html-output?
    $filename=$spooldir."/".$group."-".$article_first."-".
              $article_last.".html";
    if (!file_exists($filename)) {
      // no, we need to create a new html-output
      $output="";
      reset($headers);
      $c=current($headers);
      for ($i=0; $i<=count($headers)-1; $i++) {  // create the array $liste
        if ($c->isAnswer == false) {             // where are all the articles
          $liste[]=$c->id;                       // in that don't have
        }                                        // references
        $c=next($headers);
      }
      reset($liste);
      if (count($liste)>0) {
        $output.=thread_show_recursive($headers,$liste,1,"",$group,$article_first,
                 $article_last,$article_count);
      }
      // cache the html-output
      $file=fopen($filename,"w");
      fputs($file,$output);
      fclose($file);
    } else {
      // yes, a cached output exists, load it!
      $file=fopen($filename,"r");
      $output=fread($file,filesize($filename));
      fclose($file);
    }
    thread_show_head();
    echo $output;
    thread_show_tail();
  }
}




/*
 * returns the article-numbers of all articles in a given subthread
 *
 * $id: article number or message id of a article in a subthread
 * $thread: thread data, as returned by thread_cache_load()
 */
function thread_getsubthreadids($id,$thread) {
  // recursive helper function to walk through the subtree
  function thread_getsubthreadids_recursive($id) {
    global $thread;
    $answers=array($thread[$id]->number);
    // has this article answers?
    if(isset($thread[$id]->answers)) {
      // walk through the answers
      foreach($thread[$id]->answers as $answer) {
        $answers=array_merge($answers,
             thread_getsubthreadids_recursive($answer));
      }
    }
    return $answers;
  }

//echo htmlspecialchars(print_r($thread,true));
  // exists the article $id?
  if(!isset($thread[$id]))
    return false;
  // "rewind" the subthread to the first article in the subthread
  $current=$id;
  flush();
  while(isset($thread[$id]->references)) {
    foreach($thread[$id]->references as $reference) {
      if((trim($reference)!='') && (isset($thread[$reference]))) {
        $id=$reference;
        continue 2;
      }
    }
    break;
  }

  // walk through the thread and fill up $subthread
  // use the recursive helper-function thread_getsubthreadids_recursive
  $subthread=thread_getsubthreadids_recursive($id);
  return $subthread;
}

?>
