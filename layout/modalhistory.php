<?php require '../backend/conn.php'; ?>
<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
<script src="js/jquery3.6.0.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>

<div class="modal-header">
	<h3>Riwayat 7 hari terakhir</h3>
	<button class="border border-0" type="" data-bs-dismiss="modal">
		<img src="img/icons/x-lg.svg"/>
	</button>
</div>
<div class="modal-body">
	
	<div class="table-responsive">
	<table class="table table-striped table-sm" id="tbHistory">
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
			if($a==1)		{return 'Masuk';}
			elseif($b==1)	{return 'Keluar';}
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
<div class="modal-footer d-flex justify-content-center">
	<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tututp</button>
</div>

<script>
	$(document).ready(function () {
		$('#tbHistory').DataTable({
			"scrollY": "50vh",
			"scrollCollapse": true,
			"order": [[2, "desc"]],
			language:{
				url: 'js/id.json'
			}
		});
		$('.dataTables_length').addClass('bs-select');
	});
</script>