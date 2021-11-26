<?php
require 'conn.php';

if(isset($_POST['cartId'])){
	$cartId = $_POST['cartId'];
	$newVal = $_POST['newVal'];
	
	$sql = "update cart set take_amount = '$newVal' where cart_id = '$cartId' ";
	mysqli_query($servConnQuery,$sql);
}
?>