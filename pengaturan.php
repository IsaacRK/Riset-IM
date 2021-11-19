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

<div class="p1">
	<h1>Pengaturan</h1>
</div>

<div class="row">
	<div class="col-4 mb-2">
		<a href="penyimpanan.php" class="btn btn-primary mt-2">Pengaturan Penyimpanan</a>
	</div>
	<div class="col-4 mb-2">
		<a href="kapasitas.php" class="btn btn-primary mt-2">Pengaturan Kapasitas Kolom dan Baris</a>
	</div>
</div>

<div class="card mb-1 shadow-sm">
<div class="card-body">
	<div class="p1">
		<h4>Pengaturan Rentang Report</h4>
	</div>

</div>
</div>


<div class="card mb-1 shadow-sm">
<div class="card-body">
	<div class="p1">
		<h4>Pengaturan Rentang Performance Indikator</h4>
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