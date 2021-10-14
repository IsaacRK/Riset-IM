<?php
include"../backend/conn.php";
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
	JsBarcode("#barcodeShow","141200123");
</script>