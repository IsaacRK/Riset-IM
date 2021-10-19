<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<?php include"layout/header.php"?>	
</head>

<body>
<?php
	include"layout/sidebar.php";
?>
<div class="content">
 <div class="container mr-0">
 <div class="p-1">
		<div class="mb-3">
			<h1>Profile</h1>
		</div>
	</div>

  <div class="row mb-2 ml-2">
		<div class="col-7">
    <form action="backend/upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    </form>
    </div>
  </div>
 </div>
</div>
<?php
	include"layout/js.php";
?>
</body>
</html>