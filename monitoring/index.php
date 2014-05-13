<!DOCTYPE html>
<html lang="en"><head>
  <title>Weimarnetz - Monitoring</title>
  <?php include("../inc/_head.inc.php") ?>
  <script src="/inc/sorttable.js"></script>
  <link href="/inc/monitoring.css" rel="stylesheet">
  <link href="/inc/jquery.loadmask.css" rel="stylesheet">
</head>

<body onload="setIframeHeight('ifrm');" onresize="setIframeHeight('ifrm');">

  <?php include("../inc/navbar.inc.php") ?>
<?php
  $apifile = "http://www.weimarnetz.de/weimarnetz.json";
  $monfile = "http://www.weimarnetz.de/monitoring.json";

  $api = file_get_contents($apifile);
  $json = json_decode($api, true);
  $mon = file_get_contents($monfile);
  $monjson = json_decode($mon, true);
  $servertable = '<table class="table table-striped sortable">' 
    . '<thead>'
    . ' <tr>'
    .	'<th title="Hostname des Servers">Name</th>'
    .	'<th title="Status des Servers (Up=läuft, Down=aus)">Status</th>'
    .	'<th title="Anzahl Services in Ordnung">Ok</th>'
    .	'<th title="Anzahl Services mit Warnung">Warnung</th>'
    .	'<th title="Anzahl kritischer Services">Kritisch</th>'
    .	'<th title="Anzahl Services, auf deren Rückmeldung gewartet wird">Wartend</th>'
    .	'<th title="Anzahl Serices mit Status unbekannt">Unbekannt</th>'
    .  '</tr>'
    .'</thead>';
  foreach($monjson['server'] as $server) {
    if ($server['host_state'] == "UP" ) { $stateclass = "success";} else {$stateclass = "danger";}
    if ($server['num_services_ok'] > 0 ) { $okclass = "";} else {$okclass = "danger";}
    if ($server['num_services_warn'] > 0 ) { $warnclass = "warning";} else {$warnclass = "";}
    if ($server['num_services_crit'] > 0 ) { $critclass = "danger";} else {$critclass = "";}
    if ($server['num_services_pending'] > 0 ) { $pendingclass = "info";} else {$pendingclass = "";}
    $servertable .= '<tr>'
      . '<td class="' . $stateclass . '">' . $server['host'] . '</td>'
      . '<td>' . $server['host_state'] . '</td>'
      . '<td class="' . $okclass . '">' . $server['num_services_ok'] . '</td>'
      . '<td class="' . $warnclass . '">' . $server['num_services_warn'] . '</td>'
      . '<td class="' . $critclass . '">' . $server['num_services_crit'] . '</td>'
      . '<td class="' . $pendingclass . '">' . $server['num_services_pending'] . '</td>'
      . '<td>' . $server['num_services_unknown'] . '</td>'
      . '</tr>';  
  }

  $servertable .= '</table>';

  if ($monjson['routes_counter']['service_state'] == "OK" && $monjson['olsrd']['service_state'] == "OK") {
    $servicetable = '<div class="row alert alert-success">VPN + OLSR OK - OLSR: ' . $monjson['olsrd']['svc_plugin_output'] . ', Routen: ' . $monjson['routes_counter']['svc_plugin_output'] . '</div>';
  } else {
    $servicetable = '<div class="row alert alert-danger">VPN + OLSR nicht OK - OLSR: ' . $monjson['olsrd']['svc_plugin_output'] . ', Routen: ' . $monjson['routes_counter']['svc_plugin_output'] . '</div>';
  }
    
?>
  <div class="container">

<h1>Monitoring</h1>
<div class="row">
<div class="span6">Monitoring von Freifunkroutern in Weimar - Dokumentation folgt.</div>
</div>

<h2>Allgemeine Daten</h2>
<div class="row warning">
<h3>VPN</h3>
<?php echo $servicetable;?>
<h3>Server</h3>
<?php echo $servertable;?>
</div>

<h2>Daten der Router</h2>
<div class="row">
<div class="routergesamt">Router gesamt: </div>
Router erreichbar: <?php echo $json['state']['nodes']; ?> 
<table class="router table table-striped sortable">
    <thead>
        <tr>
            <th title="Vor so vielen Stunden wurde die Information zuletzt aktualisiert" class="sorttable_sorted sorttable_numeric">Alter in h<span id="sorttable_sortfwdind">&nbsp;▾</span></th>
            <th title="Name des Routers">Name</th>
	    <th title="Knotennummer des Routers" class="sorttable_numeric">Knoten</th>
	    <th title="Firmwareversion, die aktuell installiert ist">Firmware</th>
	    <th title="So lang ist der letzte Neustart her" class="sorttable_numeric">Uptime in h</th>
	    <th title="Anzahl der Nachbarknoten, die dieser Knoten sieht" class="sorttable_numeric">Nachbarn</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
<div class="infoboxes">

</div>
	
<script src="/inc/underscore.js"></script>
  <?php include("../inc/footer.inc.php") ?>

</div>

