<?php
require 'conn.php';
require 'usersession.php';

if(isset($_POST['submit'])){
    //Mengambil data yang dimasukkan dari form
    $BRNG   = $_POST['nmbrng'];
    $link   = $_POST['link'];
	$toko	= $_POST['toko'];
	$alamat	= $_POST['alamat'];
    $harga  = $_POST['harga'];
    $ONG    = $_POST['ongkir'];
    $jumlah = $_POST['JMLH'];

	$err = 0;

    //Melihat apakah ada data yang belum diisi
    if($BRNG == null){
        //header('location:Pembelian.php');
		echo'barang kosong';
		$err++;
    }
	if($link == null){
        //header('location:Pembelian.php');
		$link = '-';
    }
	if($harga == null){
        //header('location:Pembelian.php');
		echo'harga kosong';
		$err++;
    }
	if($ONG == null){
		$ONG = 0;
	}
	if($toko == null){
		$toko = '-';
	}
	if($alamat == null){
		$alamat = '-';
	}
	if($jumlah == null){
        //header('location:Pembelian.php');
		echo'jumlah kosong';
		$err++;
    }
	
	if($err==0){
    
    //Mencari barang yang memiliki nama yang sama pada database
    $stid = "SELECT * FROM stock WHERE stock_name = '$BRNG'";
    $runsrch = mysqli_query($servConnQuery, $stid);
    $SUS = mysqli_fetch_assoc($runsrch);
    $stckid = $SUS['stock_id'];
	
    //Memasukkan data ke database
    $pmbln = "INSERT into pembelian (id, stock_id, link, toko, alamat, jumlah, harga, Ongkir, totalhrg, RAB) 
    value (default,'$stckid','$link', '$toko', '$alamat', '$jumlah','$harga','$ONG','0' ,default)";
    $inpmb = mysqli_query($servConnQuery, $pmbln);

    //Mengambil id terakhir dari tabel pembelian
    $ENGINE = "SELECT MAX(id) from pembelian";
    $REACTOR = mysqli_query($servConnQuery, $ENGINE);
    $LIGHT = mysqli_fetch_assoc($REACTOR);
    $SABOT = $LIGHT['MAX(id)'];    

    //Membuat data PPN dari Jumlah dan Harga id terakhir	    
    $AMOGUS = "SELECT jumlah * harga / 10 from pembelian where id = '$SABOT'";
    $BIGGUS = mysqli_query($servConnQuery, $AMOGUS);
    $VENT = mysqli_fetch_assoc($BIGGUS);
    $MEDBAY = $VENT['jumlah * harga / 10'];

    //Memasukkan data PPN ke id terakhir	    
    $ELECTRICAL = "UPDATE pembelian SET ppn ='$MEDBAY' WHERE id = '$SABOT'";
    $EMERGENCE = mysqli_query($servConnQuery, $ELECTRICAL);

    //Membuat data Harga total dari Jumlah, Harga, Ongkir dan PPN dari id terakhir
    $total = "SELECT jumlah * harga + Ongkir + ppn from pembelian where id = '$SABOT'";
    $run = mysqli_query($servConnQuery, $total);
    $row = mysqli_fetch_assoc($run);
    $jumTot = $row['jumlah * harga + Ongkir + ppn'];
	
    //Memasukkan data Harga total ke id terakhir
    $hrgttl = "UPDATE pembelian SET totalhrg = '$jumTot' WHERE id = '$SABOT'";
    $frttl = mysqli_query($servConnQuery, $hrgttl);
	
    //Memasukkan data Beli ke tabel harga
    $hrg = "UPDATE harga SET beli='$harga' WHERE id = '$SABOT'";
    $inhr= mysqli_query($servConnQuery, $hrg);

    //header('location:Pembelian.php');
    }else{
		echo'terdapat error: backend/pmbln.php baris 83';
	}

}

if(isset($_POST['buat'])){
    //Menggati data RAB menjadi 1 apabila tombol ditekan
    $RAB = "UPDATE pembelian SET RAB = '1';";
    $done = mysqli_query($servConnQuery, $RAB);

    header('location:Pembelian.php');
}

?>
