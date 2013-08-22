<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Monitoring</title>
  <?php include("./inc/_head.inc.php") ?>
</head>

<body onload="setIframeHeight('ifrm');" onresize="setIframeHeight('ifrm');">

  <?php include("./inc/navbar.inc.php") ?>

  <div class="container">

	 	<h1>Monitoring</h1>
	 	<div class="row">
	 	<div class="span6">Monitoring von Freifunkroutern in Weimar - Dokumentation folgt.</div>
	 	<div class="span1 offset5"><a class="btn" href="http://intercity-vpn.de/networks/ffweimar/" target="_blank">Neues&nbsp;Tab</a></div>
	 	</div>
	 	<div class="row">	 	
	 	</div>
	 	<div>&nbsp;</div>
	 	<div style="text-align: center"><iframe id="ifrm" src="http://intercity-vpn.de/networks/ffweimar/" width="98%" scrolling="yes" marginwidth="0"
marginheight="0" frameborder="0">test</iframe></div>
	 	
	
  <?php include("./inc/footer.inc.php") ?>

</div>

<?php include("./inc/_foot.inc.php") ?>

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

</body></html>
