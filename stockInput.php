<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>
<!DOCTYPE html>
<html>

<head>
	<title>Stock Input</title>
	<?php include"layout/header.php"; ?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Stock Input</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
				<h3>Stock Registration</h3>
				</br>
				
<form action="inputbarcode.php" method="post">

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
		<input required type="text" class="form-control" name="category" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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
				<option value="2" class="dropdown-item">rak 2</option>
				<option value="3" class="dropdown-item">rak 3</option>
				<option value="4" class="dropdown-item">rak 4</option>
				<option value="5" class="dropdown-item">rak 5</option>
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
				<option value="3" class="dropdown-item">baris 3</option>
				<option value="4" class="dropdown-item">baris 4</option>
				<option value="5" class="dropdown-item">baris 5</option>
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
		
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
							<h3>Stock Update</h3>
				</br>
				
				<div class="row mt-2">
					<div class="col-sm">nama kompnen</div>
					<div class="col-sm">
						<input class="" style="" required type="text" name="user" id=""/>
					</div>
				</div>
					
				<div class="row mt-2">
					<div class="col-sm">Kategori</div>
					<div class="col-sm">
						<input class="" style="" required type="text" name="user" id=""/>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-sm">jumlah</div>
					<div class="col-sm">
						<input class="" style="" required type="text" name="user" id=""/>
					</div>
				</div>
				
				<div class="row mt-2">	
					<div class="col-sm">Lokasi penyimpanan</div>
					<div class="col-sm">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							rak 1
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-sm"></div>
					<div class="col-sm">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							lantai 1
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-sm"></div>
					<div class="col-sm">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							kolom A
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-sm"></div>
					<div class="col-sm">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							baris 1
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-6 mx-auto">
						<input class="btn btn-primary btn-block" type="submit" name="update" value="Update"/>
					</div>
				</div>
			
			</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php
	include"layout/js.php";
?>

</body>
</html>