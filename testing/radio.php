<?php
if(isset($_POST["submit"])){
	echo $_POST['txt'];
}

?>

<button onclick="radio0()">tombol 0</button>
<button onclick="radio1()">tombol 1</button>

<form method="post">

	<input type="radio" name="metodeBayar" id="metodeBayar0" value="0" >radio0
	<input type="radio" name="metodeBayar" id="metodeBayar1" value="1" >radio1
	
	<input type="text" name="txt" id="txt">

	<input type="submit" name="submit" value="submit">
</form>
<script>
	function radio0(){
		document.getElementById("metodeBayar0").checked = true;
		document.getElementById("txt").value = "nol";
	}
	
	function radio1(){
		document.getElementById("metodeBayar1").checked = true;
		document.getElementById("txt").value = "satu";
	}
</script>
