<?php
    require 'auth.php';
   $resources = $obj_admin->display('swastik_resources','resource_id'); 
   $contact = $obj_admin->display('swastik_contact','contact_id');
?>

<!DOCTYPE html>
<html>
<head>
   <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
   <title>Public Info</title>
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
  <style>
    .left a{
      /*padding: 20px 10px;*/
      text-decoration: none;
      font-size: large;
    }

  </style>
</head>
<body>

<ul>
  <li><a  href="home.php">Home</a></li>
   <li><a href="manage.php">Manage</a></li>
   <li><a class="active" href="">Public Info</a></li>
   <li><a  href="users.php">Users</a></li>
   <li><a href="feedback.php">Feedback</a></li>
   <li><a  href="codes.php">Codes</a></li>
    <li><a href="../f-e/home.php">View as User</a></li>
  <li style="float:right"><a href="../f-e/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>

<div class="left">

  <h2>Contact Details(Preview) <br> <a href="manage/edit.php?a=contact_address,contact_no,contact_email,contact_noticeno,contact_maplink&b=swastik_contact&c=contact_id&d=1" style="color:;">Edit</a> </h2>
  <div class="contact" style="width: 40%;">
  <iframe style="margin: 10px;" src="<?php echo $contact[0]['contact_maplink'] ?>" style="border:0" allowfullscreen="" width="80%" height="220" frameborder="0"></iframe>
                <div class="more" style="margin:0 auto;;">
                <p><i class="fa-solid fa-location-dot"></i> <?php echo $contact[0]['contact_address'] ?></p>  
                <p><i class="fa-solid fa-phone"></i><a href="tel:+977-<?php echo $contact[0]['contact_no'] ?>">+977-<?php echo $contact[0]['contact_no'] ?></a></p>
                <p><i class="fa-solid fa-envelope"></i><a href="mailto:<?php echo $contact[0]['contact_email'] ?>"> contact@swastikcollege.edu.np</a></p>
                <p><i class="fa-solid fa-bullhorn"></i><a href="tel:<?php echo $contact[0]['contact_noticeno'] ?>"> <?php echo $contact[0]['contact_noticeno'] ?> </a></p></div>
</div>


   



  <!-- -------------------External Resources-------------------- -->
  <div class="left">
  <h2>External Resources</h2>
  <a href="manage/add_resource.php">Add New</a>

                <table>
                    <thead>
                        <td style="width:50px">id</td>
                        <td style="width:300px">Resource Name</td>
                        <td style="width:400px">Link</td>
                        <td style="width:100px">Actions</td>
                    </thead>

                    <?php if ($resources[0]['resource_id']==NULL){ ?>
                      <tr>
                          <td colspan="4" style="text-align: center;"> Nothing Found. </td>
                      </tr>
                    <?php }else{ 

                     foreach($resources as $r){ ?>
                    <tr>
                        <td><?php echo $r['resource_id'] ?></td>  
                        <td><?php echo $r['resource_title']?></td>
                        <td><?php echo $r['resource_link']?></td>
                        <td>
                            <form method="post">
                            <a href="manage/edit.php?a=resource_title,resource_link&b=swastik_resources&c=resource_id&d=<?php echo $r['resource_id'] ?>" style="color:green;">Edit</a> 
                            <a onclick="return confirm('Are you sure to delete?')" href="manage/delete.php?a=swastik_resources&b=resource_id&c=<?php echo $r['resource_id'] ?>" style="color:red" class="right">Delete </a>
                        </form>
                        </td>

                </tr>



                    <?php } }  ?>
                </table>
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
            </div>

</body>
</html>


