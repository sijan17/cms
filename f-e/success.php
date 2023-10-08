<?php
if($_COOKIE['signupsuccess']!=true){
    header('Location:login.php');
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
            <div style="border: 1px solid green; padding: 20px;border-radius: 20px;">
            <div class="topic">
                <h3 style="color:green;">Email Verification Required <i class="fa-regular fa-envelope"></i></h3>
            </div>
            
    
    
                <div class="" style="text-align:center;">
                    <!-- <p>We have got your sign up request. You will be notified when the college management accepts your request. It won't take so long. <br> <br> In case If you don't get any response <br> <a  style="color: blue;" href="contact.php">Contact Us. </a></p> -->
                    <p>Almost there! <br>Time to verify your email. <br>Check your email to verify.<br><br> <!-- In case If you don't get any response <br> <a  style="color: blue;" href="contact.php">Contact Us. </a></p> -->
                </div>
            
        </div>
            </form>
        </div>





            </div>

        </div>


    </div>



</body>

</html>