<?php
$arr = array(0,5,0,5,5,5,0,0);
print_r($arr);
echo'</br>';
echo'jumlah total: '.array_sum($arr).'</br>';

$arIn = count($arr);
echo 'index: '.$arIn.'</br>';

$count=0;
for($i=0;$i<$arIn;$i++){
	if($arr[$i]!=0){
		$count++;
	}
}
echo 'bukan 0: '.$count.'</br>';

$rata = array_sum($arr)/$count;
echo 'rata: '.$rata.'</br>';
?>