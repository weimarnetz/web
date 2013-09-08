<?
/*  Newsportal NNTP<->HTTP Gateway
 *  Version: 0.36
 *  Download: http://florian-amrhein.de/newsportal
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

include "lib/types.inc.php";
include "lib/thread.inc.php";
include "lib/message.inc.php";
include "lib/post.inc.php";
//include "lib/validator.inc.php";

/*
 * opens the connection to the NNTP-Server
 *
 * $server: adress of the NNTP-Server
 * $port: port of the server
 */
function nntp_open($nserver=0,$nport=0) {
  global $text_error,$server_auth_user,$server_auth_pass,$readonly;
  global $server,$port;
  // echo "<br>NNTP OPEN<br>";
  $authorize=((isset($server_auth_user)) && (isset($server_auth_pass)) &&
              ($server_auth_user != ""));
  if ($nserver==0) $nserver=$server;
  if ($nport==0) $nport=$port;
  $ns=@fsockopen($nserver,$nport);
  $weg=line_read($ns);  // kill the first line
  if (substr($weg,0,2) != "20") {
    echo "<p>".$text_error["error:"].$weg."</p>";
    fclose($ns);
    $ns=false;
  } else {
    if ($ns != false) {
      fputs($ns,"MODE reader\r\n");
      $weg=line_read($ns);  // and once more
      if ((substr($weg,0,2) != "20") && 
          ((!$authorize) || ((substr($weg,0,3) != "480") && ($authorize)))) {
        echo "<p>".$text_error["error:"].$weg."</p>";
        fclose($ns);
        $ns=false;
      }
    }
    if ((isset($server_auth_user)) && (isset($server_auth_pass)) &&
        ($server_auth_user != "")) {
      fputs($ns,"AUTHINFO USER $server_auth_user\r\n");
      $weg=line_read($ns);
      fputs($ns,"AUTHINFO PASS $server_auth_pass\r\n"); 
      $weg=line_read($ns);
      if (substr($weg,0,3) != "281") {
        echo "<p>".$text_error["error:"]."</p>";
        echo "<p>".$text_error["auth_error"]."</p>";
      }
    }
  }
  if ($ns==false) echo "<p>".$text_error["connection_failed"]."</p>";
  return $ns;
}

/*
 * Close a NNTP connection
 *
 * $ns: the handle of the connection
 */
function nntp_close(&$ns) {
  if ($ns != false) {
    fputs($ns,"QUIT\r\n");
    fclose($ns);
  }
}

/*
 * Validates an email adress
 *
 * $address: a string containing the email-address to be validated
 *
 * returns true if the address passes the tests, false otherwise.
 */
function validate_email($address)
{
  global $validate_email;
  $return=true;
  if (($validate_email >= 1) && ($return == true))
    $return = (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_A-z{|}~]+'.'@'.
               '[-!#$%&\'*+\\/0-9=?A-Z^_A-z{|}~]+\.'.
               '[-!#$%&\'*+\\./0-9=?A-Z^_A-z{|}~]+$',$address));
  if (($validate_email >= 2) && ($return == true)) {
    $addressarray=address_decode($address,"garantiertungueltig");
    $return=checkdnsrr($addressarray[0]["host"],"MX");
    if (!$return) $return=checkdnsrr($addressarray[0]["host"],"A");
  }
  return($return);
}

/*
 * decodes a block of 7bit-data in uuencoded format to it's original
 * 8bit format.
 * The headerline containing filename and permissions doesn't have to
 * be included.
 * 
 * $data: The uuencoded data as a string
 *
 * returns the 8bit data as a string
 *
 * Note: this function is very slow and doesn't recognize incorrect code.
 */
