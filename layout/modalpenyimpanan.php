<?php
?>
<div class="modal-header">
	<h4 class="modal-title">Apakah anda yakin ingin meghapus tempat penyimpanan ini?</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-footer">
	<div class="row w-100">
		<form method="post" action="">
		<div class="col d-grid gap-2 w-100">
			<input type="hidden" name="rakId" value="<?php echo $_GET['rakId']; ?>">
			<input type="submit" name="hapusRak" class="btn btn-danger fw-bold" value="Hapus">
		</div>
		</form>
		<div class="col d-grid gap-2 w-100">
			<button type="button" class="btn btn-success fw-bold" data-bs-dismiss="modal">Batalkan</button>
		</div>
	</div>
</div>