<script type="text/html" id='table-data'>
    
    <% _.each(items,function(item,key,list){ if (item.doc.firmware){%>
    <tr>
        <td class="<%= lastChangeColor(item.doc.mtime) %>"><%= item.doc.mtime  %></td>
        <td><a href="#" data-toggle="modal" data-target="#info<%= key %>"><%= item.doc.hostname %></a></td>
	  <% if (item.doc.olsr.ipv4Config) {%> 
	    <td data-nodenumer="<%= item.doc.weimarnetz.nodenumber %>" data-mainip="<%= item.doc.olsr.ipv4Config.mainIpAddress %>">
	      <a href="http://<%= item.doc.olsr.ipv4Config.mainIpAddress %>/cgi-bin-status.html" target="_blank">
	      <%= item.doc.weimarnetz.nodenumber %>
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
          <div class="modal-body" width="100%">
	    <ul class="nav nav-tabs" id="dev<%= key%>">
	      <li class="active"><a href="#general<%= key %>" data-toggle="tab">Allgemein</a></li>
	      <li><a href="#contact<%= key %>" data-toggle="tab">Kontakt</a></li>
	      <li><a href="#network<%= key %>" data-toggle="tab">Netzwerk</a></li>
	      <li><a href="#olsr<%= key %>" data-toggle="tab">OLSR</a></li>
	      <li><a href="#map<%= key %>" data-toggle="tab" data-tab-url="http://map.weimarnetz.de/#detail?node=<%= item.id %>">Karte</a></li>
	    </ul>
	    <div class="tab-content">
	      <div class="tab-pane fade in active" id="general<%= key %>">
		<dl>
		  <dt>Gerät</dt><dd><%= item.doc.system.sysinfo[1] %></dd>
		  <dt>Hardware</dt><dd><%= item.doc.hardware %></dd>
		  <% if (item.doc.weimarnetz.nexthop ) { %>
		    <dt>nächster Nachbar</dt><dd><%= item.doc.weimarnetz.nexthop %></dd>
		  <% } %>
		  <% if (item.doc.weimarnetz.gateway) { %>
		    <dt>Gateway</dt><dd><%= item.doc.weimarnetz.gateway %></dd>
		  <% } %>
		  <% if (item.doc.weimarnetz.gatewaycost) { %>
		    <dt>Gatewaykosten</dt><dd><%= item.doc.weimarnetz.gatewaycost %></dd>
		  <% } %>
		</dl>
	      </div>
	      <div class="tab-pane fade in" id="network<%= key %>">
		<dl class="slim">
		<% _.each(item.doc.interfaces,function(iface,ifaceKey,ifaceList) {
		  if (iface.ipaddr) {%>
		    <dt><%= iface.ifname%></dt><dd><%=iface.ipaddr%></dd>
		<%}
		 }) %>
		</dl>
	      </div>
	      <div class="tab-pane fade in" id="contact<%= key %>">
		<dl>
		  <% if (item.doc.freifunk.contact.nickname) { %>
		    <dt>Ansprechpartner</dt><dd><%= item.doc.freifunk.contact.nickname %></dd>
		  <% } %>
		  <% if (item.doc.freifunk.contact.mail) { %>
		    <dt>Email</dt><dd><%= item.doc.freifunk.contact.mail %></dd>
		  <% } %>
		  <% if (item.doc.freifunk.contact.phone) { %>
		    <dt>Telefon</dt><dd><%= item.doc.freifunk.contact.phone %></dd>
		  <% } %>
		  <% if (item.doc.location) { %>
		    <dt>Standort</dt><dd><a href="http://map.weimarnetz.de/#detail?node=<%= item.id %>" target="_blank"><%= item.doc.location %></a></dd>
		  <% } %>
		</dl>
	      </div>
	      <div class="tab-pane fade in" id="olsr<%= key %>">
		<dl class="table-display wide">
		<% _.each(item.doc.olsr.links,function(olinks,olsrKey,olsrList) {%>
		  <dt><%= olinks.destNodeId%></dt><dd><%=olinks.destAddr%></dd>
		<% }) %>
		</dl>
	      </div>
	      <div class="tab-pane fade" id="map<%= key%>">
		<div><iframe class="map" id="imap<%= key%>"></iframe></div>
		<script type="text/javascript">
		$('a[href="#map<%= key %>"]').on('shown.bs.tab', function (e) {
		  var el = document.getElementById("imap<%= key%>");
		  lat = parseFloat("<%= item.doc.latitude %>");
		  lon = parseFloat("<%= item.doc.longitude %>");
		  lat1 = lat - 0.0001;
		  lat2 = lat + 0.0001;
		  lon1 = lon - 0.0001;
		  lon2 = lon + 0.0001;
		  console.log(lon1);
		  el.setAttribute('src', 'http://map.weimarnetz.de/mapnohostdetails.html#bbox=' + lat1 + ',' + lon1 + ',' + lat2 + ',' + lon2); 
		});

		 <%= "<"+"/script>" %>
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
    if (! item.doc.weimarnetz) {
      item.doc.weimarnetz = {};
    }
    if (! item.doc.weimarnetz.nodenumber && item.doc.olsr && item.doc.olsr.ipv4Config) {
      item.doc.weimarnetz.nodenumber = getNodeNumber(item.doc.olsr.ipv4Config.mainIpAddress);
    }
    if (! item.doc.weimarnetz.nodenumber) { item.doc.weimarnetz.nodenumber = NaN; }
  });
  console.log(26, 'sorted: ', rows);
  $("div.routergesamt").html("Router gesamt: " + rows.length);
  $("table.router tbody").html(_.template(tableTemplate,{items:rows}));
  $("div.infoboxes").html(_.template(infoBoxes,{items:rows}));
} ),
error: function(XMLHttpRequest, textStatus, errorThrown){alert("Error");
}
});
};
test()

function getNodeNumber(ip) {
  ip = ip.split(".");
  return Math.floor(ip[2]) + ( Math.floor(ip[3] / 64)  ) * 255;
}

function lastChangeColor(mtime) {
  if (mtime<=20) {
    return "success";
  } else if (mtime<=192) {
    return "warning";
  } else {
    return "danger";
  }
}
  

</script>
<script src="/inc/jquery.loadmask.js"></script>
<script src="/inc/bootstrap-remote-tabs.js"></script>

</body></html>
