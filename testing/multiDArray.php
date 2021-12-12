<?php
include'../backend/conn.php';

$sql = 'select * from penyimpanan order by rak asc';
$run = mysqli_query($servConnQuery, $sql);

$arr = array();
$rak = 0;

//jika rak berbeda maka tambah label
//jika rak sama maka input ke dalam array yang telah memiliki label
//jika rak berbeda maka masukkan ke dalam aray

while($row = mysqli_fetch_assoc($run)){
	$x = array();
		if($row['rak'] != $rak){
			$x[] = 'lantai'.$row['rak'];
			$x[] = $row['lantai'];
		}else{
			$x[] = $row['lantai'];
		}
		$rak = $row['rak'];	
}

//$a = array('lantai1',1,2,3,4,5);
//$b = array('lantai2',1,2,3,4,5);
//array_push($arr, $a);
//array_push($arr, $b);
var_dump($arr);

?>