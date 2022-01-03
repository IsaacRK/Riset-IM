<?php
include'../backend/conn.php';

if(isset($_GET["itemName"])){
	$iName = $_GET['itemName'];
	
	$query = "select * from stock where stock_name = '$iName'";
	$run = mysqli_query($servConnQuery, $query);
	$row = mysqli_fetch_assoc($run);
	$val = 0;
	if(mysqli_num_rows($run)>0){
		$val = mysqli_num_rows($run);
	}
	
	$jenisKomponen = '';
	if($val == 0){
		$jenisKomponen = '
			<select name="category" class="btn btn-light btn-block border dropdown-toggle p-2 form-control">
				<option value="001" class="dropdown-item">Elektronik</option>
				<option value="011" class="dropdown-item">Peralatan</option>
				<option value="100" class="dropdown-item">Lain-Lain</option>
			</select>
		';
	}else{
		$jenisKomponen = '
			<span class="form-control" id="categoryUpdate" style="background-color:#e9ecef"></span>
		';
	}
	
	$infoBarang = '';
	if($val==0){
		$infoBarang='<small>Barang baru</small>';
	}else{
		$infoBarang='<small>Barang tersedia pada penyimpanan</small>';
	}
	
	$rak = 1;
	$lan = 1;
	$kol = 1;
	$bar = 1;
	if($val > 0){
		$penyim = $row['storage_id'];
		$penyimQuery = "select * from penyimpanan where storage_id = '$penyim'";
		$penyimRun = mysqli_query($servConnQuery, $penyimQuery);
		if(mysqli_num_rows($penyimRun) > 0){
			$penyimRow = mysqli_fetch_assoc($penyimRun);
			
			$rak = $penyimRow['rak'];
			$lan = $penyimRow['lantai'];
			$kol = $penyimRow['kolom'];
			$bar = $penyimRow['baris'];
		}
	}

	?>
		<form action="" id="itemData">
			<input type="hidden" id="" name="itemName" value="<?php echo $iName; ?>">
				<div class="mb-3">
					<div class="py-1 d-flex align-items-start">
					<?php echo $infoBarang;?>
					</div>
				</div>						
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Kategori</span>
					</div>
					<?php echo $jenisKomponen;?>
				</div>
				<div class="input-group input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah</span>
					</div>
					<input required type="number" class="form-control" name="amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				</div>
			
			<div class="row mt-2">	
				<div class="col-4 mb-2">Lokasi penyimpanan:</div>
				<div class="container">
					<div class="row">
					
						<div class="col">
							<select name="rak" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item" <?php if($rak == 1){echo 'selected';}?> >rak 1</option>
								<option value="2" class="dropdown-item" <?php if($rak == 2){echo 'selected';}?> >rak 2</option>
								<option value="G" class="dropdown-item" <?php if($rak == 3){echo 'selected';}?> >rak G</option>
							</select>
						</div>
			
						<div class="col">
							<select name="lantai" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item" <?php if($lan == 1){echo 'selected';}?> >lantai 1</option>
								<option value="2" class="dropdown-item" <?php if($lan == 2){echo 'selected';}?> >lantai 2</option>
								<option value="3" class="dropdown-item" <?php if($lan == 3){echo 'selected';}?> >lantai 3</option>
								<option value="4" class="dropdown-item" <?php if($lan == 4){echo 'selected';}?> >lantai 4</option>
								<option value="5" class="dropdown-item" <?php if($lan == 5){echo 'selected';}?> >lantai 5</option>
							</select>
						</div>
			
						<div class="col">
							<select name="kolom" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item" <?php if($kol == 1){echo 'selected';}?> >kolom 1</option>
								<option value="2" class="dropdown-item" <?php if($kol == 2){echo 'selected';}?> >kolom 2</option>
								<option value="3" class="dropdown-item" <?php if($kol == 3){echo 'selected';}?> >kolom 3</option>
								<option value="4" class="dropdown-item" <?php if($kol == 4){echo 'selected';}?> >kolom 4</option>
								<option value="5" class="dropdown-item" <?php if($kol == 5){echo 'selected';}?> >kolom 5</option>
								<option value="6" class="dropdown-item" <?php if($kol == 6){echo 'selected';}?> >kolom 6</option>
								<option value="7" class="dropdown-item" <?php if($kol == 7){echo 'selected';}?> >kolom 7</option>
								<option value="8" class="dropdown-item" <?php if($kol == 8){echo 'selected';}?> >kolom 8</option>
							</select>
						</div>
			
						<div class="col">
							<select name="baris" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
								<option value="1" class="dropdown-item" <?php if($bar == 1){echo 'selected';}?> >baris 1</option>
								<option value="2" class="dropdown-item" <?php if($bar == 2){echo 'selected';}?> >baris 2</option>
							</select>
						</div>
		
						<div class="col-6 mx-auto mt-5 d-flex justify-content-center">
							<input class="btn btn-primary btn-block" type="submit" name="insert" value="Masukkan"/>
						</div>
					</div>
				</div>
			</div>
		</form>	
		<script>
		$(function(){
			$("#itemData").on("submit", function(e){
				var dataString = $(this).serialize();
				
				$.ajax({
					type: "POST",
					url: "backend/inputhandler.php",
					data: dataString,
					success: function(){
						$("#modalBarcode").modal("show").find(".modal-content").load("layout/modalbarcode.php?"+dataString);
					}
				});
				e.preventDefault();
			});
		});
		</script>
<?php
}

?>
