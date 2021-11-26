<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
	header('location:Verifyno.php');
}else{}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Akutansi</title>
	<?php include"layout/header.php";?>
</head>
<body>
<?php include"layout/sidebar.php";?>

<div class="content">
	<div class="container mr-0">
	
		<h1 class="p-1">Akutansi</h1>
		
		<div class="card shadow-sm">
			<div class="card-body">
				
			</div>
		</div>
	
	</div>
</div>

<?php include"layout/js.php";?>
</body>
</html>
