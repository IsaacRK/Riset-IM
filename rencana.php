<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
	header('location:Verifyno.php');
}else{}

if($userlvl == 'staff'){
	header('location:dashboard.php');
}else if($userlvl == 'operator'){
	header('location:dashboard.php');
}else if($userlvl == 'procurement'){
	header('location:dashboard.php');
}else{	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Perencanaan</title>
<?php include'layout/header.php'; ?>
</head>
<body>

<?php
	include"layout/sidebar-old.php";
?>

<div class="content">
<div class="container mr-0">

<!-------------------------->
<!--| construction banner|-->
<!-------------------------->
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
<!-------------------------->
<!--| construction banner|-->
<!-------------------------->

	<div class="p-1 mb-3">
		<div class="row">
		
			<div class="col">
				<h1>Enterprise Resource Planning</h1>
			</div>

		</div>
	</div>

	<div class="row mb-3">
	
	<div class="col-sm">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3>Peringatan Stok Minim</h3>
			<table id="tbStock" class="table table-striped table-sm">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Lokasi Penyimpanan</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sqlStock = "
							select stock.*, penyimpanan.*
							from stock
							join penyimpanan on stock.storage_id = penyimpanan.storage_id
							where stock.amount <= 10
							";
						$runStock = mysqli_query($servConnQuery, $sqlStock);
						$data = array();
						while($rowStock = mysqli_fetch_assoc($runStock)){
							$data[] = $rowStock;
						}
						foreach($data as $stock){
							$tempat = 'L'.$stock['lantai'].' B'.$stock['baris'].' C'.$stock['kolom'];
					?>
					<tr>
						<td><?php echo $stock['stock_name']; ?></td>
						<td><?php echo $stock['amount']; ?></td>
						<td><?php echo $tempat; ?></td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<div class="d-grid d-md-flex justify-content-md-end">
				<a href="pembelian.php" class="btn btn-primary float-right">Pembelian</a>
			</div>
		</div>
	</div>
	</div>
	
	<div class="col-sm">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3>Indikator Peforma</h3>
			
			<div class="card">
				<div class="card-body">
					
					<div class="row">

						<div class="col-6 mb-3">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Target Pemasukan Bulanan</b></div>
								<div class="card-text"><h4>Rp.100.000 </h4></div>
							</div>
							</div>
						</div>
						
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Rata-Rata Pemasukan Seminggu</b></div>
								<div class="card-text"><h4>Rp.100.000</h4></div>
							</div>
							</div>
						</div>
						
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Total Pembelian Bulanan</b></div>
								<div class="card-text"><h4>Rp.100.000</h4></div>
							</div>
							</div>
						</div>
							
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Nilai Performa</b></div>
								<div class="card-text"><h4>100%</h4></div>
							</div>
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
			
			<!--<canvas class="w-100" id="harga"></canvas>-->
			
		</div>
	</div>
	</div>
	
	</div>
	
	<div class="row my-0 mt-0 mb-3">
	
		<div class="card shadow-sm px-0">
			<div class="card-body">
				<h3>Status Pengiriman</h3>
				
				<div class="w-50">
				<form method="post" action="">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" placeholder="Kode Resi" aria-label="Example text with button addon" aria-describedby="Form Resi">
					  <input class="btn btn-outline-secondary" type="submit" id="" value="+">
					</div>
				</form>
				</div>
				
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Pengirim</th>
							<th>Alamat Tujuan</th>
							<th>Lokasi Terkini<th>
							<th>Nomor Resi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>placeholder</td>
							<td>placeholder</td>
							<td>placeholder</td>
							<td>placeholder</td>
							<td></td>
							<td>placeholder</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	
	</div>
			
</div>
</div>
</div>
</div>

<script>
$(document).ready(function(){
	var harga = $('#harga');
	
	var dataHarga = {
		labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
		datasets: [{
			label: "pemasukan",
			data: [2,7,2,5,2,2,2,2,2,2,2,5,2,7,2],
			backgroundColor: 'rgb(16, 100, 174)',
			borderColor: 'rgba(16, 100, 174, 0.3)',
		},{
			label: "pengeluaran",
			data: [3,8,3,6,9,9,9,9,9,9,9,6,3,8,3],
			backgroundColor: 'rgb(174, 16, 16)',
			borderColor: 'rgba(174, 16, 16, 0.3)',
		}]
	}
	
	var hargaChart = new Chart(harga, {
		type: 'line',
		data: dataHarga
	});
});

$(function(){
	$('#tbStock').DataTable({
		"scrollY": "25vh",
		"scrollCollapse": true,
		language:{
			url: 'js/id.json'
		}
	});
	$('.dataTables_length').addClass('bs-select');
});
</script>

</body>
</html>
<?php }?>
