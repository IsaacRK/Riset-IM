<?php
require 'backend/conn.php';
require 'backend/usersession.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>VERIFY</title>
<?php include"layout/header.php"?>
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
    <p>Harap verifikasi akun anda</p>
    <p>Link verifikasi seharusnya berada di email yang anda masukkan</p>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-exclamation" viewBox="0 0 16 16">
    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0Zm0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
    </svg><br>
    <a href="logout.php">Keluar</a><br>
    </div>
 </div>
</div>
</body>
</html>
