<?php header("Content-Type: text/xml"); ?>
<?php echo '<?';?>xml version="1.0" encoding="UTF-8"<?php echo '?>';?>

<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:itunes="http://www.itunes.com/DTDs/Podcast-1.0.dtd" >

<?php /* 
    * Name of your Channel, 
    * URL to your Website,
    * Description and
    * Language of your channel
    */ 
//ini_set('display_errors', 'On');
?>

<channel>
<title>Diskussionen im Weimarnetz</title>
<link>http://www.weimarnetz.de/newsgroups</link>
<description>Unsere Diskussionsliste als Archiv im Netz</description>
<language>de-DE</language>

<?
/* *** Some settings ****/
// Newsgroup
$group="freifunk.de.weimar.discuss";
// Path to the spool-dir of your newsportal-installation
$spooldir="http://www.weimarnetz.de/newsgroups/spool/";
// Where is your newsportal.php?
$newsportal="./newsportal.php";
// Link to your article.php
$articlelink="http://www.weimarnetz.de/newsgroups/article.php";
// Maximum number of articles
$maxArticles=20;

include "config.inc.php";
include ("$newsportal");
$compress_spoolfiles=false;
$thread=thread_load($group);

// print_r($thread);

$lines=array();
$i=0;
foreach($thread as $t) {
  $i++;
  if($i==$maxArticles) break; // maximum articles shown
  echo "<item>\n";
  echo '<title>'.htmlspecialchars($t->subject).' ('.
       htmlspecialchars($t->name).")</title>\n";
  echo '<link>'.$articlelink.'?id='.$t->number.'&amp;group='.$group.'</link>\n';
  echo '<dc:contributor>'.htmlspecialchars($t->name).' ('.
       htmlspecialchars($t->from).')</dc:contributor>'."\n";
  echo '<pubDate>'.date('c', $t->date).'</pubDate>'."\n";
  echo "</item>\n";
}
?>
</channel>
</rss>
