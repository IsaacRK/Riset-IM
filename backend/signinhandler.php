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
		http://inventory.cypiral.org/backend/verify.php?email='.$email.'&hash='.$hash.'';
		$headers = 'From:noreply@yourwebsite.com' . "\r\n";
		mail($to, $subject, $message, $headers);

		$query = "select * from pengguna where user = '$user' and pass = '$pass'";
		$run = mysqli_query($servConnQuery, $query);
		$row = mysqli_fetch_assoc($run);
		if($row > 0){
		session_start();
		$_SESSION['uid'] = $row['id'];
		header('location: Profile.php');
		}else{}
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
