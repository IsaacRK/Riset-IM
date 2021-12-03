<?php
	
require 'conn.php';
require 'usersession.php';

if(isset($_POST['itemName'])){
	//---new sequence---//
	//---pre-Query
	//-----a.fetch data & declare variables from form
	//---1.insert / update stock
	//-----a.sql query check | if row > 0 = update else insert
	//-----b.get storage id from fetch data form
	//-----c.sql query storage
	//---2.update barcode
	//---3.insert history
	
	echo$stockName = $_POST['itemName'];
	echo$rak	= $_POST['rak'];
	echo$lantai	= $_POST['lantai'];
	echo$kolom	= $_POST['kolom'];
	echo$baris	= $_POST['baris'];
	
	$check 		= '';
	$amountDb 	= '';
	$barcode	= '';
	
	echo$queryStockCheck 	= "select * from stock where stock_name = '$stockName'";
	$queryStockCheckRun 	= mysqli_query($servConnQuery, $queryStockCheck);
	if(mysqli_num_rows($queryStockCheckRun)>0){
		//barang ada
		echo '</br>barang ada</br>';
		echo $check = 1;
		$fetch 		= mysqli_fetch_assoc($queryStockCheckRun);
		$amountDb 	= $fetch['amount'];
		$stock_id 	= $fetch['stock_id'];
		$kategori 	= $fetch['category'];
		$barcode 	= $rak.$lantai.$kolom.$baris.$kategori.$stock_id;
	}else{
		//tidak ada di penyimpanan
		echo '</br>barang baru</br>';
		echo $check = 0;
	}
	
	$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lantai' and kolom = '$kolom' and baris = '$baris'";
	$storageSearchRun 	= mysqli_query($servConnQuery, $storageSearchQuery);
	$storageIdFetch 	= mysqli_fetch_assoc($storageSearchRun);
	$storage_id 		= $storageIdFetch['storage_id'];
	
	$kategori 	= $_POST['category'];
	$amount 	= $_POST['amount'];
	$user_id 	= $_SESSION['uid'];
	
	if($check == 1){
		//update barang
		$totalAmount 		= $amount + $amountDb;
		$stockUpdateQuery 	= "update stock set amount = '$totalAmount', storage_id = '$storage_id', barcode = '$barcode' where stock_id = '$stock_id'";
		if($stockUpdateRun 	= mysqli_query($servConnQuery, $stockUpdateQuery)){
			echo 'Update Done!';
		}
		
		//update tampilan rak
		//ambil jumlah barang yang di simpan pada rak tersebut
		echo$rakIsiSql 	= "select * from stock where storage_id = '$storage_id'";
		$rakIsiRun 	= mysqli_query($servConnQuery, $rakIsiSql);
		$rakIsi 	= mysqli_num_rows($rakIsiRun);
		
		//update jumlah barang pada rak yang di simpan
		$rakUpd 	= "update penyimpanan set isi = '$rakIsi' where storage_id = '$storage_id'";
		mysqli_query($servConnQuery, $rakUpd);
	}
	if($check == 0){
		//insert
		$inputQuery =
		"insert into 
		stock (stock_id, stock_name, category, amount, storage_id, barcode)
		values (default, '$stockName', '$kategori', '$amount', '$storage_id', '000');
		";
		mysqli_query($servConnQuery, $inputQuery);
		
		$stockSearchQuery 	= "select stock_id from stock where stock_name = '$stockName'";
		$stockSearchRun 	= mysqli_query($servConnQuery, $stockSearchQuery);
		$stockSearchFetch 	= mysqli_fetch_assoc($stockSearchRun);
		$stock_id 			= $stockSearchFetch['stock_id'];
		$barcode 			= $rak.$lantai.$kolom.$baris.$kategori.$stock_id;
		$inputBarcode =
		"update stock 
		set barcode = '$barcode'
		where stock_id = '$stock_id'
		";
		
		$sqlIsi = "insert into harga (stock_id, input, beli, jual) values ('$stock_id', '0', '0', '0')";
		mysqli_query($servConnQuery, $sqlIsi);
		
		if(mysqli_query($servConnQuery, $inputBarcode)){
			echo 'insert done!';
		}
		
		//update tampilan rak
		//ambil jumlah barang yang di simpan pada rak tersebut
		echo$rakIsiSql 	= "select * from stock where storage_id = '$storage_id'";
		$rakIsiRun 	= mysqli_query($servConnQuery, $rakIsiSql);
		$rakIsi 	= mysqli_num_rows($rakIsiRun);
		
		//update jumlah barang pada rak yang di simpan
		$rakUpd 	= "update penyimpanan set isi = '$rakIsi' where storage_id = '$storage_id'";
		mysqli_query($servConnQuery, $rakUpd);
	}

	$now = date("Y-m-d");
	$historyQuery = 
	"insert into 
	history (history_id, stock_id, amount, input, output, user_id, date) 
	values (default, '$stock_id', '$amount', '1', NULL, '$user_id', '$now')";
	mysqli_query($servConnQuery, $historyQuery);
	
}

//algoritma lama
/*
if(isset($_POST['pointer'])){
	if($point == "input"){
	
		$stockName = $_POST['itemName'];
		$kategori = $_POST['category'];
		$amount = $_POST['amount'];
		
		$user_id = $_SESSION['uid'];

		$rak	= $_POST['rak'];
		$lantai	= $_POST['lantai'];
		$kolom	= $_POST['kolom'];
		$baris	= $_POST['baris'];
		
		$storageSearchQuery = "select * from penyimpanan where rak = '$rak' and lantai = '$lantai' and kolom = '$kolom' and baris = '$baris'";
		$storageSearchRun = mysqli_query($servConnQuery, $storageSearchQuery);
		$storageIdFetch = mysqli_fetch_assoc($storageSearchRun);
		$storage_id = $storageIdFetch['storage_id'];
		
		//input barang-no barcode
		$inputQuery =
		"insert into 
		stock (stock_id, stock_name, category, amount, storage_id, barcode)
		values (default, '$stockName', '$kategori', '$amount', '$storage_id', '000');
		";
		mysqli_query($servConnQuery, $inputQuery);
		
		$stockSearchQuery = "select stock_id from stock where stock_name = '$stockName'";		$stockSearchRun = mysqli_query($servConnQuery, $stockSearchQuery);
		$stockSearchFetch = mysqli_fetch_assoc($stockSearchRun);
		$stock_id = $stockSearchFetch['stock_id'];
		
		$storageQuery = "update penyimpanan set stock_id = '$stock_id' where storage_id = '$storage_id'";
		mysqli_query($servConnQuery, $storageQuery);
		
		//input barang with barcode
		$barcode = $rak.$lantai.$kolom.$baris.$kategori.$stock_id;
		$inputBarcode =
		"update stock 
		set barcode = '$barcode'
		where storage_id = '$storage_id'
		";
		mysqli_query($servConnQuery, $inputBarcode);
		
		//input history
		$now = date("Y-m-d");
		$historyQuery = 
		"insert into 
		history (history_id, stock_id, amount, input, output, user_id, date) 
		values (default, '$stock_id', '$amount', '1', NULL, '$user_id', '$now')";
		mysqli_query($servConnQuery, $historyQuery);
	}

	if($point == "update"){
		
		$user_id = $_SESSION['uid'];
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
		$barcode = $rak.$lantai.$kolom.$baris.$kategori.$stock_id;
		
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
		history (history_id, stock_id, amount, input, output, user_id, date) 
		values (default, '$stock_id', '$amount', '1', NULL, '$user_id', '$now')";
		mysqli_query($servConnQuery, $historyQuery);
	}
}*/

?>
