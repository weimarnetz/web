    <?php
    $gwip = $_GET['gateway'];
    $gwnode = $_GET['gwnode'];
    $neighborip = $_GET['nodeip'];
    $neighbornode = $_GET['node'];
    if ($gwip <> '' or $neighborip <> ''){
      echo '<div class="alert jumbotron alter-unlock alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><div class="container">';
      echo '<h2>Dein Internetzugang wurde erfolgreich freigeschaltet</h2>';
      if ($gwip <> '') {
        echo '<p>Den Internetzugang stellt Dir <a href="http://', $gwip, '/cgi-bin/luci/freifunk/contact">dieser freundliche Nachbar</a> bereit.</p>';
      }  
      if ($neighborip <> '') {
        echo '<p>Dein nächster Weimarnetzknoten wird von <a href="http://', $neighborip , '/cgi-bin/luci/freifunk/contact">diesem freundlichen Nachbarn</a> betrieben</p>';
      }
      echo "</div></div>";
    }
    ?>
