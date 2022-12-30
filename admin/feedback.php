<?php
    require 'auth.php';
   
   $f= $obj_admin->display('swastik_feedback','feedback_id');

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>Feedback</title>
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">

<style>
    thead{
        font-weight: bold;
    }

</style>
</head>
<body>

<ul>
  <li><a href="home.php">Home</a></li>
   <li><a   href="manage.php">Manage</a></li>
   <li><a   href="public.php">Public Info</a></li>
   <li><a href="users.php">Users</a></li>
   <li><a  class="active"  href="feedback.php">Feedback</a></li>
   <li><a  href="codes.php">Codes</a></li>
   <li><a href="../f-e/home.php">View as User</a></li>
  
  <li style="float:right"><a href="../f-e/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>


<div class="left">
<div class="contents">
  <!-- -------------------Notices------------------- -->
  <h2>Feedbacks</h2>


                <table>
                    <b>
                    <thead>
                      <td style="width:50px">S.N</td>
                        <td style="width:100px">Feedback By</td>
                        <td style="width:500px">Feedback Content</td>
                        <td style="width:50px">Actions</td>
                        
                    </thead>
                </b>
                    <?php
                    for($i=0; $i<=10; $i++){
                        if($f[$i]['feedback_id'] != NULL){
                    ?>
                    
                    <tr>
                        <td><?php echo $i?></td>  
                        <td><?php echo $f[$i]['feedback_by']?></td>
                        <td><?php echo $f[$i]['feedback_content']?></td>
                        <td><a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_feedback&b=feedback_id&c=<?php echo $f[$i]['feedback_id'] ?>" style="color:red" class="right">Delete </a></td>
                        
                      </tr>





                    <?php } } ?>
                </table>


            </div>
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


