<?php
require 'backend/conn.php';

if(@$_SESSION['uid']!=null){
	header('location:dashboard.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Login and Registrasi</title>
	<?php include "layout/header.php"?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>
<body class="bg-light bg-gradient">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient">
  <div class="container-fluid">
    <a class="navbar-brand">Inventory Management</a>
	
    <form action="backend/loginhandler.php" method="post" class="d-flex">
	  <input class="form-control" required type="text" name="user" id="" placeholder="Nama User"/>
	  <input class="form-control ms-2" required type="password" name="pass" id="" placeholder="Kata Sandi"/>      
	  <button class="btn btn-light btn-outline-primary ms-2" type="submit" name="submit" value="Login">Login</button>
    </form>
    </div>
  </div>
</nav>

<div class="row" style="width:100%">
<div class="col">

<div class="container mt-5" style =" ">
				
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
<div class="col">

<div class="container mt-2 d-flex justify-content-center">
 <div class="card border border-0 bg-transparent ms-3">
  <div class="card-body" style="width:400px;">

    <div class="row card border-0 text-center bg-transparent">
     <div class="col">
			<h2 class="text-primary">Registrasi</h2>
     </div>
    </div>
  <form action="backend/signinhandler.php" method="post">
    <div class="row border-0">
     <div class="col">

        <div class="row border-0 text-center mb-1">
         <div class="col-sm">
          <span class="text-primary">Nama</span></br>
          <input class="" style="width:300px" required type="text" name="user" id=""/>
         </div>
		</div>
		<div class="row border-0 text-center mb-1">
         <div class="col-sm">
          <span class="text-primary">Email</span></br>
          <input class="" style="width:300px" required type="text" name="email" id=""/>
         </div>
        </div>

        <div class="row border-0 text-center mb-1">
         <div class="col-sm">
          <span class="text-primary">Kata Sandi</span></br>
          <input class="" style="width:300px" required type="password" name="pass" id=""/>
         </div>
		</div>
		<div class="row border-0 text-center mb-1">
         <div class="col-sm">
          <span class="text-primary">Konfirmasi Kata Sandi</span></br>
          <input class="" style="width:300px" required type="password" name="passcon" id=""/>
         </div>
        </div>

        <div class="row border-0 text-center">
         <div class="col text-center">
          <span class="text-primary">Verifikasi Captcha</span></br>
          <canvas id="captcha" class="" width="190" height="70">captcha text</canvas>
         </div>
		</div>
		<div class="row border-0 text-center mb-1">
         <div class="col text-center mt-4">
          <input id="textBox" type="text" class="" style="width:300px" name="text"></br>
		  <button class="btn border border-secondary mt-1" formnovalidate id="refreshButton" type="submit">Ganti</button>
         </div>
        </div>

        <div class="row card border-0 bg-transparent text-center mb-1">
         <div class="col-sm mb-1">
         <Button class="btn btn-primary" type="submit" name="submit" value="register">Daftar</button>
         </div>
        </div>
		
  </form>
  </div>
  </div>
</div>

</div>

</div>

<script src="script.js"></script>
</body>
</html>
