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
	
	$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

	$sql="SELECT * FROM stock WHERE stock_name LIKE '%".$searchTerm."%' ORDER BY stock_name ASC"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

	$hasil=mysqli_query($servConnQuery,$sql); //Query dieksekusi

	//Disajikan dengan menggunakan perulangan
	while ($row = mysqli_fetch_array($hasil)) {
		$data[] = $row['stock_name'];
	}
	//Nilainya disimpan dalam bentuk json
	echo json_encode($data);

?>