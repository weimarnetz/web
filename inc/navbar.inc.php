<?php

	function getActiveClass($filename) {
		if ($filename == basename($_SERVER["SCRIPT_NAME"]))
		{
			return "class='active'";
			}
			
	}

?>
<style>
body {
  padding-top: 50px;
  padding-bottom: 20px;
}
</style>
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
          <li <?php echo getActiveClass("/about")?> ><a href="/about">Selbstdarstellung</a></li>
          <li <?php echo getActiveClass("/wiki")?>><a href="/wiki">Wiki</a></li>
          <li <?php echo (strpos(dirname($_SERVER["SCRIPT_NAME"]), "/newsgroups") !== false) ? "class='active'":"" ;?> ><a href="/newsgroups" >Newsserver</a></li>
          <li <?php echo getActiveClass("/termsofuse")?>><a href="/termsofuse" >Nutzungsbedingungen</a></li>
          <li <?php echo getActiveClass("/picopeering")?>><a href="/picopeering" >Picopeering Aggreement</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="/map" class="dropdown-toggle"  data-toggle="dropdown">Karten <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li <?php echo getActiveClass("/map2")?> ><a href="/map2">Geographische Karte (aktiv + inaktiv)</a></li>
          <li <?php echo getActiveClass("/map")?> ><a href="/map">Geographische Karte (Live!)</a></li>
          <li <?php echo getActiveClass("/topology")?> ><a href="/topology">Topologische Karte</a></li>
        </ul>          
      </li>
      <li class="dropdown">
        <a href="/status" class="dropdown-toggle"  data-toggle="dropdown">Status <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li <?php echo getActiveClass("/status")?> ><a href="/status" >OLSR Status</a></li>   
          <li <?php echo getActiveClass("/monitoring")?> ><a href="/monitoring" >Monitoring</a></li>
         </ul>
      </li>
      <li class="dropdown">
        <a href="/freifunk/firmware/ar71xx" class="dropdown-toggle"  data-toggle="dropdown">Firmware <b class="caret"></b></a>
        <ul class="dropdown-menu">
<li <?php echo (strpos(dirname($_SERVER["SCRIPT_NAME"]), "/freifunk/firmware/ar71xx") !== false) ? "class='active'":"" ;?> ><a href="/freifunk/firmware/ar71xx" >Atheros (TP-Link, Ubiqity, usw)</a></li>   
          <li <?php echo getActiveClass("freifunk/firmware/brcm47xx")?> ><a href="/freifunk/firmware/brcm47xx" >Broadcom (Linksys, Buffalo, usw.)</a></li>
          <li <?php echo getActiveClass("freifunk/firmware/nightlies")?> ><a href="/freifunk/firmware/nightlies" >Nightly Builds</a></li>
        </ul>
      </li>
      <li class="divider-vertical"></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li <?php echo getActiveClass("/partner")?> ><a href="/partner">Partner</a></li>
      <li class="dropdown">
        <a href="/impressum.php" class="dropdown-toggle"  data-toggle="dropdown">Impressum <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li <?php echo getActiveClass("/impressum")?> ><a href="/impressum">Impressum</a></li>
          <li <?php echo getActiveClass("/contact")?> ><a href="/contact">Kontakt</a></li>
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
