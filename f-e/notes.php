<?php
require 'auth.php';
if(isset($_POST['upload-note'])){
    $post = $obj_admin->upload_note($_POST, $_FILES['note_file']);
    
}
if(isset($_POST['download'])){
    $download = $obj_admin->download_notes($_POST);
}
if(isset($_POST['open'])){
    $download = $obj_admin->open_notes($_POST);
}
if($_SESSION['user_permission']==0){
    $notes= $obj_admin->display_('swastik_notes','note_faculty','note_semester','note_id');
}else{
    $notes = $obj_admin->display('swastik_notes','note_id');
}
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
                <h3>NOTES</h3>
               
            </div>

            <div class="contents">
                <?php
                if($_SESSION['user_permission']==1){ ?>


                <div class="post-assignment">
                    <form class="teachers-form" method="post" enctype="multipart/form-data">
                        <!-- <p class="title">Upload Note</p> -->
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

                        <label>Note Title</label>
                        <input type="text" name="note_title">


                        <label>File</label>
                        <input type="file" name="note_file">

                        <input type="submit" name="upload-note" value="Upload">
                    </form>
                    <div class="un-msg"><?php echo $post; ?> </div>
                    <div class="su_message"><?php echo $su_message; ?> </div>
                </div>
                 <?php } ?>



                <div class="topic-container">Recently Uploaded <?php if($_SESSION['user_permission']==0){ ?>( For
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
                if($notes[0]['note_id']==NULL){
                    echo "<div style='text-align:center;color:red'> Notes not found.</div>";
                 }else{
                  foreach($notes as $note){ ?>
                <div class="notes-section container1">
                    <div class="flex-title note-title"><span><?php echo $note['note_title']; ?></span> 
                        <span class="date">

                        <?php if($note['user_id']==$_SESSION['user_id']){ ?>    
                        <a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_notes&b=note_id&c=<?php echo $note['note_id'] ?>"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>

                        <?php } 
                            
                        $time = $obj_admin->time_ago($note['note_date']);
                        
                        echo $time;
                        
                        ?>
                        <!-- <span class="more"><i class="fa-solid fa-ellipsis-vertical"></i></span>    -->
                         </span> 
                    </div>
                    <div class="notice-author">Uploaded by <?php echo $note['note_author']; ?> 
                       .</div>
                    <div class="notes-buttons">
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $note['note_id']; ?>">
                      <div class="flex-buttons">  
                     <input type="submit" name="open" value="Open">
                     
                     <input type="submit" name="download" value="Download">
                    </div>
                </form>

                </div>

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
                    <?php } ?>                </ul>
            </div>
        </div>



    </div>

</body>

</html>