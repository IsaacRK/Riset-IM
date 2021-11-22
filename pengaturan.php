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

<!-------------------------->
<!--| construction banner|-->
<!-------------------------->
<div class="card text-light bg-danger my-3">
<div class="card-body">
	<div class="row">
		<div class="col-2 d-flex justify-content-center">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
		  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
		  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
		</svg>
		</div>
		<div class="col-8 d-flex justify-content-center">
		<h5 class="card-title">Masih Dalam Tahap pengerjaan</h5>
		</div>
		<div class="col-2 d-flex justify-content-center">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
		  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
		  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
		</svg>
		</div>
	</div>
</div>
</div>
<!-------------------------->
<!--| construction banner|-->
<!-------------------------->

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