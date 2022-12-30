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
    <title>Home</title>
    <link rel="stylesheet" href="../style/style-d.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <style type="text/css">
.container1,.post-assignment {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
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
                        <li><a class="active" href="#" ><i class="fa-solid fa-house"></i><span
                                    class="title">Home</span></a></li>
                        <li><a href="assignment.php"><i class="fa-solid fa-clipboard-list"></i><span
                                    class="title">Assignment</span></a></li>
                        <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                        <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                        <li><a href="feedback.php"><i class="fa-solid fa-comment"></i><span class="title">Feedback</span></a></li>
                        <li><a href="profile.php"><i class="fa-solid fa-user"></i><span class="title">Profile</span></a></li>
                        <li><a href="logout.php" onClick="return confirm('Are you sure you want to log out?')"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="title">Log Out</span>
                        </a></li>
                        <!-- <li><a onclick="darkLight()"> <i class="fa-solid fa-moon"></i> Dark/Light</a></li> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="title">
                <h3>Discussion</h3>
               
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
$count = $obj_admin->count("swastik_replies","r_to",$questions[$i]['q_id'])
    ?> 
<div class="container1">
  <img src="../user-img/<?php echo $user_info['user_image'] ?>" alt="Avatar" style="width:100%;">
  <p><b><?php 

  if($questions[$i]['q_by']==$_SESSION['user_id']){
        echo "You";
    }else{
        echo $user_info['user_fullname'];
  } ?></b> : <?php echo $questions[$i]['q_content'] ?></p>
  <span class="time-right" ><a style="color:#719523" href="replies.php?q=<?php echo $questions[$i]['q_id'];?>"><?php echo $count ?> Replies</i>
</a> |

    <?php if($questions[$i]['q_by']==$_SESSION['user_id']){ ?>
    
       
        <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_questions&b=q_id&c=<?php echo $questions[$i]['q_id'] ?>" class="right"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>
   
   
  <?php } ?> 
    <?php
                            
    $time = $obj_admin->time_ago($questions[$i]['q_time']);                        
    echo $time;
    ?> 
        
    </span>
    
  <span class="replies"></span>
</div>
<?php }} ?>

                


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
    <script>
function darkLight() {
   var element = document.body;
   element.classList.toggle("dark-mode");

   var container = document.getElementsByClassName("container1");
   container.classList.toggle("dark-mode");
}
</script>

</body>

</html>