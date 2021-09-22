<?php
/*
$host = 'ec2-54-220-14-54.eu-west-1.compute.amazonaws.com';
$userdb = '';
$passdb = '688b61c5af2016c5f675aa68010baedeef2c8640d1497244ebac4196d11bb1c8';
$db = '';
*/
//$servConnQuery = pg_connect("host=".$host." dbname=d77t2tdfp36qfc user=bvtaybhwbljwnv password=".$passdb." port=5432");
$servConnQuery = mysqli_connect('localhost', 'root', '', 'pblwamsy');

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}
@session_start();
//$conn = mysqli_connect();

/*
if(mysqli_connect_errno()){
	echo "connection to database error : ".mysqli_connect_error();
}
*/
?>