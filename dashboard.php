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
		<div class="mb-3">
			<h1>Halaman Beranda</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-sm">
			<div class="card">
			<div class="card-body">
			
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Arduino
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				  </div>
				</div>
			
				</br>
				
				<div class="card">
					<div class="card-body px-0"  style="background-color:#2879ff73;">
						<div class="container p-0" style="height:200px">
						<div id="mapping" class="carousel slide carousel-dark h-100" data-bs-ride="carousel">
							<!-- Carousel indicators -->
							<ol class="carousel-indicators">
								<?php
									$queryNum = 8;
									$maxStorageIdQuery = "select max(storage_id) from penyimpanan";
									$maxStorageIdRun = mysqli_query($servConnQuery,$maxStorageIdQuery);
									$maxStorageIdFetch = mysqli_fetch_array($maxStorageIdRun);
									$maxStorageId = $maxStorageIdFetch[0];
									$maxStorageIdRounded = round($maxStorageId/$queryNum,0,PHP_ROUND_HALF_DOWN);
									
									for($i=0;$i<$maxStorageIdRounded;$i++){
										if($i==0){
											echo'
											<li data-bs-target="#mapping" data-bs-slide-to="'.$i.'" class="active"></li>
											';
										}else{
											echo'<li data-bs-target="#mapping" data-bs-slide-to="'.$i.'"></li>
											';
										}
									}
								?>
							</ol>
							
							<!-- Wrapper for carousel items -->
							<div class="carousel-inner">
								<?php
									function filter_even($var){
										return($var = $var % 2);
									}
									
									function boxColorFunc($fetch){
										if($fetch==null){
											$col='color-tertiary';
										}else{
											$col='color-primary text-light';
										}
										return($col);
									}
									
									function stringEcho($a,$b){
										$string = '
										<div class="col p-1 d-flex justify-content-center">
											<div class="shadow-sm border rounded rak-box text-center '.$a.'">
												'.$b.'
											</div>
										</div>';
										return ($string);
									}
									
									for($a=0;$a<$maxStorageIdRounded;$a++){
										if($a==0){
											echo'
								<div class="carousel-item active">
									<div class="row">';
										}else{
											echo'
											<div class="carousel-item">
												<div class="row">';
										}
										
										$mappingOffsetQuery='';
										if($a==0){
											$mappingOffsetQuery='';
										}else{
											$z = $a * $queryNum;
											$mappingOffsetQuery='offset '.$z;
										}
										
										$mappingQuery = "select * from penyimpanan limit ".$queryNum." ".$mappingOffsetQuery;
										$mappingRun = mysqli_query($servConnQuery, $mappingQuery);
										if(mysqli_num_rows($mappingRun)>0){
											$stringBoxTop='';
											$stringBoxBottom='';
											$box='';
											$line = 1;
											while ($mappingFetch = mysqli_fetch_assoc($mappingRun)){
												if(filter_even($mappingFetch['storage_id'])==1){
													$box = boxColorFunc($mappingFetch['stock_id']);
													$stringBox = stringEcho($box,'C'.$line.'B1');
													$stringBoxTop=$stringBoxTop.$stringBox;
												}else{
													$box = boxColorFunc($mappingFetch['stock_id']);
													$stringBox = stringEcho($box,'C'.$line.'B2');
													$stringBoxBottom=$stringBoxBottom.$stringBox;
													$line++;
												}
											}
											echo $stringBoxTop.'<div class="w-100"></div>'.$stringBoxBottom;
										}
										$lantai = $a+1;
										echo'
										</div>
										<div class="carousel-caption d-md-block" style="position:static!important">
											<h5>Lantai '.$lantai.'</h5>
										</div>
									</div>
									';
									}
								?>
							</div>
							
							<!-- Carousel controls -->
							<a class="carousel-control-prev" href="#mapping" data-bs-slide="prev">
								<span class="carousel-control-prev-icon"></span>
							</a>
							<a class="carousel-control-next" href="#mapping" data-bs-slide="next">
								<span class="carousel-control-next-icon"></span>
							</a>
							
						</div>
						</div>
						
					</div>
				</div>
				
				<h4 class="card-title">Daftar Komponen</h4>
				
				<table class="table table-striped table-sm" id="tbComponent">
					<thead>
					<tr>
						<th scope="col">Nama Komponen</th>
						<th scope="col">Jumlah</th>
					</tr>
					</thead>
					<tbody>
						<?php
							$stockQuery = "select * from stock order by stock_id desc";
							$stockRun = mysqli_query($servConnQuery, $stockQuery);
							
							if(mysqli_num_rows($stockRun)>0){
								while($stockFetch = mysqli_fetch_assoc($stockRun)){
									echo"
										<tr>
											<td>".$stockFetch['stock_name']."</td>
											<td>".$stockFetch['amount']."</td>
										</tr>
									";
								}
							}
						?>
					</tbody>
				</table>
			
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
			
				<!--
				<div class="card">
					<div class="card-body" style="height:250px;">
						<canvas id="chartDisplay" width="" height=""></canvas>
					</div>
				</div>
				-->
				
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
	})
	
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
		$('#tbComponent').DataTable({
			"scrollY": "50vh",
			"scrollCollapse": true,
			language:{
				url: 'js/id.json'
			}
		});
		$('.dataTables_length').addClass('bs-select');
		
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
</script>

</body>
</html>