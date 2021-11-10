<?php
require 'backend/conn.php';
require 'backend/usersession.php';
?>
<html>
<head>
	<title>Penyimpanan</title>
	<?php include'layout/header.php';?>
</head>
<body>
	<?php include"layout/sidebar.php";?>
<div class="content">
<div class="container mr-0">
	<div class="p-1">
		<div class="row">
			<div class="col">
				<h1>Halaman Pengaturan Penyimpanan</h1>
			</div>
			<div class="col-3 mt-1 p-1 d-flex justify-content-end">
				<div class="d-grid gap-2 w-100">
					<button class="btn btn-primary">Tambah Penyimpanan</button>
				</div>
			</div>
		</div>
	</div>
	
	<form action="" id="formRak">
	<div class="row">
		<div class="col-9">
			<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-control">
				<option value="1" class="dropdown-item">Rak 1</option>
				<option value="2" class="dropdown-item">Rak 2</option>
			</select>
		</div>
		<div class="col-auto">
			<input class="btn btn-primary mt-2" type="submit" name="butonRak" value="Ganti Rak">
		</div>
	</div>
	</form>
	
	<form action="" id="formLantai">
	<div class="row">
		<div class="col-9">
			<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-control">
				<option value="1" class="dropdown-item">Rak 1</option>
				<option value="2" class="dropdown-item">Rak 2</option>
			</select>
		</div>
		<div class="col-auto">
			<input class="btn btn-primary mt-2" type="submit" name="butonRak" value="Ganti Lantai">
		</div>
	</div>
	</form>
	
	<div id="divPenyimpanan"></div>

</div>
</div>
<?php
	include"layout/js.php";
?>
<script>
$(document).ready(function(){
	$("#divPenyimpanan").load('layout/halamanPenyimpanan.php');
});
</script>
</body>
</html>