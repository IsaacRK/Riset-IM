<?php

include'../backend/conn.php';
include'../backend/usersession.php';

echo'<h3>Invoice ID Generator</h3></br>';
echo' | format</br>';
echo' | INV/DATE/USER_ID/SERIAL_NUM</br>';

$date = date('Ymd');
$inv = 'INV/'.$date.'/'.$userId.'/serialNum';

echo '</br>'.$inv.'</br>';
echo'</br>';

echo'serial Num -> dihitung dari invoice hari yang sama</br>';
echo'|.................|-> jika belum ada invoice pada satu hari maka serialNum = 1</br>';
echo'|.................|-> jika ada invoice pada satu hari dengan user yang sama maka serialNum = serialNum + 1</br>';
echo'|.................|-> serialNum akan reset pada hari berikutnya, hari 1 = serialNum 1; hari 1 = serialNum 2; hari 2 = serialNum 1; dan seterusnya</br></br>';

echo substr($inv , strrpos($inv, "/") + 1);
?>