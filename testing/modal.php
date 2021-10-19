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
			$var = $var+$chartFetch['amount'];
		}
	}
	array_push($arr,$var);
}
echo'['.$arr[0].','.$arr[1].','.$arr[2].','.$arr[3].','.$arr[4].','.$arr[5].','.$arr[6].','.$arr[7].']';
?>
<html>
<body>
<iframe src="https://stackoverflow.com/questions/12032664/load-a-html-page-within-another-html-page" name="targetframe" allowTransparency="true" scrolling="no" frameborder="0" >
    </iframe>
</body>
</html>