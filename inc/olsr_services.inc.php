<table class="table table-striped">                                                                                                                   
	<thead>                                                                                                                                       
		<tr>                                                                                                                                  
			<th>URL</th>
			<th>Protokoll</th>
			<th>Quelle</th>
		</tr>                                                                                                                                 
	</thead>                                                                                                                                      
<tbody id="services_table">

<?php
$contents = file_get_contents("/var/run/services_olsr");
$contentLines = explode("\n", $contents);

foreach ($contentLines as &$line)  
{
	if (($line == "" || strpos($line, "#") == 0))
	{
		continue;
	}
	
	echo "<tr>";
	$serviceLine = explode("#", $line);
	$serviceLine[1] = trim($serviceLine[1]);
	if (strpos($serviceLine[1], "my") !== false)
	{
		$serviceLine[1] = "weimarnetz.de";
	}
	$service = explode("|", $serviceLine[0]);
	echo "<td><a href=\"".$service[0]."\" target=\"_window\">".$service[2]."</a></td>";
	echo "<td>".$service[1]."</td>";
	echo "<td><a href=\"http://".$serviceLine[1]."/cgi-bin-status.html\" target=\"_window\">".$serviceLine[1]."</a></td>";
	echo "</tr>";
}

?>
</tbody>
</table>
