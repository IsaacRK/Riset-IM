<?php
require '../backend/conn.php';
require '../backend/usersession.php';

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}
$sql = '';
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = '
	select harga.* , stock.*
	from harga
	join stock
	on stock.stock_id = harga.stock_id
	where harga.id = '.$id
	;
}

	$run = mysqli_query($servConnQuery, $sql);
	$data = mysqli_fetch_assoc($run);
	
	$sid = $data['stock_id'];
	$tglSql = "select date from history where stock_id = '$sid' and input = '1' order by date desc limit 1";
	$tglRun = mysqli_query($servConnQuery, $tglSql);
	$tglRow = mysqli_fetch_assoc($tglRun);
	$tgl = '';
	if($tglRow == null){
		$tgl = 'Input sebelum Riwayat';
	}else{
		$tgl = $tglRow['date'];
	}
	$beli = rupiah($data['beli']);
	if($data['beli'] == 0){
		$beli = 'data belum ada';
	}
	$jual = rupiah($data['jual']);
	if($data['jual'] == 0){
		$jual = 'data belum ada';
	}

?>
<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Edit Harga</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
	<form action="" method="post">
<div class="modal-body">
	<fieldset disabled>
		<label for="disabledTextInput" class="form-label" >Nama</label>
		<input type="Text" class="form-control" id="disabledTextInput" placeholeder="disabled input" value="<?php echo$data['stock_name'];?>">	
		<label for="disabledTextInput" class="form-label" >Jumlah</label>
		<input type="Text" class="form-control" id="disabledTextInput" placeholeder="disabled input" value="<?php echo$data['amount'];?>">
		<label for="disabledTextInput" class="form-label">Tanggal Input</label>
		<input type="Text" class="form-control" id="disabledTextInput" placeholeder="disabled input" value="<?php echo$tgl;?>">
		<label for="exampleInputHargaBeli" class="form-label">Harga Beli</label>
		<input type="HargaBeli" class="form-control" id="exampleInputHargaBeli" value="<?php echo$data['beli']?>">
	</fieldset disabled>
	<label for="exampleInputHargaJual" class="form-label">Harga Jual</label>
	<input type="HargaJual" name="edit" class="form-control" id="exampleInputHargaJual" >
	<input type="hidden" name="editId" value="<?php echo$sid; ?>" >
</div>
<div class="modal-footer">
	<input type="submit"  class="btn btn-primary" name="editBtn" value="Submit">
	</form>
	<span class="btn btn-secondary" data-bs-dismiss="modal">Batal</span>
</div>