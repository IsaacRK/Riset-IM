	<?php
	include "../backend/conn.php";
	include "../backend/usersession.php";
	echo $userlvl;
	echo '</br>';
	
	if($userlvl != 'supervisor'){
		echo 'not supervisor';
	}else{
		echo 'supervisor';
	}
	
	echo '</br>';
	
	if($userlvl != 'staff' || 'operator'){
		echo 'not staff or operator';
	}else{
		echo 'staff or operator';
	}
	echo '</br>';
	$op = 'operator';
	if($op != 'operator'){
		echo 'aaaaaaaaa';
	}
	?>
	<body>
	
	</body>