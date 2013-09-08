<?
/*
 * directories and files
 */
$spooldir="spool";
$imgdir="img";
$file_newsportal="newsportal.php";
$file_index="index.php";
$file_thread="thread.php";
$file_article="article.php";
// $file_article_full="article.php";
$file_attachment="attachment.php";
$file_post="post.php";
$file_cancel="cancel.php";
$file_language="lang/deutsch.lang";
$file_footer="";
$file_groups="groups.txt";

/* 
 * newsserver setup
 */
$server="localhost";
$port=119;
// $post_server="";
// $post_port=119;
$maxfetch=0; // depricated
$initialfetch=0;  // depricated
//$server_auth_http=true;

/*
 * Grouplist Layout
 */
$gl_age=true;

/*
 * Thread layout
 */
$thread_treestyle=7;
$thread_show["date"]=true;
$thread_show["subject"]=true;
$thread_show["author"]=true;
$thread_show["authorlink"]=true;
$thread_show["replies"]=true;		// bastian: war "true"
$thread_show["lastdate"]=false; 		// bastian: war "false"	// makes only sense with $thread_show["replies"]=false
$thread_show["threadsize"]=false;
$thread_maxSubject=50;
$maxarticles=400;
$maxarticles_extra=100;
$age_count=3;
$age_time[1]=86400; //24 hours
$age_color[1]="red";
$age_time[2]=259200; //3 days
$age_color[2]="#999900";
$age_time[3]=604800; //7 days
$age_color[3]="#00bb00";
$thread_sort_order=-1;
$thread_sort_type="thread";
$articles_per_page=50;
$startpage="first";

/* 
 * Frames 
 */
// for frames-support: read README in the frames-directory
//$frame_article="article";
//$frame_thread="thread";
//$frame_groups="_top";
//$frame_post="_top";
//$frame_threadframeset="_top";
$frame_externallink="_blank";

/* 
 * article layout 
 */
$article_show["Subject"]=true;
$article_show["From"]=true;
$article_show["Newsgroups"]=true;
$article_show["Followup"]=true;
$article_show["Organization"]=true;
$article_show["Date"]=true;
$article_show["Message-ID"]=false;
$article_show["User-Agent"]=false;
$article_show["References"]=false;
$article_show["From_link"]=true;
//$article_show["From_rewrite"]=array('@',' (at) ');
$article_showthread=true;
$article_graphicquotes=true;

/*
 * settings for the article flat view, if used
 */
$articleflat_articles_per_page=10;
$articleflat_chars_per_articles=500;

/*
 * Message posting
 */
$send_poster_host=false;
$readonly=false;
$testgroup=false;
$validate_email=1;
$organization="Weimarnetz e.V webnews";
$setcookies=true;
// $anonym_address="set_this@to_something_valid";
$msgid_generate="md5";
$msgid_fqdn=$_SERVER["HTTP_HOST"];
$post_autoquote=true;

/* 
 * Attachments
 */
$attachment_show=true;
$attachment_delete_alternative=true; // delete non-text mutipart/alternative
$attachment_uudecode=false;  // experimental!

/*
 * Security settings
 */
$block_xnoarchive=false;

/*
 * Cache
 */
$cache_articles=false;  // article cache, experimental!
$cache_index=3600; // cache the group index for one hour before reloading
$cache_thread=60; // cache the thread for one minute reloading

/*
 * Misc 
 */
$title="Newsportal";
$cutsignature=true;
$compress_spoolfiles=false;

// website charset, "koi8-r" for example
$www_charset = "utf-8";
// Use the iconv extension for improved charset conversions
$iconv_enable=true;
// timezone relative to GMT, +1 for CET
$timezone=+1;

/*
 * Group specific config 
 */
//$group_config=array(
//  '^de\.alt\.fan\.aldi$' => "aldi.inc",
//  '^de\.' => "german.inc"
//);

/*
 * Do not edit anything below this line
 */
// Load group specifig config files
if((isset($group)) && (isset($group_config))) {
  foreach ($group_config as $key => $value) {
    if (ereg($key,$group)) {
      include $value;
      break;
    }
  }
}

// check the settings
include "lib/check.php";

// load the english language definitions first because some of the other
// definitions are incomplete
include("lang/english.lang"); 
include($file_language);
?>
