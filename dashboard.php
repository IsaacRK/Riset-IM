<?php

require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
			header('location:Verifyno.php');
}else{}
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
		<div class="row">
			<div class="col">
				<h1>Beranda</h1>
			</div>
			<div class="col-3 mt-1 p-1 d-flex justify-content-end">
			<div class="d-grid gap-2 w-100">
				<a href="backend/report.php" class="btn btn-primary">Unduh Laporan</a>
			</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			
				<form action="" id="formBarang">
				<div class="row">
					<div class="col-9">
						<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-select">
							<option value="1" class="dropdown-item">Rak 1</option>
							<option value="2" class="dropdown-item">Rak 2</option>
						</select>
					</div>
					<div class="col">
						<input class="btn btn-primary mt-2" type="submit" name="butonRak" value="Ganti Rak">
					</div>
				</div>
				</form>
				
				</br>
				
				<div id="divBarang"></div>
			
			</div>
			</div>
		</div>
		
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			
				<div class="w-100">
					<form id="searchChart" action="">
						<div class="row">
							<div class="col-8">
								<input class="form-control" name="graphSearch" type="text" id="graphSearch" placeholder="Cari Barang">
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
					</div>
				</div>
				
				<h4 class="card-title">Catatan Aktifitas</h4>
				
				<div class="table-responsive">
				<table class="table table-striped table-sm" id="tbActivity">
					<thead>
					<tr>
						<th scope="col">Nama Komponen</th>
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
					WHERE date > CURRENT_DATE - INTERVAL 7 day order by date(date) desc;";
					$historyRun = mysqli_query($servConnQuery, $queryHistory);
					$arr = array();
					while($row = mysqli_fetch_assoc($historyRun)){
						$arr[] = $row;
					}
					function status($a, $b){
						if($a==1)		{return 'Input';}
						elseif($b==1)	{return 'Output';}
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
							<div class="w-100 color-tertiary p-2 text-center fw-bold">Belum ada barang yang di ambil</div>
						';
					}
				?>
				</div>
			
			</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php
	include"layout/js.php";
?>

<script>
	$(document).ready(function(){
		$("#divChart").load('layout/a.php');
	});
	
	
	$(document).ready(function(){
		$("#divBarang").load('layout/halamanBarang.php?rak=1');
	});
	
	$(function(){
		$("#searchChart").on("submit", function(e){
			var dataString = $(this).serialize();
			//alert(dataString);
			
			$.ajax({
				type: "POST",
				url: "backend/inputhandler.php",
				data: dataString,
				success: function(){
					$("#divChart").load('layout/a.php?'+dataString);
				}
			});
			e.preventDefault();
		});
	});

	$(document).ready(function () {
		$('#tbActivity').DataTable({
			"scrollY": "50vh",
			"scrollCollapse": true,
			"order": [[2, "desc"]],
			language:{
				url: 'js/id.json'
			}
		});
		$('.dataTables_length').addClass('bs-select');
	});
	
	$(function(){
	$("#graphSearch").autocomplete({
		source: 'backend/autocomplete.php'
	});
	});
	
	$(function(){
		$('#formBarang').on("submit", function(e){
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
</script>

</body>
</html>
