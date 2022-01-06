<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
			header('location:Verifyno.php');
}else{}
if($userlvl == 'supervisor'){
	header('location:rencana.php');
}else if($userlvl == 'procurement'){
	header('location:rencana.php');
}else{}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Beranda</title>
	<?php include"layout/header.php"?>
<style>
.color-danger{
	background-color:#FF9600;
}
	.hun{
	width: 30%;
	margin-bottom: 5px;
	margin-top: 5px;
}
@media screen and (max-width:800px) {
.hun{
	width:50%;
	margin-top: 0px;
}
      }
</style>
</head>

<body>
<?php
	include"layout/sidebar-old.php";
?>
       
<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="row">
			<div class="col">
				<h1>Beranda
					<span style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#infoPage">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
							<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
					</span>
				</h1>
			</div>
			<?php 	if($userlvl == 'staff'){
			}else if($userlvl == 'operator'){
			}else{	?>
				<div class="col-3 mt-1 p-1 d-flex justify-content-end hun">
				<div class="d-grid gap-2 w-100">
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSetReport">
					  Unduh Laporan
					</button>
				</div>
				</div>
		        <?php } ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm">
			<div class="card shadow-sm mb-2">
			<div class="card-body">
			
				<form action="" id="formBarang">
				<div class="row">
					<div class="col-sm-9">
						<select name="rak" id="rak" class="btn btn-light border dropdown-toggle m-2 form-select">
							<option value="1" class="dropdown-item">Rak 1</option>
							<option value="2" class="dropdown-item">Rak 2</option>
							<option value="G" class="dropdown-item">Rak G</option>
						</select>
					</div>
					<div class="col-sm d-grid">
						<input class="btn btn-primary my-2" type="submit" name="butonRak" value="Ganti rak">
					</div>
				</div>
				</form>
				
				</br>
				
				<div id="divBarang"></div>
				
				<div class="btn btn-primary" onclick="modalBarang()">Lihat selengkapnya</div>
			</div>
			</div>
		</div>
		
		<div class="col-sm">
			<div class="card shadow-sm mb-4">
			<div class="card-body">
				
				<h4 class="card-title">Aktivitas barang</h4>
				
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
					<div class="card-body" id="divChart" style="">
						<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
						
						
						</div>
					</div>
				</div>
				
			</div>
			</div>
			
			<div class="card shadow-sm">
			<div class="card-body">
			
				<h4 class="card-title">Riwayat aktivitas</h4>
				
				<div class="table-responsive">
				<table class="table table-striped table-sm" id="tbActivity">
					<thead>
					<tr>
						<th scope="col">Nama komponen</th>
						<th scope="col">Status</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Operator</th>
						<th scope="col">Jumlah</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$queryHistory	="
					SELECT history.* , pengguna.user, stock.stock_name
					FROM history
					JOIN pengguna ON history.user_id = pengguna.id
					JOIN stock ON history.stock_id = stock.stock_id
					WHERE date > CURRENT_DATE - INTERVAL 7 day order by date(date) desc limit 5;";
					$historyRun = mysqli_query($servConnQuery, $queryHistory);
					$arr = array();
					while($row = mysqli_fetch_assoc($historyRun)){
						$arr[] = $row;
					}
					function status($a, $b){
						if($a==1)		{return 'Masuk';}
						elseif($b==1)	{return 'Keluar';}
						else			{return 'DB ERR';}
					}
					foreach($arr as $data){ 
					?>
						<tr>
							<td class='fw-bold'><?php echo $data['stock_name']; ?></td>
							<td><?php echo status($data['input'],$data['output']); ?></td>
							<td><?php echo $data['date'];?></td>
							<td><?php echo $data['user'];?></td>
							<td><?php echo $data['amount'];?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php
					if(mysqli_num_rows($historyRun)== 0){
						echo'
							<div class="w-100 color-tertiary p-2 text-center fw-bold">Belum ada barang yang diambil</div>
						';
					}
				?>
				</div>
				
				<div class="btn btn-primary" onclick="historyModal()">Lihat keseluruhan</div>
			
			</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="modalHistory">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modalhistoryisi">
      
    </div>
  </div>
</div>

<div class="modal fade" id="modalbarang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modalbarangisi">
      
    </div>
  </div>
</div>

<div class="modal fade" id="modalSetReport">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
		<div class="modal-header">
			<button class="border border-0" type="" data-bs-dismiss="modal">
				<img src="img/icons/x-lg.svg"/>
			</button>
		</div>
		<div class="modal-body">
			<h3>Unduh Data Laporan</h3>
			<form method="post" action="backend/report.php">
				<div class="input-group mb-3">
					<label class="input-group-text" for="hariX">Ambil Data:</label>
					<select class="form-select" name="hari" aria-label="Default select example">
						<option selected>Pilih Hari</option>
						<option value="1">7 hari</option>
						<option value="2">1 Bulan</option>
						<option value="3">3 Bulan</option>
						<option value="4">Seluruh Data</option>
					</select>
				</div>
				<input type="submit" name="submit" class="btn btn-primary" value="Unduh Data">
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
		</div>
    </div>
  </div>
</div>


<div class="modal fade" id="infoPage">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Penggunaan Website</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<h4>Rak</h4>
					<p>menampilkan daftar dari rak yang telah di </p>
				<h4>Daftar Komponen</h4>
				<h4>Aktifitas Barang</h4>
				<h4>Riwayat Aktifitas</h4>
				<h4>Unduh Laporan</h4>
			</div>
		</div>
	</div>
</div>

<?php
	include"layout/js.php";
?>

<script>
	//history
	
	$(async function(){
		let page = await fetch("layout/halamanBarang.php?rak=1");
		let text = await page.text();
		document.getElementById("divBarang").innerHTML = text;
	});
	
	$(function(){
		$('#formBarang').on("submit",function(e){
			var dataString = $(this).serialize();
			
			$.ajax({
				type: "POST",
				url: "layout/test.html",
				data: dataString,
				success: function(){
					$("#divBarang").load('layout/halamanBarang.php?'+dataString)
				}
			});
			e.preventDefault();
		});
	});
	
	async function modalBarang(){
		var e = document.getElementById("rak");
		var rak = e.value;
		console.log(rak);
		
		let page = await fetch('layout/modalbarang.php?rak='+rak);
		let docu = await page.text();
		let tag = document.getElementById("modalbarangisi").innerHTML = docu;
		$('#modalbarang').modal('show').find('.modal-content').tag;
	}
	
	//chart
	$(document).ready(function(){
		$("#divChart").load('layout/a.php');
	});
	
	$(function(){
		$("#graphSearch").autocomplete({
			source: 'backend/autocomplete.php'
		});
	});
	
	$(function(){
		$("#searchChart").on("submit", function(e){
			var dataString = $(this).serialize();
			//alert(dataString);
			
			$.ajax({
				type: "POST",
				url: "layout/test.html",
				data: dataString,
				success: function(){
					$("#divChart").load('layout/a.php?'+dataString);
				}
			});
			e.preventDefault();
		});
	});
	
	async function historyModal(){
		let page = await fetch('layout/modalhistory.php');
		let docu = await page.text();
		let tag = document.getElementById("modalhistoryisi").innerHTML = docu;
		$('#modalHistory').modal('show').find('.modal-content').tag;
	};
	
//dump code DataTabel | js ga bisa di eksekusi dari innerHTML
$(function(){
	$('#tbComponent').DataTable({
		"scrollY": "50vh",
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
