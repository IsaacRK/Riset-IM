<?php
$uid = $_SESSION['uid'];
$cartQuery = "select *  from cart where user_id = '$uid' and checkout = false";
$cartQueryRun = mysqli_query($servConnQuery,$cartQuery);

if(mysqli_num_rows($cartQueryRun) > 0){
	
	echo'
	<form action="" method="post">
	<div class="row m-1">
	
	';
	
	while($cartFetch = mysqli_fetch_assoc($cartQueryRun)){
		$cartTakeAmount	= $cartFetch['take_amount'];
		$cartNecesity	= $cartFetch['necessity'];
		$stockId		= $cartFetch['stock_id'];
		$cartId			= $cartFetch['cart_id'];

		$stockFindQuery	= "select stock_name from stock where stock_id = '$stockId'";
		$stockFindQueryRun = mysqli_query($servConnQuery,$stockFindQuery);
		$stockNameFetch = mysqli_fetch_assoc($stockFindQueryRun);
		$stockName		= $stockNameFetch['stock_name'];
		
		echo'
			<div class="col-2">
				<label class="checkbox">
				  <span class="checkbox_input">
					<input class="boxhidden" type="checkbox" name="checkbox[]" value="'.$cartId.'"/>
					<span class="checkbox_control">
					  <svg
						viewBox="0 0 24 24"
						aria-hidden="true"
						focusable="false"
					  >
						<path
						  fill="none"
						  stroke="currentColor"
						  stroke-width="3"
						  d="M1.73 12.91l6.37 6.37L22.79 4.59"
						/>
					  </svg>
					</span>
				  </span>
				</label>
			</div>
			<div class="col-10 mb-2">
				<span>nama komponen: '.$stockName.'</span></br>
				<span>jumlah : '.$cartTakeAmount.'</span></br>
				<span>keperluan : '.$cartNecesity.'</span></br>
			</div>
		';
	}
	echo'
	</div>

	<div class="row mt-2">
		<div class="col-6 mx-auto">
			<input class="btn btn-primary btn-block" type="submit" name="checkout" value="Checkout"/>
		</div>
	</div>
	</form>
	';
}else{
	echo'
		<div class="p-2 d-flex flex-fill bg-light justify-content-center p-2 text-justify">
			Tidak ada barang di Keranjang
		</div>
	';
}
?>