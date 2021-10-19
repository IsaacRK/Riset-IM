<?php
include"../backend/conn.php";
include'../backend/inputhandler.php';

?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery3.6.0.min.js"></script>
<script src="js/jquery-ui.js"></script>
</head>
<body>

<form action="" method="post">

					<input type="hidden" value="update" name="pointer">

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Nama Komponen</span>
						</div>
						<input required type="text" class="form-control" id="itemNameUpdate" name="itemNameUpdate" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
					</div>
					
					<div class="input-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Kategori</span>
						</div>
						<span class="form-control" id="categoryUpdate" style="background-color:#e9ecef"></span>
					</div>
					
					<div class="input-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah</span>
						</div>
						<input required type="number" class="form-control" name="amountUpdate" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
					</div>
					
					<div class="row mt-2">	
						<div class="col-4">Lokasi penyimpanan</div>
						<div class="col-8">
							<select name="rakUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">rak 1</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-4"></div>
						<div class="col-8">
							<select name="lantaiUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
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
							<select name="kolomUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
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
							<select name="barisUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item">baris 1</option>
								<option value="2" class="dropdown-item">baris 2</option>
							</select>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-6 mx-auto">
							<input class="btn btn-primary btn-block" type="submit" name="update" value="update"/>
						</div>
					</div>
				</form>
								
</body>
</html>