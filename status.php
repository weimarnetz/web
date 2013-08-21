<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Kontakt</title>
  <?php include("./inc/_head.inc.php") ?>
</head>

<body>

  <?php include("./inc/navbar.inc.php") ?>

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

  <?php include("./inc/footer.inc.php") ?>

  </div> <!-- ende container -->
  
  <?php include("./inc/_foot.inc.php") ?>
  
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

</body></html>
