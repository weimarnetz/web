<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - OLSR Status</title>
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
<!-- For ease i'm just using a JQuery version hosted by JQuery- you can download any version and link to it locally -->
<script src="js/jquery.js"></script>
<script>
(function($)
{
    $(document).ready(function()
    {
        $.ajaxSetup(
        {
            cache: false,
//            beforeSend: function() {
//                $('#content').hide();
//                $('#loading').show();
//            },
            complete: function() {
                $('#loading').hide();
                $('#content').show();
            },
            success: function() {
                $('#loading').hide();
                $('#content').show();
            }
        });
        var $container = $("#content");
        $container.load("status_olsrtable.php");
        var refreshId = setInterval(function()
        {
            $container.load('status_olsrtable.php');
        }, 5000);
    });
})(jQuery);
</script>
  </head>

  <body>

 <?php include("./inc/header.inc.php")?>


<div class="container">
<h1>OLSR connections</h1>                                                                                                                                
                                                                                                                                                                                                 
<fieldset class="cbi-section">                                                                                                                                               
        <legend>Overview of currently established OLSR connections</legend>                                                                                                                 
        <div id="content"></div>
<br />                                                                                                                                                                                            
                                                                                                                                                                                                    
<h3>Legende:</h3>                                                                                                                                                                               
<ul>                                                                                                                                                                                              
	<li><strong>LQ: </strong>Success rate of packages received from the neighbour</li>
	<li><strong>NLQ: </strong>Success rate of packages sent to the neighbour</li>
	<li><strong>ETX: </strong>Expected retransmission count</li>
	<li><strong><span style="color:#00cc00">Green</span></strong>:Very good (ETX &#60; 2)</li>
	<li><strong><span style="color:#ffcb05">Yellow</span></strong>:Good (2 &#60; ETX &#60; 4)</li>
	<li><strong><span style="color:#ff6600">Orange</span></strong>:Still usable (4 &#60; ETX &#60; 10)</li>
	<li><strong><span style="color:#bb3333">Red</span></strong>:Bad (ETX &#62; 10)</li>
</ul>                                                                                                                                                                                               
</fieldset>
</div>
 <?php include("./inc/footer.inc.php")?>



</body></html>
