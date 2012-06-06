<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Weimarnetz - Karte</title>
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
  
	
<?php include("./inc/header.inc.php")?>

	 <div class="container">
  <script src="http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1" type="text/javascript"></script>
                <script type="text/javascript">                                                                            
                        var alias = new Array;                                                                             
                        var points = new Array;                                                                            
                        var unkpos = new Array;                                                                            
                        var lineid = 0;                                                                                    
                        onload=new Function("if(null!=window.ffmapinit)ffmapinit();");                                     
                                                                                                                           
                        function Mid(mainip,aliasip)                                  
                        {                                                             
                                alias[aliasip]=mainip;                                
                        }                                                             
                                                                                      
                        function Node(mainip,lat,lon,ishna,hnaip,name)                
                        {                                                            
                                points[mainip] = new VELatLong(lat, lon);
                                map.AddPushpin(new VEPushpin(mainip, points[mainip],  
                                './img/'+(ishna?'hna':'node')+'.gif', 'Node:'+name,
                                '<br><img src="./img/'+(ishna?'hna':'node')+'.gif">'+
                                '<br>IP:'+mainip+'<br>DefGW:'+hnaip));                                                         
                        }                                                                                                      
                                                                                                                               
                        function Self(mainip,lat,lon,ishna,hnaip,name)                                                         
                        {                                                                                                      
                                //map.SetDashboardSize(VEDashboardSize.Small);                                                 
                                map.LoadMap(new VELatLong(lat, lon), 15, VEMapStyle.Hybrid);                                   
                                map.SetScaleBarDistanceUnit(VEDistanceUnit.Kilometers);     
                                map.ShowMiniMap(14, 474);                                   
                                Node(mainip,lat,lon,ishna,hnaip,name);                      
                        }                                                                   
                                                                                            
                        function Link(fromip,toip,lq,nlq,etx)                               
                        {                                                                   
                                if (0==lineid && null!=window.ffmapstatic) ffmapstatic();
                                if (null != alias[toip]) toip = alias[toip];             
                                if (null != alias[fromip]) fromip = alias[fromip];       
                                if (null != points[fromip] && null != points[toip])      
                                {                                                        
                                        var w = 1;                                       
                                        if (etx < 4) w++;                                
                                        if (etx < 2) w++;                                
                                        map.AddPolyline(new VEPolyline('id'+lineid, [points[fromip], points[toip]],
                                        new VEColor(102,Math.floor(lq*255.0),Math.floor(nlq*255.0),1.0), w));      
                                }                                                                                  
                                else                                                                               
                                {                                                                                  
                                        if (null == points[toip]) unkpos[toip] = '';                               
                                        if (null == points[fromip]) unkpos[fromip] = '';                           
                                }                                                                                  
                                lineid++;                                                                    
                        }                                                               
                                                                                        
                        function PLink(fromip,toip,lq,nlq,etx,lata,lona,ishnaa,latb,lonb,ishnab)
                        {                                                                       
                                Link(fromip,toip,lq,nlq,etx);                                   
                        }                                                                       
                                                                                                
                        function ffmapinit()                                                    
                        {                                                                       
                                if(null!=window.map)map.Dispose();
                                                                                                                                                               
                                var INFINITE = 99.99;                                                                          
                                                                                                                               
                                map = new VEMap('ffmap');
                                
                                <?php
                                	$latlonfile = file_get_contents("/var/run/latlon.js");
                                	
                                	if ($latlonfile) {
                                		$lines = explode("\n", $latlonfile);
                                		echo current($lines);
                                		while (next($lines)) {
                                			echo current($lines);
                                			}
                                		}
                                	?>
                        }                                                                                        
                                                                                                                 
                        function ffgoto(ip)                                                                      
                        {                                                                                        
                                map.SetCenter(points[ip]);                                                       
                        }                                                                                        
                </script>                                                                                        
                <div id="ffmap" style="position:relative; width:100%; height:640px;"></div> 

	</div>

    	
<?php include("./inc/footer.inc.php")?>


</body></html>