function uudecode_line($line) {
  $data=substr($line,1);
  $length=ord($line[0])-32;
  $decoded="";
  for ($i=0; $i<(strlen($data)>>2); $i++) {
    $pack=substr($data,$i<<2,4);
    $upack="";
    $bitmaske=0;
    for ($o=0; $o<4; $o++) {
      $g=((ord($pack[3-$o])-32));
      if ($g==64) $g=0;
      $bitmaske=$bitmaske | ($g << (6*$o));
    }
    $schablone=255;
    for ($o=0; $o<3; $o++) {
      $c=($bitmaske & $schablone) >> ($o << 3);
      $schablone=($schablone << 8);
      $upack=chr($c).$upack;
    }
    $decoded.=$upack;
  }
  $decoded=substr($decoded,0,$length);
  return $decoded;
}

/*
 * decodes uuencoded Attachments.
 *
 * $data: the encoded data
 *
 * returns the decoded data
 */
function uudecode($data) {
  $d=explode("\n",$data);
  $u="";
  for ($i=0; $i<count($d)-1; $i++)
    $u.=uudecode_line($d[$i]);
  return $u;
}

/*
 * returns the mimetype of an filename
 *
 * $name: the complete filename of a file
 *
 * returns a string containing the mimetype
 */
function get_mimetype_by_filename($name) {
  $ending=strtolower(strrchr($name,"."));
  switch($ending) {
    case ".jpg":
    case ".jpeg":
      $type="image/jpeg";
      break;
    case ".gif":
      $type="image/gif";
      break;
    case ".png":
      $type="image/png";
      break;
    case ".bmp":
      $type="image/bmp";
      break;
    default:
      $type="text/plain";
  }
  return $type;
}

/*
 * Test, if the access to a group is allowed. This is true, if $testgroup is
 * false or the groupname is in groups.txt
 *
 * $groupname: name of the group to be checked
 *
 * returns true, if access is allowed
 */
function testGroup($groupname) {
  global $testgroup,$file_groups;
  if ($testgroup) {
    $gf=fopen($file_groups,"r");
    while (!feof($gf)) {
      $read=trim(line_read($gf));
      $pos=strpos($read," ");
      if ($pos != false) {
        if (substr($read,0,$pos)==trim($groupname)) return true;
      } else {
        if ($read == trim($groupname)) return true;
      }
    }
    fclose($gf);
    return false;
  } else {
    return true;
  }
}

function testGroups($newsgroups) {
  $groups=explode(",",$newsgroups);
  $count=count($groups);
  $return="";
  $o=0;
  for ($i=0; $i<$count; $i++) {
    if (testgroup($groups[$i]) &&
        (!function_exists("npreg_group_has_write_access") || 
         npreg_group_has_write_access($groups[$i]))) {
      if ($o>0) $return.=",";
      $o++;
      $return.=$groups[$i];
    }
  }
  return($return);
}

/*
 * read one line from the NNTP-server
 */
function line_read(&$ns) {
  if ($ns != false) {
    $t=str_replace("\n","",str_replace("\r","",fgets($ns,1200)));
    return $t;
  }
}

/*
 * Split an internet-address string into its parts. An address string could
 * be for example:
 * - user@host.domain (Realname)
 * - "Realname" <user@host.domain>
 * - user@host.domain
 *
 * The address will be split into user, host (incl. domain) and realname
 *
 * $adrstring: The string containing the address in internet format
 * $defaulthost: The name of the host which should be returned if the
 *               address-string doesn't contain a hostname.
 *
 * returns an hash containing the fields "mailbox", "host" and "personal"
 */
