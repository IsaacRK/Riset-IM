<?php
//include"../backend/conn.php";
/*
for($a=1;$a<=1;$a++){
	for($b=1;$b<=5;$b++){
		for($c=1;$c<=4;$c++){
			for($d=1;$d<=2;$d++){
				echo'rak '.$a.' lantai '.$b.' kolom '.$c.' baris '.$d.'</br>';
				$sql = "INSERT INTO `penyimpanan` (`storage_id`, `rak`, `lantai`, `kolom`, `baris`, `stock_id`) VALUES (default, '$a', '$b', '$c', '$d', NULL)";
				mysqli_query($servConnQuery,$sql);
			}
		}
		echo'</br>';
	}
}
*/
$conn = mysqli_connect('localhost', 'root', '', 'updtdb');

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}

$queryA = "select * from stock";
$runA = mysqli_query($conn, $queryA);
if(mysqli_num_rows($runA)>0){
	while($fetchA = mysqli_fetch_assoc($runA)){
		$barcode = $fetchA['barcode'];
		$id = $fetchA['stock_id'];
		$barcodeUpdt = $barcode.$id;
		$queryB = "update stock set barcode = '$barcodeUpdt' where stock_id = '$id'";
		mysqli_query($conn, $queryB);
	}
}

$query = "select * from stock_test";
$run = mysqli_query($conn, $query);
echo'
			<table>
				<tr>
					<td>id</td>
					<td>name</td>
					<td>barcode</td>
				</tr>
				';
if(mysqli_num_rows($run)>0){
	while($fetch = mysqli_fetch_assoc($run)){
			echo'	
				<tr>
					<td>'.$fetch['stock_id'].'</td>
					<td>'.$fetch['stock_name'].'</td>
					<td>'.$fetch['barcode'].'</td>
				</tr>
			';
	}
}
echo'
	</table>
';

?>
<script src="js/JsBarcode.code128.min.js"></script>
<div class="container d-flex justify-content-center">
<div class="card" style="" id="barcode">
	<div class="card-body">
		<svg id="barcodeShow"></svg>
	</div>
</div>
</div>

<script>
	JsBarcode("#barcodeShow","1381001128");
</script>