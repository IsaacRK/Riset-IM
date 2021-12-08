<?php
require 'conn.php';
require 'usersession.php';

if(isset($_POST['submit'])){
    $BRNG   = $_POST['nmbrng'];
    $link   = $_POST['link'];
    $harga  = $_POST['harga'];
    $ONG    = $_POST['ongkir'];
    $jumlah = $_POST['JMLH'];

    if($BRNG == null){
        header('location:Pembelian.php');
    }else if($link == null){
        header('location:Pembelian.php');
    }else if($harga == null){
        header('location:Pembelian.php');
    }else if($jumlah == null){
        header('location:Pembelian.php');
    }else{
    $stid = "SELECT * FROM stock WHERE stock_name = '$BRNG'";
    $runsrch = mysqli_query($servConnQuery, $stid);
    $SUS = mysqli_fetch_assoc($runsrch);
    $stckid = $SUS['stock_id'];
	
	//buat pembelian
    $pmbln = "INSERT into pembelian (id, stock_id, link, jumlah, harga, Ongkir, totalhrg, RAB) 
    value (default,'$stckid','$link','$jumlah','$harga','$ONG','0' ,default)";
    $inpmb = mysqli_query($servConnQuery, $pmbln);
	    
    $AMOGUS = "SELECT jumlah * harga / 10 from pembelian where stock_id = '$stckid'";
    $BIGGUS = mysqli_query($servConnQuery, $AMOGUS);
    $VENT = mysqli_fetch_assoc($BIGGUS);
    $MEDBAY = $VENT['jumlah * harga / 10'];
    $ELECTRICAL = "UPDATE pembelian SET ppn ='$MEDBAY' WHERE stock_id = '$stckid'";
    $EMERGENCE = mysqli_query($servConnQuery, $ELECTRICAL);

	//ambil stock id dari nama barang
    $total = "SELECT jumlah * harga + Ongkir + ppn from pembelian where stock_id = '$stckid'";
    $run = mysqli_query($servConnQuery, $total);
    $row = mysqli_fetch_assoc($run);
    $jumTot = $row['jumlah * harga + Ongkir + ppn'];
	
	//update pembelian dengan stock id
    $hrgttl = "UPDATE pembelian SET totalhrg = '$jumTot' WHERE stock_id = '$stckid'";
    $frttl = mysqli_query($servConnQuery, $hrgttl);
	
	//update harga beli dari harga yang di inputkan
    $hrg = "UPDATE harga SET beli='$harga' WHERE stock_id = '$stckid'";
    $inhr= mysqli_query($servConnQuery, $hrg);

    header('location:Pembelian.php');
    }

}

if(isset($_POST['buat'])){
    $RAB = "UPDATE pembelian SET RAB = '1';";
    $done = mysqli_query($servConnQuery, $RAB);

    header('location:Pembelian.php');
}

?>
