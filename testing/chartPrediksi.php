<?php
include'../backend/conn.php';
include'../layout/header.php';

$historyArr = array();
if(isset($_GET['barang'])){
	$barang = $_GET['barang'];
	$sqlHarga = "select stock.stock_id, harga.jual
			from stock
			join harga on stock.stock_id = harga.stock_id
			where stock_name = '$barang'";
	$runHarga = mysqli_query($servConnQuery, $sqlHarga);
	$rowHarga = mysqli_fetch_assoc($runHarga);
	$harga = $rowHarga['jual'];
	$stoID = $rowHarga['stock_id'];
	
	
	for($i=0;$i<4;$i++){
		$sqlHisto = "select sum(amount) from history
		where month(date)=(month(CURRENT_DATE() - interval $i month)) 
		and output = 1 and stock_id = '$stoID'";

		$runHisto = mysqli_query($servConnQuery, $sqlHisto);
		$rowHisto = mysqli_fetch_assoc($runHisto);
		$total = 0;
		
		if($rowHisto['sum(amount)'] != null){
			$total = $rowHisto['sum(amount)'];
		}
		array_push($historyArr, $total);
	}
	
	echo $average = array_sum($historyArr)/count($historyArr);
}

?>


<canvas id="chartDisplay" style="height:100px"></canvas>

<script>
$(document).ready(function(){
	var chartDisplay = $('#chartDisplay');
	
	var activityData = {
	  labels: [1,2,3,4],
	  datasets: [{
		label: "Stok keluar",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: [<?php for($i=0;$i<4;$i++){echo$historyArr[$i].',';}?>],
		tension: 0.4,
	  }]
	};

	var lineChart = new Chart(chartDisplay, {
	  type: 'line',
	  data: activityData,
	  options: {
		scales: {
			y:{
				title: {
					display: true,
					text: 'Jumlah'
				}
			},
			x: {
				title: {
					display: true,
					text: 'Tanggal'
				}
			}
		}
	  }
	});
})

</script>