<?php
require 'backend/conn.php';
require 'backend/loginhandler.php';
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
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link href="css/responsive.css" rel="stylesheet" />
	
	<style>
	body{
		background-color:;
	}
	</style>
</head>

<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="container mt-2">
	<div class="row">
		<div class="col-sm">
			<div class="background-color:white" style="height:75%">
			<div class="card-body">
				<div class="d-flex justify-content-center">

				</div>
								<div class="container" style ="width : 500px;height : 500px; ">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
					
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<img src="img/judul.jpg" alt="judul">
							</div>	
							<div class="item">
								<img src="img/keunggulan.jpg" alt="keunggulan">
							</div>
							<div class="item">
								<img src="img/pemasukan.jpg" alt="pemasukan">
							</div>
							<div class="item">
								<img src="img/pengambilan.jpg" alt="pengambilan">
							</div>
						</div>

						<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Next</span>
						</a>
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
