<?php
include'../backend/conn.php';

if(isset($_POST['reset'])){
	
	$sqlFetch = "select * from stock";
	$runFetch = mysqli_query($servConnQuery, $sqlFetch);
	
	mysqli_query($servConnQuery, "truncate table harga");
	
	while($rowFetch = mysqli_fetch_assoc($runFetch)){
		$sid = $rowFetch['stock_id'];
		$sqlIsi = "insert into harga (stock_id, input, beli, jual) values ('$sid', '0', '0', '0')";
		mysqli_query($servConnQuery, $sqlIsi);
	}
}

if(isset($_POST['editBtn'])){
	$newVal = $_POST['edit'];
	$hargId = $_POST['editId'];
	
	$sql = "update harga set jual = '$newVal' where id = '$hargId'";
	mysqli_query($servConnQuery, $sql);
}

?>
<html>
<head>
	<title>akounttigngng</title>
	<?php include'../layout/header.php';?>
</head>
<body>

<form method="post">
	<input type="submit" name="reset" value="reset">
</form>

<table>
	<thead>
	<tr>
		<td>Nama</td>
		<td>Input</td>
		<td>Harga Beli</td>
		<td>Harga Jual</td>
		<td>Edit</td>
	</tr>
	</thead>
	<tbody>
	<?php
		$sql = "
			select harga.* , stock.stock_name
			from harga
			join stock
			on stock.stock_id = harga.stock_id
		";
		
		$run = mysqli_query($servConnQuery, $sql);
		$arr = array();
		while($row = mysqli_fetch_assoc($run)){
			$arr[] = $row;
		}
		foreach($arr as $data){
			$id = $data['id'];
			$sid = $data['stock_id'];
			$tglSql = "select date from history where stock_id = '$sid' and input = '1' order by date desc limit 1";
			$tglRun = mysqli_query($servConnQuery, $tglSql);
			$tglRow = mysqli_fetch_assoc($tglRun);
			$tgl = '';
			if($tglRow == null){
				$tgl = 'crooot';
			}else{
				$tgl = $tglRow['date'];
			}
	?>
	<tr>
		<td><?php echo$data['stock_name'];?></td>
		<td><?php echo$tgl;?></td>
		<td><?php echo$data['beli'];?></td>
		<td><?php echo$data['jual'];?></td>
		<td>
			<button data-bs-toggle="modal" data-bs-target="#editModal<?php echo$id;?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
				  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
				</svg>
			</button>
		</td>
	</tr>

	<!-- Modal -->
	<div class="modal fade" id="editModal<?php echo$id;?>" tabindex="-1" aria-labelledby="modalEditHarga" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Edit Harga</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form method="post"; >
				<input type="text" name="edit">
				<input type="hidden" name="editId" value="<?php echo$id;?>">
		  </div>
		  <div class="modal-footer">
			<input type="submit" class="btn btn-secondary" data-bs-dismiss="modal" name="editBtn" value="Submit">
			</form>
			<button type="button" class="btn btn-primary">Save changes</button>
		  </div>
		</div>
	  </div>
	</div>
	
		<?php } ?>
	</tbody>
</table>

</body>
</html>