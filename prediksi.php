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
	
		<table class="table">
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
					$hari = 7;
					$sid = $data['stock_id'];
					//$sqlHistory = "select * from history where stock_id = $sid and date > CURRENT_DATE - INTERVAL $hari day and output = 1";
					$sqlHistory = "select * from history where stock_id = $sid and date > CURRENT_DATE - INTERVAL 3 month and output = 1";
					$runHistory = mysqli_query($servConnQuery, $sqlHistory);
					
					//pengembilan total ambil dalam 3 bulan
					$predStok = '';
					$x = 0;
					$total = 0;
					while($rowHistory = mysqli_fetch_assoc($runHistory)){
						if($rowHistory != null){
							$total = $total + $rowHistory['amount'];
						}else{
							$total = 0;
						}
					}
					
					$bulanIni = 0;
					$sqlBulanKemarin = "select * from history where stock_id = $sid and date > CURRENT_DATE - INTERVAL 1 month and output = 1";
					$runBulanKemarin = mysqli_query($servConnQuery, $sqlBulanKemarin);
					while($rowBulanKemarin = mysqli_fetch_assoc($runBulanKemarin)){
						if($rowBulanKemarin != null){
							$bulanIni = $bulanIni + $rowBulanKemarin['amount'];
						}else{
							$bulanIni = 0;
						}
					}
					
					//perhitungan rata rata stok keluar
					//
					//data 3 minggu di rata rata = a
					//data minggu terahir = b
					//nilai akhir = pembandingan nilai akhir dan rata rata
					//nilai keluaran dari bulan ini dibandingkan dengan rata rata
					//jika lebih dari rata rata maka + dan sebaliknya
					$x = $total;
					if($total != 0){
						$x = ceil($total / 90);
					}
					
					//penentuan style stok keluar
					if($bulanIni > $x){
						$predStok = '
							<h5 class="text-success">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($bulanIni < $x){
						$predStok = '
							<h5 class="text-danger">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
								<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($bulanIni == $x){
						$predStok ='
							<h5 class="text-warning">
							'.$x.'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
								<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
							</svg>
							</h5>
						';
					}
					
					//pengambilan harga stok
					//tabel harga_history 3bulan
					$sqlHharg = "select * from harga_history where stock_id = $sid and date > CURRENT_DATE - INTERVAL 3 month";
					$runHharg = mysqli_query($servConnQuery, $sqlHharg);
					$a = 0;
					if(mysqli_num_rows($runHharg)>0){
					while($rowHharg = mysqli_fetch_assoc($runHharg)){
						$a = $a + $rowHharg['harga'];
					}}
					
					$a = $a / 90;
					$a = ceil($a);
					//tabel harga
					$sqlHarg = "select * from harga where stock_id = $sid";
					$runHarg = mysqli_query($servConnQuery, $sqlHarg);
					$rowHarg = mysqli_fetch_assoc($runHarg);
					$harga	 = ceil($rowHarg['jual']);
					
					//penentuan style perubahan harga
					$predHarg = '';
					if($harga > $a){
						$predHarg = '
							<h5 class="text-success">
							'.rupiah($a).'
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
							</svg>
							</h5>
						';
					}
					if($harga < $a){
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
				<tr>
				<td><?php echo $data['stock_name']; ?></td>
				<td><?php echo $data['amount']; ?></td>
				<td><?php echo $predStok; ?></td>
				<td><?php echo $predHarg; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item">
					<a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				</li>
			</ul>
		</nav>
		
		<!--
		<h5 class="text-success">
		<?php echo rupiah(10000);?>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
			<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
		</svg>
		</h5>

		<h5 class="text-danger">
		<?php echo rupiah(10000);?>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
			<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
		</svg>
		</h5>

		<h5 class="text-warning">
		<?php echo rupiah(10000);?>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
			<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
		</svg>
		</h5>
		-->
		
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