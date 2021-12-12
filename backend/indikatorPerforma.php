<?php
require'backend/conn.php';

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}
//ambil target harga
$sqlTarget='select * from target order by id desc limit 1';
$runTarget=mysqli_query($servConnQuery, $sqlTarget);
$rowTarget=mysqli_fetch_assoc($runTarget);
$target = $rowTarget['target'];

//ambil rata rata pemasukan seminggu
//harga diambil dari invoice 7 hari terakhir
$sqlRata = 'select * from invoice where date > now() - interval 7 day';
$runRata = mysqli_query($servConnQuery, $sqlRata);
$rata = 0;
while($rowRata = mysqli_fetch_assoc($runRata)){
	$rata = $rata + $rowRata['total_harga'];
}
if($rata != 0){
	$rata = round($rata/7);
}

//ambil total pembelian bulanan
//harga diambil dari rab bulan ini
$sqlBeli1 = "SELECT * FROM history WHERE MONTH(date) = MONTH(CURRENT_DATE()) and input = 1";
$runBeli1 = mysqli_query($servConnQuery, $sqlBeli1);

//menghitung performa

function hitung($a, $b){
	$c = $a/$b;
	return $c * 100;
}
$sqlTotal = "select * from invoice where MONTH(date) = MONTH(CURRENT_DATE())";
$runTotal = mysqli_query($servConnQuery, $sqlTotal);
$total = 0;
$persen = 0;
while($rowTotal = mysqli_fetch_assoc($runTotal)){
	$total = $total + $rowTotal['total_harga'];
}
if($target != null && $total != 0){
	$persen = hitung($total, $target);
}

?>