<?php
require 'auth.php';

if(isset($_POST['Post'])){
    $post = $obj_admin->post_questions($_POST);
}


$questions=$obj_admin->display('swastik_questions' ,'q_id');
$resources = $obj_admin->display('swastik_resources','resource_id');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>Notes</title>
    <link rel="stylesheet" href="../style/style-d.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <style type="text/css">
        .container1 {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px 20px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container1::after {
  content: "";
  clear: both;
  display: table;
}

.container1 img {
  float: left;
  max-width: 40px;
  height: 40px;
  /*width: 100%;*/
  margin-right: 20px;
  border-radius: 50%;
}

.container1 img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
  margin-top: 10px;

}

.time-left {
  float: left;
  color: #999;
  margin-top: 10px;

}
.replies{
    float: left;
    color: #999;
    /*margin-left: 20px;*/
    margin-top: 10px;

}
a{
    text-decoration: none;
    
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
                        <li><a href="home.php" ><i class="fa-solid fa-house"></i><span
                                    class="title">Home</span></a></li>
                        <li><a href="assignment.php"><i class="fa-solid fa-clipboard-list"></i><span
                                    class="title">Assignment</span></a></li>
                        <li><a href="#" class="active"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                        <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
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
                <h3>Ask Teachers</h3>
               
            </div>

            <div class="contents">



<div class="notice post-assignment" position>

<form class="teachers-form" method="post">

<textarea name="q_content" placeholder="Ask your question..."></textarea>
                               
<input type="submit" name="Post" value="Post">
</form>
<div class="message"><?php echo $post; ?></div>                        
</div>
<h2>Recent Questions</h2>
<?php 
for($i=0; $i<=10;$i++) { 
if($questions[$i]['q_id']!=NULL) { 
$user_info = $obj_admin->edit("user_image,user_fullname","swastik_users","user_id",$questions[$i]['q_by']);
    ?> 
<div class="container1">
  <img src="../user-img/<?php echo $user_info['user_image'] ?>" alt="Avatar" style="width:100%;">
  <p><?php echo $user_info['user_fullname'] ?> : <?php echo $questions[$i]['q_content'] ?></p>
  <span class="time-right"><a href="replies.php?q=<?php echo $questions[$i]['q_id'];?>">5 Replies</a> | 
    <?php
                            
    $time = $obj_admin->time_ago($questions[$i]['q_time']);                        
    echo $time;
    ?> 
        
    </span>
  <span class="replies"></span>
</div>
<?php }} ?>

<!-- <div class="container1 darker">
  <img src="../user-img/user-default.png" alt="Avatar" class="right" style="width:100%;">
  <p>Hey! I'm fine. Thanks for asking!</p>
  <span class="time-left">11:01</span>
</div> -->






                


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