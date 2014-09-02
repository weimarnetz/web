<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Spenden</title>
  <?php include("../inc/_head.inc.php") ?>
</head>

<body>

  <?php
  include("../inc/navbar.inc.php");
  include("../inc/betterplace.inc.php");
  ?>

  <div class="container">
    
    <!-- CONTENT -->
    <h1>Spenden</h1>
    <p>Die Nutzung von Weimarnetz ist kostenlos und keiner der Betreiber von Netzknoten verlangt Geld oder andere Zuwendungen. Jeder Mensch soll das Netz ohne Anmeldung, eigene Router und schlechtes Gewissen nutzen können. Falls das Gewissen trotzdem hineinredet, stellt einen eigenen Router auf und unterstützt uns durch Spenden.
    <p>Eure Spenden werden z.B. dafür eingesetzt:</p>
    <ul>
      <li>Zur Deckung laufenden Kosten, unter anderem für den VPN-Server, um die Störerhaftung von den DSL-Einspeisern zu nehmen.</li>
      <li>An wichtigen Punkten unterstützen wir den Aufbau von Routern, auch aufwändigere Installationen zur Stabilisierung des Netzes möchten wir fördern.</li>
      <li>Wir stellen Informationsmaterial her, um unsere Idee besser erklären und mehr Leute zum Mitmachen bewegen zu können.</li>
      <li>Nicht nur in Weimar gibt es ein Freifunk-Projekt. Die Projekte vernetzen sich untereinander und wir helfen gemeinsame Treffen oder den Besuch von Konferenzen zu finanzieren.</li>
    </ul>
    <p>Hier sind nun drei Wege, uns finanziell zu unterstützen:</p>
    <div class="row">
      <div class="col-sm-12 col-lg-4">
        <h2>Betterplace.org</h2>
        <p>Mit dieser Spendenplattform können wir konkrete Projekte angeben, die auch den Spendern transparent den Fortschritt und die Verwendung der Spenden anzeigt.</p>
        <p>Zahlen und Fakten:</p>
          <ul>
              <li>Laufende Kampagnen: <?php echo $bpIncompleteNeedCount; ?></li>
              <li>Abgeschlossene Kampagnen: <?php echo $bpCompletedNeedCount; ?></li>
              <li>Eindeutige Spender: <?php echo $bpPrjJson['donor_count']; ?></li>
              <li>Positive Meinungen: <?php echo $bpPrjJson['positive_opinions_count']; ?></li>
              <li>Negative Meinungen: <?php echo $bpPrjJson['negative_opinions_count']; ?></li>
              <li><a href="<?php echo $bpPlatformLink?>" target="_blank">Mehr Informationen</a></li>
              <li><a href="<?php echo $bpDonationLink?>" target="_blank">Direkt spenden</a></li>
          </ul>
          Gesamtspendenstand:
          <a href="<?php echo $bpPlatformLink?>" target="_blank">
              <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $bpProgressPercentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $bpProgressPercentage; ?>%;">
                      <?php echo $bpProgressPercentage; ?> %
                  </div>
              </div>
          </a>
      </div>
      <div class="col-sm-12 col-lg-4">
        <h2>Laufende Kampagnen</h2>
          <dl>
              <?php
              foreach($bpNeeds as $need) {
                  if (! $need['completed']) {
                      foreach($need['links'] as $link) {
                          $donationLink = "";
                          if ($link['rel'] == 'new_donation') {
                              $donationLink = $link['href'];
                          }
                      }
                      echo "<dt>" . $need['title'] . "</dt>";
                      ?>
                      <dd>
                          <p><?php echo $need['progress_percentage']; ?> % des Betrages sind schon gespendet:</p>
                              <a href="<?php echo $donationLink; ?>" target="_blank">
                                  <div class="progress">
                                      <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $need['progress_percentage']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $need['progress_percentage']; ?>%;">
                                          noch <strong><?php echo $need['open_amount_in_cents']/100; ?> €</strong>
                                      </div>
                                  </div>
                              </a>
                          <p>
                              <?php echo $need['donated_amount_in_cents']/100; ?> € von <?php echo $need['requested_amount_in_cents']/100; ?> € erreicht -
                              <a href="<?php echo $donationLink; ?>" target="_blank">Spende für diesen Bedarf</a>
                          </p>
                      </dd>
                      <?php
                  }
              }
              ?>
          </dl>
      </div>
      <div class="col-sm-12 col-lg-4">
        <h2>Überweisung</h2>
	<p>Für alle, die ihre Bankgeschäfte noch klassisch erledigen steht natürlich weiterhin der Weg einer Überweisung offen. Daueraufträge sind gern gesehen.
	<ul>
	  <li>Kontonummer: 365004871</li>
	  <li>Bankleitzahl: 82051000</li>
	  <li>IBAN: DE30 8205 1000 0365 0048 71</li>
	  <li>BIC: HELADEF1WEM</li>
	  <li>(Sparkasse Mittelthüringen)</li>
	</ul>
      </div>
    </div> <!-- ende row -->
    <p>Weimarnetz e.V. ist ein gemeinnütziger Verein und berechtigt, Spendenbescheinigungen auszustellen. Die Spendenbescheinigungen stellen wir im 1. Quartal des Folgejahres für Spenden über 100 Euro aus, für die Erstellung benötigen wir die komplette Anschrift des Spenders. Bei Spenden über betterplace.org wird uns diese Arbeit abgenommen.</p>
    <?php include("../inc/footer.inc.php") ?>
  </div> <!-- ende container -->
  
  <?php include("../inc/_foot.inc.php") ?>


</body></html>