function address_decode($adrstring,$defaulthost) {
  $parsestring=trim($adrstring);
  $len=strlen($parsestring);
  $at_pos=strpos($parsestring,'@');     // find @
  $ka_pos=strpos($parsestring,"(");     // find (
  $kz_pos=strpos($parsestring,')');     // find )
  $ha_pos=strpos($parsestring,'<');     // find <
  $hz_pos=strpos($parsestring,'>');     // find >
  $space_pos=strpos($parsestring,')');  // find ' '
  $email="";
  $mailbox="";
  $host="";
  $personal="";
  if ($space_pos != false) {
    if (($ka_pos != false) && ($kz_pos != false)) {
      $personal=substr($parsestring,$ka_pos+1,$kz_pos-$ka_pos-1);
      $email=trim(substr($parsestring,0,$ka_pos-1));
    }
  } else {
    $email=$adrstring;
  }
  if (($ha_pos != false) && ($hz_pos != false)) {
    $email=trim(substr($parsestring,$ha_pos+1,$hz_pos-$ha_pos-1));
    $personal=substr($parsestring,0,$ha_pos-1);
  }
  if ($at_pos != false) {
    $mailbox=substr($email,0,strpos($email,'@'));
    $host=substr($email,strpos($email,'@')+1);
  } else {
    $mailbox=$email;
    $host=$defaulthost;
  }
  $personal=trim($personal);
  if (substr($personal,0,1) == '"') $personal=substr($personal,1);
  if (substr($personal,strlen($personal)-1,1) == '"')
    $personal=substr($personal,0,strlen($personal)-1);
  $result["mailbox"]=trim($mailbox);
  $result["host"]=trim($host);
  if ($personal!="") $result["personal"]=$personal;
  $complete[]=$result;
  return ($complete);
}

/*
 * Read the groupnames from groups.txt, and get additional informations
 * of the groups from the newsserver
 */
function groups_read($server,$port) {
  global $gl_age,$file_groups,$spooldir,$cache_index;
  // is there a cached version, and is it actual enough?
  $cachefile=$spooldir.'/groups.dat';
  if((file_exists($cachefile)) && (filemtime($cachefile)+$cache_index>time())) {
    // cached file exists and is new enough. so lets read it out.
    $file=fopen($cachefile,"r");
    $data="";
    while(!feof($file)) {
      $data.=fgets($file,1000);
    }
    fclose($file);
    $newsgroups=unserialize($data);
  } else {
    $ns=nntp_open($server,$port);
    if ($ns == false) return false;
    $gf=fopen($file_groups,"r");
    // if we want to mark groups with new articles with colors, wie will later
    // need the format of the overview
    $overviewformat=thread_overview_read($ns);
    while (!feof($gf)) {
      $gruppe=new newsgroupType;
      $tmp=trim(line_read($gf));
      if(substr($tmp,0,1)==":") {
        $gruppe->text=substr($tmp,1);
        $newsgroups[]=$gruppe;  
      } elseif(strlen(trim($tmp))>0) {
        // is there a description in groups.txt?
        $pos=strpos($tmp," ");
        if ($pos != false) {
          // yes.
          $gruppe->name=substr($tmp,0,$pos);
          $desc=substr($tmp,$pos);
        } else {
          // no, get it from the newsserver.
          $gruppe->name=$tmp;
          fputs($ns,"XGTITLE $gruppe->name\r\n");
          $response=line_read($ns);
          if (strcmp(substr($response,0,3),"282") == 0) {
            $neu=line_read($ns);
            do {
              $response=$neu;
              if ($neu != ".") $neu=line_read($ns);
            } while ($neu != ".");
            $desc=strrchr($response,"\t");
            if (strcmp($response,".") == 0) {
              $desc="-";
            }
          } else {
            $desc=$response;
          }
          if (strcmp(substr($response,0,3),"500") == 0)
            $desc="-";
        }
        if (strcmp($desc,"") == 0) $desc="-";
        $gruppe->description=$desc;
        fputs($ns,"GROUP ".$gruppe->name."\r\n"); 
        $t=explode(" ",line_read($ns));
        $gruppe->count=$t[1];
        // mark group with new articles with colors
        if($gl_age) {
          fputs($ns,'XOVER '.$t[3]."\r\n");
          $tmp=explode(" ",line_read($ns));
          if($tmp[0]=="224") {
            $tmp=line_read($ns);
            if($tmp!=".") {
              $head=thread_overview_interpret($tmp,$overviewformat,$gruppe->name);
              $tmp=line_read($ns);
              $gruppe->age=$head->date;
            }
          }
        }
        if ((strcmp(trim($gruppe->name),"") != 0) &&
            (substr($gruppe->name,0,1) != "#"))
          $newsgroups[]=$gruppe;
      }
    }
    fclose($gf);
    nntp_close($ns);
    // write the data to the cachefile
    $file=fopen($cachefile,"w");
    fputs($file,serialize($newsgroups));
    fclose($file);
  }
  return $newsgroups;
}

