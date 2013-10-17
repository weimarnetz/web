<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Mitmachen</title>
  <?php include("../inc/_head.inc.php") ?>
</head>

<body>

  <?php include("../inc/navbar.inc.php") ?>

  <div class="container">
    
    <!-- CONTENT -->
    <div class="row">
      <div class="col-sm-12">

        <h3>Jeder kann mitmachen!</h3>

        <p>Sprich mit deinem Freundeskreis, Geschäftspartnerinnen, -partern und allen Menschen die dich umgeben und verbreite die Idee von Freifunk.

        Alle können Freifunker werden! Wir freuen uns über Unterstützung bei:</p>
      
        <ul>
          <li>der <strong>Erweiterung des Freifunk-Netzwerks</strong> durch das Aufstellen neuer Freifunk-Router (<a href="#aufstellen">siehe unten</a>) oder durch das Bereitstellen interessanter Standorte für Freifunk-Router (z.B. Dächer).</li>
          <li>der <strong>Entwicklung von Infomaterial</strong>, Bannern, Transparenten, T-Shirts, ... was immer dir Kreatives einfällt!</li>
          <li>der <strong>Verbreitung der Idee</strong> auf Veranstaltungen, Barcamps und Kongressen.</li>
          <li>dem <strong>Betreiben von Diensten</strong> für die Community und der Entwicklung von Webanwendungen.</li>
        </ul>

        <p>Komm zum <a href="../contact">Freifunk-Treffen</a> oder frag auf der <a href="../contact">Mailingliste</a>. Du kannst uns auch mit <a href="http://www.betterplace.org/de/projects/14895-weimarnetz-e-v-freies-wlan-in-weimar">Spenden</a> unterstützen.
        </p>
    

        <h3 id="aufstellen">Du möchtest einen Freifunk-Router aufstellen?</h3>
      
        <div class="row">

          <div class="col-sm-4 col-lg-4">
            <div class="case" id="case-starter">
              <div class="case-head page-header">
                <h3>Starter-Kit</h3>
                <h5>Wohnung, Geschäft, Bürogemeinschaft, Café, Restaurant, Bar</h5>
                <img class="img-responsive"  src="../img/participate/participate_small.png">
              </div>
              <div class="case-body">
                <dl>
                  <dt>Du möchtest</dt>
                  <dd>
                    <ul>
                      <li>dich mit dem Freifunk-Netz in deiner Nachbarschaft verbinden.</li>
                      <li>deinen Internet-Anschluss freigeben.</li>
                      <li>den ersten Freifunk-Router in deiner Umgebung aufstellen.</li>
                    </ul>
                  </dd>
                  <dt>So kannst du mitmachen</dt>
                  <dd>
                    <ul>
                      <li>Besorge einen Freifunk-fähigen Router. Empfehlung: <a href="#" data-toggle="tooltip" title="TP-Link TL-WR841N, ~20 EUR, 2.4 GHz.">TL-WR-841N</a> oder <a href="#" data-toggle="tooltip" title="TP-Link TL-WDR3600, ~55 EUR, 2.4 GHz und 5 GHz.">TL-WDR3600</a>.
                      </li>
                      <li>Falls du deinen Internet-Zugang freigeben möchtest, wählt sich dein Router automatisch in unser VPN ein, um dich vor Abmahnungen zu schützen 
                      </li>
                      <li>Installiere und konfiguriere die <a href="#" data-toggle="tooltip" title="Die Freifunk-Firmware ist eine Software, die auf einem Router installiert wird und ihn in einen Freifunk-Router verwandelt.">Freifunk-Firmware</a>.
                        <!-- TODO: Link (wie flashe ich?) -->
                      </li>
                      <li>Stelle den Router an einem geeigneten Ort auf (z.B. Fensterbank).</li>
                    </ul>
                  </dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="col-sm-4 col-lg-4">
            <div class="case" id="case-level2">
              <div class="case-head page-header">
                <h3>Nachbarschaft</h3>
                <h5>Balkon, hohes Gebäude, öffentlicher Platz, Park, weitläufiges Gelände</h5>
                <img class="img-responsive"  src="../img/participate/participate_medium.png">
              </div>
              <div class="case-body">
                <dl>
                  <dt>Du möchtest</dt>
                  <dd>
                    <ul>
                      <li>das Freifunk-Netz auf ein größeres Gebiet erweitern. Dazu eignen sich insbesondere höher gelegene Standorte (z.B. Balkone oder Dächer).</li>
                      <li>eine Verbindung zu einem weiter entfernten (bis ~5km) Freifunk-Router herstellen. Für stabile Verbindungen wird eine freie Sicht zum entfernten Router benötigt.</li>
                    </ul>
                  </dd>
                  <dt>So kannst du mitmachen</dt>
                  <dd>
                    <ul>
                      <li>Besorge einen Freifunk-fähigen Outdoor-Router. Empfehlungen:
                        <ul>
                          <li>
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoStation M2, ~80 EUR, 2.4 GHz.">NanoStation M2</a> oder
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoStation M2 loco, ~60 EUR, 2.4 GHz.">M2 loco</a> (2.4 GHz)
                          </li>
                          <li>
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoStation M5, ~80 EUR, 5 GHz.">NanoStation M5</a> oder
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoStation M5 loco, ~60 EUR, 5 GHz.">M5 loco</a> (5 GHz)
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="col-sm-4 col-lg-4">
            <div class="case" id="case-backbone">
              <div class="case-head page-header">
                <h3>Backbone</h3>
                <h5>Dach, Dachgeschoss, hohes Gebäude, öffentliches Gebäude, Rathaus, Kirchturm</h5>
                <img class="img-responsive"  src="../img/participate/participate_big.png">
              </div>
              <div class="case-body">
                <dl>
                  <dt>Du möchtest</dt>
                  <dd>
                    <ul>
                      <li>das "Rückgrat" des Freifunk-Netzes stärken, indem du stabile Richtfunk-Verbindungen zu weit entfernten Freifunk-Routern aufbaust (bis ~10km). Für stabile Verbindungen wird eine freie Sicht zum entfernten Router benötigt.</li>
                    </ul>
                  </dd>
                  <dt>So kannst du mitmachen</dt>
                  <dd>
                    <ul>
                      <li>Besorge mehrere Freifunk-fähige Outdoor-Router für 5 GHz. Empfehlungen:
                        <ul>
                          <li>
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoStation M5, ~80 EUR, 5 GHz.">NanoStation M5</a> (bis ~5 km)
                          </li>
                          <li>
                            <a href="#" data-toggle="tooltip" title="Ubiquiti NanoBridge M5, ~80 EUR, 5 GHz.">NanoBridge M5</a> (bis ~10 km)
                          </li>
                        </ul>
                      </li>
                      <li>Die neuen Verbindungen solltest du mit den Freifunker_innen planen, die die entfernten Router betreiben.</li>
                    </ul>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
	</div>
        
          <div class="clearfix hidden-lg"></div>
	<div class="row">
          <div class="col-sm-12 col-lg-12">
            <h3 id="more">Weitere Informationen und Hinweise</h3>
            <dl>
              <dt>Wo stehen schon Freifunk-Router?</dt>
              <dd>Schau mal auf der <a href="../map2">Netzkarte</a> nach. Wenn es bei dir noch keinen Freifunk-Router in der Nachbarschaft gibt, dann sei die oder der Erste!</dd>
              <dt>Benötige ich einen Router für 2.4 GHz oder 5 GHz?</dt>
              <dd>Damit sich ein Freifunk-Router mit einem anderen Freifunk-Router über WLAN verbinden kann, müssen beide Router im gleichen Frequenzband (2.4 GHz oder 5 GHz) arbeiten. Die meisten Router funken momentan (Ende 2013) auf dem 2.4 Ghz-Band; 5 Ghz wird zumeist für Richtfunk-Strecken eingesetzt. In Zweifelsfall sprich dich mit deinen Funknachbarn ab oder komme zum Freifunktreffen.</dd>
              <dt>Können mehrere Freifunk-Router an einem Ort miteinander verbunden werden?</dt>
              <dd>Mehrere Freifunk-Router können über ein Switch mit Netzwerk-Kabeln verbunden werden. Die im <em>Starter-Kit</em> empfohlenen Router haben z.B. einen integrierten Switch. Das bedeutet, du kannst zwei dieser Router direkt mit einem Kabel verbinden</dd>
            </dl>

            <small>Die Inhalte dieser Seite wurden von <a href="http://berlin.freifunk.net" target="_blank">Freifunk Berlin</a> übernommen und angepasst.</small>
          </div>

        </div> <!--end case-row-->
    
      </div> <!-- end page-12 -->
    </div> <!-- end page-row -->


<script>
  $('[data-toggle="tooltip"]').tooltip({placement: 'top', html: true})
  $('[data-toggle="popover"]').popover({placement: 'top', html: true})
</script>

    <?php include("../inc/footer.inc.php") ?>

  </div> <!-- ende container -->    

  <?php include("../inc/_foot.inc.php") ?>


</body></html>
