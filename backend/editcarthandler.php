<?php
if(isset($_POST['btnEditCart'])){
	$cartId = $_POST['cartId'];
	$x = $_POST['amount'];
	$necessity = $_POST['necessity'];
	$updateCartQuery = "update cart set take_amount = '$x', necessity = '$necessity' where cart_id = '$cartId' ";
	mysqli_query($servConnQuery,$updateCartQuery);
}
if(isset($_POST['hapusKeranjang'])){
	$cartId = $_POST['cartId'];
	$sql = "DELETE FROM cart WHERE cart_id='$cartId'";
	mysqli_query($servConnQuery,$sql);
}
?>