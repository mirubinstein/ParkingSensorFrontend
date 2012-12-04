<?php
	#Register spaces and cars node IDs
	$parkingSpacesID = array('1');
	$carsID = array('6','5');
	$xmlLoc = '/opt/tinyos-2.1.1/apps/Oscilloscope/data.xml';

	if (file_exists($xmlLoc) && filesize($xmlLoc) != 0) {
		$data = simplexml_load_file($xmlLoc);

		$parkingData = array();
		
		$carsData = array();
		foreach ($data as $node):
			if (in_array($node['id'], $parkingSpacesID)) {
				$baseline = $node->reading[count($node->reading)-1];
				
				$parkingData[] = array($node,$baseline);
			} elseif (in_array($node['id'], $carsID)) {
				$carsData[] = $node;
			}
		endforeach;
	} else {
		header('Location: /sensors/user/');
		exit;
	}
?>
	<?php
		foreach ($parkingData as $spots):
			$base = (int)$spots[1];
			$value = (int)$spots[0]->reading[0];
			if ($base > $value) {
				$big = $base;
				$small = $value;
			} else {
				$big = $value;
				$small = $base;
			}
			echo "<li data-role='list-divider'>Parking Spots</li>";
			echo "<li><a>";
			if ($big / $small > 1.5) {
				#Occupied
				echo "<img src='OccupiedSmall.png' width='80' height='80' />";
			} else {
				#Vaccant
				echo "<img src='VaccantSmall.png' width='80' height='80'/>";
			}
			echo "<h3>Spot #",$spots[0]['id'],"</h3>";
			echo "<p>Last Checked:<BR>",$spots[0]->reading[0][0]['time'],"</p></a>";
			echo "<a href='javascript:void(0)' onclick='moreInfo(",$spots[0]['id'],",",$spots[1],",",$spots[0]->reading[0],");' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a>";
			echo "</li>";
		endforeach;
	?>
<!-- Filler Data -->
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #2</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(2,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #3</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(3,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='VaccantSmall.png' width='80' height='80' /><h3>Spot #4</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(4,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='VaccantSmall.png' width='80' height='80' /><h3>Spot #5</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(5,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #6</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(6,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #7</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(7,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #8</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(8,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='VaccantSmall.png' width='80' height='80' /><h3>Spot #9</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(9,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>
<li><a><img src='OccupiedSmall.png' width='80' height='80' /><h3>Spot #10</h3><p>Last Checked:<BR><?php echo $parkingData[0][0]->reading[0][0]['time'] ?></p></a><a href='javascript:void(0)' onclick='moreInfo(10,0,0);' data-rel='popup' data-position-to='window' data-transition='pop'>More Info</a></li>

<li data-role='list-divider'>Customers</li>
<?php
	foreach ($carsData as $car):
		echo "<li>";
		echo "<h3>Customer #",$car['id'],"</h3>";
		echo "<p>Last Reading:<BR>",$car->reading[0]['time'],"</p>";
		echo "<span class='ui-li-count'>",gmdate("H:i:s", sizeof($car->reading)),"</span>";
		echo "</li>";
	endforeach;
?>
