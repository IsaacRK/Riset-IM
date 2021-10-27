<?php
include "../backend/conn.php";

function xpercent_of_y($x, $y){
	return $x * ($y / 100);
}
function x_aspercent_of_y($x,$y){
	return (100 * $x) / $y;
}


$elek = '';
$pera = '';
$lain = '';
$totalBarang = '';
$ei = 0;
$pi = 0;
$li = 0;

$sql = "select * from stock";
$run = mysqli_query($servConnQuery, $sql);
if(mysqli_num_rows($run)>0){
	while($row = mysqli_fetch_assoc($run)){
		//echo 'id: '.$row['stock_id'].' | cate: '.$row['category'].'</br>';
		if($row['category']=='001'){
			$elek++;
			$ei = $ei + $row['amount'];
		}
		if($row['category']=='010'){
			$pera++;
			$pi = $pi + $row['amount'];
		}
		if($row['category']=='100'){
			$lain++;
			$li = $li + $row['amount'];
		}
		$totalBarang++;
	}
}

$totalStorage='';
$storageCheck='';
$storageQuery = "select * from penyimpanan";
$storageRun = mysqli_query($servConnQuery, $storageQuery);
if(mysqli_num_rows($storageRun)>0){
	while($srow = mysqli_fetch_assoc($storageRun)){
		$totalStorage++;
		if($srow['stock_id']!=null){
			$storageCheck++;
		}
	}
}

$x = $totalStorage - $storageCheck;

echo 'elektronik = '.$elek;
echo '</br>peralatan = '.$pera;
echo '</br>lain-lain = '.$lain;
echo '</br>total barang = '.$totalBarang;
echo '</br>-----------------------';
echo '</br>isi '.$storageCheck.' | total '.$totalStorage;

$e = xpercent_of_y(x_aspercent_of_y($elek,$totalBarang),$storageCheck);
$p = xpercent_of_y(x_aspercent_of_y($pera,$totalBarang),$storageCheck);
$l = xpercent_of_y(x_aspercent_of_y($lain,$totalBarang),$storageCheck);

?>
<html>
<head>
<script src="../js/jquery3.6.0.min.js"></script>
<script src="../js/chart.js"></script>
</head>
<body>
	<canvas id="Chart" style=""></canvas>
<script>

$(document).ready(function(){
	var barDisplay = $('#Chart');
	var nilaiData1 = [<?php echo$elek.','.$pera.','.$lain; ?>];
	var nilaiData2 = [<?php echo$ei.','.$pi.','.$li; ?>];
	var warna = ["#1064AE", "#89c5fb"];
	
	var barData = {
		labels: ["Elektronik", "Peralatan", "Lain-lain"],
		datasets: [{
			backgroundColor: "#1064AE",
			data: nilaiData1,
		}]
		/*{
			backgroundColor: "#89c5fb",
			data: nilaiData2,
		}]*/
	};
	
	var barOptions = {
		legend: {
			display: true,
			text: "nama text disini"
		},
		indexAxis: 'y',
		scales: {
			x: {
				title: {
					display: true,
					text: 'Jumlah'
				}
			}
		}
	};
	
	var pieChart = new Chart(barDisplay, {
		type: "bar",
		data: barData,
		options: barOptions
	});
});
</script>
<body>