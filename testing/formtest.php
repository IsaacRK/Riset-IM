<?php
include"../backend/conn.php";
include'../backend/inputhandler.php';

?>
<html>
<head>

<script src="js/jquery3.6.0.min.js"></script>

<script>
	$(document).ready(function(){
		$("#divShow").load('a.php');
	})
</script>
</head>
<body>
	<div class="card">
		<div class="card-body" id="divChart" style="max-height:250px;max-width:500px">
			<div style="border:1px solid black;" id="divShow"></div>
		</div>
	</div>
</body>
</html>