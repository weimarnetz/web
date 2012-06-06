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
  </head>

  <body>

 <?php include("./inc/header.inc.php")?>

  <script type="text/javascript" src="./js/cbi.js"></script>
<script type="text/javascript">//<![CDATA[                         
                                                                   
        XHR.poll(10 , '<%=REQUEST_URI%>', { status: 1 },           
                function(x, info)                                  
                {                                                  
                var nt = document.getElementById('olsr_neigh_table');
                        if (nt)                                      
                        {                                            
                                var s = '';                          
                                for (var idx = 0; idx < info.length; idx++)
                                {                                          
                                        var neigh = info[idx];             
                                                                           
                                        s += String.format(                
                                                '<tr class="cbi-section-table-row cbi-rowstyle-'+(1 + (idx % 2))+'">' +
                                                        '<td class="cbi-section-table-cell" style="background-color:%s"><a href="http://%s/cgi-bin-status.html">%s</a></td>',
                                                neigh.dfgcolor, neigh.rip, neigh.rip                                                                                         
                                                );                                                                                                                           
                                        if (neigh.hn) {                                                                                                                      
                                                s += String.format(                                                                                                          
                                                        '<td class="cbi-section-table-cell" style="background-color:%s"><a href="http://%s/cgi-bin-status.html">%s</a></td>',
                                                        neigh.dfgcolor, neigh.hn, neigh.hn                                                                                   
                                                        );                                                                                                                   
                                                }                                                                                                                            
                                        else    {                                                                                                                            
                                                s += String.format(                                                                                                          
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">?</td>',                                             
                                                        neigh.dfgcolor                                                                                                       
                                                        );                                                                                                                   
                                                }                                                                                                                            
                                        s += String.format(                                                                                                                  
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">%s</td>' +                                           
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">%s</td>' +                                           
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">%s</td>' +                                           
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">%s</td>' +                                           
                                                        '<td class="cbi-section-table-cell" style="background-color:%s">%s</td>' +                                           
                                                '</tr>',                                                                                                                     
                                                                                                                                                                             
                                                        neigh.dfgcolor, neigh.lip, neigh.dfgcolor, neigh.dev, neigh.dfgcolor, neigh.lq, neigh.dfgcolor, neigh.nlq, neigh.color, neigh.cost || '?'
                                                );                                                                                                                                               
                                }                                                                                                                                                                
                                                                                                                                                                                                 
                                nt.innerHTML = s;                                                                                                                                                
                        }                                                                                                                                                                        
                }                                                                                                                                                                                
        );                                                                                                                                                                                       
//]]></script>

<h2><a id="content" name="content"><%:OLSR connections%></a></h2>                                                                                                                                
                                                                                                                                                                                                 
<fieldset class="cbi-section">                                                                                                                                               
        <legend><%:Overview of currently established OLSR connections%></legend>                                                                                                                 
                                                                                                                                                                                                 
        <table class="cbi-section-table">                                                                                                                                    
                <thead>                                                                                                                                                                          
                        <tr class="cbi-section-table-titles">                                                                                                                                    
                                <th class="cbi-section-table-cell"><%:Neighbour IP%></th>                                                                                                        
                                <th class="cbi-section-table-cell"><%:Hostname%></th>                                                                                                            
                                <th class="cbi-section-table-cell"><%:Local interface IP%></th>                                                                              
                                <th class="cbi-section-table-cell"><%:Device%></th>                                                                                          
                                <th class="cbi-section-table-cell">LQ</th>                                                                                                                       
                                <th class="cbi-section-table-cell">NLQ</th>                                                                                                                      
                                <th class="cbi-section-table-cell">ETX</th>                                                                                                                      
                        </tr>                                                                                                                                                                    
                </thead>                                                                                                                                                     
                                                                                                                                                                                                 
                <tbody id="olsr_neigh_table">
                
                <?php
                
                ?>                                                                                                                                                    
                
                <%      local i = 1                                                                                                                                                              
                        for k, link in ipairs(links) do                                                                                                                                          
                        link.Cost = tonumber(link.Cost) or 0                                                                                                                                     
                        color = olsrtools.etx_color(link.Cost)                                                                                                               
                                                                                                                                                                             
                        defaultgw_color = ""                                                                                                                                                     
                        if link.defaultgw == 1 then                                                                                                                                              
                                defaultgw_color = "#ffff99"                                                                                                                                      
                        end                                                                                                                                                                      
                %>                                                                                                                                                                               
                                                                                                                                                                                                 
                <tr class="cbi-section-table-row cbi-rowstyle-<%=i%>">                                                                                                                           
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><a href="http://<%=link["Remote IP"]%>/cgi-bin-status.html"><%=link["Remote IP"]%></a></td>
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><a href="http://<%=link["Hostname"]%>/cgi-bin-status.html"><%=link["Hostname"]%></a></td>  
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><%=link["Local IP"]%></td>                                                                 
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><%=link["Local Device"]%></td>                                                             
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><%=link.LQ%></td>                                                                          
                        <td class="cbi-section-table-cell" style="background-color:<%=defaultgw_color%>"><%=link.NLQ%></td>                                                                         
                        <td class="cbi-section-table-cell" style="background-color:<%=color%>"><%=string.format("%.3f", link.Cost)%></td>                                                           
                </tr>                                                                                                                                                                             
                <%                                                                                                                                                                               
                        i = ((i % 2) + 1)                                                                                                                                                           
                end %>                                                                                                                                                                              
                </tbody>                                                                                                                                                                            
        </table>                                                                                                                                                                                    
<br />                                                                                                                                                                                            
                                                                                                                                                                                                    
<h3>Legende:</h3>                                                                                                                                                                               
<ul>                                                                                                                                                                                              
        <li><strong>LQ: </strong><%:Success rate of packages received from the neighbour%></li>                                                                                                     
        <li><strong>NLQ: </strong><%:Success rate of packages sent to the neighbour%></li>                                                                                                          
        <li><strong>ETX: </strong><%:Expected retransmission count%></li>                                                                                                                           
</ul>                                                                                                                                                                                               
</fieldset>
    	
 <?php include("./inc/footer.inc.php")?>



</body></html>