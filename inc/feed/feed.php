<?php
include_once("mergedrss.php");

// place our feeds in an array
$feeds = array(
        array('http://www.weimarnetz.de/newsgroups/backend.php','Weimarnetz Newsserver','http://www.weimarnetz.de/newsgroups/backend.php'),
        array('https://www.facebook.com/feeds/page.php?id=130383450345014&format=rss20', 'Weimarnetz im Facebook','http://www.facebook.com/weimarnetz')
//	array('', 'Freifunk Radio', 'http://wiki.freifunk.net/Freifunk.radio')
);


// set the header type
header("Content-type: text/xml");

// set an arbitrary feed date
$feed_date = date("r", mktime(10,0,0,9,8,2010));

// Create new MergedRSS object with desired parameters
$MergedRSS = new MergedRSS($feeds, "Weimarnetz News Feed", "http://www.weimarnetz.de/", "This is the merged RSS feed our resources", $feed_date);

//Export the first 10 items to screen
$MergedRSS->export(false, true, 10);

