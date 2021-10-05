<?php
include_once"conn.php";

$searchTerm = $_GET['term'];

$sql="SELECT * FROM stock WHERE stock_name LIKE '%".$searchTerm."%' ORDER BY stock_name ASC";

$hasil=mysqli_query($servConnQuery,$sql);

while ($row = mysqli_fetch_array($hasil)) {
	$data[] = $row['stock_name'];
	
}

echo json_encode($data);
?>