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
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTabelEdit">
					  Tambah Penyimpanan
					</button>
				</div>
			</div>
		</div>
	</div>
	
	<form action="" id="formRak">
	<div class="row">
		<div class="col-9">
			<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-select">
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
			<select name="lan" class="btn btn-light border dropdown-toggle m-2 form-select">
				<option value="1" class="dropdown-item">Lantai 1</option>
				<option value="2" class="dropdown-item">Lantai 2</option>
				<option value="3" class="dropdown-item">Lantai 3</option>
				<option value="4" class="dropdown-item">Lantai 4</option>
				<option value="5" class="dropdown-item">Lantai 5</option>
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

<div class="modal" id="modalTabelEdit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Modal body..
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
	include"layout/js.php";
?>
<script>
$(document).ready(function(){
	$("#divPenyimpanan").load('layout/halamanPenyimpanan.php');
});

$(function(){
	$('#formRak').on("submit", function(e){
		var dataString = $(this).serialize();
		
		$.ajax({
			type: "POST",
			url: "layout/test.html",
			data: dataString,
			success: function(){
				$("#divPenyimpanan").load('layout/halamanPenyimpanan.php?'+dataString)
			}
		});
		e.preventDefault();
	});
});

$(function(){
	$('#formLantai').on("submit", function(e){
		var dataString = $(this).serialize();
		
		$.ajax({
			type: "POST",
			url: "layout/test.html",
			data: dataString,
			success: function(){
				$("#divPenyimpanan").load('layout/halamanPenyimpanan.php?'+dataString)
			}
		});
		e.preventDefault();
	});
});
</script>
</body>
</html>