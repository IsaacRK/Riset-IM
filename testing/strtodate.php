<?php
$str	='18-10-2021 11:36';
$date	= strtotime($str);
echo date('Y-m-d h:i', $date);
?>