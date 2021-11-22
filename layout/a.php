<?php
require '../backend/conn.php';
include '../layout/header.php';

//deklarasi variabel
$arr=array();
$inv=array();
$day=array();
$var=0;

if(isset($_GET['graphSearch'])){
		
	$stockName = $_GET['graphSearch'];
	$stockIdQuery = "select * from stock where stock_name = '$stockName'";
	$stockIdRun = mysqli_query($servConnQuery, $stockIdQuery);
	$stockIdFetch = mysqli_fetch_assoc($stockIdRun);
	$stockId = $stockIdFetch['stock_id'];
		
	for($i=0; $i<=7; $i++){

		//menenentukan hari dari barang yang akan diambil
		//hari sekarang dikurangi $i hari
		$chartFetchQuery = "SELECT * FROM `history` WHERE stock_id = '$stockId' and date = date_sub(CURRENT_DATE, interval $i day)";
		$chartFetchRun = mysqli_query($servConnQuery, $chartFetchQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		$var=0;
		if(mysqli_num_rows($chartFetchRun)>0){
			while($chartFetch = mysqli_fetch_assoc($chartFetchRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$chartFetch['amount'];
				$var = $var+$chartFetch['amount'];
			}
		}
		//mengitung hari, sekarang di kurangi $i hari
		$now = date("Y-m-d");
		$cut = date('m-d', strtotime($now.'-'.$i.' Days'));
		
		//memasukkan data total barang masuk ke array
		array_push($arr,$var);
		array_push($day,$cut);
		//echo ' '.$day[$i].' ';
		//echo $arr[$i].'</br>';
	}
}else{
	for($i=0; $i<=7; $i++){
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
		$chartFetchQuery = "SELECT * FROM `history` WHERE date = date_sub(CURRENT_DATE, interval $i day) and output=1";
		$chartFetchRun = mysqli_query($servConnQuery, $chartFetchQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		$out=0;
		if(mysqli_num_rows($chartFetchRun)>0){
			while($chartFetch = mysqli_fetch_assoc($chartFetchRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$chartFetch['amount'];
				$out = $out+$chartFetch['amount'];
			}
		}
		$out;
		$chartinpQuery = "SELECT * FROM `history` WHERE date = date_sub(CURRENT_DATE, interval $i day) and input=1";
		$chartinpRun = mysqli_query($servConnQuery, $chartFetchQuery);
		$inp=0;
		if(mysqli_num_rows($chartinpRun)>0){
			while($chartinpFetch = mysqli_fetch_assoc($chartinpRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$chartinpFetch['amount'];
				$inp = $inp+$chartinpFetch['amount'];
			}
		}
		echo $inp;
		//mengitung hari, sekarang di kurangi $i hari
		$now = date("Y-m-d");
		$cut = date('m-d', strtotime($now.'-'.$i.' Days'));
		
		//memasukkan data total barang masuk ke array
		array_push($arr,$out);
		array_push($inv,$inp);
		array_push($day,$cut);
		//echo ' '.$day[$i].' ';
		//echo $arr[$i].'</br>';
	}
	echo'<h5>Aktifitas 7 hari terakhir</h5>';
}

?>

<canvas id="chartDisplay" style="height:100px"></canvas>

<script>
$(document).ready(function(){
	var chartDisplay = $('#chartDisplay');
	
	var activityData = {
	  labels: <?php echo'["'.$day[7].'","'.$day[6].'","'.$day[5].'","'.$day[4].'","'.$day[3].'","'.$day[2].'","'.$day[1].'","'.$day[0].'"]'; ?>,
	  datasets: [{
		label: "Stok keluar",
		backgroundColor: 'rgba(16, 100, 174, 0.3)',
		borderColor: 'rgba(16, 100, 174, 0.3)',
		data: <?php echo'['.$arr[7].','.$arr[6].','.$arr[5].','.$arr[4].','.$arr[3].','.$arr[2].','.$arr[1].','.$arr[0].']'; ?>,
	  },{
		label: "Stok masuk",
		backgroundColor: 'yellow',
		borderColor: 'yellow',
		data: <?php echo'['.$inv[7].','.$inv[6].','.$inv[5].','.$inv[4].','.$inv[3].','.$inv[2].','.$inv[1].','.$inv[0].']';?>,
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
