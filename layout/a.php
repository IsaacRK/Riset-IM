<?php
require '../backend/conn.php';

//deklarasi variabel
$arr=array();
$inp=array();
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
		$chartFetchInputQuery = "SELECT * FROM `history` WHERE stock_id = '$stockId' and date = date_sub(CURRENT_DATE, interval $i day) and input=1";
		$chartFetchInputRun = mysqli_query($servConnQuery, $chartFetchInputQuery);
		
		$chartFetchOutputQuery = "SELECT * FROM `history` WHERE stock_id = '$stockId' and date = date_sub(CURRENT_DATE, interval $i day) and output=1";
		$chartFetchOutputRun = mysqli_query($servConnQuery, $chartFetchOutputQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		$in=0;
		if(mysqli_num_rows($chartFetchInputRun)>0){
			while($chartIn = mysqli_fetch_assoc($chartFetchInputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$in = $in+$chartIn['amount'];
			}
		}
		
		$out=0;
		if(mysqli_num_rows($chartFetchOutputRun)>0){
			while($chartOut = mysqli_fetch_assoc($chartFetchOutputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$out = $out+$chartOut['amount'];
			}
		}
		
		//mengitung hari, sekarang di kurangi $i hari
		$now = date("Y-m-d");
		$cut = date('m-d', strtotime($now.'-'.$i.' Days'));
		
		//memasukkan data total barang masuk ke array
		array_push($inp,$in);
		array_push($arr,$out);
		array_push($day,$cut);
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
		$chartFetchInputQuery = "SELECT * FROM `history` WHERE date = date_sub(CURRENT_DATE, interval $i day) and input=1";
		$chartFetchInputRun = mysqli_query($servConnQuery, $chartFetchInputQuery);
		
		$chartFetchOutputQuery = "SELECT * FROM `history` WHERE date = date_sub(CURRENT_DATE, interval $i day) and output=1";
		$chartFetchOutputRun = mysqli_query($servConnQuery, $chartFetchOutputQuery);
		
		//mereset jumlah total barang setiap 1 hari menjadi 0
		$in=0;
		if(mysqli_num_rows($chartFetchInputRun)>0){
			while($chartIn = mysqli_fetch_assoc($chartFetchInputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$in = $in+$chartIn['amount'];
			}
		}
		
		$out=0;
		if(mysqli_num_rows($chartFetchOutputRun)>0){
			while($chartOut = mysqli_fetch_assoc($chartFetchOutputRun)){
				//hitung jumlah total barang yang masuk/keluar pada satu hari, dari hari yang di tentukan
				$out = $out+$chartOut['amount'];
			}
		}
		
		//mengitung hari, sekarang di kurangi $i hari
		$now = date("Y-m-d");
		$cut = date('m-d', strtotime($now.'-'.$i.' Days'));
		
		//memasukkan data total barang masuk ke array
		array_push($arr,$out);
		array_push($inp,$in);
		array_push($day,$cut);
	}
	echo'<h5>Aktivitas 7 hari terakhir</h5>';
}

?>

<canvas id="chartDisplay" style="height:100px"></canvas>

<script>
$(document).ready(function(){
	var chartDisplay = $('#chartDisplay');
	
	var activityData = {
	  labels: [<?php for($i=7;$i>=0;$i--){ echo $day[$i].','; } ?>],
	  datasets: [{
		label: "Stok keluar",
		backgroundColor: '#FF9600',
		borderColor: '#FF9600',
		data: [<?php for($i=7;$i>=0;$i--){ echo $arr[$i].','; } ?>],
	  },{
		label: "Stok masuk",
		backgroundColor: '#00A1FF',
		borderColor: '#00A1FF',
		data: [<?php for($i=7;$i>=0;$i--){ echo $inp[$i].','; } ?>],
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
