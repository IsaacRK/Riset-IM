<?php
$var1 = $_GET['a'];

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
                               <span><?php echo $var1; ?></span>
                           </div>
                       </div>
				</div>
				
				<div class="row">
					<div class="col-6">
                           <div class="mb-3">
                               <span>Nama Komponen:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span>Nama dari Komponen</span>
                           </div>
                       </div>
				</div>
				
				<div class="row">
					<div class="col-6">
                           <div class="mb-3">
                               <span>Nama Komponen:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span>Nama dari Komponen</span>
                           </div>
                       </div>
				</div>
				
				<div class="container d-flex justify-content-center">
				<div class="card" style="">
					<div class="card-body">
						<svg id="barcode"></svg>
					</div>
				</div>
				</div>
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print</button>
			</div>
			
			<script>
				JsBarcode("#barcode", "<?php echo $var1; ?>");
			</script>