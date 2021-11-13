<?php

$data = $_POST['image'];

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$data = base64_decode($data);
$imgNm = time().'.png';
file_put_contents('../Photo/'.$imgNm, $data);
?>