/*
 * print the group names from an array to the webpage
 */
function groups_show($gruppen) {
  global $gl_age;
  if ($gruppen == false) return;
  global $file_thread,$text_groups;
  $c = count($gruppen);
  echo '<div class="np_index_groupblock">';
  $acttype="keins";
  for($i = 0 ; $i < $c ; $i++) {
    $g = $gruppen[$i];
    if(isset($g->text)) {
      if($acttype!="text") {
        $acttype="text";
        if($i>0)
          echo '</div>';
        echo '<div class="np_index_grouphead">';
      }
      echo $g->text;
    } else {
      if($acttype!="group") {
        $acttype="group";
        if($i>0)
          echo '</div>';
        echo '<div class="np_index_groupblock">';
      }
      echo '<div class="np_index_group">';
      echo '<a ';
      if ((isset($frame_threadframeset)) && ($frame_threadframeset != ""))
        echo 'target="'.$frame_threadframeset.'" ';
      echo 'href="'.$file_thread.'?group='.urlencode($g->name).'">'.$g->name."</a>\n";
      if($gl_age)
        $datecolor=thread_format_date_color($g->age);
      echo '<small>(';
      if($datecolor!="")
        echo '<font color="'.$datecolor.'">'.$g->count.'</font>';
      else
        echo $g->count;
      echo ')</small>';
      if($g->description!="-")
        echo '<br><small>'.$g->description.'</small>';
      echo '</div>';
    }
    echo "\n";
    flush();
  }
  echo "</div></div>\n";
}

/*
 * gets a list of aviable articles in the group $groupname
 */
/*
function getArticleList(&$ns,$groupname) {
  fputs($ns,"LISTGROUP $groupname \r\n");
  $line=line_read($ns);
  $line=line_read($ns);
  while(strcmp($line,".") != 0) {
    $articleList[] = trim($line);
    $line=line_read($ns);
  }
  if (!isset($articleList)) $articleList="-";
  return $articleList;
}
*/

/*
 * Decode quoted-printable or base64 encoded headerlines
 *
 * $value: The to be decoded line
 *
 * returns the decoded line
 */
function headerDecode($value) {
  if (eregi('=\?.*\?.\?.*\?=',$value)) { // is there anything encoded?
    if (eregi('=\?.*\?Q\?.*\?=',$value)) {  // quoted-printable decoding

      $charset=eregi_replace('(.*)=\?(.*)\?Q\?(.*)\?=(.*)','\2',$value);
      $result1=eregi_replace('(.*)=\?.*\?Q\?(.*)\?=(.*)','\1',$value);
      $result2=eregi_replace('(.*)=\?.*\?Q\?(.*)\?=(.*)','\2',$value);
      $result3=eregi_replace('(.*)=\?.*\?Q\?(.*)\?=(.*)','\3',$value);
      $result2=str_replace("_"," ",quoted_printable_decode($result2));
      $newvalue=$result1.recode_charset($result2,$charset).$result3;
    }
    if (eregi('=\?.*\?B\?.*\?=',$value)) {  // base64 decoding
      $result1=eregi_replace('(.*)=\?.*\?B\?(.*)\?=(.*)','\1',$value);
      $result2=eregi_replace('(.*)=\?.*\?B\?(.*)\?=(.*)','\2',$value);
      $result3=eregi_replace('(.*)=\?.*\?B\?(.*)\?=(.*)','\3',$value);
      $result2=base64_decode($result2);
      $newvalue=$result1.$result2.$result3;
    }
    if (!isset($newvalue)) // nothing of the above, must be an unknown encoding...
      $newvalue=$value;
    else
      $newvalue=headerDecode($newvalue);  // maybe there are more encoded
    return($newvalue);                    // parts
  } else {   // there wasn't anything encoded, return the original string
    return($value);
  }
}

