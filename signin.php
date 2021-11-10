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
				<canvas id="captcha">captcha text</canvas>
            <input id="textBox" type="text" name="text">
            <div id="buttons">
                <input id="submitButton" type="submit">
                <button id="refreshButton" type="submit">Refresh</button>
            </div>
            <span id="output"></span>
				</div>
				<div class="col-sm"></div>
				<div class="col-sm"></div>
			</div>
				<input class="btn btn-primary" type="submit" name="submit" value="register"/>
				</div>
			</div>
		</div>
		</form>

	</br>
	</div>
	</div>
</div>
<script src="script.js"></script>
</body>

</html>
