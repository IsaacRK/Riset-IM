<?php
include'../layout/header.php';
require '../backend/conn.php';
require '../backend/usersession.php';

$arr=array();
$var=0;
for($i=0; $i<=7; $i++){
	$chartFetchQuery = "SELECT * FROM `history` WHERE input = '1' and date = date_sub(CURRENT_DATE, interval $i day)";
	$chartFetchRun = mysqli_query($servConnQuery, $chartFetchQuery);
	$var=0;
	if(mysqli_num_rows($chartFetchRun)>0){
		while($chartFetch = mysqli_fetch_assoc($chartFetchRun)){
			echo$i.'-';
			echo $chartFetch['amount'].'-';
			echo$var = $var+$chartFetch['amount'];
			echo'</br>';
		}
	}
	array_push($arr,$var);
}
echo'['.$arr[0].','.$arr[1].','.$arr[2].','.$arr[3].','.$arr[4].','.$arr[5].','.$arr[6].','.$arr[7].']';