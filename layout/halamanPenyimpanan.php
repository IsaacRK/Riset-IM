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