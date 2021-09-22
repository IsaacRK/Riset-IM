<?php
require 'backend/conn.php';
require 'backend/signinhandler.php';
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
	
	<title>Halaman Registrasi</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link href="css/responsive.css" rel="stylesheet" />
	
	<style>
	body{
		background-color:;
	}
	</style>
</head>

<body>
<div class="d-flex justify-content-center">
	<div class="card" style="width: 70%; margin: 50px">
	<div class="card-body text-primary">	

		<form action="" method="post">
		<div class="container">
			<div class="row">
				<div class="col-sm d-flex justify-content-center">
				<h4 class="">Registrasi</h4>
				</div>
			</div>
			
			<div class="row mb-2">
				<div class="col-sm">
				<span class="">Username:</span>
				</br>
				<input class="" style="" required type="text" name="user" id=""/>
				</div>
				<div class="col-sm"></div>
				<div class="col-sm"></div>
			</div>

			<div class="row mb-2">
				<div class="col-sm">
				<span class="">Password:</span>
				</br>
				<input class="" style="" required type="password" name="pass" id=""/>
				</div>
				<div class="col-sm">
				<span class="">Tulis ulang Password:</span>
				</br>
				<input class="" style="" required type="password" name="pass" id=""/>
				</div>
				<div class="col-sm">
				<span>terdiri dari huruf dan angka</span>
				</div>
			</div>
			
			<div class="row mb-2">
				<div class="col-sm">
				<span class="">email:</span>
				</br>
				<input class="" style="" required type="text" name="email" id=""/>
				</div>
				<div class="col-sm">
				<span class="">nomor telepon:</span>
				</br>
				<input class="" style="" required type="number" name="notelp" id=""/>
				</div>
				<div class="col-sm"></div>
			</div>
			
			<div class="row mb-2">
				<div class="col-sm">
				<span>verivikasi chapta:</span>
				</div>
				<div class="col-sm"></div>
				<div class="col-sm"></div>
			</div>
			
			<div class="row">
				<div class="col-sm">
					<div class="card">
					<div class="card-body">
						<span>kode chapta</span>
					</div>
					</div>
				</div>
				<div class="col-sm">
				<input class="btn btn-primary" type="submit" name="submit" value="register"/>
				</div>
			</div>
		</div>
		</form>

	</br>
	</div>
	</div>
</div>

</body>

</html>