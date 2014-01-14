<?php

        function getActiveClass($filename) {
                if ($filename == basename($_SERVER["SCRIPT_NAME"]) or strcmp(dirname($_SERVER["SCRIPT_NAME"]), $filename) == 0)
                {
                        return "class='active'";
                        }
        }

?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" <?php echo getActiveClass("index.php")?> href="/"><strong>Weimarnetz</strong></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li class="divider-vertical"></li>
      <li class="dropdown">
        <a href="/wiki" class="dropdown-toggle" data-toggle="dropdown">Informationen <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Einstieg</li>
          <li <?php echo getActiveClass("/about")?> ><a href="http://www.weimarnetz.de/about">Selbstdarstellung</a></li>
          <li <?php echo getActiveClass("/mitmachen")?> ><a href="http://www.weimarnetz.de/mitmachen">Mitmachen</a></li> 
          <li <?php echo getActiveClass("/contact")?> ><a href="http://www.weimarnetz.de/contact">Community</a></li>
          <li <?php echo getActiveClass("/spenden")?> ><a href="http://www.weimarnetz.de/spenden">Spenden</a></li>
          <li class="dropdown-header">Dokumentation</li>
          <li <?php echo getActiveClass("/wiki")?>><a href="http://wireless.subsignal.org">Wiki</a></li>
          <li <?php echo getActiveClass("/newsgroups")?> ><a href="http://www.weimarnetz.de/newsgroups" >Mailinglisten</a></li>
          <li class="dropdown-header">Rechtliches</li>
          <li <?php echo getActiveClass("/termsofuse")?>><a href="http://www.weimarnetz.de/termsofuse" >Nutzungsbedingungen</a></li>
          <li <?php echo getActiveClass("/picopeering")?>><a href="http://www.weimarnetz.de/picopeering" >Picopeering Aggreement</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="/map" class="dropdown-toggle"  data-toggle="dropdown">Daten <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Status</li>
          <li <?php echo getActiveClass("/status")?> ><a href="http://www.weimarnetz.de/status" >OLSR Status</a></li>  
	  <li <?php echo getActiveClass("/services")?> ><a href="http://www.weimarnetz.de/services" >Angebote/Dienste</a></li> 
          <li <?php echo getActiveClass("/monitoring")?> ><a href="http://www.weimarnetz.de/monitoring" >Monitoring</a></li>
          <li class="dropdown-header">Karten</li>
          <li <?php echo getActiveClass("/map2")?> ><a href="http://www.weimarnetz.de/map2">Geographische Karte (aktiv + inaktiv)</a></li>
          <li <?php echo getActiveClass("/maplive")?> ><a href="http://www.weimarnetz.de/maplive">Geographische Karte (Live!)</a></li>
          <li <?php echo getActiveClass("/topology")?> ><a href="http://www.weimarnetz.de/topology">Topologische Karte</a></li>
        </ul>          
      </li>
      <li class="dropdown">
        <a href="/freifunk/firmware/ar71xx" class="dropdown-toggle"  data-toggle="dropdown">Downloads <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li class="dropdown-header">Meshkit</li>
	  <li <?php echo getActiveClass("/meshkit")?> ><a href="http://meshkit.weimarnetz.de" >Eigene Firmware bauen</a></li>
          <li class="dropdown-header">Firmware</li>
	  <li <?php echo (strpos(dirname($_SERVER["SCRIPT_NAME"]), "/freifunk/firmware/ar71xx") !== false) ? "class='active'":"" ;?> ><a href="http://www.weimarnetz.de/freifunk/firmware/ar71xx" >Atheros (TP-Link, Ubiqity, usw)</a></li>   
          <li <?php echo getActiveClass("freifunk/firmware/brcm47xx")?> ><a href="http://www.weimarnetz.de/freifunk/firmware/brcm47xx" >Broadcom (Linksys, Buffalo, usw.)</a></li>
          <li <?php echo getActiveClass("freifunk/firmware/nightlies")?> ><a href="http://www.weimarnetz.de/freifunk/firmware/nightlies" >Nightly Builds</a></li>
          <li class="dropdown-header">Medien</li>
        </ul>
      </li>
      <li class="divider-vertical"></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li <?php echo getActiveClass("/partner")?> ><a href="http://www.weimarnetz.de/partner">Partner</a></li>
      <li class="dropdown">
        <a href="/impressum.php" class="dropdown-toggle"  data-toggle="dropdown">Impressum <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li <?php echo getActiveClass("/impressum")?> ><a href="http://www.weimarnetz.de/impressum">Impressum</a></li>
          <li <?php echo getActiveClass("/contact")?> ><a href="http://www.weimarnetz.de/contact">Kontakt</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
    
    <noscript><div class="container">
    <div class="alert alert-error">
    <strong>Achtung!</strong> Bitte aktiviere Javascript in Deinem Browser, um diese Website vollständig nutzen zu können.
    </div>
    </div></noscript>
