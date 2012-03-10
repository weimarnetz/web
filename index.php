<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Rootserver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Unknown" >

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="http://twitter.github.com/bootstrap/examples/images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Weimarnetz Rootserver</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="./index.php">Home</a></li>
				  <li><a href="./wiki.php">Wiki</a></li>
				  <li><a href="./map.php">Karte</a></li>             
              <li><a href="./topology.php">Topologie</a></li>
              <li><a href="./status.php" >OLSR Status</a></li>
              <li><a href="./news.php" >Newsserver</a></li>
              <li><a href="./about.php">Über</a></li>
              <li><a href="./contact.php">Kontakt</a></li>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <h1>Willkommen im Weimarnetz</h1>
      
      <h2>Aktuelle Meldungen</h2>
      <div class="row">
      <div class="span6">
      <?php
      	$wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles");
      	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
      	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
      	?>
      	</div>
      	<div class="span6">                                                                                                          
				<a href="http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles&action=edit" target="_blank"><small>Text bearbeiten</small></a>
			</div>
			</div>      	
      <h2>Aktuelle Diskussionen</h2>
      <div class="row">
      <div class="span6">
      <?php
      	echo str_replace("<a href=", "<a target=_blank href=",file_get_contents("http://weimarnetz.de/latestnews.html"));
      	?>
      	</div>
      	<div class="span6">
      	<A HREF="./news.php" target="_blank" >Direktlink</A> zum Newsserver<br>Benutzername: <I>freifunk</I> Passwort: <I>weimar</I>
      	</div>
      	</div>
      	<h2>Spendenaufruf</h2>
      	<div class="row">
      	<div class="span6"><?php
      	$wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Spendenaufruf");
      	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
      	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
      	?></div>
      	<div class="span6">
<form action="https://www.paypal.com/cgi-bin/webscr"
   method="post">
   <input type="hidden" name="cmd" value="_xclick" />
   <input type="hidden" name="business"
        value="wireless-discuss@subsignal.org" />
   <input type="hidden" name="item_name"
      value="Weimarnetz e.V. Einzelspende" />
   <input type="hidden" name="item_number"
      value=": Spende ueber weimarnetz.de" />
   <input type="hidden" name="amount" value="" />
   <input type="hidden" name="lc" value="DE" />
   <input type="image"
        src="http://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif"
        title="Paypal-Spende"
        border="0" name="submit" alt="Paypal-Spende" />
   <img alt="" border="0"
      src="http://www.paypal.com/de_DE/i/scr/pixel.gif"
      width="1" height="1" />
   <input type="hidden" name="no_shipping" value="2" />
   <input type="hidden" name="no_note" value="1" />
   <input type="hidden" name="currency_code" value="EUR" />
   <input type="hidden" name="tax" value="0" />
   <input type="hidden" name="bn" value="IC_Beispiel" />
</form>
	</div>
	</div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/jquery.js"></script>

  

</body></html>