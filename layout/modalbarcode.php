<?php
if(isset($_GET['itemName'])){
	$itemName = $_GET['itemName'];
	$amount = $_GET['amount'];
	
	$rak = $_GET['rak'];
	$lan = $_GET['lantai'];
	$klm = $_GET['kolom'];
	$bar = $_GET['baris'];

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
										<p>rak:'.$rak.'</p></br>
										<p>lantai:'.$lan.'</p></br>
										<p>kolom:'.$klm.'</p></br>
										<p>baris:'.$bar.'</p>
									';
								?>
							   </span>
                           </div>
                       </div>
				</div>
				
				<div class="container d-flex justify-content-center">
				<div class="card" style="width:300px;height:100px;">
					<div class="card-body">
					</div>
				</div>
				</div>
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print</button>
			</div>
<?php } ?>