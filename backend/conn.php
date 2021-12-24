<?php
$server 	= 'localhost';
$userNM 	= 'root';
$pass 		= '';
$database 	= 'pblwamsy';
$servConnQuery = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}
@session_start();
date_default_timezone_set("Asia/Jakarta");
?>
