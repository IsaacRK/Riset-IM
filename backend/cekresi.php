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

//input resi
if(isset($_POST['kirimKR'])){
	$exped = $_POST['exped'];
	$noRes = $_POST['kodeResi'];

		switch ($exped){
			case 1:
				$data = $GTrack->jne($noRes);
				$exped = 'JNE';
				break;
			case 2:
				$data = $GTrack->jnt($noRes);
				$exped = 'J&T';
				break;
			case 3:
				$data = $GTrack->tiki($noRes);
				$exped = 'TIKI';
				break;
			case 4:
				$data = $GTrack->pos($noRes);
				$exped = 'POS';
				break;
			case 5:
				$data = $GTrack->wahana($noRes);
				$exped = 'Wahana';
				break;
			case 6:
				$data = $GTrack->siCepat($noRes);
				$exped = 'SICEPAT';
				break;
			case 7:
				$data = $GTrack->ninjaXpress($noRes);
				$exped = 'Ninja Xpress';
				break;
			case 8:
				$data = $GTrack->jetExpress($noRes);
				$exped = 'JET Express';
				break;
			default:
				echo'error pada "backend/cekresi.php"';
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

		//cek apakah resi sudah ada di database
		$cek = "select * from resi where no_resi = '$noRes'";
		$cekRun = mysqli_query($servConnQuery, $cek);
		if(mysqli_num_rows($cekRun)==null){
			$insert = "
			insert into 
			resi (no_resi, expedisi, tanggal, pengirim, alamat, lokasi, pesan, error)
			value ('$noRes', '$exped', '$tanggal', '$pengirim', '$alamatTujuan', '$lokasiSekarang', '$lokasiPesan', $err)";
			mysqli_query($servConnQuery, $insert);
		}else{
			echo'<script>alert("Nomor Resi sudah ada")</script>';
		}
	}else{
		//hapus resi...
	}
}


//refresh informasi struk
if(isset($_POST['refreshStruk'])){
	$sql = "select * from resi where error = 0";
	$run = mysqli_query($servConnQuery, $sql);
	while($data = mysqli_fetch_assoc($run)){
		$id = $data['id'];
		$noRes = $data['no_resi'];
		$exped = $data['expedisi'];
		
		switch ($exped){
			case "JNE":
				$data = $GTrack->jne($noRes);
				$exped = 'JNE';
				break;
			case "J&T":
				$data = $GTrack->jnt($noRes);
				$exped = 'J&T';
				break;
			case "TIKI":
				$data = $GTrack->tiki($noRes);
				$exped = 'TIKI';
				break;
			case "POS":
				$data = $GTrack->pos($noRes);
				$exped = 'POS';
				break;
			case "Wahana":
				$data = $GTrack->wahana($noRes);
				$exped = 'Wahana';
				break;
			case "SICEPAT":
				$data = $GTrack->siCepat($noRes);
				$exped = 'SICEPAT';
				break;
			case "Ninja Xpress":
				$data = $GTrack->ninjaXpress($noRes);
				$exped = 'Ninja Xpress';
				break;
			case "JET Express":
				$data = $GTrack->jetExpress($noRes);
				$exped = 'JET Express';
				break;
			default:
				echo'error pada "backend/cekresi.php"';
		}
		
		if(($data->error) == false){
			$err = 0;
		}else{
			$err = 1;
		}
		
		if($err == 0){
			$tglStr 		= $data->info->tanggal_kirim;
			$tanggal 		= date('Y-m-d h:i', strtotime($tglStr));
			$pengirim 		= $data->pengirim->nama;
			$alamatTujuan 	= $data->info->tujuan_pengiriman;
			$x 				= count($data->history) - 1;
			$lokasiSekarang = $data->history[$x]->posisi;
			$lokasiPesan 	= $data->history[$x]->message;
			$noRes;
		
			$upd = "update resi set alamat='$alamatTujuan', lokasi='$lokasiSekarang', pesan='$lokasiPesan', error='$err' where id='$id'";
			mysqli_query($servConnQuery, $upd);
		}else{
			$upd = "update resi set error='$err' where id='$id'";
			mysqli_query($servConnQuery, $upd);
		}
	}
}


//ambil data untuk di tampilkan
$sql = "select * from resi";
$run = mysqli_query($servConnQuery, $sql);

$arr = array();
while($row = mysqli_fetch_assoc($run)){
	$arr[] = $row;
}
?>