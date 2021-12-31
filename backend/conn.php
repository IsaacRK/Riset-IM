<?php

$server 	= 'localhost';
$userNM 	= 'root';		//cypr9718
$pass 		= '';			//pq6SPaHWYiKe38
$database 	= 'pblwamsy';	//cypr9718_pblwamsy
$servConnQuery = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}
@session_start();
date_default_timezone_set("Asia/Jakarta");
?>
