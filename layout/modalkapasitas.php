<?php
if(isset($_GET['rakId'])){
	$rid = $_GET['rakId'];
}
?>
<div class="modal-header">
	<h4 class="modal-title">Edit kapasitas penyimpanan</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
	<form method="post" action="">
		<input type="number" class="form-control" name="maxCap">
		<input type="hidden" name="storageId" value="<?php echo$rid; ?>">
		<input type="submit" class="btn btn-success" name="btnEdit" value="Ubah Kapasitas">
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
</div>