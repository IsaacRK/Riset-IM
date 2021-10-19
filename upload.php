<?php
require 'conn.php';
require 'usersession.php';
$Id_Prof = $_SESSION["uid"];   
$user_prof = $username;
$target_dir = "D:/Xampp/htdocs/Riset-IM-Main_02/Photo/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      $filename = $_FILES["fileToUpload"]["name"];
      
      
      $SRCID_01 = "select filename from image where user_id = '$Id_Prof'";
      $SRCID_02 = mysqli_query($servConnQuery, $SRCID_01);
      $SRCID_03 = mysqli_num_rows($SRCID_02);
      if ($SRCID_03 == ""){

        // Get all the submitted data from the form
        $sql = "INSERT INTO image (user_id, username, filename) VALUES ('$Id_Prof', '$user_prof', '$filename')";
  
        // Execute query
        mysqli_query($servConnQuery, $sql);

        header("Location:../Profile.php");
      } else {
        
        $Delete_01 = "DELETE FROM image WHERE user_id = '$Id_Prof'";
        $Delete_02 = mysqli_query($servConnQuery, $Delete_01);

        // Get all the submitted data from the form
        $sql = "INSERT INTO image ( user_id, username, filename) VALUES ('$Id_Prof', '$user_prof', '$filename')";
  
        // Execute query
        mysqli_query($servConnQuery, $sql);

        header("Location:../Profile.php");
      }

    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
?>