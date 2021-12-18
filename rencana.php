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

	<div class="p-1 mb-3">
		<div class="row">
		
			<div class="col">
				<h1>Dashboard</h1>
			</div>

		</div>
	</div>

	<div class="row mb-3">
	
	<div class="col col-lg-6">
	<div class="card shadow-sm">
		<div class="card-body overflow-auto">
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
				<a href="Pembelian.php" class="btn btn-primary float-right">Pembelian</a>
			</div>
		</div>
	</div>
	</div>
	
	<div class="col col-lg-6">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3>Indikator Peforma</h3>
			
			<a href="Indikator.php" class="link-dark" style="text-decoration:none;">
			<div class="card">
				<div class="card-body">
					
					<div class="row">
						<div class="col-6 mb-3">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Target Pemasukan Bulanan</b></div>
								<div class="card-text text-success">
									<div class="row">
										<?php include'backend/indikatorPerforma.php';?>
										<h4><?php echo rupiah($target);?></h4>
									</div>
								</div>
							</div>
							</div>
						</div>
						
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Rata-Rata Pemasukan Seminggu</b></div>
								<div class="card-text"><h4><?php echo rupiah($rata);?></h4></div>
							</div>
							</div>
						</div>
						
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Total Pembelian Bulanan</b></div>
								<div class="card-text text-danger"><h4>Rp100.000</h4></div>
							</div>
							</div>
						</div>
							
						<div class="col-6">
							<div class="card">
							<div class="card-body">
								<div class="card-title"><b>Nilai Performa</b></div>
								<div class="card-text"><h4><?php echo$persen; ?>%</h4></div>
								<div class="progress">
									<div class="progress-bar" style="width: <?php echo$persen; ?>%"></div>
								</div>
							</div>
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
			</a>
			<!--<canvas class="w-100" id="harga"></canvas>-->
			
		</div>
	</div>
	</div>
	
	</div>
	
	<div class="my-0 mt-0 mb-3">
	
		<div class="card shadow-sm px-0">
			<div class="card-body">
				<h3>Status Pengiriman</h3>
				<?php include'backend/cekresi.php'; ?>
				<div class="row">
				
				<div class="col">
					<form method="post" action="">
						<div class="input-group mb-3">
							<select class="form-select form-select-sm" name="exped" aria-label=".select-expedisi">
								<option selected>Pilih Expedisi</option>
								<option value="1">JNE</option>
								<option value="2">JNT</option>
								<option value="3">TIKI</option>
								<option value="4">POS</option>
								<option value="5">WAHANA</option>
								<option value="6">siCepat</option>
								<option value="7">Ninja Xpress</option>
								<option value="8">Jet Express</option>
							</select>
							<input type="number" class="form-control" name="kodeResi" placeholder="Kode Resi" aria-label="Form Resi" aria-describedby="Form Resi">
							<input class="btn btn-outline-secondary" name="kirimKR" type="submit" id="" value="+">
						</div>
					</form>
				</div>

				<div class="col d-md-flex justify-content-md-end">
					<form method="post" action="">
						<input type="submit" name="refreshStruk" value="Perbarui Informasi Struk" class="btn btn-primary">
					</form>
				</div>

				</div>
				
				<div class="overflow-auto">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Pengirim</th>
							<th>Alamat Tujuan</th>
							<th>Lokasi Terkini</th>
							<th>Nomor Resi</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($arr as $data){
							?>
							<tr>
							<td><?php echo$data['tanggal']; ?></td>
							<td><?php echo$data['pengirim']; ?></td>
							<td><?php echo$data['alamat']; ?></td>
							<td><?php echo$data['lokasi'].'</br>'.$data['pesan']; ?></td>
							<td><?php echo$data['no_resi']; ?></td>
							</tr>
							<?php
						}
					?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	
	</div>
	
	<div class="my-0 mt-0 mb-3">
		<div class="card shadow-sm px-0">
			<div class="card-body">
				<h3>Prediksi</h3>

				<div class="w-100">
					<form id="searchChart" action="">
						<div class="row">
							<div class="col-8">
								<input class="form-control" name="graphSearch" type="text" id="graphSearch" placeholder="Cari aktivitas barang">
							</div>
							<div class="col-4 d-grid gap-2">
								<button class="btn btn-primary" type="submit" name="graphBtnSearch" value="Cari"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
								<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
								</svg></button>
							</div>
						</div>
					</form>
				</div>
				
				</br>

				<div class="card">
					<div class="card-body" style="">
						<div class="d-flex flex-row-reverse bd-highlight">
							<a class="btn btn-primary" href="prediksi.php">Lihat Selengkapnya</a>
						</div>
						
						<div  id="divChart">
						<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
						
						</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	
</div>
</div>

<script>

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
	
$(document).ready(function(){
		$("#divChart").load('layout/b.php');
});
$(function(){
		$("#searchChart").on("submit", function(e){
			var dataString = $(this).serialize();
			alert(dataString);
			
			$.ajax({
				type: "POST",
				url: "backend/inputhandler.php",
				data: dataString,
				success: function(){
					$("#divChart").load('layout/b.php?'+dataString);
				}
			});
			e.preventDefault();
		});
});
</script>

</body>
</html>
<?php }?>
