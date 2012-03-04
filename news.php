<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Newsserver</title>
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
    <script type="text/javascript">
		function setIframeHeight(iframeName) {
		  //var iframeWin = window.frames[iframeName];
		  var iframeEl = document.getElementById? document.getElementById(iframeName): document.all? document.all[iframeName]: null;
		  if (iframeEl) {
		  iframeEl.style.height = "auto"; // helps resize (for some) if new doc shorter than previous
		  //var docHt = getDocHeight(iframeWin.document);
		  // need to add to height to be sure it will all show
		  var h = alertSize();
		  var new_h = (h-148);
		  iframeEl.style.height = new_h + "px";
		  //alertSize();
		  }
		}

		function alertSize() {
		  var myHeight = 0;
		  if( typeof( window.innerWidth ) == 'number' ) {
		    //Non-IE
		    myHeight = window.innerHeight;
		  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		    //IE 6+ in 'standards compliant mode'
		    myHeight = document.documentElement.clientHeight;
		  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		    //IE 4 compatible
		    myHeight = document.body.clientHeight;
		  }
		  //window.alert( 'Height = ' + myHeight );
		  return myHeight;
		}
	</script>
  </head>

  <body onload="setIframeHeight('ifrm');" onresize="setIframeHeight('ifrm');">

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
              <li><a href="./index.php">Home</a></li>
              <li><a href="./wiki.php">Wiki</a></li>
              <li><a href="./map.php">Karte</a></li>             
              <li><a href="./topology.php">Topologie</a></li>
              <li><a href="./status.php" >OLSR Status</a></li>
              <li class="active"><a href="./news.php" >Newsserver</a></li>
              <li><a href="./about.php">Über</a></li>
              <li><a href="./contact.php">Kontakt</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	 <div class="container">
	 	<h1>Newsserver</h1>
	 	<div class="row">
	 	<div class="span6">Zugang zu Newsgroups und Mailinglisten der Freifunkcommunity</div>
	 	<div class="span1 offset5"><a class="btn" href="http://weimarnetz.de/newsgroups" target="_blank">Neues&nbsp;Tab</a></div>
	 	</div>
	 	<div class="row">	 	
	 	<div class="span6"><span class="label label-info">Zugang:</span> Benutzername: <I>freifunk</I> Passwort: <I>weimar</I></div>
	 	</div>
	 	<div>&nbsp;</div>
	 	<div style="text-align: center"><iframe id="ifrm" src="http://weimarnetz.de/newsgroups" width="98%" scrolling="yes" marginwidth="0"
marginheight="0" frameborder="0">test</iframe></div>
	 	
	
	</div>

    	
        <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster--> 
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/jquery.js"></script>	



</body></html>