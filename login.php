<?php
require 'backend/conn.php';
require 'backend/loginhandler.php';

if(@$_SESSION['uid']!=null){
	header('location:dashboard.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="images/favicon.png" type="">
	
	<title>Halaman Masuk</title>
	
	<?php require 'layout/header.php';?>
	
	<style>
	body{
		background-color:;
	}
	</style>
</head>

<body>

<div class="container mt-2">
	<div class="row">
		<div class="col-sm">
			<div class="background-color:white" style="height:75%">
			<div class="card-body">
				<div class="d-flex justify-content-center">

				</div>
				<div class="container" style ="width : 500px;height : 500px; ">
				
					<div id="cLogin" class="carousel carousel-dark slide" data-bs-ride="carousel">

						<!-- Indicators/dots -->
						<div class="carousel-indicators">
							<button type="button" data-bs-target="#cLogin" data-bs-slide-to="0" class="active"></button>
							<button type="button" data-bs-target="#cLogin" data-bs-slide-to="1"></button>
							<button type="button" data-bs-target="#cLogin" data-bs-slide-to="2"></button>
							<button type="button" data-bs-target="#cLogin" data-bs-slide-to="3"></button>
						</div>

						<!-- The slideshow/carousel -->
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="img/judul.jpg" alt="judul" class="d-block w-100">
							</div>
							<div class="carousel-item">
								<img src="img/keunggulan.jpg" alt="Los Angeles" class="d-block w-100">
							</div>
							<div class="carousel-item">
								<img src="img/pemasukan.jpg" alt="Chicago" class="d-block w-100">
							</div>
							<div class="carousel-item">
								<img src="img/pengambilan.jpg" alt="New York" class="d-block w-100">
							</div>
						</div>

						<!-- Left and right controls/icons -->
						<button class="carousel-control-prev" type="button" data-bs-target="#cLogin" data-bs-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#cLogin" data-bs-slide="next">
							<span class="carousel-control-next-icon"></span>
						</button>
					</div>
				
				</div>
			</div>
			</div>
		</div>
		
		<div class="col-sm">
			<div class="card text-primary" style="width : 500px;height : 345px;">
			<div class="card-body">
			
			<form action="" method="post">
				<h4 class="card-title font-weight-bold">Selamat Datang di Basis Data Persediaan Alat</h4>

				<span class="card-title">Username</span>
				</br>
				<input class="form-control" required type="text" name="user" id=""/>
				</br>
				<span class="card-title">Password</span>
				</br>
				<input class="form-control" required type="password" name="pass" id=""/>
				</br>
				<div class="col-6 mx-auto">
					<input class="btn btn-primary btn-block" type="submit" name="submit" value="Login"/>
				</div>
				</br>
				<span class="d-flex justify-content-center">Belum punya akun? <a href="signin.php">Register</a></span>
				</br>
			</form>
			
			</div>
			</div>
		</div>
	</div>
</div>
</body>

</html>
