<?php
require '../layout/header.php';
$num = array(
	1,2,3,4,5,6,7,8,9,10,
	11,12,13,14,15,16,17,18,19,20,
	21,22,23,24,25,26,27,28,29,30,
	31,32,33,34,35,36,37,38,39,40,
	41,42,43,44,45,46,47,48,49,50
);

$maxArr = count($num);

$filter_even = function($item){
	return($item % 2)== 0;
};

$filter_odd = function($item){
	return($item & 1);
};

//$even = array_filter($num, $filter_even);
//$odd = array_filter($num, $filter_odd);

function filter_even_tes($var){
	return($var = $var % 2)==0;
};
function filter_odd_tes($var){
	return($var = $var & 1);
};

function divideByTen($x){
	return($x = $x/10);
}
$var = 43;
$end = divideByTen($var);
echo round($end,0,PHP_ROUND_HALF_DOWN);
echo'</br>';
for($i=0;$i<$end;$i++){
	$ec = '';
	for($a=1;$a<=10;$a++){
		$ec = $ec.'['.$a.']';
	}
	echo $ec;
	echo'</br>';
}


/*
for($i=0; $i<$maxArr; $i++){
	$even = array_filter($i,$filter_even);
	if($num[$i]==isset($even[$i])){
		echo
			$num[$i].'</br>'
		;
		
	}
}
for($i=0; $i<$maxArr; $i++){
	if($num[$i]==isset($odd[$i])){
		echo $num[$i].'</br>';
	}
}

*/

/*
$mappingQuery = "select * from penyimpanan where lantai = '1' and  baris = '1'";
$mappingRun = mysqli_query($servConnQuery, $mappingQuery);
if(mysqli_num_rows($mappingRun) > 0){
	while($mappingFetch = mysqli_fetch_assoc($mappingRun)){
		if($mappingFetch['stock_id']==null){
			echo'
				<div class="col p-1 d-flex justify-content-center">
					<div class="shadow-sm border rounded rak-box color-tertiary">
						'.$mappingFetch['storage_id'].'
					</div>
				</div>
			';
		}else{
			echo'
				<div class="col p-1 d-flex justify-content-center">
					<div class="shadow-sm border rounded rak-box color-primary">
						'.$mappingFetch['storage_id'].'
					</div>
				</div>
			';
		}
	}
}*/

if(isset($_GET['barcode'])){
	echo'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</br>';
}

?>
<button type="button" onClick="jumper()">aaa</button></br>
<button type="button" onclick="sendData()">send</button></br>
<div id="target">10329302911</div>



<script>

function jumper(){
	var target = document.getElementById('target').innerHTML;
	location.href = window.location.href+"?barcode="+target;
}

function btnForm(){
	var target = document.getElementById('target').innerHTML;
	document.write('<form action="" method="post" id="a">');
	document.write('<input type="hidden" value="');document.write(target);document.write('">');
	document.write('</form>');
	document.write('<div>aaaa</div>');
}

function sendData(){
	var target 		= document.getElementById('target').innerHTML;
	var dataSend	= {barcode:target};
	$.ajax({
		type:"GET",
		data:dataSend,
		success:function(result){
			//console.log(data)
			//location.reload();
			 $('#result').text('name: ' + result );
		},
		error:function(error){
			colsole.log('err ${error}')
		}
	})
}
</script>
