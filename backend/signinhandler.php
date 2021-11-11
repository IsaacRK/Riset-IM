<?php

if(isset($_POST['submit'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$confirm = $_POST['passcon'];
	$email = $_POST['email'];
	$hash = md5( rand(0,1000) );
	$emailpattern = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i';
	$query = "
	insert into pengguna (id, user, pass, email, hash)
	values (default,'".$user."','".$pass."','".$email."','".$hash."');
	";
	if(!preg_match($emailpattern, $email)){
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			Email tidak valid
		</div>
		";
	}else if(strpos($pass, $confirm) !== true){
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			Password dan Konfirmasi Password berbeda
		</div>
		";
	}else{
		$run = mysqli_query($servConnQuery, $query);
		if($run){
		$to = $email;
		$subject = 'Signup | Verification';
		$message = '
		Thanks for signing up!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
		 
		------------------------
		Username: '.$name.'
		Password: '.$password.'
		------------------------
		 
		Please click this link to activate your account:
		inventory.cypiral.org/backend/verify.php?email='.$email.'&hash='.$hash.'';
		$headers = 'From:noreply@yourwebsite.com' . "\r\n";
		mail($to, $subject, $message, $headers);

		echo "
		<div style='width:100%;pading:5px;background-color:#23C552;color:white;text-align:center;font-weight:bold;'>
			Akun $user berhasil di buat
		</div>
		";
		header("Location:Verifyno.php");
		}else{
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			error saat pembuatan akun
		</div>
		";
		}
	}
}

?>
