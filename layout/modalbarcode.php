<?php
include "../backend/conn.php";
$itemName = '';
$amount = '';
$rak = '';
$lan = '';
$klm = '';
$bar = '';
$stockId = '';

if(isset($_GET['itemName'])){
	$itemName = $_GET['itemName'];
	$amount = $_GET['amount'];
	
	$rak = $_GET['rak'];
	$lan = $_GET['lantai'];
	$klm = $_GET['kolom'];
	$bar = $_GET['baris'];
	
	$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lan' and kolom = '$klm' and baris = '$bar'";
	$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
	$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		
	$storage_id = $storageIdFetch['storage_id'];
	$stockId	= $storageIdFetch['stock_id'];
	
	$stockBarcodeSearchQuery = "select barcode from `stock` where stock_id = '$stockId' and storage_id = '$storage_id'";
	$stockBarcodeSearchQueryRun = mysqli_query($servConnQuery,$stockBarcodeSearchQuery);
	$stockBarcodeFetch = mysqli_fetch_assoc($stockBarcodeSearchQueryRun);
	$stockBarcode = $stockBarcodeFetch['barcode'];
}

if(isset($_GET['itemNameUpdate'])){
	$itemName = $_GET['itemNameUpdate'];
	$amount = $_GET['amountUpdate'];
	
	$rak = $_GET['rakUpdate'];
	$lan = $_GET['lantaiUpdate'];
	$klm = $_GET['kolomUpdate'];
	$bar = $_GET['barisUpdate'];
	
	$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lan' and kolom = '$klm' and baris = '$bar'";
	$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
	$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		
	$storage_id = $storageIdFetch['storage_id'];
	$stockId	= $storageIdFetch['stock_id'];
	
	$stockBarcodeSearchQuery = "select barcode from `stock` where stock_id = '$stockId' and storage_id = '$storage_id'";
	$stockBarcodeSearchQueryRun = mysqli_query($servConnQuery,$stockBarcodeSearchQuery);
	$stockBarcodeFetch = mysqli_fetch_assoc($stockBarcodeSearchQueryRun);
	$stockBarcode = $stockBarcodeFetch['barcode'];
}

?>

			<div class="modal-header">
				<button class="border border-0" type="" data-bs-dismiss="modal">
					<img src="img/icons/x-lg.svg"/>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
                           <div class="mb-3">
                               <span>Nama Komponen:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span><?php echo $itemName; ?></span>
                           </div>
                       </div>
				</div>
				
				<div class="row">
					<div class="col-6">
                           <div class="mb-3">
                               <span>Jumlah:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span><?php echo $amount; ?></span>
                           </div>
                       </div>
				</div>
				
				<div class="row">
					<div class="col-6">
                           <div class="mb-3">
                               <span>Lokasi Penyimpanan:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span>
								<?php
									echo'
										<span>rak:'.$rak.'</span></br>
										<span>lantai:'.$lan.'</span></br>
										<span>kolom:'.$klm.'</span></br>
										<span>baris:'.$bar.'</span>
									';
								?>
							   </span>
                           </div>
                       </div>
				</div>
				
				<div class="container d-flex justify-content-center">
				<div class="card" style="">
					<div class="card-body">
						<svg id="barcodeShow"></svg>
					</div>
				</div>
				</div>
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print</button>
			</div>
			<script>
				JsBarcode("#barcodeShow","<?php echo $stockBarcode; ?>");
			</script>