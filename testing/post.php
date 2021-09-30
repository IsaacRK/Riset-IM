<?php
include"../backend/conn.php";
include"../backend/usersession.php";

	
	$a = $_POST['name'];
	$aa = $_POST['email'];
	$AAA = $_POST['phone'];

	$query = "insert into test (id, a, aa, AAA) value (default,'$a','$aa','$AAA')";
	$run = mysqli_query($servConnQuery, $query);

?>