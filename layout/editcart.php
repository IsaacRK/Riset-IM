<?php
	require '../backend/conn.php';
	
	$itemName='';
	$cartAmount='';
	$keperluan='';
	if(isset($_GET['cartData'])){
		$cartId 	= $_GET['cartData'];
		$cartSql 	= "select * from cart where cart_id = '$cartId'";
		$cartRun 	= mysqli_query($servConnQuery, $cartSql);
		$cartRow 	= mysqli_fetch_assoc($cartRun);
		$itemId 	= $cartRow['stock_id'];
		$cartAmount	= $cartRow['take_amount'];
		$keperluan 	= $cartRow['necessity'];
		
		$itemSql	= "select * from stock where stock_id = '$itemId'";
		$itemRun	= mysqli_query($servConnQuery, $itemSql);
		$itemFetch	= mysqli_fetch_assoc($itemRun);
		$itemName	= $itemFetch['stock_name'];
	}
?>
<div class="modal-header">
	<h2>Edit Cart</h2>
</div>
<div class="modal-body">
		<div class="row">
			<div class="col-6">
				<div class="mb-3">
					<span>Nama Barang:</span>
				</div>
			</div>
			<div class="col-6">
				<div class="mb-3">
					<span><?php echo $itemName; ?></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="mb-3">
					<span>Jumlah Tersedia:</span>
				</div>
			</div>
			<div class="col-6">
				<div class="mb-3">
					<span><?php echo $cartAmount; ?></span>
				</div>
			</div>
		</div>
		
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah Diambil</span>
			</div>
			<input required type="text" class="form-control" name="necessity" value="<?php echo $cartAmount; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Keperluan</span>
			</div>
			<input required type="text" class="form-control" name="necessity" value="<?php echo $keperluan; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		
	<div class="modal-footer d-flex justify-content-center">
	</div>
</div>