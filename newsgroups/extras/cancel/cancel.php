<?php 
  /* 
   with this script you can delete (cancel) articles.

   DO NOT USE IT, IF YOU DON'T KNOW WHAT A CANCEL IS!

   Especialy, don't use it in UseNet and protect it with a password (with
   .htaccess for example), or anybody can delete any article woldwide!
  */
  die("");
   include "config.inc.php";

    

   // register parameters
   $newsgroups=$_REQUEST["newsgroups"];
   $group=$_REQUEST["group"];
   $type=$_REQUEST["type"];
   $subject=$_REQUEST["subject"];
   $name=$_REQUEST["name"];
   $cancelid=$_REQUEST["cancelid"];
   $email=$_REQUEST["email"];
   $body=$_REQUEST["body"];
   $abspeichern=$_REQUEST["abspeichern"];
   $references=$_REQUEST["references"];
   $id=$_REQUEST["id"];

   include "auth.inc";

   // is access to cancel.php allowed
   if(!function_exists("npreg_user_is_moderator") || !npreg_user_is_moderator($group)) {
     die("access denied");
   }

// Save name and email in cookies
if (($setcookies==true) && (isset($abspeichern)) && ($abspeichern=="ja")) {
  setcookie("cookie_name",stripslashes($name),time()+(3600*24*90));
  setcookie("cookie_email",$email,time()+(3600*24*90));
}


   include "head.inc";
   include $file_newsportal;



// Load name and email from cookies
if ($setcookies) {
  if ((isset($cookie_name)) && (!isset($name))) $name=$cookie_name;
  if ((isset($cookie_email)) && (!isset($email))) $email=$cookie_email;
}

// load name and email from database

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

if (!isset($type)) {
  $type="reply";
}

if (!isset($group)) $group=$newsgroups;

?>
<table><tr><td valign="top">
<?php include "forumnavi.inc.php";?>
</td><td valign="top" width="100%">
<?php

// Is there a new article to be bost to the newsserver?
if ($type=="cancel") {

  $show=0;
  // error handling
  if (trim($body)=="") {
    $type="retry";
    $error=$text_post["missing_message"];
  }
  if (trim($email)=="") {
    $type="retry";
    $error=$text_post["missing_email"];
  }
  if (!validate_email(trim($email))) {
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
  if ($type=="cancel") {
    if (!$readonly) {
      // post article to the newsserver
      $message=message_cancel(quoted_printable_encode(stripslashes($subject)),
                 $email." (".quoted_printable_encode($name).")",
                 $newsgroups,$references,$body,$cancelid);
      // Article sent without errors?
      if (substr($message,0,3)=="240") {
?>

<h1 align="center">Nachricht gelöscht</h1>

<p>Das Cancel wurde erfolgreich verschickt</p>

<p><a href="<?php echo $file_thread.'?group='.urlencode($group).'">'.$text_post["button_back"].'</a> '
     .$text_post["button_back2"].' '.urlencode($group) ?></p>
<?php 
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
  $bodyzeile="Grund für das Löschen:\n\n\n";
  if ($head->name != "") {
    $bodyzeile.=$head->name;
  } else {
    $bodyzeile.=$head->from;
  }
  $bodyzeile.=" schrieb die folgende Nachricht:\n";
  $bodyzeile.="---------------------------------------\n\n";
  for ($i=0; $i<=count($body)-1; $i++) {
    $bodyzeile.=$body[$i]."\n";
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

  echo '<h1 align="center">Artikel in '.$newsgroups
    .' löschen</h1>';

echo '<p><b>Achtung!</b> Der Artikel wird auf allen <b>allen</b> '.
     'angeschlossenen Newsservern und damit in <b>allen Foren '.
     'gelöscht!</b></p>';

  if (isset($error)) echo "<p>$error</p>"; ?>

<br>

<form action="<?php echo $file_cancel?>" method="get">

<div class="np_post_header">
<table>
<tr><td align="right"><b><?php echo $text_header["subject"] ?></b></td>
<td><input type="text" name="subject" value="<?php echo htmlentities(stripslashes($subject));?>" size="40" maxlength="80"></td></tr>
<tr><td align="right"><b>Name:</b></td>
 <td align="left"><input type="text" name="name"
 <?php if (isset($name)) echo 'value="'.
  htmlentities(stripslashes($name)).'"'; ?>
 size="40" maxlength="40"></td></tr>
<tr><td align="right"><b>eMail:</b></td>
 <td align="left"><input type="text" name="email"
 <?php if (isset($email)) echo "value=\"$email\""; ?>
 size="40" maxlength="40"></td></tr>
</table>
</div>
<br>

<div class="np_post_body">
<table>
<tr><td><b><?php echo $text_post["message"];?></b><br>
<textarea name="body" rows="10" cols="79" wrap="physical">
<?php if (isset($bodyzeile)) echo stripslashes($bodyzeile); ?>
</textarea></td></tr>
<tr><td>
<input type="submit" value="Löschen">
<?php if ($setcookies==true) { ?>
<input type="checkbox" name="abspeichern" value="ja">
<?php echo $text_post["remember"];?>
<?php } ?>
</td>
</tr>
</table>
</div>
<input type="hidden" name="type" value="cancel">
<input type="hidden" name="cancelid" value="<?php echo $head->id;?>">
<input type="hidden" name="newsgroups" value="<?php echo $newsgroups; ?>">
<input type="hidden" name="references" value="<?php echo htmlentities($references); ?>">
<input type="hidden" name="group" value="<?php echo $group; ?>">
</form>

<?php } } ?>
</td></tr></table>


<?php include "tail.inc"; ?>
