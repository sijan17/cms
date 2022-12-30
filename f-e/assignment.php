<?php
require 'auth.php';


 if(isset($_POST['post_assi'])){
    $post = $obj_admin->post_assi($_POST, $_FILES['assi_file']);
}
if($_SESSION['user_permission']==0){
    $assignments = $obj_admin->display_('swastik_assignments','assi_faculty','assi_semester','assi_id');
}else{
    $assignments = $obj_admin->display('swastik_assignments','assi_id');
}
$resources = $obj_admin->display('swastik_resources','resource_id');


if(isset($_POST['download'])){
    $download = $obj_admin->download_assi($_POST);
}
if(isset($_POST['open'])){
    $open = $obj_admin->open_assi($_POST);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
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
                <li><a href="assignment.php" class="active"><i class="fa-solid fa-clipboard-list"></i><span
                            class="title">Assignment</span></a></li>
                <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                <li><a href="feedback.php"><i class="fa-solid fa-comment"></i><span class="title">Feedback</span></a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user"></i><span class="title">Profile</span></a></li>
                <li><a href="logout.php" onClick="return confirm('Are you sure you want to log out?')"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="title">Log Out</span> </a></li>
      
                    </div>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="title">
                <h3>ASSIGNMENTS</h3>              
            </div>

            <div class="contents">

            <?php
                if($_SESSION['user_permission']==1){ ?>


                <div class="post-assignment">
                    <form class="teachers-form" method="post" enctype="multipart/form-data">
                        <!-- <p class="title">Post Assignment</p> -->

                        <label>Assignment Title</label>
                        <input type="text" name="assi_title">

                        <div id="forStudents">
                        <label for="">Faculty</label>
                        <select name="faculty">
                            <option value="1">CSIT</option>
                            <option value="0" >BCA</option>
                        </select>  

                        <label for="">Semester</label>
                        <select name="semester">
                            <option value="1">First</option>
                            <option value="2" >Second</option>
                            <option value="3">Third</option>
                            <option value="4" >Fourth</option>
                            <option value="5">Fifth</option>
                            <option value="6" >Sixth</option>
                            <option value="7">Seventh</option>
                            <option value="8" >Eighth</option>
                        </select>  
                    </div>

                        <label>Description</label>
                        <textarea class="teachers-textarea" name="assi_desc"></textarea>

                        <label>Due Date</label>
                        <input type="date" name="assi_due_date">

                        <label>File(If any)</label>
                        <input type="file" name="assi_file">

                        <input type="submit" name="post_assi" value="Post">
                    </form>
                    <div class="message"> <?php echo $post; ?> </div>
                </div>
                 <?php } ?>
                

                
                <div class="topic-container">Most Recent <?php if($_SESSION['user_permission']==0){ ?>( For
                          <?php
                          if($_SESSION['user_faculty']!=NULL){
                           if($_SESSION['user_faculty']==1){
                              echo "CSIT"; }
                          else{
                               echo "BCA"; 
                             }
                           }                             
                             echo " sem ".$_SESSION['user_semester'] ?>) <?php } ?></div>
                <?php
                if($assignments[0]['assi_id']==NULL){
                    echo "<div style='text-align:center;color:red'> Assignments not found.</div>";
                 }else{
                 foreach($assignments as $assi){ ?>
                <div class="assignment-section container1">
                    <div class="flex-title assignment-title"><span><?php echo $assi['assi_title']; ?></span> 
                        <span class="date">
                            <?php if($assi['user_id']==$_SESSION['user_id']){ ?>    
                        <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_assignments&b=assi_id&c=<?php echo $assi['assi_id'] ?>"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>

                        <?php }
                            
                        $time = $obj_admin->time_ago($assi['assi_date']);

                        
                        echo $time;
                        
                        ?>     </span> </div>
                    <div class="assignment-desc"><?php echo $assi['assi_desc']; ?></div>
                    <div class="assignment-author">Posted By  <?php echo $assi['assi_author']; ?> </div>
                    
                    <?php if($assi['assi_file']!=NULL){ ?>
                    <form method="post">
                    <input type="hidden" name="id" value="<?php echo $assi['assi_id']; ?>">
                      <div class="flex-buttons">  
                     <input type="submit" name="open" value="Open">
                     
                     <input type="submit" name="download" value="Download">
                    </div>
                </form>
                <?php } ?>
                       
                        <div class="submission-date">Due Date: <span style="color:green"><b><?php echo $assi['assi_due_date']; ?></b> ( <?php
                            
                        $time = $obj_admin->time_left($assi['assi_due_date']);
                        
                        echo $time;
                        
                        ?> ) </span></div>
                    

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

</body>

</html><?php
require 'auth.php';


 if(isset($_POST['post_assi'])){
    $post = $obj_admin->post_assi($_POST, $_FILES['assi_file']);
}
if($_SESSION['user_permission']==0){
    $assignments = $obj_admin->display_('swastik_assignments','assi_faculty','assi_semester','assi_id');
}else{
    $assignments = $obj_admin->display('swastik_assignments','assi_id');
}
$resources = $obj_admin->display('swastik_resources','resource_id');


if(isset($_POST['download'])){
    $download = $obj_admin->download_assi($_POST);
}
if(isset($_POST['open'])){
    $open = $obj_admin->open_assi($_POST);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
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
                <li><a href="assignment.php" class="active"><i class="fa-solid fa-clipboard-list"></i><span
                            class="title">Assignment</span></a></li>
                <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                <li><a href="feedback.php"><i class="fa-solid fa-comment"></i><span class="title">Feedback</span></a></li>
                <li><a href="profile.php"><i class="fa-solid fa-user"></i><span class="title">Profile</span></a></li>
                <li><a href="logout.php" onClick="return confirm('Are you sure you want to log out?')"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="title">Log Out</span> </a></li>
      
                    </div>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="title">
                <h3>ASSIGNMENTS</h3>              
            </div>

            <div class="contents">

            <?php
                if($_SESSION['user_permission']==1){ ?>


                <div class="post-assignment">
                    <form class="teachers-form" method="post" enctype="multipart/form-data">
                        <!-- <p class="title">Post Assignment</p> -->

                        <label>Assignment Title</label>
                        <input type="text" name="assi_title">

                        <div id="forStudents">
                        <label for="">Faculty</label>
                        <select name="faculty">
                            <option value="1">CSIT</option>
                            <option value="0" >BCA</option>
                        </select>  

                        <label for="">Semester</label>
                        <select name="semester">
                            <option value="1">First</option>
                            <option value="2" >Second</option>
                            <option value="3">Third</option>
                            <option value="4" >Fourth</option>
                            <option value="5">Fifth</option>
                            <option value="6" >Sixth</option>
                            <option value="7">Seventh</option>
                            <option value="8" >Eighth</option>
                        </select>  
                    </div>

                        <label>Description</label>
                        <textarea class="teachers-textarea" name="assi_desc"></textarea>

                        <label>Due Date</label>
                        <input type="date" name="assi_due_date">

                        <label>File(If any)</label>
                        <input type="file" name="assi_file">

                        <input type="submit" name="post_assi" value="Post">
                    </form>
                    <div class="message"> <?php echo $post; ?> </div>
                </div>
                 <?php } ?>
                

                
                <div class="topic-container">Most Recent <?php if($_SESSION['user_permission']==0){ ?>( For
                          <?php
                          if($_SESSION['user_faculty']!=NULL){
                           if($_SESSION['user_faculty']==1){
                              echo "CSIT"; }
                          else{
                               echo "BCA"; 
                             }
                           }                             
                             echo " sem ".$_SESSION['user_semester'] ?>) <?php } ?></div>
                <?php
                if($assignments[0]['assi_id']==NULL){
                    echo "<div style='text-align:center;color:red'> Assignments not found.</div>";
                 }else{
                 foreach($assignments as $assi){ ?>
                <div class="assignment-section container1">
                    <div class="flex-title assignment-title"><span><?php echo $assi['assi_title']; ?></span> 
                        <span class="date">
                            <?php if($assi['user_id']==$_SESSION['user_id']){ ?>    
                        <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_assignments&b=assi_id&c=<?php echo $assi['assi_id'] ?>"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>

                        <?php }
                            
                        $time = $obj_admin->time_ago($assi['assi_date']);

                        
                        echo $time;
                        
                        ?>     </span> </div>
                    <div class="assignment-desc"><?php echo $assi['assi_desc']; ?></div>
                    <div class="assignment-author">Posted By  <?php echo $assi['assi_author']; ?> </div>
                    
                    <?php if($assi['assi_file']!=NULL){ ?>
                    <form method="post">
                    <input type="hidden" name="id" value="<?php echo $assi['assi_id']; ?>">
                      <div class="flex-buttons">  
                     <input type="submit" name="open" value="Open">
                     
                     <input type="submit" name="download" value="Download">
                    </div>
                </form>
                <?php } ?>
                       
                        <div class="submission-date">Due Date: <span style="color:green"><b><?php echo $assi['assi_due_date']; ?></b> ( <?php
                            
                        $time = $obj_admin->time_left($assi['assi_due_date']);
                        
                        echo $time;
                        
                        ?> ) </span></div>
                    

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

</body>

</html>