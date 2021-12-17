<?php

include'../backend/conn.php';
$sql = "select * from history order by history_id desc limit 1";
$run = mysqli_query($servConnQuery, $sql);
$row = mysqli_fetch_assoc($run);
$tgl = date_create($row['date']);
echo date_format($tgl, 'd-m');

?>