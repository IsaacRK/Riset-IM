<?php
	require '../backend/conn.php';
	
	$itemName='';
	$cartAmount='';
	$totlAmount='';
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
		$totlAmount	= $itemFetch['amount'];
	}
?>
<div class="modal-header">
	<div class="row">
		<div class="col">
			<h2>Edit Cart</h2>
		</div>
		<div class="col">
			<div class="d-flex justify-content-end">
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus">
				
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
					</svg>
				
				</button>
			</div>
		<div>
	</div>
</div>
<form action="" method="POST">
<div class="modal-body">
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Nama Barang</span>
			</div>
			<input required type="text" class="form-control" value="<?php echo $itemName; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled readonly>
		</div>
		
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah Tersedia</span>
			</div>
			<input required type="text" class="form-control" value="<?php echo $totlAmount; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled readonly>
		</div>
		
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah Diambil</span>
			</div>
			<input required type="text" class="form-control" name="amount" value="<?php echo $cartAmount; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		
		<div class="input-group input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-sm">Keperluan</span>
			</div>
			<input required type="text" class="form-control" name="necessity" value="<?php echo $keperluan; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		
		<input type="hidden" name="cartId" value="<?php echo$cartId; ?>">
		
</div>
<div class="modal-footer d-flex justify-content-center">
	<input type="submit" class="btn btn-primary" name="btnEditCart" value="Perbarui">
</div>
</form>

<div id="modalHapus" class="modal fade" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-bold" id="modalHapusLabel">Hapus Barang Pada Keranjang?</h5>
			</div>
			<div class="modal-body">
				<p>Apakah anda yakin akan menghapus barang dari keranjang anda?</p>
				<p>Tidakan ini tidak dapat di urungkan.</p>
			</div>
			<div class="modal-footer">
			<div class="row w-100">
				<div class="col w-100">
				<form action="" method="post" class="d-grid gap-2">
					<input type="submit" name="hapusKeranjang" class="btn btn-danger fw-bold" value="Hapus">
					<input type="hidden" name="cartId" value="<?php echo$cartId; ?>">
				<form>
				</div>
				<div class="col d-grid gap-2 w-100">
					<button type="button" class="btn btn-success fw-bold" data-bs-dismiss="modal">Batalkan</button>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script>
function sendData(x){
	var cartId = '?hapusKeranjang='+x;
	$.ajax({
		type: "POST",
		url: "backend/editcarthandler.php",
		data: cartId,
		success: function(){
			location.reload();
		}
	});
}
</script>