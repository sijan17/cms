<?php
require 'auth.php';
$q = $_GET['q'];
if($q==NULL){
    die('Forbidden.');
}


$question = $obj_admin->edit("*","swastik_questions","q_id",$q);
$user1_info = $obj_admin->edit("user_image,user_fullname","swastik_users","user_id",$question['q_by']);

$r=$obj_admin->display('swastik_replies where r_to='.$q ,'r_id');


?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>Manage</title>
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
</head>
<body>

<ul>
  <li><a  href="home.php">Home</a></li>
   <li><a class="active" href="manage.php">Manage</a></li>
   <li><a href="public.php">Public Info</a></li>
   <li><a href="users.php">Users</a></li>
   <li><a href="feedback.php">Feedback</a></li>
    <li><a href="../f-e/home.php">View as User</a></li>
  <li style="float:right"><a  onclick="return confirm('Are you sure you want to logout?')" href="../f-e/logout.php">Logout</a></li>
</ul>

<div class="left">
<!-- -------------------Manage Questions-------------------- -->
  <h2>Replies to:</h2>
  <p><?php echo $question['q_content'] ?></p>

                <table>
                    <thead>
                        <td style="width:50px">S.N.</td>
                        <td style="width:100px">Reply By</td>
                        <td style="width:500px">Reply Content</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($r[0]['r_id']==NULL){ ?>
                      <tr>
                          <td colspan="4" style="text-align: center;"> No Posts Found. </td>
                      </tr>
                    <?php }else{ 

                     for($i=0;$i<=10;$i++) {
                     if($r[$i]['r_id']!=NULL){ 
                        $user_info = $obj_admin->edit("user_fullname","swastik_users","user_id",$r[$i]['r_by']);?>
                    <tr>
                        <td><?php echo $i ?></td>  
                        <td><?php echo $user_info['user_fullname'] ?></td>
                        <td><?php echo $r[$i]['r_content']?></td>
                        

                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=r_content&b=swastik_replies&c=r_id&d=<?php echo $r[$i]['r_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_replies&b=r_id&c=<?php echo $r[$i]['r_id'] ?>&d=<?php echo $q; ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>





                    <?php } } } ?>
                </table>



            </div>

    <?php if(isset($_COOKIE['message'])){ ?>
   <div id="success-alert" class="message" style="display: none;"><h2><?php echo $_COOKIE["message"]; ?> <i class="fa-regular fa-circle-check"></i></h2></div>
 <?php } ?>
   <script src="../js/jquery.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
  $("#success-alert").fadeIn(1000);
  setTimeout(function(){ $('#success-alert').fadeOut(1000) }, 2500);
     });

    </script>

</body>
</html>


