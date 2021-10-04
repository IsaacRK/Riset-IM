<?php

require_once 'conn.php';
require_once 'usersession.php';

if(isset($_POST['addToCart'])){
	
	$stockId 	= $_POST['stock_id'];
	$operator	= $_SESSION['uid'];
	$amount		= $_POST['amount_taken'];
	$necessity	= $_POST['necessity'];
	
	$query = "
	insert into cart (cart_id, user_id, stock_id, take_amount, necessity, checkout)
	values (default, '$operator', '$stockId', '$amount', '$necessity', false);
	";
	mysqli_query($servConnQuery, $query);
}
?>