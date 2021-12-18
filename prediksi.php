<?php
include'backend/conn.php';
require 'backend/usersession.php';

if ($userAC == '0'){
			header('location:Verifyno.php');
}else{}
if($userlvl == 'supervisor'){
	header('location:rencana.php');
}else if($userlvl == 'procurement'){
	header('location:rencana.php');
}else{}

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Prediksi</title>
	<?php include"layout/header.php"?>
</head>

<body>
<?php
	include"layout/sidebar-old.php";
?>
       
<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<h1>Prediksi</h1>
	</div>

	<div class="card shadow-sm mb-2">
	<div class="card-body">
		
		<div class="table-responsive">
		<table class="table" id="collapseParent">
			<thead>
				<th>Nama Stok</th>
				<th>Jumlah</th>
				<th>Prediksi Stok Keluar</th>
				<th>Prediksi Pergeseran Harga</th>
			</thead>
			<tbody>
				<?php
				//setup pagination
				$batas = 10;
				$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
				$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
				
				$previous = $halaman - 1;
				$next = $halaman + 1;
				
				//pagination - ambil total data
				$data = mysqli_query($servConnQuery,"select stock_id from stock");
				$jumlah_data = mysqli_num_rows($data);
				$total_halaman = ceil($jumlah_data / $batas);
				
				//ambil data dari database
				$arr = array();
				$sql = "select * from stock order by stock_id asc limit $halaman_awal, $batas";
				$run = mysqli_query($servConnQuery, $sql);
				$nomor = $halaman_awal+1;
				while($row = mysqli_fetch_assoc($run)){
					$arr[] = $row;
				}
				foreach($arr as $data){
					//pengambilan barang 	= 3 MINGGU
					//harga barang 			= 3 BULAN
					
					$hari = 7;
					$sid = $data['stock_id'];
					
					//------========|[Pengambilaan Stok Keluar]|========------
					//pengambilan stok barang | 3 minggu
					//$sqlHistory = "select * from history where stock_id = $sid and date > CURRENT_DATE - INTERVAL 3 month and output = 1";
					$brngKel = array();
					for($i=0;$i<=2;$i++){
						$sqlHistory = "SELECT sum(amount) FROM history WHERE stock_id = $sid and YEARWEEK(date) = YEARWEEK(date_sub(curdate(), interval $i week)) and output = 1";
						$runHistory = mysqli_query($servConnQuery, $sqlHistory);
						$rowHistory = mysqli_fetch_assoc($runHistory);
						if($rowHistory['sum(amount)'] != null){
							$minggu	= $rowHistory['sum(amount)'];
						}else{
							$minggu	= 0;
						}
						array_push($brngKel, $minggu);
					}

					//pengembilan total ambil dalam 3 minggu
					
					$predStok = '';
					
					//perhitungan rata rata stok keluar
					//
					//data 3 minggu di rata rata = a
					//data minggu terahir = b
					//nilai akhir = pembandingan nilai akhir dan rata rata
					//nilai keluaran dari bulan ini dibandingkan dengan rata rata
					//jika lebih dari rata rata maka + dan sebaliknya
					$x = 0;
					if(array_sum($brngKel)!=0){
						$x = ceil(array_sum($brngKel)/3);
					}
					
					//penentuan style stok keluar
					if($brngKel[0] < $x){
						$predStok = '
							<h5 class="text-success">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($brngKel[0] > $x){
						$predStok = '
							<h5 class="text-danger">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
								<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($brngKel[0] == $x){
						$predStok ='
							<h5 class="text-warning">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
								<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
							</svg>
							</h5>
						';
					}
					
					//------========|[Pengambilaan Harga Barang]|========------
					//pengambilan harga stok
					//ambil harga_history 3 bulan | setiap 1 bulan
					$hrgArr = array();
					for($i=3;$i>=0;$i--){
						$sqlHharg = "select * from harga_history where stock_id = $sid and month(`date`) = month(now())-$i order by id desc";
						$runHharg = mysqli_query($servConnQuery, $sqlHharg);
						$rowHharg = mysqli_fetch_assoc($runHharg);
						if(isset($rowHharg['harga'])){
							$bulan = $rowHharg['harga'];
						}else{
							$y = count($hrgArr) - 1;
							if(isset($hrgArr[$y])){
								$bulan = $hrgArr[$y];
							}else{
								$bulan = 0;
							}
						}
						array_push($hrgArr, $bulan);
					}
					
					//total harga
					$a = 0;
					if(array_sum($hrgArr)!=0){
						$a = ceil(array_sum($hrgArr)/4);
					}
					
					//tabel harga
					$sqlHarg = "select * from harga where stock_id = $sid";
					$runHarg = mysqli_query($servConnQuery, $sqlHarg);
					$rowHarg = mysqli_fetch_assoc($runHarg);
					$harga	 = $rowHarg['jual'];
					
					//penentuan style perubahan harga
					$predHarg = '';
					if($harga < $a){
						$predHarg = '
							<h5 class="text-success">
							'.rupiah($a).'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($harga > $a){
						$predHarg = '
							<h5 class="text-danger">
							'.rupiah($a).'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
								<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($harga == $a){
						$predHarg ='
							<h5 class="text-warning">
							'.rupiah($a).'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
								<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
							</svg>
							</h5>
						';
					}
					
				?>
				<tr data-bs-toggle="collapse" href="#collapse<?php echo$sid; ?>">
					<td><?php echo $data['stock_name']; ?></td>
					<td><?php echo $data['amount']; ?></td>
					<td><?php echo $predStok; ?></td>
					<td><?php echo $predHarg; ?></td>
				</tr>
				<tr>
					<td colspan=4 style="padding:0!important">
						<div id="collapse<?php echo$sid; ?>" class="collapse" data-bs-parent="#collapseParent">
							<div class="row p-2">
								<div class="col-sm-6">
									prediksi stok keluar
									<canvas id="divChartKel<?php echo$sid; ?>"></canvas>
								</div>
								<div class="col-sm-6">
									prediksi harga barang
									<canvas id="divChartHrg<?php echo$sid; ?>"></canvas>
								</div>
							</div>
						</div>
						<script>
							$(document).ready(function(){
								//chart barang keluar
								var chartKeluar<?php echo$sid; ?> = $('#divChartKel'+<?php echo$sid; ?>);
								
								var data<?php echo$sid; ?> = {
									labels: [3,2,1,0],
									datasets: [{
										label: "Stok keluar",
										backgroundColor: '#FF9600',
										borderColor: '#FF9600',
										data: [<?php echo $brngKel[2].','.$brngKel[1].','.$brngKel[0]; ?>],
										tension: 0.3,
									},{
										label: "Prediksi",
										backgroundColor: '#FF9600',
										borderColor: '#FF9600',
										data: [<?php echo $brngKel[2].','.$brngKel[1].','.$brngKel[0].','.$x; ?>],
										tension: 0.3,
										borderDash: [10,5],
									}]
								}
								
								var lnKel<?php echo$sid; ?> = new Chart(chartKeluar<?php echo$sid; ?>, {
									type: 'line',
									data: data<?php echo$sid; ?>,
									options: {
										scales: {
											y:{
												title: {
													display: true,
													text: 'Jumlah'
												}
											},
											x: {
												title: {
													display: true,
													text: 'Minggu'
												}
											}
										}
									}
								})
								
								//chart harga barang
								var chartHarga<?php echo$sid; ?> = $('#divChartHrg'+<?php echo$sid; ?>);
								
								var harga<?php echo$sid; ?> = {
									labels: [4,3,2,1,0],
									datasets: [{
										label: "Harga",
										backgroundColor: '#FF9600',
										borderColor: '#FF9600',
										data: [<?php echo $hrgArr[0].','.$hrgArr[1].','.$hrgArr[2].','.$hrgArr[3]; ?>],
										tension: 0.3,
									},{
										label: "Prediksi",
										backgroundColor: '#FF9600',
										borderColor: '#FF9600',
										data: [<?php echo $hrgArr[0].','.$hrgArr[1].','.$hrgArr[2].','.$hrgArr[3].','.$a; ?>],
										tension: 0.3,
										borderDash: [10,5],
									}]
								}
								
								var harga<?php echo$sid; ?> = new Chart(chartHarga<?php echo$sid; ?>, {
									type: 'line',
									data: harga<?php echo$sid; ?>,
									options: {
										scales: {
											y:{
												title: {
													display: true,
													text: 'Jumlah'
												}
											},
											x: {
												title: {
													display: true,
													text: 'Bulan'
												}
											}
										}
									}
								})
							});
						</script>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
		
		<nav class="nav">
			<ul class="pagination justify-content-center overflow-auto">
				<li class="page-item nav-item">
					<a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Sebelumnya</a>
				</li>
				<?php
				$s = 1;
				if($halaman > 3){
					$s = $halaman-3;
				}
				$max = $halaman+3;
				if($halaman+3 >=  $total_halaman-1){
					$max = $total_halaman;
				}
				for($x=$s;$x<=$max;$x++){
					?> 
					<li class="page-item nav-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item nav-item">
					<a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Selanjutnya</a>
				</li>
			</ul>
		</nav>
		
	</div>
	</div>


</div>
</div>

<?php
	include"layout/js.php";
?>

<script>
</script>

</body>
</html>