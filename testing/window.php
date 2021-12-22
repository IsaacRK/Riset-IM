<?php
include"../backend/conn.php";
$sql = mysqli_query($servConnQuery, "select * from stock limit 10");
?>
<table>
	<tr>
		<td>nama</td>
		<td>btn</td>
	<tr>
	<?php while($row = mysqli_fetch_assoc($sql)){ ?>
	<tr>
		<td><?php echo $row['stock_name'] ;?></td>
		<td><button onclick="btn('<?php echo $row['stock_id'] ;?>')">btn</button></td>
	</tr>
	<?php } ?>
</table>
<script>
	function btn(x){
		alert(x);
	}
</script>