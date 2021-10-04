<?php

if(isset($_POST['checkout'])){
	$value = $_POST['checkbox'];
	for($i=0;$i<count($value);$i++){
		$cartId = $value[$i];
		
		$cartFetchQuery = "select * from cart where cart_id = '$cartId'";
		$cartFetchRun	= mysqli_query($servConnQuery, $cartFetchQuery);
		$cartFetch 		= mysqli_fetch_assoc($cartFetchRun);
		
		$stockId = $cartFetch['stock_id'];
		
		$stockFetchQuery 	= "select * from stock where stock_id = $stockId";
		$stockFetchRun 		= mysqli_query($servConnQuery, $stockFetchQuery);
		$stockFetch 		= mysqli_fetch_assoc($stockFetchRun);
	
		$stockAmount	= $stockFetch['amount'];
		$takeAmount 	= $cartFetch['take_amount'];
		
		$finalAmount = $stockAmount - $takeAmount;
		
		$stockUpdateQuery = "update stock set amount='$finalAmount' where stock_id='$stockId'";
		mysqli_query($servConnQuery, $stockUpdateQuery);
		
		$cartUpdateQuery = "update cart set checkout=true where cart_id=$cartId";
		mysqli_query($servConnQuery, $cartUpdateQuery);
	}
}

?>