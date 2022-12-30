<?php 
 require 'public_auth.php';
  $contact = $obj_admin->display('swastik_contact','contact_id');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../style/style-public.css">
    <style>
        i{
            padding:  5px 10px;
        }
       .contact a{
            color: blue;
        }

    </style>


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
                    <a href="index.html"  id="about-us">About Us</a>
                    <a href="#" class="active" id="contact">Contact</a>
                    <a href="login.php" id="login">Log In</a>
                    <a href="register.php" id="register">Register</a>
                </div>

            </div>
        </div>
        <div class="body">



            <div class="content">

                <div class="contact" style=" margin: 0 auto; ">
                <h3 class="topic">Swastik College</h3>

                <iframe style="margin: 10px;" src="<?php echo $contact[0]['contact_maplink'] ?>" style="border:0" allowfullscreen="" width="80%" height="220" frameborder="0"></iframe>
                <div class="more" style="margin:0 auto;;">
                <p><i class="fa-solid fa-location-dot"></i> <?php echo $contact[0]['contact_address'] ?></p>  
                <p><i class="fa-solid fa-phone"></i><a href="tel:+977-<?php echo $contact[0]['contact_no'] ?>">+977-<?php echo $contact[0]['contact_no'] ?></a></p>
                <p><i class="fa-solid fa-envelope"></i><a href="mailto:<?php echo $contact[0]['contact_email'] ?>"> contact@swastikcollege.edu.np</a></p>
                <p><i class="fa-solid fa-bullhorn"></i><a href="tel:<?php echo $contact[0]['contact_noticeno'] ?>"> <?php echo $contact[0]['contact_noticeno'] ?> </a></p>

            </div>
            </div>



            </div>

        </div>


    </div>



</body>

</html>