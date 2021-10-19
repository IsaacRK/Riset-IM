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

	if(isset($_POST['update'])){
		$nama = $_POST['input1'];
		$tipe = $_POST['input2'];
		$juml = $_POST['input3'];
		$rak  = $_POST['input4'];
		$lan  = $_POST['input5'];
		$kol  = $_POST['input6'];
		$bar  = $_POST['input7'];
		
		echo '-----------</br>'.
			 $nama.'</br>'.
			 $tipe.'</br>'.
			 $juml.'</br>'.
			 $rak.'</br>'.
			 $lan.'</br>'.
			 $kol.'</br>'.
			 $bar.'</br>'.
			 '-----------</br>'
		;
	}
?>
<button type="button" onClick="jumper()">aaa</button></br>
<button type="button" onclick="sendData()">send</button></br>
<div id="target">10329302911</div>
</br>

				<form action="" method="post">
					<input type="text" name="input1" id="input1"></br>
					<select name="input2">
						<option value="001" class="dropdown-item">Elektronik</option>
						<option value="010" class="dropdown-item">Sekali Pakai</option>
						<option value="011" class="dropdown-item">Peralatan</option>
						<option value="100" class="dropdown-item">Lain-Lain</option>
					</select></br>
					<input required type="number" name="input3"></br>
					<select name="input4">
						<option value="1" class="dropdown-item">rak 1</option>
					</select></br>
					<select name="input5">
						<option value="1" class="dropdown-item">lantai 1</option>
						<option value="2" class="dropdown-item">lantai 2</option>
						<option value="3" class="dropdown-item">lantai 3</option>
						<option value="4" class="dropdown-item">lantai 4</option>
						<option value="5" class="dropdown-item">lantai 5</option>
					</select></br>
					<select name="input6">
						<option value="1" class="dropdown-item">kolom 1</option>
						<option value="2" class="dropdown-item">kolom 2</option>
						<option value="3" class="dropdown-item">kolom 3</option>
						<option value="4" class="dropdown-item">kolom 4</option>
						<option value="5" class="dropdown-item">kolom 5</option>
					</select></br>
					<select name="input7">
						<option value="1" class="dropdown-item">baris 1</option>
						<option value="2" class="dropdown-item">baris 2</option>
					</select></br>
					<input type="submit" name="update" value="update"/>
				</form>

<div id="display"></div>
<iframe src="https://google.com" style="height:200px;width:300px" title="Iframe Example"></iframe>
<script>


$(function(){
	$("#input1").autocomplete({
		source: '../backend/autocomplete.php'
	});
});
//-----------------------------
let timer;
const waitTime = 500;
const a = (txt) => {
	//http request here
	console.log(txt);
	document.getElementById('display').innerHTML = txt;
	checkDb(txt);
}
const input = document.querySelector('#input1');
input.addEventListener('keyup', (e)=> {
	const txt = e.currentTarget.value;
	clearTimeout(timer);
	timer = setTimeout(() => {
		a(txt);
	},waitTime);
});
function checkDb(txt){
	var val	= 'text='+txt;
	$.ajax({
		type:"GET",
		url:'a.php',
		data:val,
		success:function(result){
			//console.log(data)
			//location.reload();
			//$('#result').text('name: ' + result );
		},
		error:function(error){
			colsole.log('err ${error}')
		}
	})
}
//-------------------------------
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
