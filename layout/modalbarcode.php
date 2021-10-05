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
	
	$stockIdSearchQuery = "select stock_id from `stock` where rak like '$rak' and lantai like '$lan' and kolom like '$klm' and baris like '$bar'";
	$stockIdSearchQueryRun = mysqli_query($servConnQuery,$stockIdSearchQuery);
	$stockIdFetch = mysqli_fetch_assoc($stockIdSearchQueryRun);
	$stockId = $stockIdFetch['stock_id'];
}

if(isset($_GET['itemNameUpdate'])){
	/*$itemName = $_GET['itemNameUpdate'];
	
	$stockIdSearchQuery = "select stock_id from `stock` where rak like '$rak' and lantai like '$lan' and kolom like '$klm' and baris like '$bar'";
	$stockIdSearchQueryRun = mysqli_query($servConnQuery,$stockIdSearchQuery);
	$stockIdFetch = mysqli_fetch_assoc($stockIdSearchQueryRun);
	$stockId = $stockIdFetch['stock_id'];*/
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
				JsBarcode("#barcodeShow","<?php echo $stockId; ?>");
			</script>