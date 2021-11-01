	<?php
	include "../backend/conn.php";
	$sqlHistory = "select * from history";
	$runHistory = mysqli_query($servConnQuery, $sql);

	
	//$items = array();

	//while($row = mysqli_fetch_assoc($run)){
	//	$items[] = $row;
	//}
	//$fileName = "aaaa-".date('d-m-Y').".xls";
	//header('Content-Type: application/vnd.ms-excel');
	//header('Content-Disposition: attachment; filename='.$fileName);
	/*
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


-tanggal | nama barang | operator | jumlah barang | untuk apa
	<table border='1'>
	<tr>
	<th>Tanggal</th>
	<th>Nama Barang</th>
	<th>Operator</th>
	<th>Jumlah</th>
	<th>Status</th>
	<th>Untuk</th>
	</tr>
	<?php foreach($items as $data) { ?>
	<tr>
	<td><?php echo $data ['history_id']; ?></td>
	<td><?php echo $data ['stock_id']; ?></td>
	<td><?php echo $data ['amount']; ?></td>
	<td><?php echo $data ['input']; ?></td>
	<td><?php echo $data ['output']; ?></td>
	<td><?php echo $data ['user_id']; ?></td>
	</tr>
	<?php } ?>
	</table>
	</div>

	</body>