<?php 
	require '../backend/conn.php';
	$rak = $_GET['rak'];
?>

<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
<script src="js/jquery3.6.0.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>

<div class="modal-header">
	<h3>Daftar Komponen</h3>
	<button class="border border-0" type="" data-bs-dismiss="modal">
		<img src="img/icons/x-lg.svg"/>
	</button>
</div>
<div class="modal-body">

<div class="table-responsive">
<table class="table table-striped table-sm" id="tbBarang">
	<thead>
	<tr>
		<th scope="col">Nama Komponen</th>
		<th scope="col">Jumlah</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$stockQuery = "
		select stock.* , penyimpanan.*
		from stock
		join penyimpanan
		on stock.storage_id = penyimpanan.storage_id
		where penyimpanan.rak = '$rak'
		order by stock.stock_id desc";
		$stockRun = mysqli_query($servConnQuery, $stockQuery);
		$arr = array();
		
		while($stockFetch = mysqli_fetch_assoc($stockRun)){
			$arr[] = $stockFetch;
		}
		foreach($arr as $data){ ?>
		<tr>
			<td><?php echo $data['stock_name'] ?></td>
			<td><?php echo $data['amount'] ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>

</div>
<div class="modal-footer d-flex justify-content-center">
	<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
</div>

<script>
$(function(){
	$('#tbBarang').DataTable({
		"scrollY": "50vh",
		"scrollCollapse": true,
		language:{
			url: 'js/id.json'
		}
	});
	$('.dataTables_length').addClass('bs-select');
});
</script>