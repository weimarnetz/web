<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Kontakt</title>
  <?php include("../inc/_head.inc.php") ?>
</head>

<body>

  <?php include("../inc/navbar.inc.php") ?>

  <div class="container">
    <h1>Kontakt</h1>
    Es gibt mannigfaltige Möglichkeiten, uns zu erreichen.<br>
    <div class="row">
      <!-- hier sind 4 blöcke -->
      <!-- 1/2 grid, auf großem display 1/4 grid -->
      <div class="col-sm-6 col-lg-3"><h2>Per Mailingliste</h2>
        <address><strong>Allgemeine Liste</strong><br>
          wireless@subsignal.org    
        </address>
        <address><strong>Diskussionsliste</strong><br>
          wireless-discuss@subsignal.org</address>
          <span class="label label-warning">Achtung!</span> Die Teilnahme an den Mailinglisten setzt eine <a href="http://wireless.subsignal.org/index.php?title=Mailingliste" target="_blank">Registrierung</a> voraus, sonst kommt unter Umständen nie eine Antwort an. Alternativ kann der <a href="./news.php">Newsserver</a> ohne Anmeldung genutzt werden. 
        </div>
        <div class="col-sm-6 col-lg-3"><h2>Persönlich</h2>
          <p>Wir treffen uns wöchentlich jeden Dienstag ab 20 Uhr, meist im Maschinenraum in der Marienstraße 18. Neben Vorträgen und der Möglichkeit zum Erfahrungsaustausch gibt es viel praktische Firmwareentwicklung und wenn nötig, Bastelorgien am Gerät. Falls dann noch Zeit bleibt, kann man Mate und Bier genießen.<br> Wir begrüßen außerdem gern neue Interessenten und geben Hilfestellung bei Problemen oder der Inbetriebnahme eines neuen Knoten.</p>
          <p>Wann und wo das nächste Treffen stattfindet und ob es aktuelle Themen zu bearbeiten gibt, steht im <a href="http://wireless.subsignal.org/index.php?title=Treffen" target="_blank" >Wiki</a>.</p>
        </div>
        <div class="col-sm-6 col-lg-3"><h2>Postalisch</h2>
          <address><strong>Weimarnetz e.V.</strong><br>
            Marienstr. 18<br>
            99423 Weimar</address>
          </div>
          <div class="col-sm-6 col-lg-3"><h2>Telefonisch</h2>
            <address><strong>Weimarnetz Sorgentelefon</strong><br>
              03643 / 544 304</address>   
            </div> 
          </div>
          <div class="row">
            <!-- zweite Reihe -->
            <!-- 1 grid je für fb und twitter, auf großem display 1/2 -->
            <div class="col-sm-12 col-lg-6">
              <h2>Twitter</h2>
              <p>Folge uns auf Twitter und verpasse keine Neuigkeiten</p>
              <a class="twitter-timeline" href="https://twitter.com/weimarnetz" data-chrome="nofooter transparent noborders" data-tweet-limit="5" data-widget-id="386773629188317184">Tweets von @weimarnetz</a>
              <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
            <div class="col-sm-12 col-lg-6">
              <h2>Facebook</h2>
              <p>Gib uns dein Like bei Facebook. Hier findest du Informationen und kannst uns Fragen stellen oder mit uns diskutieren.</p>
              <div class="fb-like-box" data-href="http://www.facebook.com/weimarnetz" data-width="The pixel width of the plugin" data-height="300" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
              <div id="fb-root"></div>
              <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
            </div>
          </div>
          <?php include("../inc/footer.inc.php")?>

        </div> <!-- ende container -->

        <?php include("../inc/_foot.inc.php")?>

</body>
</html>
