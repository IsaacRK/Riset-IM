<?php
include'../layout/header.php';
require '../backend/conn.php';
require '../backend/usersession.php';

echo date("d-m-Y");
echo"</br>";

if(isset($_POST['pointer'])){
	$point = $_POST['pointer'];
	if($point == "input"){	
		$stockName = $_POST['itemName'];
		$kategori = $_POST['category'];
		$amount = $_POST['amount'];
		$operator = $username;

		$rak	= $_POST['rak'];
		$lantai	= $_POST['lantai'];
		$kolom	= $_POST['kolom'];
		$baris	= $_POST['baris'];

		$barcode = '0'.$rak.$lantai.$kolom.$baris.$kategori;
		
		echo $storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lantai' and kolom = '$kolom' and baris = '$baris'";
		$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
		$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		echo"</br>";
		$storage_id = $storageIdFetch['storage_id'];

		echo $inputQuery =
		"insert into 
		stocktest (stock_id, stock_name, category, amount, storage_id, operator, barcode)
		values (default, '$stockName', '$kategori', '$amount', '$storage_id', '$operator', '$barcode');
		";$br;
		$inputRun = mysqli_query($servConnQuery, $inputQuery);
		echo"</br>";
		echo $stockSearchQuery = "select stock_id from stocktest where stock_name = '$stockName' and storage_id = '$storage_id'";
		$stockSearchRun = mysqli_query($servConnQuery, $stockSearchQuery);
		$stockSearchFetch = mysqli_fetch_assoc($stockSearchRun);
		$stock_id = $stockSearchFetch['stock_id'];
		echo "</br>";
		//$storageQuery = "update penyimpanan set stock_id = '$stock_id' where storage_id = '$storage_id'";
		//$storageQueryRun = mysqli_query($servConnQuery, $storageQuery);
		$now = date("Y-m-d");
		echo $historyQuery = 
		"insert into 
		history (history_id, stock_id, amount, input, output, date) 
		values (default, '$stock_id', '$amount', '1', NULL, '$now')";
		mysqli_query($servConnQuery, $historyQuery);
	}
}


?>

<html>
<head>


</head>
<body>
<div class="container">
<div class="card">
			<div class="card-body">
				<h3>Stock Registration</h3>
				</br>
				
				<form action="" method="post">
				
					<input type="hidden" value="input" name="pointer">

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Nama Komponen</span>
						</div>
						<input required type="text" class="form-control" name="itemName" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
					</div>
					
					<div class="input-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Kategori</span>
						</div>
							<select name="category" class="btn btn-light btn-block border dropdown-toggle p-2 form-control">
								<option value="001" class="dropdown-item">Elektronik</option>
								<option value="010" class="dropdown-item">Sekali Pakai</option>
								<option value="011" class="dropdown-item">Peralatan</option>
								<option value="100" class="dropdown-item">Lain-Lain</option>
							</select>
					</div>
					
					<div class="input-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah</span>
						</div>
						<input required type="number" class="form-control" name="amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
					</div>
					
					<div class="row mt-2">	
						<div class="col-4">Lokasi penyimpanan</div>
						<div class="col-8">
							<select name="rak" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">rak 1</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-4"></div>
						<div class="col-8">
							<select name="lantai" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">lantai 1</option>
								<option value="2" class="dropdown-item">lantai 2</option>
								<option value="3" class="dropdown-item">lantai 3</option>
								<option value="4" class="dropdown-item">lantai 4</option>
								<option value="5" class="dropdown-item">lantai 5</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-4"></div>
						<div class="col-8">
							<select name="kolom" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">kolom 1</option>
								<option value="2" class="dropdown-item">kolom 2</option>
								<option value="3" class="dropdown-item">kolom 3</option>
								<option value="4" class="dropdown-item">kolom 4</option>
								<option value="5" class="dropdown-item">kolom 5</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-4"></div>
						<div class="col-8">
							<select name="baris" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">baris 1</option>
								<option value="2" class="dropdown-item">baris 2</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-6 mx-auto">
							<input class="btn btn-primary btn-block" type="submit" name="input" value="input"/>
						</div>
					</div>
				</form>
				
			</div>
			</div>
		</div>
</body>