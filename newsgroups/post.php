<?php
/*  Newsportal NNTP<->HTTP Gateway
 *  Download: http://florian-amrhein.de/newsportal
 *
 *  Copyright (C) 2002-2004 Florian Amrhein
 *  E-Mail: florian.amrhein@gmx.de
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

@$newsgroups=$_REQUEST["newsgroups"];
@$group=$_REQUEST["group"];
@$type=$_REQUEST["type"];
@$subject=stripslashes($_REQUEST["subject"]);
@$name=$_REQUEST["name"];
@$email=$_REQUEST["email"];
@$body=stripslashes($_REQUEST["body"]);
@$abspeichern=$_REQUEST["abspeichern"];
@$references=$_REQUEST["references"];
@$id=$_REQUEST["id"];
if (!isset($group)) $group=$newsgroups;

include "config.inc.php";
include "auth.inc";

// Save name and email in cookies
if (($setcookies==true) && (isset($abspeichern)) && ($abspeichern=="ja")) {
  setcookie("cookie_name",stripslashes($name),time()+(3600*24*90));
  setcookie("cookie_email",$email,time()+(3600*24*90));
} 
if ((isset($post_server)) && ($post_server!=""))
  $server=$post_server;
if ((isset($post_port)) && ($post_port!=""))
  $port=$post_port;

 include "head.inc";
 include $file_newsportal;


?>
<?php

  // has the user write-rights on the newsgroups?
  if((function_exists("npreg_group_has_read_access") &&
      !npreg_group_has_read_access($group)) ||
     (function_exists("npreg_group_is_visible") &&
      !npreg_group_is_visible($group)) ||
     (function_exists("npreg_group_has_write_access") &&
      !npreg_group_has_write_access($group))) {
    die("access denied");
  }


// Load name and email from cookies
if ($setcookies) {
  if ((isset($_COOKIE["cookie_name"])) && (!isset($name)))
    $name=$_COOKIE["cookie_name"];
  if ((isset($_COOKIE["cookie_email"])) && (!isset($email)))
    $email=$_COOKIE["cookie_email"];
}

// Load name and email from the registration system, if available
if(function_exists("npreg_get_firstname")) {
  $name=npreg_get_firstname();
  $form_noname=true;
  if(function_exists("npreg_get_lastname"))
    $name.=" ".npreg_get_lastname();
}

if(function_exists("npreg_get_email")) {
  $email=npreg_get_email();
  $form_noemail=true;
}

if((!isset($references)) || ($references=="")) {
  $references=false;
}

if (!isset($type)) {
  $type="new";
}

if ($type=="new") {
  $subject="";
  $bodyzeile="";
  $show=1;
}



// Is there a new article to be bost to the newsserver?
if ($type=="post") {
  $show=0;
  // error handling
  if (trim($body)=="") {
    $type="retry";
    $error=$text_post["missing_message"];
  }
  if ((trim($email)=="") && (!isset($anonym_address))) {
    $type="retry";
    $error=$text_post["missing_email"];
  }
  if (($email) && (!validate_email(trim($email)))) {
    $type="retry";
    $error=$text_post["error_wrong_email"];
  }
  if (trim($name)=="") {
    $type="retry";
    $error=$text_post["missing_name"];
  }
  if (trim($subject)=="") {
    $type="retry";
    $error=$text_post["missing_subject"];
  }
  if ($type=="post") {
    if (!$readonly) {
      // post article to the newsserver
      if($references)
        $references_array=explode(" ",$references);
      else
        $references_array=false;
      if(($email=="") && (isset($anonym_address)))
        $nemail=$anonym_address;
      else
        $nemail=$email;
      $message=message_post($subject,
                 $nemail." (".$name.")",
                 $newsgroups,$references_array,addslashes($body));
      // Article sent without errors, or duplicate?
      if ((substr($message,0,3)=="240") ||
          (substr($message,0,7)=="441 435")) {
?>

<h1 class="np_post_headline"><?php echo $text_post["message_posted"];?></h1>

<p><?php echo $text_post["message_posted2"];?></p>

<p><a href="<?php echo $file_thread.'?group='.urlencode($group).'">'.$text_post["button_back"].'</a> '
     .$text_post["button_back2"].' '.urlencode($group) ?></p>
<?
      } else {
        // article not accepted by the newsserver
        $type="retry";
        $error=$text_post["error_newsserver"]."<br><pre>$message</pre>";
      }
    } else {
      echo $text_post["error_readonly"];
    }
  }
}

// A reply of an other article.
if ($type=="reply") {
  $message=message_read($id,0,$group);
  $head=$message->header;
  $body=explode("\n",$message->body[0]);
  nntp_close($ns);
  if ($head->name != "") {
    $bodyzeile=$head->name;
  } else {
    $bodyzeile=$head->from;
  }
  $bodyzeile=$text_post["wrote_prefix"].$bodyzeile.
             $text_post["wrote_suffix"]."\n\n";
  for ($i=0; $i<=count($body)-1; $i++) {
    if((isset($cutsignature)) && ($cutsignature==true) &&
       ($body[$i]=='-- '))
      break;
    if (trim($body[$i])!="") {
      if($body[$i][0]=='>')
        $bodyzeile.=">".$body[$i]."\n";
      else
        $bodyzeile.="> ".$body[$i]."\n";
    } else {
      $bodyzeile.="\n";
    }
  }
  $subject=$head->subject;
  if (isset($head->followup) && ($head->followup != "")) {
    $newsgroups=$head->followup;
  } else {
    $newsgroups=$head->newsgroups;
  }
  splitSubject($subject);
  $subject="Re: ".$subject;
  // Cut off old parts of a subject
  // for example: 'foo (was: bar)' becomes 'foo'.
  $subject=eregi_replace('(\(wa[sr]: .*\))$','',$subject);
  $show=1;
  $references=false;
  if (isset($head->references[0])) {
    for ($i=0; $i<=count($head->references)-1; $i++) {
      $references .= $head->references[$i]." ";
    }
  }
  $references .= $head->id;
}

if ($type=="retry") {
  $show=1;
  $bodyzeile=$body;
}

if ($show==1) {

if ($testgroup) {
  $testnewsgroups=testgroups($newsgroups);
} else {
  $testnewsgroups=$newsgroups;
}

if ($testnewsgroups == "") {
  echo $text_post["followup_not_allowed"];
  echo " ".$newsgroups;
} else {
  $newsgroups=$testnewsgroups;

  echo '<h1 class="np_post_headline">'.$text_post["group_head"].$newsgroups
    .$text_post["group_tail"].'</h1>';

  if (isset($error)) echo "<p>$error</p>"; ?>

<form action="<?php echo $file_post?>" method="post" name="postform">

<div class="np_post_header">
<table>
<tr><td align="right"><b><?php echo $text_header["subject"] ?></b></td>
<td><input type="text" name="subject" value="<?
echo htmlspecialchars($subject);?>" size="40" maxlength="80"></td></tr>
<tr><td align="right"><b><?=$text_post["name"]?></b></td>
 <td align="left">
 <?
 if($form_noname===true) {
   echo htmlspecialchars($name);
 } else {
   echo '<input type="text" name="name"';
   if (isset($name)) echo 'value="'.
    htmlspecialchars(stripslashes($name)).'"';
   echo 'size="40" maxlength="40">';
 }
 ?>
 </td></tr>
 <tr><td align="right"><b><?=$text_post["email"]?></b></td>
 <td align="left">
 <?
 if($form_noemail===true) {
   echo htmlspecialchars($email);
 } else {
   echo '<input type="text" name="email"';
   if (isset($email)) echo 'value="'.htmlspecialchars(stripslashes($email)).'"';
   echo 'size="40" maxlength="40">';
 }
 ?>
 </td></tr>
</table>
</div>

<div class="np_post_body">
<table>
<tr><td><b><?php echo $text_post["message"];?></b><br>
<textarea id="postbody" name="body" rows="20" cols="79" wrap="virtual"><?
if ((isset($bodyzeile)) && ($post_autoquote))
  echo htmlspecialchars($bodyzeile); ?>
</textarea></td></tr>
<tr><td>

<?php if(!$post_autoquote) { ?>
<input type="hidden" id="hidebody" value="<?
if (isset($bodyzeile)) echo htmlspecialchars(stripslashes($bodyzeile)); ?>">

<script language="JavaScript">
<!--
function quoten() {
  document.getElementById("postbody").value=document.getElementById("hidebody").value;
  document.getElementById("hidebody").value="";
}
//-->
</script>


<input tabindex="100" type="Button" name="quote" value="<?=$text_post["quote"]?>" onclick="quoten()">

<?php } ?>

<input type="submit"  value="<?php echo $text_post["button_post"];?>">
<?php if ($setcookies==true) { ?>
<input type="checkbox" name="abspeichern" value="ja">
<?php echo $text_post["remember"];?>
<?php } ?>
</td>
</tr>
</table>
</div>
<input type="hidden" name="type" value="post">
<input type="hidden" name="newsgroups" value="<?=htmlspecialchars($newsgroups); ?>">
<input type="hidden" name="references" value="<?=htmlentities($references); ?>">
<input type="hidden" name="group" value="<?=htmlspecialchars($group); ?>">
</form>

<?php } } ?>

<?php include "tail.inc"; ?>
