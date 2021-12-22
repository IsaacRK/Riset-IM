<?php

require_once 'conn.php';
require_once 'usersession.php';

if(isset($_POST['addToCart'])){
	
	$stockId 	= $_POST['stock_id'];
	$operator	= $_SESSION['uid'];
	$amount		= $_POST['amount_taken'];
	$necessity	= $_POST['necessity'];
	
	//cek apakah barang melebihi jumlah pada database
	$stockFetchQuery 	= "select * from stock where stock_id = $stockId";
	$stockFetchRun 		= mysqli_query($servConnQuery, $stockFetchQuery);
	$stockFetch 		= mysqli_fetch_assoc($stockFetchRun);
	
	$stockName 		= $stockFetch['stock_name'];
	$stockAmount	= $stockFetch['amount'];
	
	$finalAmount = $stockAmount - $amount;
	
	if($finalAmount < 0){
		echo'
			<script>
				$(document).ready(function(){
				alert("Barang [ '.$stockName.' ] yang di ambil [ '.$amount.' ] melebihi jumlah yang tersedia! [ '.$stockAmount.' ]");
				})
			</script>
		';
		header('location:../stockoutput.php');
	}else{
		$query = "
		insert into cart (cart_id, user_id, stock_id, take_amount, necessity, checkout)
		values (default, '$operator', '$stockId', '$amount', '$necessity', false);
		";
		if(mysqli_query($servConnQuery, $query)){
			header('location:../stockoutput.php');
		}
	}
	
	
}
header('location:../stockoutput.php');
?>