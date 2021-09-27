<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>
<!DOCTYPE html>
<html>

<head>
	<title>Dashboard</title>
	<?php include"layout/header.php"?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>
<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Stock Output</h1>
		</div>
	</div>

	<div class="row mb-2 ml-2">
		<div class="col-5">
			<div class="row border border-dark rounded">
				<div class="col-2">
					<img class="m-1" src="img/icons/search.svg" width="25" height="25"/>
				</div>
				<div class="col-10">
					<input class="form-control border border-0" style="" type="text" placeholder="Nama Komponen" name="user" id=""/>
				</div>
			</div>
		</div>
		<div class="col-2">
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Search"/>
		</div>
		<div class="col-5">
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Barcode Scanner"/>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
				<h3>Component Information</h3>
				</br>
				<span>Component Information</span>
				</br>
				<span>Stock : 500</span>
				</br>
				<span>Lokasi : 500</span>
				</br>
				<div class="row">
					<div class="col">
						<span>Jumlah Yang Di Ambil : </span>
					</div>
					<div class="col">
						<div class="border border-dark rounded m-1 p-1 text-center">jumlah</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<span>Keperluan : </span>
					</div>
					<div class="col">
						<div class="border border-dark rounded m-1 p-1 text-center">Nama Projek</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<span>Pengambil : </span>
					</div>
					<div class="col">
						<div class="border border-dark rounded m-1 p-1 text-center">nama</div>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6 mx-auto">
						<input class="btn btn-primary btn-block" type="submit" name="submit" value="Update"/>
					</div>
				</div>
			</div>	
			</div>
		</div>
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
				<h3>Cart</h3>
				
				<div class="row m-1">
					<div class="col-2">
						<div class="border border-dark rounded" style="width:50px;height:50px"></div>
					</div>
					<div class="col-10">
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
					</div>
					<div class="col-2">
						<div class="border border-dark rounded" style="width:50px;height:50px"></div>
					</div>
					<div class="col-10">
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
					</div>
					<div class="col-2">
						<div class="border border-dark rounded" style="width:50px;height:50px"></div>
					</div>
					<div class="col-10">
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
					</div>
					<div class="col-2">
						<div class="border border-dark rounded" style="width:50px;height:50px"></div>
					</div>
					<div class="col-10">
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
						<span>nama komponen: Arduino nano</span></br>
					</div>
				</div>
				
				<div class="row mt-2">
					<div class="col-6 mx-auto">
						<input class="btn btn-primary btn-block" type="submit" name="submit" value="Update"/>
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