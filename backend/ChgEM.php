<?php
require 'conn.php';
require 'usersession.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    
    $fetchSql = "select * from pengguna where id=$userId";
    $fetchRun = mysqli_query($servConnQuery, $fetchSql);
    $fetch = mysqli_fetch_assoc($fetchRun);
 if($fetch > 0){   
    if($email==null){
        header('location:../Verifyno.php');
    } else{
        $sql = "UPDATE pengguna SET email='$email' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        $hash = $fetch['hash'];
        $name = $fetch['user'];
        $password = $fetch['pass'];

		$from = "csinventory@cypiral.org";
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
		$headers = 'From:' . $from;
		mail($to, $subject, $message, $headers);

        header('location:../Verifyno.php');
    }
  }
}
?>