<?php

require 'backend/conn.php';
require 'backend/usersession.php';

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
				<h1>Halaman Beranda</h1>
			</div>
			<div class="col-3 mt-1 p-1 d-flex justify-content-end">
			<div class="d-grid gap-2 w-100">
				<a href="backend/report.php" class="btn btn-primary">Report</a>
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
						<select name="rak" class="btn btn-light border dropdown-toggle m-2 form-control">
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
								<input class="btn btn-primary" type="submit" name="graphBtnSearch" value="Cari">
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
						$activityFetchQuery	="SELECT * FROM `history` WHERE date > CURRENT_DATE - INTERVAL 7 day order by date(date) desc;";
						$activityFetchRun 	= mysqli_query($servConnQuery, $activityFetchQuery);
						if(mysqli_num_rows($activityFetchRun) > 0){
							while($activityFetch = mysqli_fetch_assoc($activityFetchRun)){
								$sid 		= $activityFetch['stock_id'];
								$amount		= $activityFetch['amount'];
								$userId		= $activityFetch['user_id'];
								$input		= $activityFetch['input'];
								$output		= $activityFetch['output'];
								$stockQuery = "select * from stock where stock_id = '$sid' order by stock_id desc";
								$stockRun 	= mysqli_query($servConnQuery, $stockQuery);
								$stockFetch = mysqli_fetch_assoc($stockRun);
								$status = '';
								if($input == 1){
									$status = "Input";
								}elseif($output == 1){
									$status = "Output";
								}else{
									$status = "db err";
								}
								
								$userFetchQuery = "select * from pengguna where id = '$userId'";
								$userFetchRun 	= mysqli_query($servConnQuery, $userFetchQuery);
								$userFetch 		= mysqli_fetch_assoc($userFetchRun);

								echo"
									<tr>
										<td class='fw-bold'>".$stockFetch['stock_name']."</td>
										<td>".$status."</td>
										<td>".$activityFetch['date']."</td>
										<td>".$userFetch['user']."</td>
										<td>".$activityFetch['amount']."</td>
									</tr>
								";
							}
						}
					?>
					</tbody>
				</table>
				<?php
					if(mysqli_num_rows($activityFetchRun)== 0){
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