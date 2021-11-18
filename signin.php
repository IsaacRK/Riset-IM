<?php
require 'backend/conn.php';
require 'backend/signinhandler.php';
?>
<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Registrasi</title>
	<?php include"layout/header.php"?>
  <style>
      .ins{
       width: 60%;
      }
      @media screen and (max-width:800px) {
        .ins{
          width: 80%;
        }
      }
    </style>
</head>

<body>

 <div class="container mt-5 d-flex justify-content-center ins">
 <div class="card border border-secondary ins">
  <div class="card-body">

    <div class="row card border-0 text-center">
     <div class="col mb-5">
			<h2 class="text-primary">Registrasi</h2>
     </div>
    </div>
  <form action="" method="post">
    <div class="row border-0">
     <div class="col">

        <div class="row border-0 text-center mb-3">
         <div class="col-sm">
          <span class="text-primary">Nama</span></br>
          <input class="" style="" required type="text" name="user" id=""/>
         </div>
         <div class="col-sm">
          <span class="text-primary">Email</span></br>
          <input class="" style="" required type="text" name="email" id=""/>
         </div>
        </div>

        <div class="row border-0 text-center mb-3">
         <div class="col-sm">
          <span class="text-primary">Kata Sandi</span></br>
          <input class="" style="" required type="password" name="pass" id=""/>
         </div>
         <div class="col-sm">
          <span class="text-primary">Konfirmasi Kata Sandi</span></br>
          <input class="" style="" required type="password" name="passcon" id=""/>
         </div>
        </div>

        <div class="row border-0 mb-3">
         <div class="col text-center">
          <span class="text-primary">Verifikasi Captcha</span></br>
          <canvas id="captcha" class="" width="190" height="70">captcha text</canvas>
         </div>
         <div class="col text-center mt-4">
          <input id="textBox" type="text" class="" name="text"></br>
          <button class="btn border border-secondary mt-1" formnovalidate id="refreshButton" type="submit">Ganti</button>
         </div>
        </div>

        <div class="row card border-0 text-center mb-2">
         <div class="col-sm mb-1">
         <Button class="btn btn-primary" type="submit" name="submit" value="register">Daftar</button>
         </div>
        </div>
		
        <div class="text-center">
		 Sudah punya akun? <a href="login.php">Login</a>
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
