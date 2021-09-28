<?php

if(isset($_POST["input"])){
	
	$stockName = $_POST['itemName'];
	$amount = $_POST['amount'];
	$operator = $username;

	$rak	= $_POST['rak'];
	$lantai	= $_POST['lantai'];
	$kolom	= $_POST['kolom'];
	$baris	= $_POST['baris'];

	/*echo"
	nama barang:".$stockName."</br>
	jumlah barang:".$amount."</br>
	lokasi:".$location."</br>
	operator:".$username."</br>
	";*/
	
	echo $query =
	"insert into stock (stock_id, stock_name, amount, rak, lantai, kolom, baris, operator, barcode)
	values (default, '$stockName', '$amount', '$rak', '$lantai', '$kolom', '$baris', '$operator', '[barcode]');
	";
	$run = mysqli_query($servConnQuery, $query);
}

?>
