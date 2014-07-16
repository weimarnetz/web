<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Services</title>
  <?php include("../inc/_head.inc.php") ?>
</head>

<body>

  <?php include("../inc/navbar.inc.php") ?>

  <div class="container">
    
    <!-- CONTENT -->
    <h1>Dienste im Weimarnetz</h1>
		Diese Dienste werden von Teilnehmern im Weimarnetz angeboten. Die Übersicht wird automatisiert erstellt und regelmäßig aktualisiert.</br>
		<div class="row alert alert-warning">Hier aufgelistete Dienste sind in der Regel nur innerhalb des Weimarnetzes oder aus anderen Freifunk-Communities, die über das <a href="http://freifunk.net/blog/2014/02/das-intercity-vpn/" target="_blank">InterCity-VPN</a> mit uns verbinden sind, erreichbar. Deshalb funktionieren einige der Links nicht, wenn man sich aus dem Internet verbindet.</div>
    <?php include("../inc/olsr_services.inc.php") ?>
    
    <?php include("../inc/footer.inc.php") ?>
    
  </div> <!-- ende container -->
  
  <?php include("../inc/_foot.inc.php") ?>


</body></html>
