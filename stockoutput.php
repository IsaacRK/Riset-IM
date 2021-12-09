<?php

require 'backend/conn.php';
require 'backend/usersession.php';
require 'backend/editcarthandler.php';

if($userlvl == 'supervisor'){
	header('location:dashboard.php');
}else if($userlvl == 'procurement'){
	header('location:dashboard.php');
}else{}

if ($userAC == '0'){
	header('location:Verifyno.php');
}

$Cid	= null;
$Cname	= '';
$CStock	= '';
$Crak	= '';
$Clan	= '';
$Cklm	= '';
$Cbar	= '';

if(isset($_POST['search'])){
	$componentNameSearch 		= $_POST['componentNameSearch'];
	
	if($componentNameSearch == null){
	header('location:stockoutput.php');
	}else{
	
	$serachComponentQuery 		= "select * from `stock` where stock_name like '$componentNameSearch'";
	$serachComponentQueryRun 	= mysqli_query($servConnQuery,$serachComponentQuery);
	$componentFetch 			= mysqli_fetch_assoc($serachComponentQueryRun);
	
	$Cid	= $componentFetch['stock_id'];
	$Cname	= $componentFetch['stock_name'];
	$CStock	= $componentFetch['amount'];
	$Caddrs = $componentFetch['storage_id'];
	
	$addrsFetchQuery	 		= "select * from `penyimpanan` where storage_id like '$Caddrs'";
	$addrsFetchQueryRun		 	= mysqli_query($servConnQuery,$addrsFetchQuery);
	$addrsFetch		 			= mysqli_fetch_assoc($addrsFetchQueryRun);
	
	$Crak	= $addrsFetch['rak'];
	$Clan	= $addrsFetch['lantai'];
	$Cklm	= $addrsFetch['kolom'];
	$Cbar	= $addrsFetch['baris'];
	}
}

if(isset($_GET['barcode'])){
	$val = $_GET['barcode'];
	
	$serachComponentQuery 		= "select * from `stock` where barcode = '$val'";
	$serachComponentQueryRun 	= mysqli_query($servConnQuery,$serachComponentQuery);
	$componentFetch 			= mysqli_fetch_assoc($serachComponentQueryRun);
	
	$Cid	= $componentFetch['stock_id'];
	$Cname	= $componentFetch['stock_name'];
	$CStock	= $componentFetch['amount'];
	$Caddrs = $componentFetch['storage_id'];
	
	$addrsFetchQuery	 		= "select * from `penyimpanan` where storage_id like '$Caddrs'";
	$addrsFetchQueryRun		 	= mysqli_query($servConnQuery,$addrsFetchQuery);
	$addrsFetch		 			= mysqli_fetch_assoc($addrsFetchQueryRun);
	
	$Crak	= $addrsFetch['rak'];
	$Clan	= $addrsFetch['lantai'];
	$Cklm	= $addrsFetch['kolom'];
	$Cbar	= $addrsFetch['baris'];
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Stok Keluar</title>
	<?php include"layout/header.php"?>
	<style>
		@media screen and (max-width: 767px){
			#barcodeScnButton{
				margin-top: 10px;
				width: 96%;
			}
		}
	</style>
</head>

<body>

<?php
	include"layout/sidebar-old.php";
	require 'backend/outputhandler.php';
