<?php
require'../layout/header.php';
$id=2;
?>
<body>

<form id="tesForm" action="">
	<div class="row">
		<div class="col-8">
			<input type="hidden" name="idPengguna" value="<?php echo$id; ?>">
			<input class="form-control" name="input2" type="text" id="graphSearch" placeholder="Cari aktivitas barang">
			<input class="form-control" name="input1" type="text" id="graphSearch" placeholder="Cari aktivitas barang">
		</div>
		<div class="col-4 d-grid gap-2">
			<button class="btn btn-primary" type="submit" name="graphBtnSearch" value="Cari"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
			<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
			</svg></button>
		</div>
	</div>
</form>

<script>
	$(function(){
		$("#tesForm").on("submit", function(e){
			var dataString = $(this).serialize();
			alert(dataString);
			
			$.ajax({
				type: "POST",
				url: "backend/inputhandler.php",
				data: dataString,
				success: function(){
					$("#divChart").load('layout/a.php?'+dataString);
				}
			});
			e.preventDefault();
		});
	});
</script>
</body>