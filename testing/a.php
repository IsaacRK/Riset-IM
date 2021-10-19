<?php
include '../backend/conn.php';
/*
if(isset($_GET['text'])){
	echo "konek</br>";
	$nama = $_GET['text'];
	echo$query = "select * from stock where stock_name = '$nama'";
	$run = mysqli_query($servConnQuery, $query);
	if(mysqli_num_rows($run) > 0){
		echo "</br>ada barang</br>
			  <div id='target'>1</div>
		";
	}else{
		echo "</br>kosong</br>
 			  <div id='target'>1</div>
		";
	}
}
*/
$uid = $_SESSION['uid'];
$query = 'select * from history';
$run = mysqli_query($servConnQuery, $query);
if(mysqli_num_rows($run)>0){
	$upq = "update history set user_id = '$uid'";
	mysqli_query($servConnQuery, $upq);
}

?>
<html>
<body>


<script>
	var = document.getElementById("target").innerHTML;
	$.ajax({
		type:"POST",
		url:'post.php',
		data:val,
		success:function(result){
			//console.log(data)
			//location.reload();
			//$('#result').text('name: ' + result );
		},
		error:function(error){
			colsole.log('err ${error}')
		}
	})
</script>
</body>
</html>