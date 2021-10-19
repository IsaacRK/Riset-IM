<?php
include '../backend/conn.php';
?>
<html>
<body>
<script src="../js/jquery3.6.0.min.js"></script>
<script src="../js/chart.js"></script>
<table class="table table-striped table-sm" id="tbActivity">
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
$activityFetchQuery	="SELECT * FROM `history` WHERE date > CURRENT_DATE - INTERVAL 7 day order by date(date) desc;";
$activityFetchRun 	= mysqli_query($servConnQuery, $activityFetchQuery);
if(mysqli_num_rows($activityFetchRun) > 0){
	while($activityFetch = mysqli_fetch_assoc($activityFetchRun)){
		$sid 		= $activityFetch['stock_id'];
		$amount		= $activityFetch['amount'];
		$userId		= $activityFetch['user_id'];
		$input		= $activityFetch['input'];
		$output		= $activityFetch['output'];
		$stockQuery = "select * from stock where stock_id = '$sid' order by stock_id desc";
		$stockRun 	= mysqli_query($servConnQuery, $stockQuery);
		$stockFetch = mysqli_fetch_assoc($stockRun);
		$status = '';
		if($input == 1){
			$status = "Input";
		}elseif($output == 1){
			$status = "Output";
		}else{
			$status = "db err";
		}
		
		$userFetchQuery = "select * from pengguna where id = '$userId'";
		$userFetchRun 	= mysqli_query($servConnQuery, $userFetchQuery);
		$userFetch 		= mysqli_fetch_assoc($userFetchRun);

		echo"
			<tr>
				<td class='fw-bold'>".$stockFetch['stock_name']."</td>
				<td>".$status."</td>
				<td>".$activityFetch['date']."</td>
				<td>".$userFetch['user']."</td>
				<td>".$activityFetch['amount']."</td>
			</tr>
		";
	}
}
?>
</tbody>
</table>
</body>
<script>	
</script>
</html>