<?php

if(isset($_POST["input"])){
	
	$stockName = $_POST['itemName'];
	$amount = $_POST['amount'];
	$operator = $username;

	$rak	= $_POST['rak'];
	$lantai	= $_POST['lantai'];
	$kolom	= $_POST['kolom'];
	$baris	= $_POST['baris'];

	$run = mysqli_query($servConnQuery, $query);
}

?>
