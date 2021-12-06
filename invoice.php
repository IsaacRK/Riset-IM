<?php
include'backend/conn.php';
include'backend/usersession.php';
if(isset($_GET['checkbox'])){
}
function rupiah($x){
	$hasil_rupiah = "Rp " . number_format($x,2,',','.');
	return $hasil_rupiah;
}
function kategori($x){
	if($x == '001'){
		return 'Elektronik';
	}
	if($x == '011'){
		return 'Peralatan';
	}
	if($x == '100'){
		return 'Lain-Lain';
	}
}	
//invoice check
//invoice Generator
//cek invoice serialNum
$inv = 'INV/'.date('Ymd').'/'.$userId.'/';
$sqlCek="select * from invoice where invoice_no like '$inv%' order by id desc limit 1";
$cekRun = mysqli_query($servConnQuery, $sqlCek);

$serNum = 1;
if(mysqli_num_rows($cekRun)>0){
	$cekRow = mysqli_fetch_assoc($cekRun);
	$x 		= substr($cekRow['invoice_no'] , strrpos($cekRow['invoice_no'], "/") + 1);
	$inv 	= $inv.$x;
}else{
	$inv 	= $inv.$serNum;
}

$sqlFind = "select * from invoice where invoice_no = '$inv'";
$runFind = mysqli_query($servConnQuery, $sqlFind);
$cartIdArr = array();
while($rowFind = mysqli_fetch_assoc($runFind)){
	$cartIdArr[] = $rowFind;
}
?>
<style>
#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>

<!------ Include the above in your HEAD tag ---------->

<!--Author      : @arboshiki-->

<div class="modal-header">
	<button class="border border-0" type="" data-bs-dismiss="modal">
		<img src="img/icons/x-lg.svg"/>
	</button>
</div>
<div class="modal-body">
	<div id="invoice">

		<div class="toolbar hidden-print">
			<div class="text-right">
				<button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
			</div>
			<hr>
		</div>
		<div class="invoice overflow-auto">
			<div style="min-width: 600px">
				<header>
					<div class="row">
						<div class="col">
							<a target="_blank"\>
							<img src="img/caktot.png" alt="logo" class="d-block w-100" />
								</a>
						</div>
						<div class="col company-details">
							<h2 class="name">
								<a target="_blank">
								Toko Murah
								</a>
							</h2>
							<div>JL City Home Regency E8 Keputih, Sukolilo, Surabaya 60111</div>
							<div>085158422477</div>
							<div>Tokomurah77714@gmail.com</div>
						</div>
					</div>
				</header>
				<main>
					<div class="row contacts">
						<div class="col invoice-to">
							<!--<div class="text-gray-light">INVOICE TO:</div>-->
							<h2 class="to"><input class="border-0" type="text" placeholder="nama pembeli"></h2>
							<!--<div class="email"><a href="mailto:john@example.com">Email Pembeli</a></div>-->
							<div class="email"><input class="border-0" type="text" placeholder="alamat pembeli"></div>
						</div>
						<div class="col invoice-details">
							<h1 class="invoice-id"><?php echo date('d-m-Y'); ?></h1>
							<!--<div class="date">Tenggat Waktu Invoice</div>-->
						</div>
					</div>
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th class="text-mid">NO</th>
								<th class="text-left">NAMA</th>
								<th class="text-right">HARGA</th>
								<th class="text-right">JUMLAH</th>
								<th class="text-right">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no =  1;
							$jumTotal = 0;
							foreach($cartIdArr as $data){
								//ambil & tampilkan data dari barang dari invoice_no yang sama
								$cid = $data['cart_id'];
								$sql = "
									SELECT cart.* , stock.stock_name , stock.category , harga.jual , invoice.total_harga
									from cart 
									join stock on cart.stock_id = stock.stock_id 
									join harga on cart.stock_id = harga.stock_id 
									join invoice on cart.cart_id = invoice.cart_id
									where cart.cart_id = $cid and invoice.invoice_no = '$inv'";
								$run = mysqli_query($servConnQuery, $sql);
								$row = mysqli_fetch_assoc($run);
								echo'
								<tr>
									<td class="no">'.$no.'</td>
									<td class="text-left"><h3>'.$row['stock_name'].'</h3>'.kategori($row['category']).'</td>
									<td class="unit">'.rupiah($row['jual']).'</td>
									<td class="qty">'.$row['take_amount'].'</td>
									<td class="total">'.rupiah($row['total_harga']).'</td>
								</tr>
								';
								//jumlah total dari barang barang di keranjang
								$jumTotal = $jumTotal + $row['total_harga'];
								$no++;
							}
							
							?>
						</tbody>
						<tfoot>
							
							<tr>
								<td colspan="2"></td>
								<td colspan="2">JUMLAH TOTAL</td>
								<td><?php echo rupiah($jumTotal); ?></td>
							</tr>
						</tfoot>
					</table>
	</br>
	</br>
	</br>
	</br>
	</br>
	</br>
	</br>

					<div class="thanks">Terimakasih</div>
					<div class="notices">
						<div>Perhatian:</div>
						<div class="notice">Harga sudah termasuk PPN</div>
					</div>
				</main>
				<footer>
					
				</footer>
			</div>
			<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
			<div></div>
		</div>
	</div>

</div>
<script>
 $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
  </script>