<!-- based on <http://getbootstrap.com/examples/jumbotron> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Weimarnetz e.V.</title>
    <?php include("./inc/_head.inc.php") ?>  
  </head>

  <body id="home">

    <?php include("./inc/navbar.inc.php") ?>

    <?php include("./inc/activation.inc.php") ?>

    <!-- grosses startseitenbanner -->
    <div id="banner" class="jumbotron jumbotron-branded cloudy-bg ff-logo-bg">
      <div class="container">
        <h1>Willkommen im Weimarnetz</h1>
        <p class="lead">Freifunk in Weimar &mdash; Das freie B&uuml;rger-WLAN!</p>
        <p>
          <a class="btn btn-primary btn-lg" href="/mitmachen">Jetzt Mitmachen &raquo;</a>
          <a class="btn btn-warning btn-lg" href="/contact">Hilfe bekommen &raquo;</a>
        </p>
        
      </div>
    </div>

    <!-- hier beginnt die eigentliche seite -->
    <div class="container">

      <!-- main reihe blöcke - content/ad -->
      <div class="row">
    
        <div class="col-sm-9">
    
          <!-- eine reihe content blöcke -->
          <div class="row">
    
            <!-- ein halber block (12/6=1/2) -->
            <div class="col-sm-6">
              <h2 class="page-header">Was ist Weimarnetz?</h2>
	      Weimarnetz baut ein freies, unabhängiges und dezentral organisiertes Datennetz in der Stadt Weimar auf. Das Netz basiert auf Funkverbindungen, die mit handelsüblichen WLAN-Geräten aufgebaut werden. Weimarnetz ist die lokale Umsetzung der über die Ländergrenzen hinweg bekannten <a href="http://www.freifunk.net" target="_blank">Freifunk-Initiative</a>.</br></br>
	      Werde auch Du Teil des Netzes und <a href="/mitmachen">mach mit!</a> 
            </div>
            <!-- ein halber block (12/6=1/2) -->
            <div class="col-sm-6">
              <!--<h2 class="page-header">Aktuelle Meldungen</h2>
              <!- dyn: news-liste -->
	      <?php //include("./inc/currentnews.inc.php") ?>
      	      <!--<p><a class="btn btn-xs btn-default" href="http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles&action=edit" target="_blank">Text bearbeiten &raquo;</a></p>
	      -->
	      <h2 class="page-header">Worum geht es?</h2>
	      <a href="/about"><img class="img-responsive" src="/img/video/ffvideo.png"/></a>
            </div>
    
   
          </div> <!-- ende reihe -->

          <!-- zweite reihe blöcke -->
          <div class="row">

            <!-- ein halber block (12/6=1/2) -->
            <div class="col-sm-6">
              <h2 class="page-header">Neues aus dem Weimarnetz</h2>
              <p>
                <!-- dyn: discuss-liste -->
	        <?php include("./inc/allnews.inc.php") ?>
        
              </p>
            </div>

            <div class="col-sm-6">
              <h2 class="page-header">Spendenaufruf</h2>
              <!-- dyn: spenden-liste -->
	      <p>
		Die Nutzung von Weimarnetz ist kostenlos und keiner der Betreiber von Netzknoten verlangt Geld oder andere Zuwendungen. Jeder Mensch soll das Netz ohne Anmeldung, eigene Router und schlechtes Gewissen nutzen können. Falls das Gewissen trotzdem hineinredet, stellt einen eigenen Router auf und unterstützt uns durch Spenden.
	      </p>
	      <p>
		Eure Spenden werden eingesetzt, um laufende Kosten zu decken, z.B. für den VPN-Server, um die Störerhaftung von den DSL-Einspeisern zu nehmen.
	      </p>
	      <p>
		Welche Möglichkeiten es gibt, uns finanziell zu unterstützen und wofür wir die Spenden einsetzen erfahrt ihr auf <a href="/spenden">dieser Seite</a>.
	      </p>
            </div>
    
          </div> <!-- ende reihe -->

				</div> <!-- ende content -->

				<div class="col-sm-3" style="text-align:right">
					<h2 class="page-header"><small class="text-muted">Termine</small></h2>
					<?php include("./inc/agendaview.inc.php") ?>
				</div>
    
        <div class="col-sm-3" style="text-align:right">
          <h2 class="page-header"><small class="text-muted">Verein</small></h2>
	  <p>
	  <address><strong>Weimarnetz e.V.</strong><br>
            Marienstr. 18<br>
            99423 Weimar</address>
          <address><strong>Weimarnetz Sorgentelefon</strong><br>
              +49 3643 544304</address>
	  <address><strong>Email</strong><br>
	    <a href="mailto:kontakt@weimarnetz.de?subject=Anfrage über weimarnetz.de">kontakt@weimarnetz.de</a>
	  </address>
	  <strong>Spenden</strong>
	  </p>
	  <p>
	  <iframe frameborder='0' marginheight='0' marginwidth='0' src='http://www.betterplace.org/de/projects/14895-weimarnetz-e-v-freies-wlan-in-weimar/widget' width='160' height='260' style='border: 0; padding:0; margin:0;'>Ihr Browser unterstützt keine Iframes. <a href='http://www.betterplace.org/projects'>Online Spenden</a> auf betterplace.org</iframe>
	  </p>
        </div>
      
      </div> <!-- ende main -->

      <?php include("./inc/footer.inc.php") ?>
  
    </div> <!-- ende inhalt /container -->


    <?php include("./inc/_foot.inc.php") ?>

  </body>
</html>
