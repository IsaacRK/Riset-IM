	<?php
	include "../backend/conn.php";
	
	$sql = "
	SELECT history.* , stock.stock_name, pengguna.user
	FROM history
	JOIN stock
	ON history.stock_id = stock.stock_id
	JOIN pengguna
	ON history.user_id = pengguna.id
	";
	$run = mysqli_query($servConnQuery, $sql);
	$arrDat = array();

	while($rowH = mysqli_fetch_assoc($run)){
		$arrDat[] = $rowH;
	}
	
	function status($in){
		if($in == 1){
			return "input";
		}else{
			return "output";
		}
	}
	$fileName = "Report-".date('d-m-Y').".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$fileName);
	
	/*
	//while($row = mysqli_fetch_assoc($run)){
	//}
	//$fileName = "aaaa-".date('d-m-Y').".xls";
	if(isset($_POST['report'])){
		$fileName = "history-aktifitas-".date('d-m-Y').".xls";
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$fileName);
		
		$heading = false;
		
		if(!empty($items)){
			foreach($items as $data){
				if(!$heading){
					echo implode("\t",array_keys($data))."\n";
					$heading = true;
				}
				echo implode("\t",array_values($data))."\n";
			}
		}
		exit();
	}
	*/
	?>
	<html>
	<head>

	<style>
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	</style>

	</head>
	<body>
	<p>Aktifitas</p>
	<table border='1'>
	<tr>
	<th>Tanggal</th>
	<th>Nama Barang</th>
	<th>Operator</th>
	<th>Jumlah</th>
	<th>Status</th>
	</tr>
	<?php foreach($arrDat as $data) { ?>
	<tr>
		<td><?php echo $data ['date']; ?></td>
		<td><?php echo $data ['stock_name']; ?></td>
		<td><?php echo $data ['user']; ?></td>
		<td><?php echo $data ['amount']; ?></td>
		<td><?php echo status($data ['input']); ?></td>
	</tr>
	<?php } ?>
	</table>
	</br>
	<!---------->
	<p>Barang</p>
	<table border='1'>
	<tr>
	<th>Nama</th>
	<th>Jumlah</th>
	<th>Kode Barang</th>
	</tr>
	<?php
		$query = "
		SELECT stock.* , penyimpanan.* 
		FROM stock 
		JOIN penyimpanan 
		ON stock.storage_id = penyimpanan.storage_id 
		ORDER BY penyimpanan.lantai DESC
		";
		$qrun = mysqli_query($servConnQuery, $query);
		$arrItm = array();
		
		while($rowS = mysqli_fetch_assoc($qrun)){
			$arrItm[] = $rowS;
		}
	$curr_lan=0;
	foreach($arrItm as $item) { 
		if($item ['lantai']!=$curr_lan){
			$curr_lan = intval($item ['lantai']);
			echo "
			<tr>
				<th colspan='3'>Lantai".$curr_lan."</th>
			</tr>
			";
		}
	?>
	<tr>
		<td><?php echo $item ['stock_name']; ?></td>
		<td><?php echo $item ['amount']; ?></td>
		<td><?php echo $item ['barcode']; ?></td>
	</tr>
	<?php } ?>
	</table>
	</body>