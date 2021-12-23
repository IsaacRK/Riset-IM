<?php
require 'conn.php';
require 'usersession.php';

//Mengambil ID akun pengguna
$Id_Prof = $_SESSION["uid"];   
$user_prof = $username;

//Menunjuk directory
$target_dir = "../Photo/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//Melihat apakah file gambar gambar asli atau palsu
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
    header('location:../Profile.php');
  }
}

//Melihat apakah file berformat JPG, JPEG, PNG atau GIF
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

//Melihat apakah $uploadOk bernilai 0 dari sebuah error sebelumnya
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  
  //Mengupload file apabila $uploadOk tetap bernilai 1
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      
      //Mengambil file dan nama dari form
      $filename = $_FILES["fileToUpload"]["name"];
      
      //Melihat apakah sudah ada gambar yang diasosiasikan dengan akun pengguna      
      $SRCID_01 = "select * from image where user_id = '$Id_Prof'";
      $SRCID_02 = mysqli_query($servConnQuery, $SRCID_01);
      $SRCID_03 = mysqli_num_rows($SRCID_02);
      $SRCID_04 = mysqli_fetch_assoc($SRCID_02);
      
      //Apabila tidak ada      
      if ($SRCID_03 == ""){

        //Mengambil semua data yang diperlukan
        $sql = "INSERT INTO image (user_id, username, filename) VALUES ('$Id_Prof', '$user_prof', '$filename')";
        mysqli_query($servConnQuery, $sql);

       //Melihat apakah user telah melakukan verifikasi        
       if ($userAC == '0'){
        header("Location:../Verifyno.php");
      }else{
        header("Location:../Profile.php");
      }
        //Apabila ada gambar yang diasosiasikan dengan akun pengguna
      } else {
        $Delete_03 = $SRCID_04['filename'];
        $file_pointer = "../Photo/$Delete_03";
        
        //Menghapus nama file di database
        $Delete_01 = "DELETE FROM image WHERE user_id = '$Id_Prof'";
        $Delete_02 = mysqli_query($servConnQuery, $Delete_01);
        //Menghapus gambar dari file directory  
        if (!unlink($file_pointer)) { 
        }
        else {   
        } 
 
        $sql = "INSERT INTO image ( user_id, username, filename) VALUES ('$Id_Prof', '$user_prof', '$filename')";
        mysqli_query($servConnQuery, $sql);

        header("Location:../Profile.php");
      }

    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
?>
