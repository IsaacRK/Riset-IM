<?php
require '../backend/conn.php';
$rak='1';
$lan='1';

if(isset($_GET['rak'])){
	$rak = $_GET['rak'];
}
if(isset($_GET['lan'])){
	$lan = $_GET['lan'];
}

$arr = array();

$sql = "select * from penyimpanan where rak=$rak and lantai = $lan";
$run = mysqli_query($servConnQuery, $sql);

while($row = mysqli_fetch_assoc($run)){
	$arr[] = $row;
}

?>
<table class="table table-sm table-striped">
	<thead>
	<tr>
		<th>Rak</th>
		<th>Lantai</th>
		<th>Kolom</th>
		<th>Baris</th>
		<th>Edit</th>
		<th>Hapus</th>
	</tr>
	</thead>
	<tbody>
		<?php
		foreach($arr as $data){ ?>
		<tr>
			<td><?php echo $data['rak']; ?></td>
			<td><?php echo $data['lantai']; ?></td>
			<td><?php echo $data['kolom']; ?></td>
			<td><?php echo $data['baris']; ?></td>
			<td>
				<div class="py-2">
					<img src="img/icons/pencil-square.svg" width="32" height="32" onclick="edit(<?php echo $data['storage_id']; ?>)"/>
				</div>
			</td>
			<td>
				<div class="py-2">
					<img src="img/icons/trash.svg" width="32" height="32" onclick="hapus(<?php echo $data['storage_id']; ?>)"/>
				</div>
			</td>
		</tr>
		<?php 
		}
		if($arr==null){
			echo'<td colspan="5" class="align-middle">Data Kosong</td>';	
		}
		?>
	</tbody>
</table>