?>
<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Stok Keluar</h1>
		</div>
	</div>

	<div class="row mb-2 ms-2">
		<div class="col-md-7 d-grid gap-2 ">
		<form action="" method="post">
			<div class="row">
			<div class="col-9 d-grid">
				<div class="row border border-dark rounded" style="background:white;">
					<div class="col-2">
						<img class="m-1" src="img/icons/search.svg" width="25" height="25"/>
					</div>
					<div class="col-9">
						<input class="form-control border border-0" style="" type="text" placeholder="Nama komponen" name="componentNameSearch" id="componentNameSearch"/>
					</div>
				</div>
			</div>
			<div class="col-3 d-grid">
				<input class="btn btn-primary" type="submit" name="search" value="Cari"/>
			</div>
			</div>
		</form>
		</div>
		<div class="col-md-5 d-grid gap-2">
			<button type="button" class="btn btn-primary" id="barcodeScnButton">Barcode scanner</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm">
			<div class="card shadow-sm">
			<div class="card-body">
			<form action="" method="post">
				<h3>Informasi komponen</h3>
				</br>
				<div class="row">
					<div class="col">
						<span>Nama komponen :</span>
					</div>
					<div class="col">
					<span>
						<?php
							if($Cname != ''){
								echo $Cname;
							}else{
								echo '-';
							}
						?>
					</span>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<span>Stok : </span>
					</div>
					<div class="col">
						<span>
							<?php
								if($CStock != ''){
									echo $CStock;
								}else{
									echo '-';
								}
							?>
						</span>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<span>Lokasi : </span>
					</div>
					<div class="col">
						<?php
							if($CStock != ''){
								echo'
									<span>rak:'.$Crak.'</span></br>
									<span>lantai:'.$Clan.'</span></br>
									<span>kolom:'.$Cklm.'</span></br>
									<span>baris:'.$Cbar.'</span>
								';
							}else{
								echo '<span>-</span>';
							}
						?>
					</div>
				</div>
				</br>
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah yang diambil</span>
					</div>
					<input required type="number" class="form-control" name="amount_taken" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				</div>
				
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Keperluan</span>
					</div>
					<input required type="text" class="form-control" name="necessity" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				</div>
				
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Pengambil</span>
					</div>
					<input type="text" class="form-control" name="category" placeholder="<?php echo $username; ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
				</div>
				
				<input type="hidden" class="form-control" value="<?php echo $Cid; ?>" name="stock_id">

				<div class="row mt-2">
					<div class="col-6 mx-auto">
						<input class="btn btn-primary btn-block" type="submit" name="addToCart" value="Tambahkan ke keranjang"
							<?php
								if(isset($Cid)==null){
									echo'disabled aria-disabled="true"';
								}
							?>
						/>
					</div>
				</div>
			</form>
			
			</div>	
			</div>
		</div>
		<div class="col-sm">
			<div class="card shadow-sm">
			<div class="card-body">
				<h3>Keranjang</h3>
				
				<?php
					require'backend/carthandler.php';
				?>

			</div>
			</div>
		</div>
	</div>
</div>
</div>


<div id="modalBarcodeScn" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header"></div>
			<div class="modal-body">
				<div class="card border-0" style="width:300px;height:280px;position:relative">
					<div class="card-body p-3" style="background: #222; border-radius: 25px 25px 0px 0px;">
						<video id="previewKamera" style="width: 100%;height: 100%;"></video>
					</div>
					<div class="card-footer bg-primary" style="border-radius: 0px 0px 25px 25px">
						<select id="pilihKamera" style="max-width:400px" class="form-select">
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modalEditCart" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div id="modalInvoice" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>

<script>
	
function edit(x){	
	console.log(x);
	$('#modalEditCart').modal('show').find('.modal-content').load('layout/editcart.php?cartData='+x);
}

$(document).ready(function(){
  $("#barcodeScnButton").click(function(){
    //$('#modalBarcodeScn').modal('show').find('.modal-content').load('layout/scanBarcode2.html');
	$('#modalBarcodeScn').modal('show');
  });
});

$(function(){
	$("#componentNameSearch").autocomplete({
		source: 'backend/autocomplete.php'
	});
});


$('#modalInvoice').on('hidden.bs.modal', function () {
 location.reload();
});

</script>

<script src="js/zixing-latest.js"	type="text/javascript" crossorigin="anonymous"></script>
<script src="js/scanBarcode2.js"	type="text/javascript" crossorigin="anonymous"></script>

<?php
	include"layout/js.php";
?>
</body>
