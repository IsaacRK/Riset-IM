<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<?php include"layout/header.php"?>	
	<script>
		function previewFile(input){
			var file = $("input[type=file]").get(0).files[0];
			
			if(file){
				var reader = new FileReader();
				reader.onload = function(){
					$("#previewImg").attr("src", reader.result);
				}
				reader.readAsDataURL(file);
			}
		}
	</script>
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
		<div class="mb-3">
			<label for="fileToUpload" class="forl-label">Select image to upload:</label>
			<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile(this);">
			<img id="previewImg" alt="placeholder"></img>
			<input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
		</div>
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