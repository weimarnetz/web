    <?php
    $origin = isset($_GET['origin']) ? $_GET['origin'] : '';
    $gwip = isset($_GET['gateway']) ? $_GET['gateway'] : '';
    $gwnode = isset($_GET['gwnode']) ? $_GET['gwnode'] : '';
    $neighborip = isset($_GET['nodeip']) ? $_GET['nodeid'] : '';
    $neighbornode = isset($_GET['node']) ? $_GET['node'] : '';
    if ($gwip <> '' or $neighborip <> ''){
      echo '<div class="jumbotron alert alert-success alert-top alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><div class="container">';
      echo '<h2>Dein Internetzugang wurde erfolgreich freigeschaltet</h2>';
      if ($gwip <> '') {
        echo '<p>Den Internetzugang stellt Dir <a href="http://', $gwip, '/cgi-bin/luci/freifunk/contact">dieser freundliche Nachbar</a> bereit.</p>';
      }  
      if ($neighborip <> '') {
        echo '<p>Dein nächster Weimarnetzknoten wird von <a href="http://', $neighborip , '/cgi-bin/luci/freifunk/contact">diesem freundlichen Nachbarn</a> betrieben</p>';
      }
      if ($origin <> '') {
	echo '<p><small>PS: <a href="', urldecode($origin), '" target="_blank">Diese Seite</a> wolltest du ursprünglich ansehen.</small></p>';
      }
      echo "</div></div>";
    }
    ?>
