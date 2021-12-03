<?php
include"../backend/conn.php";
?>
<html>
<head>
<?php include"../layout/header.php";?>
<head>
<body>

<?php
setlocale (LC_TIME, 'INDONESIA');
$date = strftime( "%A, %d %B %Y %H:%M", time());
echo "Saat ini: ".$date;
echo'</br>';
setlocale (LC_TIME, 'INDONESIA');
echo "Saat ini: ".$date;
?>

<script>
</script>
</body>
</html>