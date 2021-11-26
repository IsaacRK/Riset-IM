<?php
	require '../backend/conn.php';
	require '../backend/usersession.php';
	require '../backend/checkouthandler.php';
?>
<html>
<head>
	<?php include_once"../layout/header.php" ?>
</head>
<body>
<div class="content">
<div class="container">

	<div class="card">
		<div class="card-body">
			<?php require '../backend/carthandler.php'; ?>
		</div>
	</div>

</div>
</div>
</body>
</html>