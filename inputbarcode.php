<?php

require 'backend/conn.php';
require 'backend/usersession.php';
require 'backend/inputhandler.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Dashboard</title>
	<?php include"layout/header.php"?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">

<h4> Hello </h4>
<?php
if($run){
	echo"input data berhasil";
	}else{
		echo"gagal";
	}
?>

</div>
</div>

<?php
	include"layout/js.php";
?>

</body>
</html>