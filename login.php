<?php
require 'backend/conn.php';
$salah = 0;
require 'backend/loginhandler.php';
if(@$_SESSION['uid']!=null){
	header('location:dashboard.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Login dan Registrasi</title>
	<?php include "layout/header.php"?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <style>
    .kin{
      text-align: right;
    }
    .inp{
      width:300px;
    }
		@media screen and (max-width: 767px){
      .kin{
        text-align: left;
      }
      .spc{
        width:100%;
      }
      .inp{
        width:250px;
      }
		}
	</style>
</head>
<body class="bg-light bg-gradient">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient">
	<div class="container">
    <a class="navbar-brand">Inventory Management</a>
		<form action="" method="post" class="d-flex flex-wrap">
			<div class="row m-0 p-0">
			<?php
				if($salah == 1){
					echo'
						<div class="col-sm-4 m-0 p-0">
						<div class="form-control alert alert-danger mb-0" style="padding-top:6px!important;padding-bottom:6px!important" role="alert">Nama atau Sandi salah</div>
						</div>
					';
				}
			?>
			<div class="col-sm">
			<input class="form-control" required type="text" name="user" id="" placeholder="Nama pengguna"/>
			</div>
			<div class="col-sm">
			<input class="form-control" required type="password" name="pass" id="" placeholder="Kata sandi"/>      
			</div>
			<div class="col-sm-1">
			<button class="btn btn-light btn-outline-primary ms-2" type="submit" name="submit" value="Login">Masuk</button>
			</div>
			</div>
		</form>
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
							<img src="img/hal1.jpg" alt="judul" class="d-block w-100">
						</div>
						<div class="carousel-item">
							<img src="img/hal2.jpg" alt="Los Angeles" class="d-block w-100">
						</div>
						<div class="carousel-item">
							<img src="img/hal3.jpg" alt="Chicago" class="d-block w-100">
						</div>
						<div class="carousel-item">
							<img src="img/hal4.jpg" alt="New York" class="d-block w-100">
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
  <div class="card-body">

    <div class="row card border-0 text-center bg-transparent">
     <div class="col text-center">
			<h2 class="text-primary">Registrasi</h2>
     </div>
    </div>
  <form action="backend/signinhandler.php" method="post" novalidate>
    <div class="row border-0">

    <div class="col border-0">

        <div class="row mb-3 mt-3">
            <div class="col">
				<p class="kin">Nama : </p>
            </div>
            <div class="col">
				<input class="form-control inp" required type="text" name="user" id=""/>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
				<p class="kin">Email : </p>
            </div>
            <div class="col">
              <input class="form-control inp" required type="text" name="email" id=""/>
            </div>
        </div>
                
        <div class="row mb-3">
            <div class="col">
				<p class="kin">Kata Sandi : </p>
            </div>
            <div class="col">
				<input class="form-control inp" required type="password" name="pass" id=""/>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
             <p class="kin spc">Konfirmasi Kata Sandi : </p>
            </div>
            <div class="col">
                <input class="form-control inp" required type="password" name="passcon" id=""/>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
				<p class="kin spc">Verifikasi Captcha : </p>
            </div>
			
			</br></br>
			</br></br>
            <div class="col-md-auto">
                <canvas id="captcha" class="" width="215" height="70">captcha text</canvas></br>
                <input id="textBox" type="text" class="form-control" style="width:150px" name="text">
            </div>
            <div class="col col-lg-2">
				<button type="button" value = "Ganti" onclick="history.go(0)"></button>
            </div>
			<div class="row mb-3">
				<div class="col text-center">
					<input class="btn btn-primary" type="submit" name="submit" value="Daftar">
				</div>
			</div>
		</div>

    </div>		
  </form>


   

  </div>
  </div>
</div>

</div>
</div>

</div>

<script src="script.js"></script>
</body>
</html>