/*
 * calculates an Unix timestamp out of a Date-Header in an article
 *
 * $value: Value of the Date: header
 *
 * returns an Unix timestamp
 */
function getTimestamp($value) {
  global $timezone;
  $months=array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
  $value=str_replace("  "," ",$value);
  $d=split(" ",$value,6);
  if (strcmp(substr($d[0],strlen($d[0])-1,1),",") == 0) {
    $date[0]=$d[1];  // day
    $date[1]=$d[2];  // month
    $date[2]=$d[3];  // year
    $date[3]=$d[4];  // hours:minutes:seconds
    $gmt=$d[5];      // timezone
  } else {
    $date[0]=$d[0];  // day
    $date[1]=$d[1];  // month
    $date[2]=$d[2];  // year
    $date[3]=$d[3];  // hours:minutes:seconds
    $gmt=$d[4];      // timezone
  }
  $time=split(":",$date[3]);
  // timezone handling
  $msgtimezone=0;
  if ($gmt[0]=='-') {
    $msgtimezone=-substr($gmt,1,2);
    $msgminzone=-substr($gmt,3,2);
  } else if ($gmt[0]=='+') {
    $msgtimezone=+substr($gmt,1,2);
    $msgminzone=+substr($gmt,3,2);
  }
  $time[0]=$time[0]-$msgtimezone+$timezone;
  $time[1]=$time[1]-$msgminzone+$minzone;
  $timestamp=mktime($time[0],$time[1],$time[2],$months[$date[1]],$date[0],$date[2]);
  return $timestamp;
}

function parse_header($hdr,$number="") {
  for ($i=count($hdr)-1; $i>0; $i--)
    if (preg_match("/^(\x09|\x20)/",$hdr[$i]))
      $hdr[$i-1]=$hdr[$i-1]." ".ltrim($hdr[$i]);
  $header = new headerType;
  $header->isAnswer=false;
  for ($count=0;$count<count($hdr);$count++) {
    $variable=substr($hdr[$count],0,strpos($hdr[$count]," "));
    $value=trim(substr($hdr[$count],strpos($hdr[$count]," ")+1));
      switch (strtolower($variable)) {
        case "from:": 
          $fromline=address_decode(headerDecode($value),"nirgendwo");
          if (!isset($fromline[0]["host"])) $fromline[0]["host"]="";
          $header->from=$fromline[0]["mailbox"]."@".$fromline[0]["host"];
          $header->username=$fromline[0]["mailbox"];
          if (!isset($fromline[0]["personal"])) {
            $header->name="";
          } else {
            $header->name=$fromline[0]["personal"];
          }
          break;
        case "message-id:":
          $header->id=$value;
          break;
        case "subject:":
          $header->subject=headerDecode($value);
          break;
        case "newsgroups:":
          $header->newsgroups=$value;
          break;
        case "organization:":
          $header->organization=headerDecode($value);
          break;
        case "content-transfer-encoding:":
          $header->content_transfer_encoding=trim(strtolower($value));
          break; 
        case "content-type:":
          $header->content_type=array();
          $subheader=split(";",$value);
          $header->content_type[0]=strtolower(trim($subheader[0]));
          for ($i=1; $i<count($subheader); $i++) {
            $gleichpos=strpos($subheader[$i],"=");
            if ($gleichpos) {
              $subvariable=trim(substr($subheader[$i],0,$gleichpos));
              $subvalue=trim(substr($subheader[$i],$gleichpos+1));
              if (($subvalue[0]=='"') &&
                  ($subvalue[strlen($subvalue)-1]=='"'))
                $subvalue=substr($subvalue,1,strlen($subvalue)-2);
              switch($subvariable) {
                case "charset":
                  $header->content_type_charset=array(strtolower($subvalue));
                  break;
                case "name":
                  $header->content_type_name=array($subvalue);
                  break;
                case "boundary":
                  $header->content_type_boundary=$subvalue;
                  break;
                case "format":
                  $header->content_type_format=array($subvalue);
              }
            }
          }
          break;
        case "references:":
          $ref=trim($value);
          while (strpos($ref,"> <") != false) {
            $header->references[]=substr($ref,0,strpos($ref," "));
            $ref=substr($ref,strpos($ref,"> <")+2);
          }
          $header->references[]=trim($ref);
          break;
        case "date:":
          $header->date=getTimestamp(trim($value));
          break;
        case "followup-to:":
          $header->followup=trim($value);
          break;
        case "x-newsreader:":
        case "x-mailer:":
        case "user-agent:":
          $header->user_agent=trim($value);
          break;
        case "x-face:": // not ready
//          echo "<p>-".base64_decode($value)."-</p>";
          break;
        case "x-no-archive:":
          $header->xnoarchive=strtolower(trim($value));
      }
  }
  if (!isset($header->content_type[0]))
    $header->content_type[0]="text/plain";
  if (!isset($header->content_transfer_encoding))
    $header->content_transfer_encoding="8bit";
  if ($number != "") $header->number=$number;
  return $header;
}

