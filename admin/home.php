<?php
    require 'auth.php';

   $users = $obj_admin->display('swastik_users_tbv WHERE user_email_verified=1','user_id'); 
     $f="";
     $all=false;
  if (isset($_GET['f'])) {
    $f=$_GET['f'];
    if($f=='all'){
      $all = true;
      $users = $obj_admin->display('swastik_users_tbv','user_id'); 
    }
  }
   $tc = $obj_admin->count("swastik_users","user_permission",1);
    $sc = $obj_admin->count("swastik_users","user_permission",0);
    $atc = $obj_admin->count("swastik_users","user_permission","1 AND isactive=1");
    $asc = $obj_admin->count("swastik_users","user_permission","0 AND isactive=1");
?>

<!DOCTYPE html>
<html>
<head><link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
</head>
<body>

<ul>
  <li><a class="active" href="#home">Home</a></li>
   <li><a href="manage.php">Manage</a></li>
   <li><a href="public.php">Public Info</a></li>
   <li><a href="users.php">Users</a></li>
   <li><a href="feedback.php">Feedback</a></li>
   <li><a  href="codes.php">Codes</a></li>
    <li><a href="../f-e/home.php">View as User</a></li>
  <li style="float:right"><a href="../f-e/logout.php" onclick=" return confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>

<div class="left">
  <!-- -------------------Unverified Users-------------------- -->
  <h2>User Requests <?php if($all){echo "(Email Not verified)";} ?></h2>
                <table>
                    <thead>
                        <td style="width:50px">ID</td>
                        <td style="width:100px">Name</td>
                        <td style="width:100px">Role</td>
                        <td style="width:50px">Faculty</td>
                        <td style="width:50px">Semester</td>
                        <td style="width:200px">Email</td>
                        <td style="width:100px">Reg. No.</td>
                        <td style="width:120px">Actions</td>
                    </thead>

                    <?php if ($users[0]['user_id']==NULL){ ?>
                      <tr>
                          <td colspan="8" style="text-align: center;"> No Pending Requests. </td>
                      </tr>
                    <?php }else{ 

                     foreach($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['user_id']?></td>  
                        <td><?php echo $user['user_fullname']?></td>
                        <td>
                          <?php 
                            if($user['user_permission']==1){
                              echo "Teacher";
                            }else{
                              echo "Student";
                            }
                          ?>
                        </td>
                         <td>
                          <?php
                          if($user['user_faculty']!=NULL){
                           if($user['user_faculty']==1){
                              echo "CSIT"; }
                          else{
                               echo "BCA"; 
                             }
                           }
                             ?>
                             </td>
                          <td><?php echo $user['user_semester']?></td>
                        <td><?php echo $user['user_email']?></td>
                        <td><?php echo $user['user_regno']?></td>
                        <td>
                            <form method="post">
                            <a href="user/verify.php?id=<?php echo $user['user_id'] ?>" style="color:green;">Verify</a>
                            <a onclick="return confirm('Are you sure to delete?')" href="user/delete.php?a=swastik_users_tbv&b=user_id&c=<?php echo $user['user_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>





                    <?php } } ?>
                </table>

            </div>
            <div class="right">
  <h3>
    Total Students Registered : <?php print_r($sc) ?>
  </h3>
    <h3>
    Total Teachers Registered : <?php print_r($tc) ?>
  </h3>
    <h3 style="color: green;">
    Active Students : <?php print_r($asc) ?>
  </h3>
    <h3 style="color: green;">
    Active Teachers :<?php print_r($atc) ?>
  </h3>
  <br><br>
  <h3>Increment Semester</h3>
  <p style="color:green;"><i class="fa-regular fa-lightbulb"></i> Semester field of all students will be incremented by 1. <br>Do this every time after board exam.</p>
  <h3 style="color: green;"><a onclick="return confirm('Please confirm you want to increase semester of all students.')" href="manage/increment.php?key=0">BCA</a></h3>
  <h3 style="color: green;"><a onclick="return confirm('Please confirm you want to increase semester of all students.')" href="manage/increment.php?key=1">CSIT</a></h3>
  

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


