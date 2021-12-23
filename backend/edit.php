<?php
require 'conn.php';
require 'usersession.php';


 if(isset($_POST['submit'])){
    //Mengambil data-data dari form
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $confPass = $_POST['passcon'];

    //Mengambil data pengguna berdasarkan ID	 
    $fetchSql = "select * from pengguna where id=$userId";
    $fetchRun = mysqli_query($servConnQuery, $fetchSql);
    $fetch = mysqli_fetch_assoc($fetchRun);
 if($fetch > 0){   
    //Melihat apakah kolom Nama Pengguna terisi	 
    if($user==null){

    }else{
        $sql = "UPDATE pengguna SET user='$user' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        header('location:../Profile.php');
    }
    //Melihat apakah kolom Kata Sandi terisi	 
    if($pass==null){

    }else{
     //Melihat apakah Kata Sandi sama dengan Konfirmasi Kata Sandi	    
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
    //Melihat apakah kolom Email terisi	 
    if($email==null){
    } else{
        $sql = "UPDATE pengguna SET email='$email' WHERE id = '$userId'";
        $change = mysqli_query($servConnQuery, $sql);
        header('location:../Profile.php');
    }
  }
}
?>
