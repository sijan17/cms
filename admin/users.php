<?php
    require 'auth.php';
    $s = user_id;
    if(isset($_GET['s'])){
      $s = $_GET['s']." asc--";
    }
    
   $users = $obj_admin->display('swastik_users',$s); 
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <title>Users</title>
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
</head>
<body>

<ul>
  <li><a  href="home.php">Home</a></li>
   <li><a href="manage.php">Manage</a></li>
   <li><a href="public.php">Public Info</a></li>
   <li><a class="active" href="users.php">Users</a></li>
   <li><a href="feedback.php">Feedback</a></li>
   <li><a  href="codes.php">Codes</a></li>
    <li><a href="../f-e/home.php">View as User</a></li>
    <li style="float:right"><a><input type="text" id="search" placeholder="Search" autocomplete="off"></a></li>
  <li style="float:right"><a href="../f-e/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>

<div class="left">
  <!-- -------------------Unverified Users-------------------- -->
  <h2>Users</h2>


                <table id="table-data">
                    <thead>
                        <td style="width:50px">ID <a href="users.php?s=user_id"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>
                        <td style="width:200px">Name<a href="users.php?s=user_fullname"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>
                        <td style="width:200px">Email</td>
                        <td style="width:80px">Role<a href="users.php?s=user_permission"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>
                        <td style="width:80px">Faculty<a href="users.php?s=user_faculty"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>
                        <td style="width:100px">Semester<a href="users.php?s=user_semester"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>
                        <td style="width:100px">Reg. No.</td>
                        <td style="width:80px">IsActive<a href="users.php?s=isactive"> <i style="float: right" class="fa-solid fa-sort-down"></i></a></td>                        
                        <td style="width:150px">Actions</td>
                    </thead>


                    <?php 
                    
                    if ($users[0]['user_id']==NULL){ ?>
                      <tr i>
                          <td colspan="5" style="text-align: center;"> No Pending Requests. </td>
                      </tr>

                    <?php }else{ 



                     foreach($users as $user) { ?>
                    <tr>
                        <td ><?php echo $user['user_id']?></td>  
                        <td><?php echo $user['user_fullname']?></td>
                        <td><?php echo $user['user_email']?></td>
                          <td>
                          <?php
                          if ($user['user_permission'] == 1) {
                            echo "Teacher";
                          }
                          else if($user['user_permission'] == 10){
                            echo "Admin";
                          }
                          else{
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
                        <td><?php echo $user['user_regno']?></td>
                        <td>
                          <?php
                          if ($user['isactive'] == 1) {
                            echo "Yes";
                          }
                          else{
                            echo "No";
                          }
                          ?>
                        </td>
                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=user_fullname,user_email,user_permission,user_faculty,user_semester,user_regno,isactive&b=swastik_users&c=user_id&d=<?php echo $user['user_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure this user is not active anymore?') " href="user/notactive.php?id=<?php echo $user['user_id'] ?>" style="color:maroon;" class="">Close</a>
                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_users&b=user_id&c=<?php echo $user['user_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>
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
            

  <script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // Live Search
     $("#search").on("keyup",function(){
       var search_term = $(this).val();

       $.ajax({
         url: "ajax-search.php",
         type: "POST",
         data : {search:search_term},
         success: function(data) {
           $("#table-data").html(data);
         }
       });
     });
  });
</script>



</body>
</html>


