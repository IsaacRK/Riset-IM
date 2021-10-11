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

<div class="container mt-2">
	<div class="row">
		<div class="col-sm">
			<div class="card text-white bg-info" style="height:100%">
			<div class="card-body">
				<div class="d-flex justify-content-center">
				<span>Information Panels</span>
				</div>			
			</div>
			</div>
		</div>
		
		<div class="col-sm">
			<div class="card text-primary">
			<div class="card-body">
			
			<form action="" method="post">
				<h4 class="card-title font-weight-bold">Welcome to Inventory Management</h4>

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
				<span class="d-flex justify-content-center">belum punya akun? <a href="signin.php">Register</a></span>
				</br>
			</form>
			
			</div>
			</div>
		</div>
	</div>
</div>
</body>

</html>