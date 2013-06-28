<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Rootserver</title>
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

    <?php include("./inc/header.inc.php")?>

    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span1">
		
					</div>
					
			<div class="span9">
      <h1>Willkommen im Weimarnetz</h1>
      
      <h2>Aktuelle Meldungen</h2>
      <div class="row-fluid">
      <div class="span6">
      <?php
      	$wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles");
      	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
      	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
      	?>
      	</div>
      	<div class="span6">                                                                                                          
				<a href="http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles&action=edit" target="_blank"><small>Text bearbeiten</small></a>
			</div>
			</div>      	
      <h2>Aktuelle Diskussionen</h2>
      <div class="row-fluid">
      <div class="span6">
      <?php
      	echo str_replace("<a href=", "<a target=_blank href=",file_get_contents("http://weimarnetz.de/latestnews.html"));
      	?>
      	</div>
      	<div class="span6">
      	<A HREF="./news.php" target="_blank" >Direktlink</A> zum Newsserver<br>Benutzername: <I>freifunk</I> Passwort: <I>weimar</I>
      	</div>
      	</div>
      	<h2>Spendenaufruf</h2>
      	<div class="row-fluid">
      	<div class="span6"><?php
      	$wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Spendenaufruf");
      	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
      	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
      	?></div>
      	<div class="span6">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MN595Q3HPXZVY">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
</div>
	</div>
	<div class="span2">
					<img src="img/Banner/120x500_mindfactory_hardware.jpg" width="120" height="500" alt="Ihre Hardware stößt an ihre Grenzen? Zeit für ein Upgrade! www.mindfactory.de" usemap="#map" />
					<map name="map">
							<!-- #$-:Image map file created by GIMP Image Map plug-in -->
							<!-- #$-:GIMP Image Map plug-in by Maurits Rijk -->
							<!-- #$-:Please do not edit lines starting with "#$" -->
							<!-- #$VERSION:2.3 -->
							<!-- #$AUTHOR:Unknown -->
							<area shape="rect" coords="3,413,116,438" target="_window" href="http://www.mindfactory.de" />
					</map>
					</div>
    </div> <!-- /container -->
    </div>

<?php include("./inc/footer.inc.php")?>    
 
</body></html>
