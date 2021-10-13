<?php
include"../backend/conn.php";
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

?>