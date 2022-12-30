<?php
    require 'auth.php';
   $n = $obj_admin->display('swastik_notices','notice_id'); 
   $note = $obj_admin->display('swastik_notes','note_id'); 
   $a = $obj_admin->display('swastik_assignments','assi_id');
   $q = $obj_admin->display('swastik_questions','q_id');
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
   <li><a  href="codes.php">Codes</a></li>
    <li><a href="../f-e/home.php">View as User</a></li>
  <li style="float:right"><a  onclick="return confirm('Are you sure you want to logout?')" href="../f-e/logout.php">Logout</a></li>
</ul>

<div class="left">
<!-- -------------------Manage Questions-------------------- -->
  <h2>Manage Questions(Most Recent First) </h2>

                <table>
                    <thead>
                        <td style="width:50px">S.N.</td>
                        <td style="width:100px">Question By</td>
                        <td style="width:500px">Question</td>
                        <td style="width:130px">Replies</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($q[0]['q_id']==NULL){ ?>
                      <tr>
                          <td colspan="4" style="text-align: center;"> No Posts Found. </td>
                      </tr>
                    <?php }else{ 

                     for($i=0;$i<=10;$i++) {
                     if($q[$i]['q_id']!=NULL){ 
                        $user_info = $obj_admin->edit("user_fullname","swastik_users","user_id",$q[$i]['q_by']);
                        $count = $obj_admin->count("swastik_replies","r_to",$q[$i]['q_id'])?>
                    <tr>
                        <td><?php echo $i ?></td>  
                        <td><?php echo $user_info['user_fullname'] ?></td>
                        <td><?php echo $q[$i]['q_content']?></td>
                        <td><a href="replies.php?q=<?php echo $q[$i]['q_id']?>">View Replies(<?php echo $count ?>)</td>

                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=q_content&b=swastik_questions&c=q_id&d=<?php echo $q[$i]['q_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_questions&b=q_id&c=<?php echo $q[$i]['q_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>





                    <?php } } } ?>
                </table>




  <!-- -------------------Manage Notices-------------------- -->
  <h2>Manage Notices(Most Recent First) </h2>


                <table>
                    <thead>
                        <td style="width:50px">S.N.</td>
                        <td style="width:100px">Notice By</td>
                        <td style="width:500px">Notice Content</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($n[0]['notice_id']==NULL){ ?>
                      <tr>
                          <td colspan="4" style="text-align: center;"> No Posts Found. </td>
                      </tr>
                    <?php }else{ 

                     for($i=0;$i<=10;$i++) {
                     if($n[$i]['notice_id']!=NULL){ ?>
                    <tr>
                        <td><?php echo $i ?></td>  
                        <td><?php echo $n[$i]['notice_author']?></td>
                        <td><?php echo $n[$i]['notice_content']?></td>
                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=notice_content&b=swastik_notices&c=notice_id&d=<?php echo $n[$i]['notice_id'] ?>" style="color:green;">Edit</a> 
                            <!-- <a href="#"  onclick="return deleteOne('swastik_notices','notice_id','<?php echo $n[$i]['notice_id'] ?>')"  style="color:red" class="right">Delete </a> -->

                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_notices&b=notice_id&c=<?php echo $n[$i]['notice_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>





                    <?php } } } ?>
                </table>


<!-- -------------------Manage Notes-------------------- -->
  <h2>Manage Notes(Most Recent First) </h2>


                <table>
                    <thead>
                        <td style="width:50px">S.N.</td>
                        <td style="width:100px">Note By</td>
                        <td style="width:80px">Faculty</td>
                        <td style="width:50px">Semester</td>
                        <td style="width:200px">Note Title</td>
                        <td style="width:300px">Note File</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($note[0]['note_id']==NULL){ ?>
                      <tr>
                          <td colspan="7" style="text-align: center;"> No Notes Found. </td>
                      </tr>
                    <?php }else{ 

                     for($i=0;$i<=10;$i++) {
                     if($note[$i]['note_id']!=NULL){ ?>
                    <tr>
                        <td><?php echo $i ?></td>  
                        <td><?php echo $note[$i]['note_author']?></td>
                       <td>
                          <?php
                          if($note[$i]['note_faculty']!=NULL){
                           if($note[$i]['note_faculty']==1){
                              echo "CSIT"; }
                          else{
                               echo "BCA"; 
                             }
                           }
                             ?>
                             </td>
                        <td><?php echo $note[$i]['note_semester']?></td>
                        <td><?php echo $note[$i]['note_title']?></td>
                        <td><?php echo $note[$i]['note_file']?></td>

                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=note_title,note_file,note_faculty,note_semester&b=swastik_notes&c=note_id&d=<?php echo $note[$i]['note_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_notes&b=note_id&c=<?php echo $note[$i]['note_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>





                    <?php } } } ?>
                </table>


<!-- -------------------Manage Assignments-------------------- -->

  <h2>Manage Assignments(Most Recent First) </h2>
                <table>
                    <thead>
                        <td style="width:50px">S.N.</td>
                        <td style="width:100px">Assignment By</td>
                        <td style="width:80px">Faculty</td>
                        <td style="width:50px">Semester</td>
                        <td style="width:300px">Assignment Title</td>
                        <td style="width:200px">Assignment Due Date</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($a[0]['assi_id']==NULL){ ?>
                      <tr>
                          <td colspan="7" style="text-align: center;"> No Assignments Found. </td>
                      </tr>
                    <?php }else{ 

                     for($i=0;$i<=10;$i++) {
                     if($a[$i]['assi_id']!=NULL){ ?>
                    <tr>
                        <td><?php echo $i ?></td>  
                        <td><?php echo $a[$i]['assi_author']?></td>
                        <td>
                          <?php
                          if($a[$i]['assi_faculty']!=NULL){
                           if($a[$i]['assi_faculty']==1){
                              echo "CSIT"; }
                          else{
                               echo "BCA"; 
                             }
                           }
                             ?>
                             </td>
                        <td><?php echo $a[$i]['assi_semester']?></td>
                        <td><?php echo $a[$i]['assi_title']?></td>
                        <td><?php echo $a[$i]['assi_due_date']?></td>
                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=assi_title,assi_desc,assi_due_date,assi_faculty,assi_semester&b=swastik_assignments&c=assi_id&d=<?php echo $a[$i]['assi_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_assignments&b=assi_id&c=<?php echo $a[$i]['assi_id'] ?>" style="color:red" class="right">Delete </a>
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

        
       //  function deleteOne(a,b,c) {
       //  $.ajax({
       //   url: "manage/delete.php",
       //   type: "GET",
       //   data : "a="+a+"&b="+b+"&c="+c,
       //   success: function() {
       //     alert("deleted");
       //   }
       // });
       //  }
        
    </script>

</body>
</html>


