<?php
require '../backend/conn.php';

//deklarasi variabel
$arr=array();
$inp=array();
$week=array();
$predict=array();
$var=0;

if(isset($_GET['graphSearch'])){
		
	$stockName = $_GET['graphSearch'];
	$stockIdQuery = "select * from stock where stock_name = '$stockName'";
	$stockIdRun = mysqli_query($servConnQuery, $stockIdQuery);
	$stockIdFetch = mysqli_fetch_assoc($stockIdRun);
	$stockId = $stockIdFetch['stock_id'];
		
	for($i=0; $i<=4; $i++){

		//menenentukan hari dari barang yang akan diambil
		//hari sekarang dikurangi $i hari
		
		$chartFetchOutputQuery = "SELECT SUM(amount) FROM `history` WHERE stock_id = '$stockId' and YEARWEEK(date, 1) = YEARWEEK(CURDATE() - INTERVAL $i WEEK, 1) and output=1";
		$chartFetchOutputRun = mysqli_query($servConnQuery, $chartFetchOutputQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		
		$out=0;
		if(mysqli_num_rows($chartFetchOutputRun)>0){
			while($chartOut = mysqli_fetch_assoc($chartFetchOutputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$out = $out+$chartOut['SUM(amount)'];
			}
		}
		
		$WNOW = "SELECT WEEK(CURDATE() - INTERVAL $i WEEK)";
		$OWL = mysqli_query($servConnQuery, $WNOW);
		$Sheffy = mysqli_fetch_assoc($OWL);
		$Bell = $Sheffy["WEEK(CURDATE() - INTERVAL $i WEEK)"];
		
		//memasukkan data total barang masuk ke array
		array_push($arr,$out);
		array_push($week,$Bell);
	}
	$PRD = "SELECT ($arr[3]+$arr[2]+$arr[1])/3";
	$KEEN = mysqli_query($servConnQuery, $PRD);
	$Clair = mysqli_fetch_assoc($KEEN);
	$False = $Clair["($arr[3]+$arr[2]+$arr[1])/3"];

	array_push($predict,$False);
}else{
	for($i=0; $i<=4; $i++){
		/*
		$lastEntryQuery = 'select stock_id from history where output = 1 ORDER BY history_id DESC LIMIT 1';
		$lastEntryRun = mysqli_query($servConnQuery, $lastEntryQuery);
		$lastEntryFetch = mysqli_fetch_assoc($lastEntryRun);
		$sid = $lastEntryFetch['stock_id'];
		
		//menenentukan hari dari barang yang akan diambil
		//hari sekarang dikurangi $i hari
		$chartFetchQuery = "SELECT * FROM `history` WHERE date = date_sub(CURRENT_DATE, interval $i day) and stock_id = '$sid'";
		$chartFetchRun = mysqli_query($servConnQuery, $chartFetchQuery);
		*/
		
		//menenentukan hari dari barang yang akan diambil
		//hari sekarang dikurangi $i hari
		
		$chartFetchOutputQuery = "SELECT SUM(amount) FROM `history` WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE() - INTERVAL $i WEEK, 1) and output=1";
		$chartFetchOutputRun = mysqli_query($servConnQuery, $chartFetchOutputQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		
		$out=0;
		if(mysqli_num_rows($chartFetchOutputRun)>0){
			while($chartOut = mysqli_fetch_assoc($chartFetchOutputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$out = $out+$chartOut['SUM(amount)'];
			}
		}
		
		$WNOW = "SELECT WEEK(CURDATE() - INTERVAL $i WEEK)";
		$OWL = mysqli_query($servConnQuery, $WNOW);
		$Sheffy = mysqli_fetch_assoc($OWL);
		$Bell = $Sheffy["WEEK(CURDATE() - INTERVAL $i WEEK)"];
		
		//memasukkan data total barang masuk ke array
		array_push($arr,$out);
		array_push($week,$Bell);
	}
	$PRD = "SELECT ($arr[3]+$arr[2]+$arr[1])/3";
	$KEEN = mysqli_query($servConnQuery, $PRD);
	$Clair = mysqli_fetch_assoc($KEEN);
	$False = $Clair["($arr[3]+$arr[2]+$arr[1])/3"];

	array_push($predict,$False);
}

?>

<canvas id="chartDisplay" style="height:100px"></canvas>

<script>
$(document).ready(function(){
	var chartDisplay = $('#chartDisplay');
	
	var activityData = {
	  labels: <?php echo'["'.$day[3].'","'.$day[2].'","'.$day[1].'","'.$day[0].'"]'; ?>,
	  datasets: [{
		label: "Stok keluar",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: <?php echo'["'.$arr[3].'","'.$arr[2].'","'.$arr[1].'","'.$predict[0].'"]'; ?>,
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
					text: 'Minggu'
				}
			}
		}
	  }
	});
})

</script>
