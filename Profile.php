<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Informasi Akun</title>
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
if ($userAC == '0'){
echo '
<form action="backend/upload.php" method="post" enctype="multipart/form-data">    
<div class="container mt-5">
 <div class="card border border-secondary">
  <div class="card-body text-center">
   <div class="row card border-0 mb-1">
    <div class="col">
     <div class="p-1">
		<div class="mb-0">
			<h1>Profile</h1>
		</div>
	 </div>
    </div>
   </div>
   <div class="row card border-0 mb-1">
    <div class="col">
		<div class="mb-3">
			<label for="fileToUpload" class="forl-label">Select image to upload:</label>
			<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile(this);">
		</div>
    </div>
   </div>
   <div class="row card border mb-1">
    <div class="col">
    <img id="previewImg" alt="placeholder"></img>
    </div>
   </div>
   <div class="row justify-content-between mt-3">
    <div class="col-4">
    <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
    </div>
    <div class="col-4">
    <a class="btn btn-light border border-secondary" href="Verifyno.php">Lewati <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
		<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
	  </svg></a>
    </div>
  </div>
  </div>
 </div>
</div>
</form>
 
';
}
else {
	include "layout/sidebar.php";
 echo '
<div class="row">
<div class="col-2"></div>
 <div class="col-10">
 <div class="container d-flex justify-content-center">
 <div class="card mt-5 border border-secondary" style="width:70%">
  <div class="card-body">

    <div class="row card border-0 text-center mb-2">
     <div class="col mb-2">
			<h2>Ganti Informasi Akun</h2>
     </div>
    </div>

    <div class="row border-0">
     <div class="col">
  <form action="backend/edit.php" method="post">
        <div class="row justify-content-between border mb-2">
         <div class="col mb-2">
          <span class="">Nama : </span></br>
          <input class=""  type="text" name="user" id=""/>
         </div>
         <div class="col d-flex justify-content-end">
              <button class="btn btn-primary mb-1 mt-1" type="submit" name="submit" value="Ganti">Ganti</button>
         </div>
        </div>

        <div class="row border mb-2">
         <div class="col-sm mb-2">
          <span class="">Kata Sandi : </span></br>
          <input class="" style="" type="password" name="pass" id=""/>
         </div>
         <div class="col-sm mb-2">
          <span class="">Konfirmasi Kata Sandi : </span></br>
          <input class="" style="" type="password" name="passcon" id=""/>
         </div>
         <div class="col d-flex justify-content-end">
              <button class="btn btn-primary mb-1 mt-1" type="submit" name="submit" value="register">Ganti</button>
         </div>
         </div>

        <div class="row border mb-2">
         <div class="col-sm mb-2">
          <span class="">Email :</span></br>
          <input class="" style="" type="text" name="email" id=""/>
         </div>
           <div class="col d-flex justify-content-end">
              <button class="btn btn-primary mb-1 mt-1" type="submit" name="submit" value="register">Ganti</button>
           </div>
        </div>

  </form>
     </div>

    </div>

  </div>
 </div>
 </div>
<form action="backend/upload.php" method="post" enctype="multipart/form-data">    
 <div class="container mt-5">
  <div class="card border border-secondary">
   <div class="card-body text-center">
    <div class="row card border-0 mb-1">
     <div class="col">
      <div class="p-1">
	 	<div class="mb-0">
			<h1>Profile</h1>
		</div>
	  </div>
     </div>
    </div>
    <div class="row card border-0 mb-1">
     <div class="col">
		 <div class="mb-3">
			<label for="fileToUpload" class="forl-label">Select image to upload:</label>
			<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile(this);">
		 </div>
     </div>
    </div>
    <div class="row card border mb-1">
     <div class="col">
     <img id="previewImg" alt="placeholder"></img>
     </div>
    </div>
    <div class="row card border-0 mt-3">
     <div class="col">
     <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
     </div>
   </div>
   </div>
  </div>
 </div>
</form>
 </div>
</div>

 ';
}
?>
<?php
	include"layout/js.php";
?>
</body>
</html>
