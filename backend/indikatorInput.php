<?php
include'conn.php';
if(isset($_POST['submitIndikator'])){
	$target = $_POST['targetPemasukan'];
	$now = date('Y-m-d');
	$sql = "insert into target(target, tanggal) values('$target','$now')";
	mysqli_query($servConnQuery, $sql);
}
?>