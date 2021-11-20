<?php
if($_SESSION['uid'] != null){
	$userFetch 		= "select * from pengguna where id='$_SESSION[uid]'";
	$userFetchRun 	= mysqli_query($servConnQuery, $userFetch);
	$userData 		= mysqli_fetch_assoc($userFetchRun);
	
	$username 		= $userData['user'];
	$userId 		= $userData['id'];
	$userlvl 		= $userData['tingkat'];
	$userAC			= $userData['active'];
	$userEM			= $userData['email'];
	$userPS			= $userData['pass'];
}else{
	header('location:index.html');
}
?>
