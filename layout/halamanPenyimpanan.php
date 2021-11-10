<?php
require '../backend/conn.php';
$arr = array();

for($i = 1; $i <= 5; $i++){
	$sql = "select * from penyimpanan where lantai = $i";
	$run = mysqli_query($servConnQuery, $sql);
	while($row = mysqli_fetch_assoc($run)){
		$arr[] = $row;
	}
}

?>
<table class="table table-striped">
	<thead>
	<tr>
		<th>Rak</th>
		<th>Lantai</th>
		<th>Kolom</th>
		<th>Baris</th>
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
		</tr>
		<?php } ?>
	</tbody>
</table>