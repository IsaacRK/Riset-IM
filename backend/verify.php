<?php
require_once 'conn.php';
?>
<!DOCTYPE html>
<html>
<head>
 <title>Verify</title>
</head>
<body>
        <?php
            //Mendeteksi apakah pengguna masuk melalui surel
            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
             
                //Mengambil email dan hash dari alamat web
                $email = $servConnQuery -> real_escape_string($_GET['email']); 
                $hash = $servConnQuery -> real_escape_string($_GET['hash']);
             
                //Memeriksa apakah ada akun yang memiliki email dan hash yang sama
                $search = "SELECT email, hash, active FROM pengguna WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
                $svf = mysqli_query($servConnQuery, $search); 
                $match  = mysqli_num_rows($svf);
                if($match > 0){
                    //Mengatifkan akun
                    $update = "UPDATE pengguna SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
                    $running = mysqli_query($servConnQuery, $update);
                    header("Location:../Dashboard.php");
                }else{
                    echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                }
            }else{
                echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
            }
        ?>
</body>
</html>
