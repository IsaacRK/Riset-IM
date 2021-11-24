<?php

if(isset($_POST['checkout'])){
	$value = $_POST['checkbox'];
	for($i=0;$i<count($value);$i++){
		$cartId = $value[$i];
		
		$user_id = $_SESSION['uid'];
		
		$cartFetchQuery = "select * from cart where cart_id = '$cartId'";
		$cartFetchRun	= mysqli_query($servConnQuery, $cartFetchQuery);
		$cartFetch 		= mysqli_fetch_assoc($cartFetchRun);
		
		$stockId = $cartFetch['stock_id'];
		
		$stockFetchQuery 	= "select * from stock where stock_id = $stockId";
		$stockFetchRun 		= mysqli_query($servConnQuery, $stockFetchQuery);
		$stockFetch 		= mysqli_fetch_assoc($stockFetchRun);
	
		$stockName 		= $stockFetch['stock_name'];
		$stockAmount	= $stockFetch['amount'];
		$takeAmount 	= $cartFetch['take_amount'];
		
		$finalAmount = $stockAmount - $takeAmount;
		
		if($finalAmount < 0){
			echo'
				<script>
					$(document).ready(function(){
					alert("Barang [ '.$stockName.' ] yang di ambil [ '.$takeAmount.' ] melebihi jumlah yang tersedia! [ '.$stockAmount.' ]");
					})
				</script>
			';
		}else{			
			$stockUpdateQuery = "update stock set amount='$finalAmount' where stock_id='$stockId'";
			mysqli_query($servConnQuery, $stockUpdateQuery);
			
			$cartUpdateQuery = "update cart set checkout=true where cart_id=$cartId";
			mysqli_query($servConnQuery, $cartUpdateQuery);
			
			$now = date("Y-m-d");
			$historyQuery = 
			"insert into 
			history (history_id, stock_id, amount, input, output, user_id, date) 
			values (default, '$stockId', '$takeAmount', NULL, 1, '$user_id', '$now')";
			mysqli_query($servConnQuery, $historyQuery);
		}
	}
}

?>