/*
 * convert the charset of a text
 */
function recode_charset($text,$source=false,$dest=false) {
  global $iconv_enable,$www_charset;
  if($dest==false)
    $dest=$www_charset;
  if(($iconv_enable) && ($source!=false)) {
    $return=iconv($source,
                 $dest."//TRANSLIT",$text);
    if($return!="")
      return $return;
    else
      return $text;
  } else {
    return $text;
  }
}

function decode_body($body,$encoding) {
  $bodyzeile="";
  switch ($encoding) {
    case "base64":
      $body=base64_decode($body);
      break;
    case "quoted-printable":
      $body=Quoted_printable_decode($body);
      $body=str_replace("=\n","",$body);
//    default:
//      $body=str_replace("\n..\n","\n.\n",$body);
  }

  return $body;
}

/*
 * makes URLs clickable
 *
 * $text: A text-line probably containing links.
 *
 * the function returns the text-line with HTML-Links to the links or
 * email-adresses.
 */
function html_parse($text) {
  global $frame_externallink;
  if ((isset($frame_externallink)) && ($frame_externallink != "")) { 
    $target=' TARGET="'.$frame_externallink.'" ';
  } else {
    $target=' ';
  }
  // regular expressions that will be applied to every word in the text
  $regexp_replace=array(
    'http://((\.*([-a-z0-9_/~@?=%#;+]|&amp;)+)+)' =>
      '<a'.$target.'href="http://\1">http://\1</a>',
    '(www\.[-a-z]+\.(de|pl|cz|sk|tk|tv|cc|cx|biz|us|uk|info|int|eu|dk|org|net|at|ch|com))' =>
      '<a'.$target.'href="http://\1">\1</a>',
    'https://([-a-z0-9_./~@?=%#&;\n]+)' =>
      '<a'.$target.'href="https://\1">https://\1</a>',
    'gopher://([-a-z0-9_./~@?=%\n]+)' =>
      '<a'.$target.'href="gopher://\1">gopher://\1</a>',
    'news://([-a-z0-9_./~@?=%\n]+)' =>
      '<a'.$target.'href="news://\1">news://\1</a>',
    'ftp://([-a-z0-9_./~@?=%\n]+)' =>
      '<a'.$target.'href="ftp://\1">ftp://\1</a>',
    //'([-a-z0-9_./n]+)@([-a-z0-9_.]+)' =>
    //  $_SESSION["loggedin"]!==true ? '(e-Mail)' :
    //  '<a href="mailto:\1@\2">\1@\2</a>'
  );
  $ntext="";
  // split every line into it's words
  $words=explode(" ",$text);
  $n=count($words);
  for($i=0; $i<$n; $i++) {
    $word=$words[$i];
    // test, if we need the slow walk through all the regular expressions
    if(eregi('www|\:|@',$word)) {
      // apply the regular expressions to the word until a matching 
      // expression is found
      foreach ($regexp_replace as $key => $value) {
        $nword=eregi_replace($key,$value,$word);
        if($nword!=$word) {
          $word=$nword;
          break;
        }
      }
    }
    // add the spaces between the words
    if($i>0)
      $ntext.=" ";
    $ntext.=$word;
  }
  return($ntext);
}


