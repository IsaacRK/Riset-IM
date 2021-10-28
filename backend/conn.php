<?php
$servConnQuery = mysqli_connect('localhost', 'root', '', 'updet');

if (mysqli_connect_errno()){
    echo "DATABASE ERROR : " . mysqli_connect_error();
}
@session_start();
date_default_timezone_set("Asia/Jakarta");
?>