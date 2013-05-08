<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Partner und Sponsoren</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Unknown" >

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon-114x114.png">
  </head>

  <body>
<script type="text/javascript">
    
    function getElement(aID)
    {
        return (document.getElementById) ?
            document.getElementById(aID) :document.all[aID];
    }

    function getIFrameDocument(aID){ 
        var rv = null; 
        var frame=getElement(aID);
        // if contentDocument exists, W3C compliant (e.g. Mozilla) 
        if (frame.contentDocument)
            rv = frame.contentDocument;
        else // bad Internet Explorer  ;)
            rv = document.frames[aID].document;
        return rv;
    }

    function adjustMyFrameHeight()
    {
        var frame = getElement("myFrame");
        var frameDoc = getIFrameDocument("myFrame");
        frame.height = frameDoc.body.offsetHeight;
    }
</script>

	
<?php include("./inc/header.inc.php")?>

	 <div class="container">
	 <h1>Unsere Partner und Sponsoren</h1>
	 Wir bedanken uns bei all unseren Partnern, Sponsoren und Förderern für die uns entgegengebrachte Unterstützung.
	 <div class="row">
	 <div class="span12">&nbsp;</div>
	 <div class="span12">
	 <div class="row">
	 <div class="span6">
	 					<a href="http://www.openwrt.org" target="_window"><img src="img/Banner/openwrt-logo.png" width="240" height="61" alt="OpenWrt" longdesc="OpenWrt schafft mit seiner Firmware für viele verschiedene WLAN-Router die Grundlagen für ein funktionierendes Netz" /></a><br />
	 					OpenWrt ermöglich uns mit seiner Firmware, unsere Router für unseren Einsatzzweck perfekt anzupassen. Durch die stetige Weiterentwicklung der OpenWrt-Community sind wir bestens für die Zukunft gerüstet.
			<br /><br />
						<a href="http://www.mindfactory.de" target="_window"><img src="img/Banner/mf_blue_on_white_logo.png" width="240" height="70" alt="Mindfactory.de" /></a><br />
						Mindfactory ist der Onlineshop für PC Hardware, Software, Freifunkrouter und mehr. Von Mindfactory erhalten wir Unterstützung beim Kauf von Hardware und Komponenten.<br /><br />
			</div>
			<div class="span4 offset2">
			<a href="http://www.sublab.org" target="_window"><img src="img/Banner/banner_sublab.svg" width="177" height="213" alt="Sublab" /></a><br />
			Das Sublab ist eine Freifunkkeimzelle in Leipzig und neue Heimat unserer Gründerväter<br /><br />
			</div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="span6 offset3">
			<a href="http://www.maschinenraum.tk" target="_window"><img src="img/Banner/maschinenraum.png" width="640" height="96" alt="Maschinenraum" /></a><br />
			Der Maschinenraum ist unsere Basis und bietet uns Platz für Testorgien und unsere wöchentlichen Treffen.<br /><br />
		</div>
		</div>
		<div class="row">
		<div class="span3 offset1">
		<a href="http://www.bittorf-wireless.de" target="_window"><img src="img/Banner/banner_bittorfwireless.png" width="306" height="38" alt="Bittorf Wireless" /></a><br />
		Bittorf Wireless unterstützt uns mit Technik, Wissen und Softwareentwicklung.<br /><br />
		</div>
		</div>
		<div class="row">
		<div class="span3 offset4">
		<a href="http://www.cstorch.de" target="_window"><img src="img/Banner/cstorch_banner.jpg" width="468" height="60" alt="christian storch - Informationstechnologie" /></a><br />
		Christian Storch Informationstechnologie hilft uns bei Softwareentwicklung, Support und Installationen.<br /><br />		
		</div>		
		</div>
		<div class="row">
		<div class="span3 offset7">
		<a href="http://www.weimar.de" target="_window"><img src="img/Banner/weimar_logo_print.png" width="143" height="58" alt="Weimar. Kulturstadt Europas" /></a><br />
		Wir arbeiten mit der Stadt Weimar zusammen und finden gemeinsam neue Standorte, die mit Weimarnetz versorgt werden sollen.		
		</div>
		</div>
	</div>
	

    		
<?php include("./inc/footer.inc.php")?>


</body></html>