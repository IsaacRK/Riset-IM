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
	
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="images/favicon.png" type="">
	
	<title>Dashboard</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link href="css/responsive.css" rel="stylesheet" />
	
	<style>
	body{
		background-color: #e0e2e1
	}
	
	login-container{
		height: 100%;
		width: 100%;
	}
	</style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center p-2 login-container">

<div class="card" style="width: 35rem; background-color: #fff">
<div class="card-body">	
	<h4>Selamat datang
	<?php
		echo $username;
	?>
	</h4>
	<div class="container">
	<div class="row">
	<div class="col text-center">
		<a href="logout.php"><button class="btn btn-danger" style="width:15rem;" type="submit" name="logout" value="logout">Logout</button></a>
	</div>
	</div>
	</div>
</div>
</div>

</div>
</div>
</body>

</html>