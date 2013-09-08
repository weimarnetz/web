<? header("Content-Type: text/xml"); ?>
<? echo '<?';?>xml version="1.0" encoding="ISO-8859-1"<? echo '?>';?>

<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN"
 "http://my.netscape.com/publish/formats/rss-0.91.dtd">

<rss version="0.91">

<? /* 
    * Name of your Channel, 
    * URL to your Website,
    * Description and
    * Language of your channel
    */ ?>

<channel>
<title>NewsPortal WebNewsReader</title>
<link>http://florian-amrhein.de/newsportal</link>
<description>News about NewsPortal</description>
<language>de-DE</language>

<?
/* *** Some settings ****/
// Newsgroup
$group="darkzone.support.newsportal.announce";
// Path to the spool-dir of your newsportal-installation
$spooldir="spool/";
// Where is your newsportal.php?
$newsportal="newsportal.php";
// Link to your article.php
$articlelink="http://myrsschannel.com/newsportal/article.php";


include $newsportal;
$compress_spoolfiles=false;
$thread=array_reverse(loadThreadData("$group"));

// print_r($thread);

$lines=array();
$i=0;
foreach($thread as $t) {
  $i++;
  if($i==15) break; // maximum articles shown
  echo "<item>\n";
  echo '<title>'.htmlspecialchars($t->subject).' ('.
       htmlspecialchars($t->name).")</title>\n";
  echo '<link>'.$articlelink.'?id='.$t->number."</link>\n";
  echo '<dc:contributor>'.htmlspecialchars($t->name).' ('.
       htmlspecialchars($t->from).')</dc:contributor>'."\n";
  echo "</item>\n";
}
?>
</channel>
</rss>
