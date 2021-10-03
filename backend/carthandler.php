<?php
$uid = $_SESSION['uid'];
$cartQuery = "select *  from cart where user_id = '$uid'";
$cartQueryRun = mysqli_query($servConnQuery,$cartQuery);

if(mysqli_num_rows($cartQueryRun) > 0){
	while($cartFetch = mysqli_fetch_assoc($cartQueryRun)){
		$cartTakeAmount	= $cartFetch['take_amount'];
		$cartNecesity	= $cartFetch['necessity'];
		$stockId		= $cartFetch['stock_id'];

		$stockFindQuery	= "select stock_name from stock where stock_id = '$stockId'";
		$stockFindQueryRun = mysqli_query($servConnQuery,$stockFindQuery);
		$stockNameFetch = mysqli_fetch_assoc($stockFindQueryRun);
		$stockName		= $stockNameFetch['stock_name'];
		
		echo'
			<div class="col-2">
				<div class="border border-dark rounded" style="width:50px;height:50px"></div>
			</div>
			<div class="col-10">
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
				<input class="btn btn-primary btn-block" type="submit" name="submit" value="Update"/>
			</div>
		</div>
	';
}else{
	echo'
	</div>
		<div class="p-2 d-flex flex-fill bg-light justify-content-center p-2 text-justify">
			Tidak ada barang di Keranjang
		</div>
	';
}
?>