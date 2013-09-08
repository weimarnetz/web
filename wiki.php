<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Wiki</title>
  <?php include("./inc/_head.inc.php") ?>
  
</head>

<body onload="setIframeHeight('ifrm');" onresize="setIframeHeight('ifrm');">

  <?php include("./inc/navbar.inc.php") ?>

	 <div class="container">
	 	<h1>Wiki</h1>
	 	<div class="row">
	 	<div class="span4">Mach mit auf unserem Wiki!</div>
	 	<div class="span1 offset7"><a class="btn" href="http://wireless.subsignal.org" target="_blank">Neues&nbsp;Tab</a></div>
	 	</div>
	 	<div class="row">	 	
	 	<div class="span6"><span class="label label-warning">Fixme!</span> Seiten mit Umlauten im Namen werden im iFrame nicht geladen</div>
	 	</div>
	 	<div>&nbsp;</div>
	 	<div style="text-align: center"><iframe id="ifrm" src="http://wireless.subsignal.org" width="98%" scrolling="yes" marginwidth="0"
marginheight="0" frameborder="0">test</iframe></div>
	 	
	
  <?php include("./inc/footer.inc.php") ?>

  </div> <!-- ende container -->
  
  <?php include("./inc/_foot.inc.php") ?>


</body></html>
