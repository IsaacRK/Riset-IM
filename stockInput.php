<?php

require 'backend/conn.php';
require 'backend/usersession.php';

function xpercent_of_y($x, $y){
	return $x * ($y / 100);
}
function x_aspercent_of_y($x,$y){
	return (100 * $x) / $y;
}


$elek = '';
$pera = '';
$lain = '';
$totalBarang = '';

$sql = "select * from stock";
$run = mysqli_query($servConnQuery, $sql);
if(mysqli_num_rows($run)>0){
	while($row = mysqli_fetch_assoc($run)){
		//echo 'id: '.$row['stock_id'].' | cate: '.$row['category'].'</br>';
		if($row['category']=='001'){
			$elek++;
		}
		if($row['category']=='010'){
			$pera++;
		}
		if($row['category']=='100'){
			$lain++;
		}
		$totalBarang++;
	}
}

$totalStorage='';
$storageCheck='';
$storageQuery = "select * from penyimpanan";
$storageRun = mysqli_query($servConnQuery, $storageQuery);
if(mysqli_num_rows($storageRun)>0){
	while($srow = mysqli_fetch_assoc($storageRun)){
		$totalStorage++;
		if($srow['stock_id']!=null){
			$storageCheck++;
		}
	}
}

$x = $totalStorage - $storageCheck;

$e = xpercent_of_y(x_aspercent_of_y($elek,$totalBarang),$storageCheck);
$p = xpercent_of_y(x_aspercent_of_y($pera,$totalBarang),$storageCheck);
$l = xpercent_of_y(x_aspercent_of_y($lain,$totalBarang),$storageCheck);

?>
<!DOCTYPE html>
<html>

<head>
	<title>Barang Masuk</title>
	<?php include"layout/header.php"; ?>
	
</head>

<body>

<?php
	include"layout/sidebar.php";
?>

<div class="content">
<div class="container mr-0">

	<div class="p-1">
		<div class="mb-3">
			<h1>Stock Masuk</h1>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="card">
			<div class="card-body">
				<h3>Data Barang</h3>
				</br>
				
				<form action="" id="itemNameForm">
					<div class="row mb-3">
						<div class="col-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-sm">Nama</span>
								</div>
								<input required type="text" class="form-control" name="itemName" id="itemName" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
							</div>
						</div>
						<div class="col d-grid gap-2">
							<input class="btn btn-primary" type="submit" name="itemNameBtn" value="Cek">
						</div>
					</div>
				</form>
				
				<div id="divItemData">
				</div>
				
			</div>
			</div>
		</div>
		
		<div class="col">
			<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-center">
					<canvas id="pieChart" style="max-width:300px;max-height:300px;"></canvas>
				</div>
				
				<canvas id="barChart" style="max-width:;max-height:;"></canvas>
			
			</div>
			</div>
		</div>
	</div>
 
</div>
</div>

<div id="modalBarcode" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<?php
	include"layout/js.php";
?>

<script>
$(function(){
	$("#itemData").on("submit", function(e){
		var dataString = $(this).serialize();
		//alert(dataString);
		
		$.ajax({
			type: "POST",
			url: "backend/inputhandler.php",
			data: dataString,
			success: function(){
				$('#modalBarcode').modal('show').find('.modal-content').load('layout/modalbarcode.php?'+dataString);
			}
		});
		e.preventDefault();
	});
});

$('#modalBarcode').on('hidden.bs.modal', function () {
 location.reload();
})

$(function(){
	$("#itemName").autocomplete({
		source: 'backend/autocomplete.php'
	});
});

$(function(){
	$("#itemNameForm").on("submit", function(e){
		var dataString = $(this).serialize();
		//alert(dataString);
		
		$.ajax({
			type: "POST",
			url: "layout/test.html",
			data: dataString,
			success: function(){
				$("#divItemData").load('layout/formitem.php?'+dataString);
			}
		});
		e.preventDefault();
	});
});

$(document).ready(function(){
	var pieDisplay = $('#pieChart');
	var nilaiData = [<?php echo$x.','.$e.','.$p.','.$l; ?>];
	var warna = ["#d4dfe9", "#1064AE", "#009AD2", "#89c5fb"];
	
	var pieData = {
		labels: ["Kosong", "elektronik", "peralatan", "lain-lain"],
		datasets: [{
			backgroundColor: warna,
			data: nilaiData,
		}]
	};
	
	var pieOptions = {
		legend: {
			display: true,
			text: "nama text disini"
		}
	};
	
	var pieChart = new Chart(pieDisplay, {
		type: "pie",
		data: pieData,
		options: pieOptions
	});
});

$(document).ready(function(){
	var barDisplay = $('#barChart');
	var nilaiData = [<?php echo$elek.','.$pera.','.$lain; ?>];
	var warna = ["#1064AE"];
	
	var barData = {
		labels: ["Elektronik", "Peralatan", "Lain-lain"],
		datasets: [{
			label: '',
			backgroundColor: warna,
			data: nilaiData,
		}],
		legend: {
			display: false
		}
	};
	
	var barOptions = {
		indexAxis: 'y',
		scales: {
			x: {
				title: {
					display: true,
					text: 'Jumlah'
				}
			}
		},
		plugins:{
			legend:{
				display: false,
			}
		}
	};
	
	var pieChart = new Chart(barDisplay, {
		type: "bar",
		data: barData,
		options: barOptions
	});
});

/*
var nameField = document.getElementById('itemNameUpdate');
var lastnamevalue = undefined;

updateNameDisplay();

setInterval(updateNameDisplay, 100);

function updateNameDisplay(){
	var aValue = nameField.value;
	if(lastnamevalue != aValue){
		document.getElementById('categoryUpdate').innerHTML = lastnamevalue = aValue;
	}
}*/
</script>
</body>
</html>
