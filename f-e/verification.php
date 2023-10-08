<?php
require 'public_auth.php';
if(isset($_GET['secret'])) {
    $secret = $_GET['secret'];
    $verify = $obj_admin->verifyEmail($secret);

}else{
    echo "<h2> Permission Denied </h2>";
    die();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>LogIn</title>
    <link rel="stylesheet" href="../style/style-public.css">
    <link rel="stylesheet" href="../style/style-public-form.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">


</head>

<body>
    <div class="bg-img"></div>

    <div class="container">
        <div class="fixed">
            <div class="header">

                <div class="logo-section">
                    <img src="../img/swastik-logo-red.png">
                </div>

                <div class="menu-section">
                    <a href="index.html" id="about-us">About Us</a>
                    <a href="contact.php" id="contact">Contact</a>
                    <a href="login.php"  id="login">Log In</a>
                    <a href="register.php" class="active" id="register">Register</a>
                </div>
            </div>
        </div>
        <div class="body">

            <div class="content">


        <div class="form">
            <div style="border: 1px solid <?php if($verify){echo "green";}else{echo "red";} ?> ; padding: 20px;border-radius: 20px;">
            <div class="topic">
                <?php if($verify){ ?>
                <h3 style="color:green;">Email Address Verified ! <i class="fa-solid fa-envelope-circle-check"></i></h3>
            <?php }else{ ?> 
                <h3 style="color:red;">Invalid Link</h3>
            <?php } ?>
            </div>
            
    
                
                <div class="" style="text-align:center;">
                    <p>
                        <?php if($verify){ ?>
                            Your email address has been verified. You will be notified when college management validates your data. <br> <br> In case If you don't get any response <br> <a  style="color: blue;" href="contact.php">Contact Us. </a>
                        <?php } else{ ?>
                             That is not a valid link. 

                        <?php } ?>
                        </p>   
                        
                </div>
                
            
        </div>
            </form>
        </div>





            </div>

        </div>


    </div>




</body>

</html>