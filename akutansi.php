<?php
require 'backend/conn.php';
require 'backend/usersession.php';
if ($userAC == '0'){
	header('location:Verifyno.php');
}

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
	
	$sql = "update harga set jual = '$newVal' where stock_id = '$hargId'";
	if(mysqli_query($servConnQuery, $sql)){
		$sqlHist = "INSERT INTO harga_history(`stock_id`, `harga`, `date`) VALUES('$hargId', '$newVal', CURDATE())";
		mysqli_query($servConnQuery, $sqlHist);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pengaturan Harga</title>
<?php include "layout/header.php"?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>
<body>

<?php
	include "layout/sidebar-old.php";
?>

<div class="content">
 <div class="container mr-0">
    <div class="p-1 mb-3">
		<div class="row">
			<div class="col juk">
				<h1>Pengaturan Harga</h1>
			</div>
        </div>
    </div>


    <div class="card shadow-sm">
	<div class="card-body">
    <table class="table table-striped table-sm display nowrap" id="tableAcc">
        <thead>
            <tr class="table-info">
                <th scope="col">Nama</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Tanggal input</th>
                <th scope="col">Harga beli</th>
                <th scope="col">Harga jual</th>
				<th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
		<?php
			function rupiah($angka){
				$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
				return $hasil_rupiah;
			}
			
			$sql = "
				select harga.* , stock.*
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
					$tgl = 'Input sebelum Riwayat';
				}else{
					$tgl = $tglRow['date'];
				}
				$beli = rupiah($data['beli']);
				if($data['beli'] == 0){
					$beli = 'data belum ada';
				}
				$jual = rupiah($data['jual']);
				if($data['jual'] == 0){
					$jual = 'data belum ada';
				}
		?>
		<tr>
			<td><?php echo$data['stock_name'];?></td>
			<td><?php echo$data['amount'];?>
			<td><?php echo$tgl;?></td>
			<td><?php echo$beli;?></td>
			<td><?php echo$jual;?></td>
			<td>
				<button class="btn btn-primary" onclick="edit(<?php echo$id;?>)">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
					  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
					  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
					</svg>
				</button>
			</td>
		</tr>
			<?php } ?>
        </tbody>
    </table>
    </div>
    </div>
    
 </div>
</div>

<script src="js/dataTables.responsive.min.js"></script>
<script src="js/dataTables.rowReorder.min.js"></script>
<script>
$(document).ready(function(){
	$('#tableAcc').DataTable({
		"scrollY": "50vh",
		responsive: true,
		language:{
			url: 'js/id.json'
		}
	});
	$('.dataTables_length').addClass('bs-select');
});

function edit(x){	
	console.log(x);
	$('#modalEdit').modal('show').find('.modal-content').load('layout/modalEditHarga.php?id='+x);
}
</script>


<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div>
  </div>
</div>

</body>
</html>
