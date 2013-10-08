        <table class="table table-striped">                                                                                                                                    
                <thead>                                                                                                                                                                          
                        <tr>                                                                                                                                    
                                <th>Neighbour IP</th>                                                                                                        
                                <th>Hostname</th>                                                                                                            
                                <th>Local interface IP</th>                                                                              
                                <th>Device</th>                                                                                          
                                <th>LQ</th>                                                                                                                       
                                <th>NLQ</th>                                                                                                                      
                                <th>ETX</th>                                                                                                                      
                        </tr>                                                                                                                                                                    
                </thead>                                                                                                                                                     
                                                                                                                                                                                                 
                <tbody id="olsr_neigh_table">
                
                <?php
		$ch = curl_init();
		$timeout = 5; // 0 wenn kein Timeout
		curl_setopt($ch, CURLOPT_URL, "http://localhost:9090/links");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_content = curl_exec($ch);
		curl_close($ch);
		$neighbors = json_decode("{ " . $file_content,true);
		
                
		for ($i=0;$i< count($neighbors[links]);$i++) {
			$etx=$neighbors[links][$i][linkCost]/1024;
			if ($etx<2){
				$backgroundcolor="#00cc00";
			} elseif ($etx<4) {
				$backgroundcolor="#ffcb05";
			} elseif ($etx<10) {
				$backgroundcolor="#ff6600";
			} else {
				$backgroundcolor="#bb3333";
			}
			if ($etx>100){
				$etx_output="INFINITE";
			} else {
				$etx_output=number_format($etx,3);
			}
 
                	echo "<tr>";
                        echo "<td><a href='http://" . $neighbors[links][$i][remoteIP] . "/cgi-bin-status.html'>" . $neighbors[links][$i][remoteIP] . "</a></td>";
                        echo "<td><a href='http://" . gethostbyaddr($neighbors[links][$i][remoteIP]) . "/cgi-bin-status.html'>" . gethostbyaddr($neighbors[links][$i][remoteIP] ). "</a></td>";
                        echo "<td>" . $neighbors[links][$i][localIP] . "</td>";
			echo "<td/>";
                        echo "<td>" . number_format($neighbors[links][$i][linkQuality],3) . "</td>";
                        echo "<td>" . number_format($neighbors[links][$i][neighborLinkQuality],3) . "</td>";
                        echo "<td style='background-color:". $backgroundcolor ."'>" . $etx_output . "</td>";
                	echo "</tr>";
		}
                ?>
                </tbody>                                                                                                                                                                            
        </table>

