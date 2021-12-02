<?php
include "../backend/conn.php";
$itemName = '';
$amount = '';
$rak = '';
$lan = '';
$klm = '';
$bar = '';

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
	
	$stockSearchQuery = "select * from `stock` where stock_name = '$itemName'";
	$stockSearchQueryRun = mysqli_query($servConnQuery,$stockSearchQuery);
	$stockFetch = mysqli_fetch_assoc($stockSearchQueryRun);
	$stockBarcode = $stockFetch['barcode'];
	$stockTotalAmount = $stockFetch['amount'];
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
	
	$stockSearchQuery = "select * from `stock` where stock_name = '$itemName'";
	$stockSearchQueryRun = mysqli_query($servConnQuery,$stockSearchQuery);
	$stockFetch = mysqli_fetch_assoc($stockSearchQueryRun);
	$stockBarcode = $stockFetch['barcode'];
	$stockTotalAmount = $stockFetch['amount'];
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
                               <span>Jumlah ditambahkan:</span>
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
                               <span>Jumlah total:</span>
                           </div>
                       </div>
                       <div class="col-6">
                           <div class="mb-3">
                               <span><?php echo $stockTotalAmount; ?></span>
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
				<div class="card" style="" id="barcode">
					<div class="card-body">
						<svg id="barcodeShow"></svg>
					</div>
				</div>
				</div>
				
			</div>
						<div class="modal-footer d-flex justify-content-center">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="printContent('barcode')">Print</button>
			</div>
			<script>
				JsBarcode("#barcodeShow","<?php echo $stockBarcode; ?>");
			</script>
			<script src="js/print.js"></script>
			<script type="text/javascript">
<!--
function printContent(id){
str=document.getElementById(id).innerHTML
newwin=window.open('','printwin','left=100,top=100,width=400,height=400')
newwin.document.write('<HTML>\n<HEAD>\n')
newwin.document.write('<TITLE>Print Page</TITLE>\n')
newwin.document.write('<script>\n')
newwin.document.write('function chkstate(){\n')
newwin.document.write('if(document.readyState=="complete"){\n')
newwin.document.write('window.close()\n')
newwin.document.write('}\n')
newwin.document.write('else{\n')
newwin.document.write('setTimeout("chkstate()",2000)\n')
newwin.document.write('}\n')
newwin.document.write('}\n')
newwin.document.write('function print_win(){\n')
newwin.document.write('window.print();\n')
newwin.document.write('chkstate();\n')
newwin.document.write('}\n')
newwin.document.write('<\/script>\n')
newwin.document.write('</HEAD>\n')
newwin.document.write('<BODY onload="print_win()">\n')
newwin.document.write(str)
newwin.document.write('</BODY>\n')
newwin.document.write('</HTML>\n')
newwin.document.close()
}
//-->
</script>