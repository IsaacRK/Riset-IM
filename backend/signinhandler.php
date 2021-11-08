<?php

if(isset($_POST['submit'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$email = $_POST['email'];
	$hash = md5( rand(0,1000) );
	$query = "
	insert into pengguna (id, user, pass) //, email, hash)
	values (default,'".$user."','".$pass."'); //,'".$email."','".$hash."');
	";
	
	$run = mysqli_query($servConnQuery, $query);
	if($run){
		echo "
		<div style='width:100%;pading:5px;background-color:#23C552;color:white;text-align:center;font-weight:bold;'>
			Akun $user berhasil di buat
		</div>
		";
	}else{
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			error saat pembuatan akun
		</div>
		";
	}
}

?>
