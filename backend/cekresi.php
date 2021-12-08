<?php
//format
//GTrack::jne('xxxxxxx')			-- 1
//GTrack::jnt('xxxxxxx')			-- 2
//GTrack::tiki('xxxxxxx')			-- 3
//GTrack::pos('xxxxxxx')			-- 4
//GTrack::wahana('xxxxxxx')			-- 5
//GTrack::siCepat('xxxxxxx') 		-- 6
//GTrack::ninjaXpress('xxxxxxx')	-- 7
//GTrack::jetExpress('xxxxxxx')		-- 8

//cek resi
require 'GTrack/vendor/autoload.php';
use GTrack\GTrack;
$GTrack = new GTrack();
//$cek    = $GTrack->jne('011440046444019');
//var_dump($cek);
//echo $cek->message;

if(isset($_POST['kirimKR'])){
	$exped = $_POST['exped'];
	$noRes = $_POST['kodeResi'];

		switch ($exped){
			case 1:
				$data = $GTrack->jne($noRes);
				break;
			case 2:
				$data = $GTrack->jnt($noRes);
				break;
			case 3:
				$data = $GTrack->tiki($noRes);
				break;
			case 4:
				$data = $GTrack->pos($noRes);
				break;
			case 5:
				$data = $GTrack->wahana($noRes);
				break;
			case 6:
				$data = $GTrack->siCepat($noRes);
				break;
			case 7:
				$data = $GTrack->ninjaXpress($noRes);
				break;
			case 8:
				$data = $GTrack->jetExpress($noRes);
				break;
			default:
				$ex = 0;
		}
	//var_dump($data);
	
	//cek resi
	//error 1 = resi mambu / tidak ada resi || error 0 = resi masih ada
	if(($data->error) == false){
		$err = 0;
	}else{
		$err = 1;
	}
	
	if($err == 0){
		//tanggal | pengirim | alamat tujuan | lokasi terkini | nomor resi
		$tglStr 		= $data->info->tanggal_kirim;
		$tanggal 		= date('Y-m-d h:i', strtotime($tglStr));
		$pengirim 		= $data->pengirim->nama;
		$alamatTujuan 	= $data->info->tujuan_pengiriman;
		$x 				= count($data->history) - 1;
		$lokasiSekarang = $data->history[$x]->posisi;
		$lokasiPesan 	= $data->history[$x]->message;
		$noRes;

		$sql = "
		insert into 
		resi (resi, tanggal, pengirim, alamat, lokasi, pesan, error)
		value ('$noRes', '$tanggal', '$pengirim', '$alamatTujuan', '$lokasiSekarang', '$lokasiPesan', $err)";
		mysqli_query($servConnQuery, $sql);
	}else{
		//hapus resi...
	}
}

//ambil data resi dari db
$sql = "select * from resi";
$run = mysqli_query($servConnQuery, $sql);

$arr = array();
while($row = mysqli_fetch_assoc($run)){
	$arr[] = $row;
}


?>