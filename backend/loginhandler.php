<?php
require 'conn.php';

if(isset($_POST["submit"])){
	$user = $_POST["user"];
	$pass = $_POST["pass"];
	
	/*
	$query = "select * from pengguna where user = '$user' and pass = '$pass'";
	$run = mysqli_query($servConnQuery, $query);
	$row = mysqli_fetch_assoc($run);
	if($row > 0){
		session_start();
		$_SESSION['uid'] = $row['id'];
		header('location:dashboard.php');
	}else{
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			username atau password salah
		</div>
		";
	}
	*/
	
	$query = "select id from pengguna where user = ? and pass = ?";
	
	$stmt = $servConnQuery->prepare($query);
	$stmt->bind_param("ss", $user, $pass);
	$stmt->execute();
	$result = $stmt->get_result();
	$id = $result->fetch_assoc();
	if($result->num_rows > 0){
		session_start();
		$_SESSION['uid'] = $id['id'];
		header('location:dashboard.php');
	}else{
		$salah = 1;
	}
	
}

?>
