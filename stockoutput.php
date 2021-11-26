<?php

require 'backend/conn.php';
require 'backend/usersession.php';
require 'backend/editcarthandler.php';

if ($userAC == '0'){
	header('location:Verifyno.php');
}else{}

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
			}
		}
	</style>
</head>

<body>

<?php
	include"layout/sidebar.php";
	require 'backend/outputhandler.php';
	require 'backend/checkouthandler.php';
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

<!-------------------------->
<!--| construction banner|-->
<!-------------------------->
<!--
<div class="card text-light bg-danger my-3">
<div class="card-body">
	<div class="row">
		<div class="col-2 d-flex justify-content-center">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
		  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
		  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
		</svg>
		</div>
		<div class="col-8 d-flex justify-content-center">
		<h5 class="card-title">Masih Dalam Tahap pengerjaan</h5>
		</div>
		<div class="col-2 d-flex justify-content-center">
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
		  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
		  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
		</svg>
		</div>
	</div>
</div>
</div>
-->
<!-------------------------->
<!--| construction banner|-->
<!-------------------------->

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
		</div>
	</div>
</div>

<div id="modalEditCart" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
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
    $('#modalBarcodeScn').modal('show').find('.modal-content').load('layout/scanBarcode.html');
  });
});

$(function(){
	$("#componentNameSearch").autocomplete({
		source: 'backend/autocomplete.php'
	});
});

</script>

<script src="js/barcodeScanner.js"	type="text/javascript" crossorigin="anonymous"></script>
<script src="js/zixing-latest.js"	type="text/javascript" crossorigin="anonymous"></script>


<?php
	include"layout/js.php";
?>
</body>
