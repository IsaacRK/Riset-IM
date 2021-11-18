<?php

require 'backend/conn.php';
require 'backend/usersession.php';

if(isset($_POST['btnEdit'])){
	$sid = $_POST['storageId'];
	$cap = $_POST['maxCap'];
	
	$editSql = "UPDATE penyimpanan SET kapasitas='$cap' WHERE storage_id='$sid'";
	$editRun = mysqli_query($servConnQuery, $editSql);
	if($editRun){
		echo'
			<script>
				alert("kapasitas berhasil di ubah");
			</script>
		';
	}
}

?>
<html>

<head>
	<title>Kapasitas Penyimpanan</title>
	<?php include"layout/header.php"?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">
	
	<div class="p-1">
		<h1>Pengaturan Kapasitas Penyimpanan</h1>
	</div>
	
	<div class="card">
		<div class="card-body">
		
		<form action="" id="formRak">
		<div class="row">
			<div class="col">
				<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-select">
					<option value="1" class="dropdown-item">Rak 1</option>
					<option value="2" class="dropdown-item">Rak 2</option>
				</select>
			</div>
			
			<div class="col">
				<select name="lan" class="btn btn-light border dropdown-toggle m-2 form-select">
					<option value="1" class="dropdown-item">Lantai 1</option>
					<option value="2" class="dropdown-item">Lantai 2</option>
					<option value="3" class="dropdown-item">Lantai 3</option>
					<option value="4" class="dropdown-item">Lantai 4</option>
					<option value="5" class="dropdown-item">Lantai 5</option>
				</select>
			</div>
			
			<div class="col-sm">
			<div class="d-grid">
				<input class="btn btn-primary mt-2" type="submit" name="butonRak" value="Ganti Penyimpanan">
			</div>
			</div>
		</div>
		</form>
		
		<!--tabel rak start-->
		<div id="divPenyimpanan"></div>
		<!--tabel rak end---->
		
		</div>
	</div>
	
</div>
</div>

<div class="modal" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div>
  </div>
</div>

<?php
	include"layout/js.php";
?>
<script>
$(document).ready(function(){
	$("#divPenyimpanan").load('layout/kapasitasPenyimpanan.php');
});

$(function(){
	$('#formRak').on("submit", function(e){
		var dataString = $(this).serialize();
		
		$.ajax({
			type: "POST",
			url: "layout/test.html",
			data: dataString,
			success: function(){
				$("#divPenyimpanan").load('layout/kapasitasPenyimpanan.php?'+dataString)
			}
		});
		e.preventDefault();
	});
});

function edit(x){	
	console.log(x);
	$('#modalEdit').modal('show').find('.modal-content').load('layout/modalkapasitas.php?rakId='+x);
}
</script>

</body>
</html>