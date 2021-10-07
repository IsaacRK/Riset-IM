<?php
include"../backend/conn.php";
//include"../backend/usersession.php";

	/*
	$a = $_POST['name'];
	$aa = $_POST['email'];
	$AAA = $_POST['phone'];

	$query = "insert into test (id, a, aa, AAA) value (default,'$a','$aa','$AAA')";
	$run = mysqli_query($servConnQuery, $query);
	*/
	if(isset($_GET['term'])){
	$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

	$sql="SELECT * FROM stock WHERE stock_name LIKE '%".$searchTerm."%' ORDER BY stock_name ASC"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

	$hasil=mysqli_query($servConnQuery,$sql); //Query dieksekusi

	//Disajikan dengan menggunakan perulangan
	while ($row = mysqli_fetch_array($hasil)) {
		$data[] = $row['stock_name'];
	}
	//Nilainya disimpan dalam bentuk json
	echo json_encode($data);
	}
	
$storageSearchQuery = "select * from penyimpanan where rak = '1' and lantai = '1' and kolom = '2' and baris = '2'";
		$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
		$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		
		echo $storage_id = $storageIdFetch['storage_id'];

?>