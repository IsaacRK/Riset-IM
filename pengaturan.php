<?php
require 'backend/conn.php';
require 'backend/usersession.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pengaturan</title>
	<?php include "layout/header.php"?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<body>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
 <div class="container mr-0">
  <div class="row">
	<div class="col-1"></div>

	<div class="col-10">
	 <div class="container d-flex justify-content-center">
 	  <div class="card mt-5 border border-secondary un">
       <div class="card-body">
	 
	    <div class="row card border-0 text-center mb-2">
      	 <div class="col mb-4">
			<h2 class="text-primary">Pengaturan</h2>
     	 </div>
    	</div> 

		<div class="row border-0 d-flex justify-content-around text-center mb-5">
			<div class="col-4 mb-2">
				<a href="penyimpanan.php" class="btn btn-primary mt-2">Pengaturan Penyimpanan</a>
			</div>
			<div class="col-4 mb-2">
				<a href="" class="btn btn-primary mt-2">Pengaturan Rentang Report</a>
			</div>
		</div>

		<div class="row border-0 d-flex justify-content-around text-center mb-2">
			<div class="col-4 mb-2">
				<a href="kapasitas.php" class="btn btn-primary mt-2">Pengaturan Kapasitas Kolom dan Baris</a>
			</div>
			<div class="col-4 mb-2">
				<a href="" class="btn btn-primary mt-2">Pengaturan Rentang Performance Indikator</a>
			</div>
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