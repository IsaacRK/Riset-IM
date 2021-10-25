<?php

?>
<html>
<head>
<?php include "../layout/header.php"; ?>
</head>
<body>

<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Barang Masuk</h1>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="card">
			<div class="card-body">
				<h3>Data Barang</h3>
				</br>
				
				<form action="" id="itemNameForm">
					<div class="row mb-3">
						<div class="col-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-sm">Nama</span>
								</div>
								<input required type="text" class="form-control" name="itemName" id="itemName" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
							</div>
						</div>
						<div class="col d-grid gap-2">
							<input class="btn btn-primary" type="submit" name="itemNameBtn" value="Cek">
						</div>
					</div>
				</form>
				
				<div id="divItemData">
				</div>
				
			</div>
			</div>
		</div>
		
		<div class="col">
			<div class="card">
			<div class="card-body">
				
			
			</div>
			</div>
		</div>
	</div>


<div id="modalBarcode" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

 
 
</div>
</div>

<script>
$(function(){
	$("itemData").on("submit", function(e){
		var dataString = $(this).serialize();
		//alert(dataString);
		
		$.ajax({
			type: "POST",
			url: "../backend/inputhandler.php",
			data: dataString,
			success: function(){
				$('#modalBarcode').modal('show').find('.modal-content').load('../layout/modalbarcode.php?'+dataString);
			}
		});
		e.preventDefault();
	});
});

$(function(){
	$("#itemName").autocomplete({
		source: '../backend/autocomplete.php'
	});
});

$(function(){
	$("#itemNameForm").on("submit", function(e){
		var dataString = $(this).serialize();
		//alert(dataString);
		
		$.ajax({
			type: "POST",
			url: "test.html",
			data: dataString,
			success: function(){
				$("#divItemData").load('modal.php?'+dataString);
			}
		});
		e.preventDefault();
	});
});

</script>
<body>