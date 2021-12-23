<?php
require '../backend/conn.php';
require '../backend/usersession.php';
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
	mysqli_query($servConnQuery, $sql);
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Forecast</title>
<?php include "../layout/header.php"?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>
<body>

<?php
//	include "../layout/sidebar-old.php";
?>

>
    
		<div class="row">
			<div class="col">
				<h1>Forecast</h1>
			</div>
        </div>
    


    <div class="card shadow-sm">
	<div class="card-body">
    <table class="table table-striped table-sm" id="tableAcc">
        <thead>
            <tr class="table-info">
                <th scope="col">Nama</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Estimasi Stok Keluar</th>
                <th scope="col">Estimasi Pergeseran Harga</th>
                
				
            </tr>
        </thead>
        <tbody>
		<?php
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
				$beli = $data['beli'];
				if($beli == 0){
					$beli = 'data belum ada';
				}
				$jual = $data['jual'];
				if($jual == 0){
					$jual = 'data belum ada';
				}
		?>
		<tr>
			<td><?php echo$data['stock_name'];?></td>
			<td><?php echo$data['amount'];?>
			<td><?php echo$tgl;?></td>
			<td><?php echo$beli;?></td>
		</tr>
		
			<?php } ?>
        </tbody>
    </table>
    </div>
    </div>
    
 </div>
</div>

<script>
$(function(){
	$('#tableAcc').DataTable({
		"scrollY": "50vh",
		"scrollCollapse": true,
		language:{
			url: 'js/id.json'
		}
	});
	$('.dataTables_length').addClass('bs-select');
});
var nama = <?php echo'"'.'nama'.'"'; ?>;
console.log(nama);
</script>

</body>
</html>
