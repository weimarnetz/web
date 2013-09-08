<?
/*
 *  NewsPortal: Functions for posting articles to a newsgroup
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
 * Encode lines with 8bit-characters to quote-printable
 *
 * $line: the to be encoded line
 *
 * the function returns a sting containing the quoted-printable encoded
 * $line
 */
function quoted1_printable_encode($line) {
  global $www_charset;
  $qp_table=array(
     '=00', '=01', '=02', '=03', '=04', '=05',
     '=06', '=07', '=08', '=09', '=0A', '=0B',
     '=0C', '=0D', '=0E', '=0F', '=10', '=11',
     '=12', '=13', '=14', '=15', '=16', '=17',
     '=18', '=19', '=1A', '=1B', '=1C', '=1D',
     '=1E', '=1F', '_',   '!',   '"',   '#',
     '$',   '%',   '&',   "'",   '(',   ')',
     '*',   '+',   ',',   '-',   '.',   '/',
     '0',   '1',   '2',   '3',   '4',   '5',
     '6',   '7',   '8',   '9',   ':',   ';',
     '<',   '=3D', '>',   '=3F', '@',   'A',
     'B',   'C',   'D',   'E',   'F',   'G',
     'H',   'I',   'J',   'K',   'L',   'M',
     'N',   'O',   'P',   'Q',   'R',   'S',
     'T',   'U',   'V',   'W',   'X',   'Y',
     'Z',   '[',   '\\',  ']',   '^',   '=5F',
     '',    'a',   'b',   'c',   'd',   'e',
     'f',   'g',   'h',   'i',   'j',   'k',
     'l',   'm',   'n',   'o',   'p',   'q',
     'r',   's',   't',   'u',   'v',   'w',
     'x',   'y',   'z',   '{',   '|',   '}',
     '~',   '=7F', '=80', '=81', '=82', '=83',
     '=84', '=85', '=86', '=87', '=88', '=89',
     '=8A', '=8B', '=8C', '=8D', '=8E', '=8F',
     '=90', '=91', '=92', '=93', '=94', '=95',
     '=96', '=97', '=98', '=99', '=9A', '=9B',
     '=9C', '=9D', '=9E', '=9F', '=A0', '=A1',
     '=A2', '=A3', '=A4', '=A5', '=A6', '=A7',
     '=A8', '=A9', '=AA', '=AB', '=AC', '=AD',
     '=AE', '=AF', '=B0', '=B1', '=B2', '=B3',
     '=B4', '=B5', '=B6', '=B7', '=B8', '=B9',
     '=BA', '=BB', '=BC', '=BD', '=BE', '=BF',
     '=C0', '=C1', '=C2', '=C3', '=C4', '=C5',
     '=C6', '=C7', '=C8', '=C9', '=CA', '=CB',
     '=CC', '=CD', '=CE', '=CF', '=D0', '=D1',
     '=D2', '=D3', '=D4', '=D5', '=D6', '=D7',
     '=D8', '=D9', '=DA', '=DB', '=DC', '=DD',
     '=DE', '=DF', '=E0', '=E1', '=E2', '=E3',
     '=E4', '=E5', '=E6', '=E7', '=E8', '=E9',
     '=EA', '=EB', '=EC', '=ED', '=EE', '=EF',
     '=F0', '=F1', '=F2', '=F3', '=F4', '=F5',
     '=F6', '=F7', '=F8', '=F9', '=FA', '=FB',
     '=FC', '=FD', '=FE', '=FF');
  // are there "forbidden" characters in the string?
  for($i=0; $i<strlen($line) && ord($line[$i])<=127 ; $i++);
  if ($i<strlen($line)) { // yes, there are. So lets encode them!
    $from=$i;
    for($to=strlen($line)-1; ord($line[$to])<=127; $to--);
    // lets scan for the start and the end of the to be encoded _words_
    for(;$from>0 && $line[$from] != ' '; $from--);
    if($from>0) $from++;
    for(;$to<strlen($line) && $line[$to] != ' '; $to++);
    // split the string into the to be encoded middle and the rest
    $begin=substr($line,0,$from);
    $middle=substr($line,$from,$to-$from);
    $end=substr($line,$to);
    // ok, now lets encode $middle...
    $newmiddle="";
    for($i=0; $i<strlen($middle); $i++)
      $newmiddle .= $qp_table[ord($middle[$i])];
    // now we glue the parts together...
    $line=$begin.'=?'.$www_charset.'?Q?'.$newmiddle.'?='.$end;
  }
  return $line;
}

