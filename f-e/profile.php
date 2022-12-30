<?php
require 'auth.php';

if(isset($_POST['post'])){
    $post = $obj_admin->post_notice($_POST);
}
if(isset($_POST['submit'])){
$change = $obj_admin->changeImage($_FILES['file']);
}


$notices = $obj_admin->display('swastik_notices','notice_id');
$resources = $obj_admin->display('swastik_resources','resource_id');


$assi = $obj_admin->display('swastik_assignments','assi_id');
if(isset($_POST['download'])){
    $download = $obj_admin->download_assi($_POST);
}
if(isset($_POST['open'])){
    $open = $obj_admin->open_assi($_POST);
}
$user_info = $obj_admin->edit("user_image","swastik_users","user_id",$_SESSION['user_id']);




if(isset($_POST['upload-note'])){
    $post = $obj_admin->upload_note($_POST, $_FILES['note_file']);
    
}
if(isset($_POST['download'])){
    $download = $obj_admin->download_notes($_POST);
}
if(isset($_POST['open'])){
    $download = $obj_admin->open_notes($_POST);
}

$note = $obj_admin->display('swastik_notes','note_id');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../style/style-d.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <style type="text/css">
        .user-info p{
            padding: 6px;
        }
               table{
            margin-bottom: 20px;
        }
        input{
            display: block;
            margin: 8px 0;
            padding: 3px;
            border-radius: 5px;
            outline: none;
            border: 1px solid black;
            height: 30px;
        }
        input[type=submit]{
             font-size: small;
             color: white;
             background-color: #04aa6d;
             border: none;
             padding: 6px;
        }
        .image{
            float: right; 
            margin-right: 30px;
            display: block;
            align-items: center;


        }
        .user-info img{
            height: 100px;
            width: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        input[type=file]{
            width: 86px;
            padding: 0px;
            font-size: small;
            padding: 3px 20px;
            border: none;

        }
        #hidden{
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="fixed-nav">
            <div class="left-div">
                <div class="fixed-logo">
                    <div class="logo-section"><img src="../img/swastik-logo-red.png"></div>
                </div>
                <div class="fixed-menu">
                    <div class="menu-section">
                        <li><a href="home.php"><i class="fa-solid fa-house"></i><span
                                    class="title">Home</span></a></li>
                        <li><a href="assignment.php"><i class="fa-solid fa-clipboard-list"></i><span
                                    class="title">Assignment</span></a></li>
                        <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                        <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                        <li><a href="feedback.php"><i class="fa-solid fa-comment"></i><span class="title">Feedback</span></a></li>
                        <li><a href="#" class="active"><i class="fa-solid fa-user"></i><span class="title">Profile</span></a></li>
                        <li><a href="logout.php" onClick="return confirm('Are you sure you want to log out?')"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="title">Log Out</span>
              
                        </a></li>
                    </div>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="title">
                <h3>PROFILE</h3>
            </div>

            <div class="user-info">
            <span class="image">
                <img src="../user-img/<?php echo $user_info['user_image']; ?>">
                <form method="post" name="uploadImage" enctype="multipart/form-data">
                    <input id="form-img" type="file" name="file">
                    <span style="display:none"><input type="submit" id="submit-form" name="submit" value="Change"></span>
                </form>
                
            </span>
            <table>
            <tr><td> Name :</td> <td> <?php echo  $_SESSION['user_fullname'] ?></td></tr>
          <tr><td>Role : </td><td> <?php if($_SESSION['user_permission'] == 0){
                echo "Student"; }
                elseif($_SESSION['user_permission'] == 1){
                    echo "Teacher";
                }
                else{
                    echo "Admin";
                }
                  ?>
                  </td>
              </tr>
              <tr><td> Reg. No.       :</td> <td> <?php echo $_SESSION['user_regno'] ?> 
              <tr> 
                <td>   Faculty  : </td><td>  <?php if($_SESSION['user_faculty']!=NULL){
                           if($_SESSION['user_faculty']==0){
                              echo "BCA"; }
                          else{
                           if($_SESSION['user_faculty']==1){
                               echo "CSIT"; 
                             }
                           }
                           } ?> </td> </tr>
               <tr> <td> Semester :</td> <td><?php echo $_SESSION['user_semester'] ?> </td> </tr>
                <tr><td> Email       :</td> <td> <?php echo $_SESSION['user_email'] ?> 
                <!-- <a style="color:blue" id="change">Change</a> -->
            </td>
                </tr>
                <tr>
                    <td></td>
                    <td> <input id="hidden"  type="text" name="email" placeholder="New Email"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input id="hidden" type="submit" name="submit" value="Change"></td>
                </tr>
            </table>
                <a onclick="changePw">Change Password </a> <td>
                <div class="password">
                    <form method="post" action="changepw.php">
                        <input type="password" name="cp" placeholder="Current Password">
                        <input type="password" name="np" placeholder="New Password">
                        <input type="submit" name="submit" value="Change">
                    </form>

                <?php if(isset($_COOKIE['message'])){ ?>
                <div class="message"><p style="color:green"><?php echo $_COOKIE["message"]; ?> </p></div>
                <?php } ?>

                </div>
            </div>


    </div>
            
            

        

        <div class="right-div">
            <div class="title"><h3>Recommended External resources:</h3></div>
            <div class="resource-content">
                <ul>
                    <?php foreach($resources as $r){ ?>
                    <li><a href="<?php echo $r['resource_link'] ?>">🔰<?php echo $r['resource_title'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>



    
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript">


    $("#change").click(function(){
        $("#hidden").slideDown(100);
    })


    function submitform()
    {
      
      document.forms["uploadImage"].submit();
    }


    var auto_refresh = setInterval(
    function()
    {
    var image = document.getElementById("form-img").value;
    
    if(image!=""){
        document.getElementById("submit-form").click();

    }
    }, 1000);
    </script>


</body>

</html>