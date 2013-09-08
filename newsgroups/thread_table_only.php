<? header("Expires: ".gmdate("D, d M Y H:i:s",time()+7200)." GMT");
/*****

Dieses Skript ist speziell für die Firmware für Router des Projektes Freifunk Weimar angepaßt, um auf der zugehörigen Infoseite die letzten 10 bearbeiteten Beiträge der Diskussionsgruppe zu präsentieren
Ziel ist es, lediglich eine Liste der letzten 10 Beiträge zu erhalten, mit Datum Autor und Verlinkung.

Letzte Bearbeitung: 16.03.08 Andreas Bräu
*****/
// register parameters
$group=$_REQUEST["group"];
if(isset($_REQUEST["first"]))
  $first=intval($_REQUEST["first"]);
if(isset($_REQUEST["last"]))
  $last=intval($_REQUEST["last"]);

include "config.inc.php";
$thread_treestyle=1;
$thread_show["replies"]=false;
$thread_show["lastdate"]=true;
$thread_show["authorlink"]=false;
$articles_per_page=5;
include("$file_newsportal");
include "auth.inc";
$title.= ' - '.$group;
//include "head.inc";
if((!function_exists("npreg_group_has_read_access") ||
    npreg_group_has_read_access($group)) &&
       (!function_exists("npreg_group_is_visible") ||
           npreg_group_is_visible($group))) {

	   ?>



	   <?



 /** echo '<table cellpadding="0" cellspacing="0" width="100%" class="np_buttonbar"><tr>';
  echo '<td class="np_button"><a class="np_button" href="'.
       $file_index.'">'.$text_thread["button_grouplist"].'</td></a>';
  if (!$readonly && 
      (!function_exists("npreg_group_has_write_access") ||
       npreg_group_has_write_access($group)))
    echo '<td class="np_button"><a class="np_button" href="'.
         $file_post.'?newsgroups='.urlencode($group).'&amp;type=new">'.
         $text_thread["button_write"]."</a></td>";
// $ns=nntp_open($server,$port);
****/
  flush();
  $headers = thread_load($group);
  $article_count=count($headers);
  if ($articles_per_page != 0) { 
    if ((!isset($first)) || (!isset($last))) {
      if ($startpage=="first") {
        $first=1;
        $last=$articles_per_page;
      } else {
        $first=$article_count - (($article_count -1) % $articles_per_page);
        $last=$article_count;
      }
    }
/*    echo '<td class="np_pages" width="100%" align="right">';
    // Show the replies to an article in the thread view?
    if($thread_show["replies"]) {
      // yes, so the counting of the shown articles is very easy
      $pagecount=count($headers);
    } else {
      // oh no, the replies will not be shown, this makes life hard...
      $pagecount=0;
      if(count($headers>0) && is_array($headers)) {
        foreach($headers as $h) {
          if($h->isAnswer==false)
            $pagecount++;
        }
      }
    }
  */
    thread_pageselect($group,$pagecount,$first);
    //echo '</td>';
  } else {
    $first=0;
    $last=$article_count;
  }
  //echo '</tr></table>';
  thread_show($headers,$group,$first,$last);
} else {
  echo $text_register["no_access_group"];
}

?> 

