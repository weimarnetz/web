<?php
/**
* usage: call counter.php?count=nodes or counter.php?count=communities or counter.php (counts communities)
*/

$communities = "http://freifunk.net/map/ffSummarizedDir.json";

//load combined api file
$api = file_get_contents($communities);
$json = json_decode($api, true);

// set the header type
header("Content-type: text/html");

if ($_GET['action'] == "twitter") {
	$nodescounter = "";
	foreach($json as $community){
		if ( substr($community['api'], 0,3 ) != "0.4" and $community['contact']['twitter']) {
			$nodescounter .= $community['contact']['twitter'].", ";
		}
	}
	echo $nodescounter;
} else if ($_GET['action'] == 'ml') {
	foreach($json as $community){
		if ( $community['contact']['ml']) {
			$emails[] = $community['contact']['ml'];
		}
	}
	echo implode(', ', array_unique($emails));
} else if ($_GET['action'] == 'email') {
	foreach($json as $community){
		if ( $community['contact']['email']) {
			$emails[] = $community['contact']['email'];
		}
	}
	echo implode(', ', array_unique($emails));
} else {
	echo count($json);
}

?>
