<?php

$server 	= 'localhost';
$userNM 	= 'cypr9718';		//cypr9718			//username dari login temboro/cpanel
$pass 		= 'j7wJUw9Abys4Y8tM';			//j7wJUw9Abys4Y8tM	//password dari login temboro/cpanel
$database 	= 'cypr9718_pblwamsy';	//cypr9718_pblwamsy	//nama database
$servConnQuery = mysqli_connect($server, $userNM, $pass, $database);

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}
@session_start();
date_default_timezone_set("Asia/Jakarta");
?>
