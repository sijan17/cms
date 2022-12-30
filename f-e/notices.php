<?php
require 'auth.php';

if(isset($_POST['post'])){
    $post = $obj_admin->post_notice($_POST);
}


$notices = $obj_admin->display('swastik_notices','notice_id');
$resources = $obj_admin->display('swastik_resources','resource_id');



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>Notices</title>
    <link rel="stylesheet" href="../style/style-d.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">

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
                        <li><a href="home.php" ><i class="fa-solid fa-house"></i><span
                                    class="title">Home</span></a></li>
                        <li><a href="assignment.php"><i class="fa-solid fa-clipboard-list"></i><span
                                    class="title">Assignment</span></a></li>
                        <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                        <li><a href="#" class="active"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                        <li><a href="feedback.php"><i class="fa-solid fa-comment"></i><span class="title">Feedback</span></a></li>
                        <li><a href="profile.php"><i class="fa-solid fa-user"></i><span class="title">Profile</span></a></li>
                        <li><a href="logout.php" onClick="return confirm('Are you sure you want to log out?')"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="title">Log Out</span>
              
                        </a></li>
                    </div>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="title">
                <h3>HOME</h3>
               
            </div>

            <div class="contents">


                    <?php
                    if($_SESSION['user_permission']==1 || $_SESSION['user_permission']==10){ ?>
    
    
                    <div class="notice post-assignment">
                        <form class="teachers-form" method="post" enctype="multipart/form-data">

                            <textarea name="notice_content" placeholder="Post Notice"></textarea>
                               
                            <input type="submit" name="post" value="Post">
                        </form>
                        <div class="message"><?php echo $post; ?></div>
                        
                    </div>
                     <?php } ?>
              

                 <div class="topic-container">

                    Recent Notices
                </div>
                <?php foreach ($notices as $notice) { 
                    $user_info = $obj_admin->edit("user_image,user_fullname","swastik_users","user_id",$notice['user_id']);
                    ?>

    <div class="container1">
    <img src="../user-img/<?php echo $user_info['user_image'] ?>" alt="Avatar" style="width:100%;">
    <p><b><?php 

  if($notice['user_id']==$_SESSION['user_id']){
        echo "You";
    }else{
        echo $user_info['user_fullname'];
  } ?></b> : <?php echo $notice['notice_content'] ?></p>
  <span class="time-right"> 
    <?php
                            
    $time = $obj_admin->time_ago($notice['notice_date']);                        
    echo $time;
    ?>         
    </span>

    
    
</div>


<?php } ?>
               
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



    </div>

</body>

</html>