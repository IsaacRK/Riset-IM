<?php

require 'backend/conn.php';
require 'backend/usersession.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
  <style>
   .ikon{
  	object-fit: cover;
  	width:  200px;
  	height: 200px;
  	border-radius:50%;
    }
    .sfa{
      width: 130%;
    }
   @media screen and (max-width:800px) {
    .ikon{
  	object-fit: cover;
  	width:  100px;
  	height: 100px;
  	border-radius:50%;
    }
    .sfa{
      width: 100%;
    }
      }
  </style>
</head>

<body>
<?php
if ($userAC == '0'){ ?>
<form action="backend/upload.php" method="post" enctype="multipart/form-data">    
<div class="container mt-5">
 <div class="card border border-secondary">
  <div class="card-body text-center">
   <div class="row card border-0 mb-1">
    <div class="col">
     <div class="p-1">
		<div class="mb-0">
			<h1>Ikon Akun</h1>
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
 
<?php
}
else { 	include "layout/sidebar.php";
?>

 <div class="content">
 <div class="container mr-0">
   <div class="row">
     <div class="col-1"></div>
     <div class="col-10">
       <div class="row mt-5 border card un">
         <div class="row">

           <div class="col-sm ms-1 text-center mt-2">
            <form action="backend/upload.php" method="post" enctype="multipart/form-data">
              <div class="col">              
               <img src="<?php echo'Photo/'.$Foto_05;?>" class="ikon my-1">
                <h3 class="text-primary">Ikon Akun</h3>
              </div>
            
              <div class="row mt-2">
               <div class="col">
                 <label for="fileToUpload" class="forl-label">Ganti ikon :</label>
                  <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile(this);">
               </div>              
             </div>

             <div class="row mt-2">
                <div class="col">
                  <h3 class="text-primary">Ikon Baru</h3></br>
                  <img id="previewImg" alt="placeholder" class="ikon"></img>
                </div>
              </div>
            
             <div class="row card border-0 mt-3 mb-3">
              <div class="col">
               <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
              </div>
             </div>

            </form>
           </div>

           <div class="col-sm">
            <div class="row card border-0 text-center mb-2">
               <div class="col mb-2">
                 <h2>Ganti Informasi Akun</h2>
               </div>
            </div>
            <div class="row border-0">
             <div class="col">
               <form action="backend/edit.php" method="post">

                 <div class="row border-0 mb-2">
                   <div class="col mb-2">
                     <span class="">Nama : </span></br>
                     <input class=""  type="text" name="user" id="" placeholder="<?php echo $username;?>"/>
                   </div>
                   <div class="col d-flex justify-content-center">
                     <button class="btn btn-primary mb-3 mt-3" type="submit" name="submit" value="Ganti">Ganti Nama</button>
                   </div>
                 </div>

                 <div class="row border-0 mb-2">
                    <div class="col-sm">
                      <div class="row">
                  <div class="col-sm mb-2">
                   <span class="">Kata Sandi : </span></br>
                   <input class="" style="" type="password" name="pass" id=""/>
                  </div>
                  <div class="col-sm mb-2">
                   <span class="">Konfirmasi Kata Sandi : </span></br>
                   <input class="" style="" type="password" name="passcon" id=""/>
                  </div>
                      </div>
                    </div>
                  <div class="col-sm d-flex justify-content-center">
                   <button class="btn btn-primary my-3 mx-5" type="submit" name="submit" value="register">Ganti Kata Sandi</button>
                  </div>
                 </div>

                 <div class="row border-0 mb-2">
                   <div class="col-sm mb-2">
                     <span class="">Email :</span></br>
                     <input class="sfa" type="text" name="email" id="" placeholder="<?php echo $userEM;?>"/>
                   </div>
                   <div class="col d-flex justify-content-center">
                     <button class="btn btn-primary mb-3 mt-3" type="submit" name="submit" value="register">Ganti Email</button>
                   </div>
                 </div>


               </form>
             </div>
           </div>
           </div>



         </div>
       </div>
     </div>
   </div>
 </div>
</div>

<?php
}
?>
<?php
	include"layout/js.php";
?>
</body>
</html>
