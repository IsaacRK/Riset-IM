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
    <p>Please verify your account</p>
    <p>The link should be in your email</p>
    </div>
 </div>
</div>
</body>
</html>
