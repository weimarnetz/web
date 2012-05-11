<?php

	function getActiveClass($filename) {
		if ($filename == basename($_SERVER["SCRIPT_NAME"]))
		{
			return "class='active'";
			}
			
	}

?>

<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./index.php">Weimarnetz Rootserver</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li <?php echo getActiveClass("index.php")?> ><a href="./index.php">Home</a></li>
              <li class="dropdown">
						<a href="#"	class="dropdown-toggle"	data-toggle="dropdown">Informationen <b class="caret"></b></a>
						<ul class="dropdown-menu">
				  			<li<?php echo getActiveClass("wiki.php")?>><a href="./wiki.php">Wiki</a></li>
							<li<?php echo getActiveClass("news.php")?>><a href="./news.php" >Newsserver</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#"	class="dropdown-toggle"	data-toggle="dropdown">Karten <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?php echo getActiveClass("map.php")?> ><a href="./map.php">Geographische Karte</a></li>
							<li <?php echo getActiveClass("topology.php")?> ><a href="./topology.php">Topologische Karte</a></li>
						</ul>					
					</li>
				   <li class="dropdown">
				   	<a href="#"	class="dropdown-toggle"	data-toggle="dropdown">Status <b class="caret"></b></a>
				   	<ul class="dropdown-menu">
				  			<li <?php echo getActiveClass("status.php")?> ><a href="./status.php" >OLSR Status</a></li> 	
				  			<li <?php echo getActiveClass("monitoring.php")?> ><a href="./monitoring.php" >Monitoring</a></li>
				  			</ul>
				   </li>
              <li class="divider-vertical"></li>
               <ul class="nav pull-right">         
              	<li <?php echo getActiveClass("about.php")?> ><a href="./about.php">Über</a></li>
              	<li <?php echo getActiveClass("contact.php")?> ><a href="./contact.php">Kontakt</a></li>
              </ul>
              </ul>
            
          </div>
        </div>
      </div>
    </div>