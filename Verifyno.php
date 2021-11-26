<?php
require 'backend/conn.php';
require 'backend/usersession.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>VERIFIKASI</title>
<?php include"layout/header.php"?>
<style>
    .form-control{
        width:80%;
    }
</style>
</head>
<body>
 <?php
 if($userAC == '1'){
     header('Location:Dashboard.php');
 }else{}
?>

<div class="container mt-5">
 <div class="card border border-secondary">
    <div class="card-body text-center">
    <span>Harap verifikasi akun anda</span></br>
    <span>Link verifikasi seharusnya sudah terkirim di email yang anda masukkan</span></br>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope-exclamation" viewBox="0 0 16 16">
    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0Zm0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
    </svg>
    <br>
    <br>

<form action="backend/ChgEM.php" method="post" enctype="multipart/form-data">
    <div class="row border-0 mb-1">
        <div class="col-sm">
            <span class="">Email yang anda kirimkan memiliki kesalahan? Silahkan ganti email anda</span></br>
        </div>
    </div>
    <div class="row border-0">
        <div class="col-sm mb-2 d-flex justify-content-center">
            <input class="form-control" type="text" name="email" id="" placeholder="<?php echo $userEM;?>"/>
        </div>
    </div>
    <div class="row card border-0 mb-3">
        <div class="col">
            <button class="btn btn-primary mb-3 mt-3" type="submit" name="submit" value="Ganti">Ubah</button>
        </div>
    </div>
</form>

    <a href="logout.php">Keluar</a><br>
    </div>
 </div>
</div>
</body>
</html>
