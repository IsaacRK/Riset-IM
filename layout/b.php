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
	
	//ambil prediksi harga
	$hrgArr = array();
	for($i=3;$i>=0;$i--){
		$sqlHharg = "select * from harga_history where stock_id = $stockId and month(`date`) = month(now())-$i order by id desc";
		$runHharg = mysqli_query($servConnQuery, $sqlHharg);
		$rowHharg = mysqli_fetch_assoc($runHharg);
		if(isset($rowHharg['harga'])){
			$bulan = $rowHharg['harga'];
		}else{
			$y = count($hrgArr) - 1;
			if(isset($hrgArr[$y])){
				$bulan = $hrgArr[$y];
			}else{
				$bulan = 0;
			}
		}
		array_push($hrgArr, $bulan);
	}
	
	//rata rata harga
	$a = 0;
	if(array_sum($hrgArr)!=0){
		$a = ceil(array_sum($hrgArr)/4);
	}

	
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

<div class="row">
	<div class="col col-sm-6">
		<canvas id="chartDisplay1" style="height:100px"></canvas>
	</div>
	<div class="col col-sm-6">
		<canvas id="chartDisplay2" style="height:100px"></canvas>
	</div>
</div>

<script>
$(document).ready(function(){
	var chartDisplay1 = $('#chartDisplay1');
	
	var activityData = {
	  labels: [<?php echo $week[3].','.$week[2].','.$week[1].','.$week[0]; ?>],
	  datasets: [{
		label: "Stok keluar",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: [<?php echo $arr[3].','.$arr[2].','.$arr[1]; ?>],
		tension: 0.4,
	  },{
		label: "Prediksi Stok Keluar",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: [<?php echo $arr[3].','.$arr[2].','.$arr[1].','.$predict[0]; ?>],
		borderDash: [10,5],
		tension: 0.4,
	  }]
	};

	var lineChart = new Chart(chartDisplay1, {
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
	
	//-----------------------------
	//harga-----------------------------------
	//-----------------------------
	var chartHarga = $('#chartDisplay2');
	var harga = {
		labels: [4,3,2,1,0],
		datasets: [{
			label: "Harga",
			backgroundColor: '#FF9600',
			borderColor: '#FF9600',
			data: [<?php echo $hrgArr[0].','.$hrgArr[1].','.$hrgArr[2].','.$hrgArr[3]; ?>],
			tension: 0.3,
		},{
			label: "Prediksi",
			backgroundColor: '#FF9600',
			borderColor: '#FF9600',
			data: [<?php echo $hrgArr[0].','.$hrgArr[1].','.$hrgArr[2].','.$hrgArr[3].','.$a; ?>],
			tension: 0.3,
			borderDash: [10,5],
		}]
	}
	
	var harga = new Chart(chartHarga, {
		type: 'line',
		data: harga,
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
						text: 'Bulan'
					}
				}
			}
		}
	})
})

</script>
