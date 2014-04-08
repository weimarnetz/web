<!DOCTYPE html>
<html lang="en"><head>
    <title>Weimarnetz - Über uns</title>
    <?php include("../inc/_head.inc.php") ?>
</head>

<body>
<!-- Styles für ein responsiv eingebundenes Video-->
<style>
.js-video {
  height: 0;
  padding-top: 25px;
  padding-bottom: 67.5%;
  margin-bottom: 10px;
  position: relative;
  overflow: hidden;
}

.js-video.widescreen {
  padding-bottom: 57.25%;
}

.js-video.vimeo {
  padding-top: 0;
}
.js-video embed, .js-video iframe, .js-video object, .js-video video {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  position: absolute;
}
</style>
  <?php include("../inc/navbar.inc.php") ?>

	 <div class="container">
		<h1>Was ist Freifunk?</h1>
		<p>Diese kurze Video erklärt dir die Idee, die hinter Freifunk steckt.</p>
		<div class="js-video [vimeo widescreen] " style="text-align: center;"><iframe src="//player.vimeo.com/video/64814620" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="http://vimeo.com/64814620">Freifunk verbindet!</a> from <a href="http://vimeo.com/kosmonautensofa">Philipp Seefeldt</a> on <a href="https://vimeo.com">Vimeo</a>.</p></div>
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
Weitere Förderer sind das free software and infrastructure tech collective |||subsignal.org, die Initiative F.E.I.N.T.org, bittorf wireless )) und der StuKo der Bauhaus-Universität Weimar.</p>
<p>Freifunk-Netze sind Selbstmach-Netze. Für den Aufbau nutzen Teilnehmer auf ihren WLAN-Routern, eine spezielle Linuxdistribution, die Freifunk-Firmware. Lokale Communities stellen die auf eigene Bedürfnisse angepasste Software dann auf ihren Websites zur Verfügung. In Dörfern und Städten gibt es immer mehr Freifunk-Gruppen und Zusammenkünfte, wo sich Interessierte treffen. Die Freifunk-Community ist Teil einer globalen Bewegung für freie Infrastrukturen. Unsere Vision ist die Demokratisierung der Kommunikationsmedien durch freie Netzwerke. Die praktische Umsetzung dieser Idee nehmen Freifunk-Communities in der ganzen Welt in Angriff.</p> 

    	
  <?php include("../inc/footer.inc.php") ?>

  </div> <!-- ende container -->
  
  <?php include("../inc/_foot.inc.php") ?>


</body></html>
