<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Über</title>
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

	
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Weimarnetz Rootserver</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="./index.php">Home</a></li>
              <li><a href="./wiki.php">Wiki</a></li>
              <li><a href="./map.php">Karte</a></li>             
              <li><a href="./topology.php">Topologie</a></li>
              <li><a href="./status.php" >OLSR Status</a></li>
              <li><a href="./news.php" >Newsserver</a></li>
              <li class="active"><a href="./about.php">Über</a></li>
              <li><a href="./contact.php">Kontakt</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	 <div class="container">
		<h1>Selbstdarstellung</h1>
		<i>Auszug aus unserem <a href="http://wireless.subsignal.org/index.php?title=Selbstdarstellung" target="_blank" >Wiki</a>:</i><br>
	 	<p>Das Projekt Wireless Weimar auch bekannt als das weimarnetz, hat zum Ziel, ein freies,
unabhängiges und nichtkommerzielles Computer-Funknetz
in Weimar zu etablieren. Es bildet eine Plattform für Menschen,
die an einer offenen Netzwerk-Infrastruktur interessiert sind,
um Erfahrungen und Ideen auszutauschen und den Aufbau und
die Entwicklung des gemeinsamen Netzes zu koordinieren.
Wir sehen uns als lokale Umsetzung der freifunk.net-Initiative.</p>
<p>Das Weimarnetz wird vom Weimarnetz e.V. gefördert, welcher sich duch Spenden finanziert.<br>
Weitere Förderer sind das free software and infrastructure tech collective |||subsignal.org,die Initiative
F.E.I.N.T.org,bittorf wireless )) und der StuKo der Bauhaus-Universität Weimar.</p>
<p>Freifunk-Netze sind Selbstmach-Netze. Für den Aufbau nutzen Teilnehmer auf ihren WLAN-Routern, eine spezielle Linuxdistribution, die Freifunk-Firmware. Lokale Communities stellen die auf eigene Bedürfnisse angepasste Software dann auf ihren Websites zur Verfügung. In Dörfern und Städten gibt es immer mehr Freifunk-Gruppen und Zusammenkünfte, wo sich Interessierte treffen. Die Freifunk-Community ist Teil einer globalen Bewegung für freie Infrastrukturen. Unsere Vision ist die Demokratisierung der Kommunikationsmedien durch freie Netzwerke. Die praktische Umsetzung dieser Idee nehmen Freifunk-Communities in der ganzen Welt in Angriff.</p> 
	</div>

    	
        <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/jquery.js"></script>	



</body></html>