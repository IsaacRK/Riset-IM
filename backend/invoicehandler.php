<?php
include'conn.php';
include'usersession.php';
echo'|--start--|</br>';
if(isset($_POST['checkbox'])){
	echo'cart id:</br>';
	
	//invoice Generator
	//cek invoice serialNum
	$inv = 'INV/'.date('Ymd').'/'.$userId.'/';
	echo '</br>';
	echo $sqlCek="select * from invoice where invoice_no like '$inv%' order by id desc limit 1";
	$cekRun = mysqli_query($servConnQuery, $sqlCek);
	echo '</br>';
	$serNum = 1;
	if(mysqli_num_rows($cekRun)>0){
		$cekRow = mysqli_fetch_assoc($cekRun);
		$x 		= substr($cekRow['invoice_no'] , strrpos($cekRow['invoice_no'], "/") + 1);
		$serNum = intval($x) + 1;
		$inv 	= $inv.$serNum;
	}else{
		$inv 	= $inv.$serNum;
	}
	
	//insert 
	$val = $_POST['checkbox'];
	for($i=0;$i<count($val);$i++){
		$cartId = $val[$i];
		echo'</br>'.$cartId.'</br>';
		
		$sqlHargaTotal = "
			SELECT cart.* , harga.jual
			FROM cart
			JOIN harga ON cart.stock_id = harga.stock_id
			WHERE cart.cart_id = $cartId
		";
		$runHargaTotal = mysqli_query($servConnQuery, $sqlHargaTotal);
		$rowHargaTotal = mysqli_fetch_assoc($runHargaTotal);
		$jumBarang = $rowHargaTotal['take_amount'];
		$harBarang = $rowHargaTotal['jual'];
		$hargaTotal = $jumBarang * $harBarang;
		
		$now = date('Y-m-d');
		echo $inputInvoiceSql = "insert into 
							invoice (invoice_no, user_id, cart_id, date, total_harga)
							values ('$inv', '$userId', '$cartId', '$now', $hargaTotal)
							";
		echo'</br>';
		if(mysqli_query($servConnQuery, $inputInvoiceSql)){
			echo'done';
		}else{
			echo'err';
		}
	}
}

echo'</br>|--end--|';
?>