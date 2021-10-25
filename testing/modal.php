<?php
include'../backend/conn.php';

if(isset($_GET["itemName"])){
	$iName = $_GET['itemName'];
	
	function stringForm($val){
		
		$jenisKomponen = '';
		if($val == 0){
			$jenisKomponen = '
				<select name="category" class="btn btn-light btn-block border dropdown-toggle p-2 form-control">
					<option value="001" class="dropdown-item">Elektronik</option>
					<option value="010" class="dropdown-item">Sekali Pakai</option>
					<option value="011" class="dropdown-item">Peralatan</option>
					<option value="100" class="dropdown-item">Lain-Lain</option>
				</select>
			';			
		}else{
			$jenisKomponen = '
				<span class="form-control" id="categoryUpdate" style="background-color:#e9ecef"></span>
			';
		}
		
		$str = '
		<form action="">
			<div class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroup-sizing-sm">Kategori</span>
				</div>
				'.$jenisKomponen.'
			</div>
			<div class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroup-sizing-sm">Jumlah</span>
				</div>
				<input required type="number" class="form-control" name="amountUpdate" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
			</div>
			
			<div class="row mt-2">	
				<div class="col-4">Lokasi penyimpanan</div>
				<div class="col-8">
					<select name="rakUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
						<option value="1" class="dropdown-item">rak 1</option>
					</select>
				</div>
			</div>
			
			<div class="row mt-2">
				<div class="col-4"></div>
				<div class="col-8">
					<select name="lantaiUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
						<option value="1" class="dropdown-item">lantai 1</option>
						<option value="2" class="dropdown-item">lantai 2</option>
						<option value="3" class="dropdown-item">lantai 3</option>
						<option value="4" class="dropdown-item">lantai 4</option>
						<option value="5" class="dropdown-item">lantai 5</option>
					</select>
				</div>
			</div>
			
			<div class="row mt-2">
				<div class="col-4"></div>
				<div class="col-8">
					<select name="kolomUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
						<option value="1" class="dropdown-item">kolom 1</option>
						<option value="2" class="dropdown-item">kolom 2</option>
						<option value="3" class="dropdown-item">kolom 3</option>
						<option value="4" class="dropdown-item">kolom 4</option>
						<option value="5" class="dropdown-item">kolom 5</option>
						<option value="6" class="dropdown-item">kolom 6</option>
						<option value="7" class="dropdown-item">kolom 7</option>
						<option value="8" class="dropdown-item">kolom 8</option>
					</select>
				</div>
			</div>
			
			<div class="row mt-2">
				<div class="col-4"></div>
				<div class="col-8">
					<select name="barisUpdate" class="btn btn-light btn-block border border-dark dropdown-toggle p-2">
						<option value="1" class="dropdown-item">baris 1</option>
						<option value="2" class="dropdown-item">baris 2</option>
					</select>
				</div>
			</div>
			
			<div class="row mt-2">
				<div class="col-6 mx-auto">
					<input class="btn btn-primary btn-block" type="submit" name="update" value="Perbarui"/>
				</div>
			</div>
		</form>	
		';
		return $str;
	}
	
	$query = "select * from stock where stock_name = '$iName'";
	$run = mysqli_query($servConnQuery, $query);
	if($x = mysqli_num_rows($run)>0){
		echo stringForm($x);
	}else{
		echo stringForm($x);
	}
}

?>
