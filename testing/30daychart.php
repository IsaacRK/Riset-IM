<html>
<head>
<?php
include'../backend/conn.php';
include'../layout/header.php';

?>
</head>
<body>

<canvas id="chartDiv" style="height:100px;"></canvas>

<?php
$hari = 7;
if(isset($_POST['30d'])){
	$hari = 30;
}
if(isset($_POST['7d'])){
	$hari = 7;
}

//select 30/7 hari sebelumnya
$inv = array();
for($i=0; $i<=$hari; $i++){

	$sql = '
	select history.*, harga.*
	from history
	join harga
	on history.stock_id = harga.stock_id
	where history.date = date_sub(CURRENT_DATE, interval '.$i.' day) and output = 1
	';
	$run = mysqli_query($servConnQuery, $sql);
	
	$x=0;
	if(mysqli_num_rows($run)>0){
		while($data = mysqli_fetch_assoc($run)){
			echo$x = $x+$data['jual'];
		}
	}
	
	array_push($inv, $x);
}

?>

<script>
var chartDiv = $("#chartDiv");

var valData = {
	labels: [<?php $hari1 = $hari+1; for($i=1;$i<=$hari1;$i++){echo $i.',';}?>],
	datasets: [{
		label: "30 hari",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: [<?php for($i=$hari;$i>=0;$i--){
			echo$inv[$i].',';
		};
		?>],
		tension: 0.5,
	},{
		label: "Rata-Rata",
		backgroundColor: 'rgba(66, 135, 245, 0.3)',
		borderColor: 'rgba(66, 135, 245, 0.3)',
		data: [
			<?php 
				$hariRata = $hari - 2;
				for($i=$hariRata;$i>=0;$i--){
					echo'0'.',';
				}
				echo$rata.','.$rata; ?>
		],
	}]
}

var monthChart = new Chart(chartDiv, {
	type: "line",
	data: valData,
	options: {
		
	}
})
</script>
</body>
</html>