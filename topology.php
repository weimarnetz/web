<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Topologie</title>
  <?php include("./inc/_head.inc.php") ?>
</head>

<body>

  <?php include("./inc/navbar.inc.php") ?>

  <script type="text/javascript">
    
    function getElement(aID)
    {
        return (document.getElementById) ?
            document.getElementById(aID) :document.all[aID];
    }

    function getIFrameDocument(aID){ 
        var rv = null; 
        var frame=getElement(aID);
        // if contentDocument exists, W3C compliant (e.g. Mozilla) 
        if (frame.contentDocument)
            rv = frame.contentDocument;
        else // bad Internet Explorer  ;)
            rv = document.frames[aID].document;
        return rv;
    }

    function adjustMyFrameHeight()
    {
        var frame = getElement("myFrame");
        var frameDoc = getIFrameDocument("myFrame");
        frame.height = frameDoc.body.offsetHeight;
    }
</script>

	 <div class="container">
		<h1>Topologie</h1>
		<div class="row">
	 	<div class="span4">Unsere aktuelle Meshtopologie - aktualisiert alle 5 Minuten.</div> 
	 	<div class="span1 offset7"><a class="btn" href="http://weimarnetz.de/freifunk/topology.png" target="_blank">Originalgröße</a></div>
	 	</div>
	 	<div style="text-align: center"><a href="http://weimarnetz.de/freifunk/topology.png" target="_blank" name="Weimarnetz Topologie"><img width="98%" src="http://weimarnetz.de/freifunk/topology.png" alt="Topologie Weimarnetz" longdesc="Zeigt die aktuelle Topologie des Netzes, Aktualisierung alle 5 Minuten" /></a></div>
    
    <?php include("./inc/footer.inc.php") ?>

    </div> <!-- ende container -->
  
    <?php include("./inc/_foot.inc.php") ?>


  </body></html>
