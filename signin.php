<?php
require 'backend/conn.php';
require 'backend/signinhandler.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Registrasi</title>
	<?php include"layout/header.php"?>
</head>

<body>
<form action="" method="post">
 <div class="container mt-5 d-flex justify-content-center">
 <div class="card border border-secondary" style="width:50%">
  <div class="card-body">

    <div class="row card border-0 text-center">
     <div class="col mb-2">
			<h2 class="text-primary">Registrasi</h2>
     </div>
    </div>

    <div class="row border-0">
     <div class="col">

        <div class="row card border-0 text-center mb-3">
         <div class="col-sm">
          <span class="text-primary">Nama</span></br>
          <input class="" style="" required type="text" name="user" id=""/>
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

        <div class="row border-0 text-center mb-3">
         <div class="col-sm">
          <span class="text-primary">Email</span></br>
          <input class="" style="" required type="text" name="email" id=""/>
         </div>
         <div class="col-sm">
          <span class="text-primary">Nomor Telepon</span></br>
          <input class="" style="" required type="number" name="notelp" id=""/>
         </div>
        </div>

        <div class="row border-0 text-center mb-3">
         <div class="col-sm">
          <span class="text-primary">Verifikasi Captcha</span></br>
          <canvas id="captcha" height="70">captcha text</canvas></br>
          <input id="textBox" type="text" name="text"></br>
          <button class="btn border border-secondary mt-1"id="refreshButton" type="submit">Refresh</button>
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


     </div>

    </div>

  </div>
 </div>
 </div>
</form>
<script src="script.js"></script>
</body>

</html>
