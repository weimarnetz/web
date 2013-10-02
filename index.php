<!-- based on <http://getbootstrap.com/examples/jumbotron> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Weimarnetz e.V.</title>
    <?php include("./inc/_head.inc.php") ?>  
  </head>

  <body id="home">

    <?php include("./inc/navbar.inc.php") ?>
    
    <!-- log-in-alert for testing-->
    <!--
    <div class="alert jumbotron alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <div class="container">
        <h2>Dein Internetzugang wurde erfolgreich freigeschaltet</h2>
        <p>Den Internetzugang stellt Dir dieser <a href='http://", $gwip, "/cgi-bin/luci/freifunk/contact'>freundliche Nachbar bereit</a></p>
      </div>
    </div>
     -->

        
    <?php include("./inc/activation.inc.php") ?>

    <!-- grosses startseitenbanner -->
    <div id="banner" class="jumbotron jumbotron-special ff-logo-bg">
      <div class="container">
        <h1>Willkommen im Weimarnetz</h1>
        <p class="lead">Freifunk in Weimar &mdash; Das freie B&uuml;rger-WLAN!</p>
        <p>
          <a class="btn btn-primary btn-lg" href="/mitmachen">Jetzt Mitfunken &raquo;</a>
          <a class="btn btn-warning btn-lg" href="/contact">Hilfe bekommen &raquo;</a>
        </p>
        
      </div>
    </div>

    <!-- hier beginnt die eigentliche seite -->
    <div class="container">

      <!-- main reihe blöcke - content/ad -->
      <div class="row">
    
        <div class="col-sm-10">
    
          <!-- eine reihe content blöcke -->
          <div class="row">
    
            <!-- ein halber block (12/6=1/2) -->
            <div class="col-sm-6">
              <h2 class="page-header">Was ist Weimarnetz?</h2>
	      Weimarnetz baut ein freies, unabhängiges und dezentral organisiertes Datennetz in der Stadt Weimar auf. Das Netz basiert auf Funkverbindungen, die mit handelsüblichen WLAN-Geräten aufgebaut werden. Weimarnetz ist die lokale Umsetzung der über die Ländergrenzen hinweg bekannten <a href="http://www.freifunk.net" target="_blank">Freifunk-Initiative</a>.</br></br>
	      Werde auch Du Teil des Netzes und <a href="http://wireless.subsignal.org/index.php?title=Schnelleinstieg">mach mit!</a> 
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
              <h2 class="page-header">Aktuelle Diskussionen</h2>
              <p>
                <!-- dyn: discuss-liste -->
	        <?php include("./inc/currentnews.inc.php") ?>
        
              </p>
              <p><a class="btn btn-xs btn-default" href="./news.php" target="_blank" >Direkt zum Newsserver</a> <small>(Benutzer: <code>freifunk</code> Passwort: <code>weimar</code>)</small></p>
            </div>

            <div class="col-sm-6">
              <h2 class="page-header">Spendenaufruf</h2>
              <!-- dyn: spenden-liste -->
	      <?php include("./inc/fundings.inc.php") ?>
      
              <!-- paypal button -->
              <ul><li>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                  <span class="label label-primary" style="vertical-align:text-top">PayPal:</span> 
                  <input type="hidden" name="cmd" value="_s-xclick">
                  <input type="hidden" name="hosted_button_id" value="MN595Q3HPXZVY">
                  <input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
                  <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
                </form>
              </li></ul>
      
              <!-- <p><a class="btn btn-default" href="#">View details &raquo;</a></p> -->
            </div>
    
          </div> <!-- ende reihe -->

        </div> <!-- ende content -->
    
        <div class="col-sm-2" style="text-align:right">
          <h2 class="page-header"><small class="text-muted">Sponsor</small></h2>
          <!-- mindfactory banner -->
          <img src="img/Banner/120x500_mindfactory_hardware.jpg" width="120" height="500" alt="Ihre Hardware stößt an ihre Grenzen? Zeit für ein Upgrade! www.mindfactory.de" usemap="#admap" />
          <map name="admap">
            <!-- #$-:Image map file created by GIMP Image Map plug-in -->
            <!-- #$-:GIMP Image Map plug-in by Maurits Rijk -->
            <!-- #$-:Please do not edit lines starting with "#$" -->
            <!-- #$VERSION:2.3 -->
            <!-- #$AUTHOR:Unknown -->
            <area shape="rect" coords="3,413,116,438" target="_blank" href="http://www.mindfactory.de" />
          </map>
        </div>
      
      </div> <!-- ende main -->

      <?php include("./inc/footer.inc.php") ?>
  
    </div> <!-- ende inhalt /container -->


    <?php include("./inc/_foot.inc.php") ?>

  </body>
</html>
