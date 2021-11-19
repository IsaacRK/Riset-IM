<?php
require 'backend/conn.php';
require 'backend/usersession.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Perencanaan</title>
<?php include'layout/header.php'; ?>
</head>
<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">

	<div class="p-1 mb-3">
		<div class="row">
		
			<div class="col">
				<h1>Enterprise Resource Planning</h1>
			</div>
		
			<div class="col-sm-2 mt-1 p-1 d-flex">
			<div class="d-grid gap-2 w-100">
				<a href="" class="btn btn-primary">
					Procerement
				</a>
			</div>
			</div>
			
			<div class="col-sm-2 mt-1 p-1 d-flex">
			<div class="d-grid gap-2 w-100">
				<a href="" class="btn btn-primary">
					Accounting
				</a>
			</div>
			</div>
		</div>
	</div>

	<div class="row">
	
	<div class="col-sm">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3>Supply chain</h3>
		
		</div>
	</div>
	</div>
	
	<div class="col-sm">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3>Enterprise performance</h3>
			
			<div class="card">
				<div class="card-body">
					<h5>Preforma Bulanan</h5>
					
					<div class="row">
						<div class="col-sm-8">

							<div class="row">
								<div class="col-12 mb-3">
									<div class="card text-white bg-primary">
									<div class="card-body">
										<div class="card-title">Target</div>
										<div class="card-text"><h3>100.000 RB</h3></div>
									</div>
									</div>
								</div>
								
								<div class="col">
									<div class="card text-white bg-success">
									<div class="card-body">
										<div class="card-title">Pemasukan</div>
										<div class="card-text"><h3>100.000 RB</h3></div>
									</div>
									</div>
								</div>
								
								<div class="col">
									<div class="card text-white bg-danger">
									<div class="card-body">
										<div class="card-title">Pengeuaran</div>
										<div class="card-text"><h4>100.000 RB</h4></div>
									</div>
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="col">
							<div class="card h-100 text-white bg-secondary">
							<div class="card-body">
								<div class="card-title">Presentase Bulanan</div>
								<div class="card-text"><h1>100%</h1></div>
							</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
			<canvas class="w-100" id="harga"></canvas>
			
		</div>
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
</script>

</body>
</html>