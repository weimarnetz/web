<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Karte</title>
  <?php include("./inc/_head.inc.php") ?>
</head>

<body>

  <?php include("./inc/navbar.inc.php") ?>

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

  <?php include("./inc/footer.inc.php")?>
  </div>


<?php include("./inc/_foot.inc.php")?>

</body></html>