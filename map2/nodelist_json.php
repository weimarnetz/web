<?php
	$owmNodesUrl = "http://mapapi.weimarnetz.de/db/_all_docs?include_docs=true";

	//load combined api file
	$owmRaw = file_get_contents($owmNodesUrl);
	$owmJson = json_decode($owmRaw, true);
	$owmRows = $owmJson['rows'];

	$nodesJson['community']['name'] = 'weimarnetz';
	$nodesJson['community']['url'] = 'http://weimarnetz.de';
	$nodesJson['version'] = '1.0.1';
	$nodesJson['updated_at'] = date('c');
	$nodesJson['nodes'] = array();

	foreach($owmRows as $row) {
		if ( ! $row['doc']['hostname'] ) {
			continue;
		}
		$node['id'] = $row['id'];
		$node['name'] = $row['doc']['hostname'];
		$node['node_type'] = "Node";
		$node['location']['lat'] = $row['doc']['latitude'];
		$node['location']['lon'] = $row['doc']['longitude'];
		$node['status']['lastcontact'] = $row['doc']['mtime'];
		$node['status']['online'] = true;
		$nodesJson['nodes'][] = $node;
	}
	header('Content-Type: application/json');
	print(json_encode($nodesJson));
?>
