<?php

if(isset($_POST['submit'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	
	
	$query = "
	insert into pengguna (id, user, pass)
	values (default,'".$user."','".$pass."');
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