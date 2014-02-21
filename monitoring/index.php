<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Monitoring</title>
  <?php include("../inc/_head.inc.php") ?>
  <script src="/inc/sorttable.js"></script>
  <link href="/inc/monitoring.css" rel="stylesheet">
</head>

<body onload="setIframeHeight('ifrm');" onresize="setIframeHeight('ifrm');">

  <?php include("../inc/navbar.inc.php") ?>

  <div class="container">

	 	<h1>Monitoring</h1>
	 	<div class="row">
	 	<div class="span6">Monitoring von Freifunkroutern in Weimar - Dokumentation folgt.</div>
	 	<div class="span1 offset5"><a class="btn" href="http://intercity-vpn.de/networks/ffweimar/" target="_blank">Neues&nbsp;Tab</a></div>
	 	</div>
	 	<div class="row">	 	
	 	</div>
	 	<div>&nbsp;</div>

<table class="outer table table-striped sortable">
    <thead>
        <tr>
            <th class="sorttable_numeric">Geändert<span id="sorttable_sortfwdind">&nbsp;▾</span></th>
            <th>Name</th>
	    <th class="sorttable_numeric">Knoten</th>
	    <th>Firmware</th>
	    <th class="sorttable_numeric">Uptime in h</th>
	    <th class="sorttable_numeric">Nachbarn</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="infoboxes">

</div>
	
<script src="../underscore.js"></script>
  <?php include("../inc/footer.inc.php") ?>

</div>

<script type="text/html" id='table-data'>
    
    <% _.each(items,function(item,key,list){ if (item.doc.firmware){%>
    <tr>
        <td class="<%= lastChangeColor(item.doc.mtime) %>"><%= item.doc.mtime  %></td>
        <td><a href="#" data-toggle="modal" data-target="#info<%= key %>"><%= item.doc.hostname %></a></td>
	  <% if (item.doc.olsr.ipv4Config) {%> 
	    <td data-nodenumer="<%= item.doc.nodeNumber %>" data-mainip="<%= item.doc.olsr.ipv4Config.mainIpAddress %>">
	      <a href="http://<%= item.doc.olsr.ipv4Config.mainIpAddress %>/cgi-bin-status.html" target="_blank">
	      <%= item.doc.nodeNumber %>
	      </a><% } else { %>
	    <td>
	  <% } %>
	</td>
	<td><%= item.doc.firmware.revision %></td>
	<td data-uptime="<%= item.doc.system.uptime %>"><%= Math.round(item.doc.system.uptime/3600)   %></td>
	<td><%= item.doc.links.length %></td>
    
    </tr>
    <% }}) %>
</script>

<script type="text/html" id='info-data'>
    <% _.each(items,function(item,key,list){ if (item.doc.firmware){%>
    <div class="modal fade" id="info<%= key %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Detailinformationen zu <strong><%= item.doc.hostname %></strong></h4>
          </div>
          <div class="modal-body">
	    <ul class="nav nav-tabs" id="dev<%= key%>">
	      <li class="active"><a href="#device<%= key %>" data-toggle="pill">Gerät</a></li>
	      <li><a href="#network<%= key %>" data-toggle="pill">Netzwerk</a></li>
	      <li><a href="#olsr<%= key %>" data-toggle="pill">OLSR</a></li>
	    </ul>
	    <div class="tab-content">
	      <div class="tab-pane fade in active" id="device<%= key %>">
		<dl><dt>Bezeichnung</dt><dd><%= item.doc.hardware %></dd></dl>
	      </div>
	      <div class="tab-pane fade in" id="network<%= key %>">
		<dl>
		<% _.each(item.doc.interfaces,function(iface,ifaceKey,ifaceList) {
		  if (iface.ipaddr) {%>
		    <dt><%= iface.ifname%></dt><dd><%=iface.ipaddr%></dd>
		<%}
		 }) %>
		</dl>
	      </div>
	      <div class="tab-pane fade in" id="olsr<%= key %>">
		<dl>
		<% _.each(item.doc.olsr.links,function(olinks,olsrKey,olsrList) {%>
		  <dt><%= olinks.destNodeId%></dt><dd><%=olinks.destAddr%></dd>
		<% }) %>
		</dl>
	      </div>
	    </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
          </div>
        </div> 
      </div>
    </div>
    <% }}) %>
</script>


<?php include("../inc/_foot.inc.php") ?>
<script  type="text/javascript">
var tableTemplate = $("#table-data").html();
var infoBoxes = $("#info-data").html();
test = function(){
url = "http://mapapi.weimarnetz.de/db/_all_docs?include_docs=true";
$.ajax({
url: url,
dataType: 'jsonp',
success: ( function(Response){
  delete Response["myhostname"]; 
  console.log(26, 'responseis: ', Response);
  var rows = Response.rows;
  rows = rows.sort(function(a,b) { return new Date(b.doc.mtime).getTime() - new Date(a.doc.mtime).getTime();}); 
  _.each(rows, function(item, key, list) {
    var diff = new Date().getTime() - new Date(item.doc.mtime).getTime();
    item.doc.mtime = Math.round(diff/36000000);
    if (item.doc.olsr && item.doc.olsr.ipv4Config) {
      item.doc.nodeNumber = getNodeNumber(item.doc.olsr.ipv4Config.mainIpAddress);
    }
  });
  console.log(26, 'sorted: ', rows);
  $("table.outer tbody").html(_.template(tableTemplate,{items:rows}));
  $("div.infoboxes").html(_.template(infoBoxes,{items:rows}));
} ),
error: function(XMLHttpRequest, textStatus, errorThrown){alert("Error");
}
});
};
test()

function getNodeNumber(ip) {
  ip = ip.split(".");
  return Math.round(ip[2]) + ( Math.round(ip[3] / 64) -1 ) * 255;
}

function lastChangeColor(mtime) {
  if (mtime<=12) {
    return "success";
  } else if (mtime<=96) {
    return "warning";
  } else if (mtime<=192) {
    return "danger";
  } else {
    return "danger";
  }
}
  

</script>
</body></html>