/*
 * read the header of an article in plaintext into an array
 * $articleNumber can be the number of an article or its message-id.
 */
function readPlainHeader(&$ns,$group,$articleNumber) {
  fputs($ns,"GROUP $group\r\n");
  $line=line_read($ns);
  fputs($ns,"HEAD $articleNumber\r\n");
  $line=line_read($ns);
  if (substr($line,0,3) != "221") {
    echo $text_error["article_not_found"];
    $header=false;
  } else {
    $line=line_read($ns);
    $body="";
    while(strcmp(trim($line),".") != 0) {
      $body .= $line."\n";
      $line=line_read($ns);
    }
    return split("\n",str_replace("\r\n","\n",$body));
  }
}

/*
 * cancel an article on the newsserver
 *
 * DO NOT USE THIS FUNCTION, IF YOU DON'T KNOW WHAT YOU ARE DOING!
 *
 * $ns: The handler of the NNTP-Connection
 * $group: The group of the article
 * $id: the Number of the article inside the group or the message-id
 */
function message_cancel($subject,$from,$newsgroups,$ref,$body,$id) {
  global $server,$port,$send_poster_host,$organization,$text_error;
  global $file_footer,$www_charset;
  flush();
  $ns=nntp_open($server,$port);
  if ($ns != false) {
    fputs($ns,"POST\r\n");
    $weg=line_read($ns);
    fputs($ns,'Subject: '.quoted_printable_encode($subject)."\r\n");
    fputs($ns,'From: '.$from."\r\n");
    fputs($ns,'Newsgroups: '.$newsgroups."\r\n");
    fputs($ns,"Mime-Version: 1.0\r\n");
    fputs($ns,"Content-Type: text/plain; charset=".$www_charset."\r\n");
    fputs($ns,"Content-Transfer-Encoding: 8bit\r\n");
    if ($send_poster_host)
      fputs($ns,'X-HTTP-Posting-Host: '.gethostbyaddr(getenv("REMOTE_ADDR"))."\r\n");
    if ($ref!=false) fputs($ns,'References: '.$ref."\r\n");
    if (isset($organization))
      fputs($ns,'Organization: '.quoted_printable_encode($organization)."\r\n");
    fputs($ns,"Control: cancel ".$id."\r\n");
    if ((isset($file_footer)) && ($file_footer!="")) {
      $footerfile=fopen($file_footer,"r");
      $body.="\n".fread($footerfile,filesize($file_footer));
      fclose($footerfile);
    }
    $body=str_replace("\n.\r","\n..\r",$body);
    $body=str_replace("\r",'',$body);
    $b=split("\n",$body);
    $body="";
    for ($i=0; $i<count($b); $i++) {
      if ((strpos(substr($b[$i],0,strpos($b[$i]," ")),">") != false ) | (strcmp(substr($b[$i],0,1),">") == 0)) {
        $body .= textwrap(stripSlashes($b[$i]),78,"\r\n")."\r\n";
      } else {
        $body .= textwrap(stripSlashes($b[$i]),74,"\r\n")."\r\n";
      }
    }
    fputs($ns,"\r\n".$body."\r\n.\r\n");
    $message=line_read($ns);
    nntp_close($ns);
  } else {
    $message=$text_error["post_failed"];
  }
  return $message;
}

?>