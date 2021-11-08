<?php
require_once 'conn.php';
?>
<!DOCTYPE html>
<html>
<head>
 <title>Verify</title>
</head>
<body>
<div id="wrap">
        <!-- start PHP code -->
        <?php

            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                $email = $servConnQuery -> real_escape_string($_GET['email']); // Set email variable
                $hash = $servConnQuery -> real_escape_string($_GET['hash']); // Set hash variable
                $search = "SELECT email, hash, active FROM pengguna WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
                $svf = mysqli_query($servConnQuery, $search); 
                $match  = mysqli_num_rows($svf);

                echo $match; 
                if($match > 0){
                    $update = "UPDATE pengguna SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
                    $running = mysqli_query($servConnQuery, $update);
                    echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
                    header("Location:../Dashboard.php");
                }else{
                    echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                }
            }else{
                echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
            }
        ?>
        <!-- stop PHP Code -->
 
         
    </div>
</body>
</html>