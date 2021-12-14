<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
	header('location:Verifyno.php');
}else{}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pengaturan</title>
	<?php include "layout/header.php"?>
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<style>
		.tan{
			width: 100%;
		}
		@media screen and (max-width: 767px){
		.tan{
			width: 200%;
			margin-left:23px;
		}
		}
	</style>
</head>

<body>
<?php include 'layout/sidebar-old.php'; ?>

<div class="content">
<div class="container mr-0">

<!-------------------------->
<!--| construction banner|-->
<!-------------------------->
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
</div>


</div>
</div>
<?php
	include"layout/js.php";
?>
</body>
</html>
