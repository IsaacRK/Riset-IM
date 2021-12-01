<?php
include'../backend/conn.php';
echo'Reset tampilan rak</br>';
?>
<form method="post">
	<input type="submit" name="submit" value="Reset">
</form>
<?php
if(isset($_POST['submit'])){
	$sql = "select * from penyimpanan";
	$run = mysqli_query($servConnQuery, $sql);
	while($row = mysqli_fetch_assoc($run)){
		$sid = $row['storage_id'];
		
		$numSql = "select * from stock where storage_id = '$sid'";
		$numRun = mysqli_query($servConnQuery, $numSql);
		$numRow = mysqli_num_rows($numRun);
		if($numRow == null){
			$numRow = 'null';
		}
		
		echo$updSql = "update penyimpanan set isi=$numRow where storage_id = '$sid'";
		echo'</br>';
		if(mysqli_query($servConnQuery, $updSql)){
			echo'rak id'.$sid.' berhasil di kalibrasi</br>';
		}else{
			echo'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
		}
	}
}

?>