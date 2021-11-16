<?php
require 'conn.php';
require 'usersession.php';


 if(isset($_POST['submit'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $confPass = $_POST['passcon'];
    
    $fetchSql = "select * from pengguna where id=$userId";
    $fetchRun = mysqli_query($servConnQuery, $fetchSql);
    $fetch = mysqli_fetch_assoc($fetchRun);
 if($fetch > 0){   
    if($user==null){

    }else{
        $sql = "UPDATE pengguna SET user='$user' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        header('location:../Profile.php');
    }
    if($pass==null){

    }else{
  if($pass !== $confPass){
		echo "
		<div style='width:100%;pading:5px;background-color:red;color:white;text-align:center;font-weight:bold;'>
			Password dan Konfirmasi Password berbeda
		</div>
		";
  } else{
        $sql = "UPDATE pengguna SET pass='$pass' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        header('location:../Profile.php');
    }       
    }
    if($email==null){
    } else{
        $sql = "UPDATE pengguna SET email='$email' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        header('location:../Profile.php');
    }
  }
}
?>