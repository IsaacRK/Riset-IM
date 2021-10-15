<?php
	
require 'conn.php';
require 'usersession.php';

if(isset($_POST['pointer'])){
	$point = $_POST['pointer'];
	if($point == "input"){
	
		$stockName = $_POST['itemName'];
		$kategori = $_POST['category'];
		$amount = $_POST['amount'];
		$operator = $username;

		$rak	= $_POST['rak'];
		$lantai	= $_POST['lantai'];
		$kolom	= $_POST['kolom'];
		$baris	= $_POST['baris'];

		$barcode = '0'.$rak.$lantai.$kolom.$baris.$kategori;
		
		$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lantai' and kolom = '$kolom' and baris = '$baris'";
		$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
		$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		
		$storage_id = $storageIdFetch['storage_id'];

		$inputQuery =
		"insert into 
		stock (stock_id, stock_name, category, amount, storage_id, operator, barcode)
		values (default, '$stockName', '$kategori', '$amount', '$storage_id', '$operator', '$barcode');
		";
		$inputRun = mysqli_query($servConnQuery, $inputQuery);
		
		$stockSearchQuery = "select stock_id from stock where stock_name = '$stockName' and storage_id = '$storage_id'";
		$stockSearchRun = mysqli_query($servConnQuery, $stockSearchQuery);
		$stockSearchFetch = mysqli_fetch_assoc($stockSearchRun);
		$stock_id = $stockSearchFetch['stock_id'];
		
		$storageQuery = "update penyimpanan set stock_id = '$stock_id' where storage_id = '$storage_id'";
		$storageQueryRun = mysqli_query($servConnQuery, $storageQuery);
		
		$now = date("Y-m-d");
		$historyQuery = 
		"insert into 
		history (history_id, stock_id, amount, input, output, date) 
		values (default, '$stock_id', '$amount', '1', NULL, '$now')";
		mysqli_query($servConnQuery, $historyQuery);
	}

	if($point == "update"){
		
		$stockName = $_POST['itemNameUpdate'];
		$amount = $_POST['amountUpdate'];

		$rak	= $_POST['rakUpdate'];
		$lantai	= $_POST['lantaiUpdate'];
		$kolom	= $_POST['kolomUpdate'];
		$baris	= $_POST['barisUpdate'];

		//---Stock Update Sequence---//
		//---1.update storage stockId to null
		//-----a.select storageId from stock->name
		//-----b.update penyimpanan stockId to null
		//---2.update stock amount ,storageId & barcode
		//-----a.select storageId from data post
		//-----b.update stock amount, storageId & barcode
		//---3.update penyimpanan stockId
		//-----a.update penyimpanan stockId from storageId(2.b)
		//---4.input ke history

		//---1.
		//---select stock amount & id
		$stockFetchQuery = "select * from stock where stock_name = '$stockName'";
		$stockFetchRun = mysqli_query($servConnQuery, $stockFetchQuery);
		$stockFetch = mysqli_fetch_assoc($stockFetchRun);
		$stockAmount = $stockFetch['amount'];
		$storage_id = $stockFetch['storage_id'];
		$stock_id = $stockFetch['stock_id'];
		$kategori = $stockFetch['category'];
		$updateAmount = $amount + $stockAmount;

		//---update storage stock_id to null
		$storageUpdateNullQuery = "update penyimpanan set stock_id = null where storage_id = '$storage_id'";
		$storageUpdateNullRun = mysqli_query($servConnQuery, $storageUpdateNullQuery);
		
		//---2.
		//---select storageId from data post
		$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lantai' and kolom = '$kolom' and baris = '$baris'";
		$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
		$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		
		$storage_id = $storageIdFetch['storage_id'];
		$barcode = '0'.$rak.$lantai.$kolom.$baris.$kategori;
		
		//---update stock amount, storage_id & barcode
		$stockUpdateQuery = "update stock set amount = '$updateAmount', storage_id = '$storage_id', barcode = '$barcode' where stock_id = '$stock_id'";
		$stockUpdateRun = mysqli_query($servConnQuery, $stockUpdateQuery);

		//---3.
		//---update storage stock_id
		$storageUpdateNullQuery = "update penyimpanan set stock_id = '$stock_id' where storage_id = '$storage_id'";
		$storageUpdateNullRun = mysqli_query($servConnQuery, $storageUpdateNullQuery);
		
		//---4.
		//---input ke history
		$now = date("Y-m-d");
		$historyQuery = 
		"insert into 
		history (history_id, stock_id, amount, input, output, date) 
		values (default, '$stock_id', '$amount', '1', NULL, '$now')";
		mysqli_query($servConnQuery, $historyQuery);
	}
}

?>
