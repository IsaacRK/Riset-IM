<?php

require 'backend/conn.php';
require 'backend/usersession.php';
require 'backend/outputhandler.php';
require 'backend/checkouthandler.php';

$Cid	= '';
$Cname	= '';
$CStock	= '';
$Crak	= '';
$Clan	= '';
$Cklm	= '';
$Cbar	= '';

if(isset($_POST['search'])){
	$componentNameSearch 		= $_POST['componentNameSearch'];
	
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

if(isset($_GET['barcode'])){
	$val = $_GET['barcode'];
	$len = strlen($val);
	$id = substr($val,7);
	$adr = '';
	if($len>8){
		$adr = substr($val,0,-2);
	}else{
		$adr = substr($val,0,-1);
	}

	$componentIdSearch = $id;
	$componentAddrSearch = $adr;
	
	$serachComponentQuery 		= "select * from `stock` where barcode like '$componentAddrSearch' and stock_id like '$componentIdSearch'";
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
	<title>Dashboard</title>
	<?php include"layout/header.php"?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>
<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Stock Output</h1>
		</div>
	</div>

	<div class="row mb-2 ms-2">
		<div class="col-7">
		<form action="" method="post">
			<div class="row">
			<div class="col-9">
				<div class="row border border-dark rounded">
					<div class="col-2">
						<img class="m-1" src="img/icons/search.svg" width="25" height="25"/>
					</div>
					<div class="col-9">
						<input class="form-control border border-0" style="" type="text" placeholder="Nama Komponen" name="componentNameSearch" id=""/>
					</div>
				</div>
			</div>
			<div class="col-3">
				<input class="btn btn-primary btn-block" type="submit" name="search" value="Search"/>
			</div>
			</div>
		</form>
		</div>
		<div class="col-5">
			<button type="button" class="btn btn-primary btn-block" id="barcodeScnButton">Barcode Scanner</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			<form action="" method="post">
				<h3>Component Information</h3>
				</br>
				<div class="row">
					<div class="col">
						<span>Nama Komponen :</span>
					</div>
					<div class="col">
					<span>
						<?php
							if($Cname != ''){
								echo $Cname;
							}else{
								echo 'belum di pilih.';
							}
						?>
					</span>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<span>Stock : </span>
					</div>
					<div class="col">
						<span>
							<?php
								if($CStock != ''){
									echo $CStock;
								}else{
									echo 'belum di pilih.';
								}
							?>
						</span>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<span>lokasi : </span>
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
								echo '<span>belum di pilih.</span>';
							}
						?>
					</div>
				</div>
				</br>
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah Yang Di Ambil</span>
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
						<input class="btn btn-primary btn-block" type="submit" name="addToCart" value="Tambahkan ke Keranjang"/>
					</div>
				</div>
			</form>
			
			</div>	
			</div>
		</div>
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
				<h3>Cart</h3>
				
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


<script>
$(document).ready(function(){
  $("#barcodeScnButton").click(function(){
    $('#modalBarcodeScn').modal('show').find('.modal-content').load('layout/scanBarcode.html');
  });
});

</script>

<script src="js/jquery3.6.0.min.js"	type="text/javascript" crossorigin="anonymous"></script>

<script src="js/barcodeScanner.js"	type="text/javascript" crossorigin="anonymous"></script>
<script src="js/zixing-latest.js"	type="text/javascript" crossorigin="anonymous"></script>


<?php
	include"layout/js.php";
?>
</body>