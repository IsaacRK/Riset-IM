<?php
//cek resi
require '../GTrack/vendor/autoload.php';
use GTrack\GTrack;
$GTrack = new GTrack();
$cek    = $GTrack->jne('011440046444019');
var_dump($cek);

echo $cek->message;
echo'</br>';
echo $cek->site;

?>