/*
 * generate a message-id for posting.
 * $identity: a string containing informations about the article, to
 *     make a md5-hash out of it.
 *
 * returns: a complete message-id
 */
function generate_msgid($identity) {
  global $msgid_generate,$msgid_fqdn;
  switch($msgid_generate) {
    case "no":
      // no, we don't want to generate a message-id.
      return false;
      break;
    case "md5":
      return '<'.md5($identity).'$1@'.$msgid_fqdn.'>';
      break;
    default:
      return false;
      break;
  }
}

/*
 * Post an article to a newsgroup
 *
 * $subject: The Subject of the article
 * $from: The authors name and email of the article
 * $newsgroups: The groups to post to
 * $ref: The references of the article
 * $body: The article itself
 */
function message_post($subject,$from,$newsgroups,$ref,$body) {
  global $server,$port,$send_poster_host,$organization,$text_error;
  global $file_footer,$www_charset,$spooldir;
  global $msgid_generate,$msgid_fqdn;
  flush();
  $ns=nntp_open($server,$port);
  if ($ns != false) {
    fputs($ns,"POST\r\n");
    $weg=line_read($ns);
    fputs($ns,'Subject: '.quoted_printable_encode($subject)."\r\n");
    fputs($ns,'From: '.$from."\r\n");
    fputs($ns,'Newsgroups: '.$newsgroups."\r\n");
    fputs($ns,"Mime-Version: 1.0\r\n");
    fputs($ns,"Content-Type: text/plain; charset=".$www_charset."; format=flowed\r\n");
    fputs($ns,"Content-Transfer-Encoding: 8bit\r\n");
    fputs($ns,"User-Agent: NewsPortal/0.36 (http://florian-amrhein.de/newsportal)\r\n");
    if ($send_poster_host)
      @fputs($ns,'X-HTTP-Posting-Host: '.gethostbyaddr(getenv("REMOTE_ADDR"))."\r\n");
    if (($ref!=false) && (count($ref)>0)) {
      // strip references
      if(strlen(implode(" ",$ref))>900) {
        $ref_first=array_shift($ref);
        do {
          $ref=array_slice($ref,1);
        } while(strlen(implode(" ",$ref))>800);
        array_unshift($ref,$ref_first);
      }
      fputs($ns,'References: '.implode(" ",$ref)."\r\n");
    }
    if (isset($organization))
      fputs($ns,'Organization: '.quoted_printable_encode($organization)."\r\n");
    if ((isset($file_footer)) && ($file_footer!="")) {
      $footerfile=fopen($file_footer,"r");
      $body.="\n".fread($footerfile,filesize($file_footer));
      fclose($footerfile);
    }
    if($msgid=generate_msgid(
                 $subject.",".$from.",".$newsgroups.",".$ref.",".$body))
      fputs($ns,'Message-ID: '.$msgid."\r\n");
    $body=str_replace("\n.\r","\n..\r",$body);
    $body=str_replace("\r",'',$body);
    $b=split("\n",$body);
    $body="";
    for ($i=0; $i<count($b); $i++) {
      if ((strpos(substr($b[$i],0,strpos($b[$i]," ")),">") != false) | (strcmp(substr($b[$i],0,1),">") == 0)) {
        $body .= textwrap(stripSlashes($b[$i]),78," \r\n")."\r\n";
      } else {
        $body .= textwrap(stripSlashes($b[$i]),74," \r\n")."\r\n";
      }
    }
    fputs($ns,"\r\n".$body."\r\n.\r\n");
    $message=line_read($ns);
    nntp_close($ns);
  } else {
    $message=$text_error["post_failed"];
  }
  // let thread.php ignore the cache for this group, so this new
  // article will be visible instantly
  $cachefile=$spooldir.'/'.$newsgroups.'-cache.txt';
  @unlink($cachefile);
  return $message;
}
?>
