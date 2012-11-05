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
		header('Location: /sensors/admin.php');
		exit;
	}
?>
<h2>Parking Space Occupancy</h2>
<table border="1">
<tr>
<th>SpotID</th>
<th>Baseline</th>
<th>Last Reading</th>
<th>Latest Value</th>
<th>Occupancy</th>
</tr>
<?php
	foreach ($parkingData as $spots):
		echo "<tr>";
		echo "<td align='center'>",$spots[0]['id'],"</td>";
		echo "<td align='center'>",$spots[1],"</td>";
		echo "<td align='center'>",$spots[0]->reading[0][0]['time'],"</td>";
		echo "<td align='center'>",$spots[0]->reading[0],"</td>";
		$base = (int)$spots[1];
		$value = (int)$spots[0]->reading[0];
		if ($base > $value) {
			$big = $base;
			$small = $value;
		} else {
			$big = $value;
			$small = $base;
		}
		if ($big / $small > 1.5) {
			echo "<td align='center'>Occupied</td>";
		} else {
			echo "<td align='center'>Vaccant</td>";
		}
		echo "</tr>";
	endforeach;
?>
</table>
<BR>
<h2>Parking History</h2>
<table border="1">
<tr>
<th>CarID</th>
<th>Last Reading</th>
<th>Time Parked</th>
</tr>
<?php
	foreach ($carsData as $car):
		echo "<tr>";
		echo "<td align='center'>",$car['id'],"</td>";
		echo "<td align='center'>",$car->reading[0]['time'],"</td>";
		echo "<td align='center'>",gmdate("H:i:s", sizeof($car->reading)),"</td>";
		echo "</tr>";
	endforeach;
?>
</table>
