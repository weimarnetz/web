<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Kontakt</title>
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

  <body data-spy="scroll" data-target=".subnav" data-offset="50">
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
		<h1>Kontakt</h1>
		Es gibt mannigfaltige Möglichkeiten, uns zu erreichen.<br>
		<div class="row">
			<div class="span6"><h2>Per Mailingliste</h2>
				<address><strong>Allgemeine Liste</strong><br>
				wireless@subsignal.org		
				</address>
				<address><strong>Diskussionsliste</strong><br>
				wireless-discuss@subsignal.org</address>
				<span class="label label-warning">Achtung!</span> Die Teilnahme an den Mailinglisten setzt eine <a href="http://wireless.subsignal.org/index.php?title=Mailingliste" target="_blank">Registrierung</a> voraus, sonst kommt unter Umständen nie eine Antwort an. Alternativ kann der <a href="./news.php">Newsserver</a> ohne Anmeldung genutzt werden. 
			</div>
			<div class="span6"><h2>Persönlich</h2>
				<p>Wir treffen uns wöchentlich jeden Dienstag ab 20 Uhr, meist im Maschinenraum in der Marienstraße 18. Neben Vorträgen und der Möglichkeit zum Erfahrungsaustausch gibt es viel praktische Firmwareentwicklung und wenn nötig, Bastelorgien am Gerät. Falls dann noch Zeit bleibt, kann man Mate und Bier genießen.<br> Wir begrüßen außerdem gern neue Interessenten und geben Hilfestellung bei Problemen oder der Inbetriebnahme eines neuen Knoten.</p>
				<p>Wann und wo das nächste Treffen stattfindet und ob es aktuelle Themen zu bearbeiten gibt, steht im <a href="http://wireless.subsignal.org/index.php?title=Treffen" target="_blank" >Wiki</a>.</p>
		</div>
		</div>
		<div class="row">
			<div class="span6"><h2>Postalisch</h2>
			 	<address><strong>Weimarnetz e.V.</strong><br>
			 	Marienstr. 18<br>
			 	99423 Weimar</address>
		 	</div>
		 	<div class="span6"><h2>Telefonisch</h2>
				<address><strong>Weimarnetz Sorgentelefon</strong><br>
				03643 / 544 304</address>	 	
		 	</div> 
	 	</div>
	 	
	</div>

    	
<?php include("./inc/footer.inc.php")?>



</body></html>