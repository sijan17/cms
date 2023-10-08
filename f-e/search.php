<?php
require 'auth.php';


if(isset($_GET['search'])){
    $searchTerm = $_GET['searchTerm'];
    $results = $obj_admin->searchData($searchTerm);
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
                        <li><a href="home.php" ><i class="fa-solid fa-house"></i><span
                                    class="title">Home</span></a></li>
                        <li><a href="assignment.php"><i class="fa-solid fa-clipboard-list"></i><span
                                    class="title">Assignment</span></a></li>
                        <li><a href="notes.php"><i class="fa-solid fa-book-open"></i><span class="title">Notes</span></a></li>
                        <li><a href="notices.php"><i class="fa-solid fa-bullhorn"></i><span class="title">Notices</span></a></li>
                        <li><a class="active" href="search.php"><i class="fa-solid fa-search"></i><span class="title">Search</span></a></li>
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
                <h3>Search</h3>
               
            </div>

            <div class="contents">
<form method="get" class="search">
        <input type="text" name="searchTerm" placeholder="Enter search term"
        <?php if(!empty($searchTerm)){
            echo "value='".$searchTerm."'";
        } ?>
        required>
        <button type="submit" name="search" class="search-button" >
        <i class="fa-solid fa-search"></i>
        </button>
    </form>

    <div class="search-results">
    <?php
if(!isset($results)){
}
else if( empty($results['Questions']) && empty($results['Notes']) && empty($results['Assignments']) && empty($results['Notices'])){
    echo "<p> No results found </p>";
}else{
    echo "<p> Search Results for: ".$searchTerm."</p>";

}

    // Display search results
    if(isset($results['Questions']) && !empty($results['Questions'])){
        echo "<div class='search-results--result'>";
        echo "<h2>Questions:</h2>";
        
        foreach ($results['Questions'] as $question) {
            $user_info = $obj_admin->edit("user_image,user_fullname","swastik_users","user_id",$question['q_by']);
            $count = $obj_admin->count("swastik_replies","r_to",$question['q_id']);
            
            echo '<div class="container1">';
            echo '<img src="../user-img/' . $user_info['user_image'] . '" alt="Avatar" style="width:100%;">';
            echo '<p><b>';
            
            if($question['q_by'] == $_SESSION['user_id']){
                echo "You";
            } else {
                echo $user_info['user_fullname'];
            }
            
            echo '</b> : ' . $question['q_content'] . '</p>';
            echo '<span class="time-right"><a style="color:#719523" href="replies.php?q=' . $question['q_id'] . '">' . $count . ' Replies</a> | ';
            
            if($question['q_by'] == $_SESSION['user_id']){ 
                echo '<a onclick="return confirm(\'Are you sure to delete?\')"  href="manage/delete.php?a=swastik_questions&b=q_id&c=' . $question['q_id'] . '" class="right"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>';
            }
            
            $time = $obj_admin->time_ago($question['q_time']);                        
            echo $time;
            echo '</span>';
            echo '<span class="replies"></span>';
            echo '</div>';
        }
        echo "</div>";
    } 

// Display search results for notices
if(isset($results['Notices']) && !empty($results['Notices'])){
    echo "<div class='search-results--result'>";
    echo "<h2>Notices:</h2>";
    
    foreach ($results['Notices'] as $notice) {
        // Get user info for the notice author
        $user_info = $obj_admin->edit("user_image,user_fullname","swastik_users","user_id",$notice['user_id']);
        
        echo '<div class="container1">';
        echo '<img src="../user-img/' . $user_info['user_image'] . '" alt="Avatar" style="width:100%;">';
        echo '<p><b>';
        
        if($notice['user_id'] == $_SESSION['user_id']){
            echo "You";
        } else {
            echo $user_info['user_fullname'];
        }
        
        echo '</b> : ' . $notice['notice_content'] . '</p>';
        echo '<span class="time-right">';
        
        $time = $obj_admin->time_ago($notice['notice_date']);
        echo $time;
        echo '</span>';
        echo '</div>';
    }
    echo "</div>";
} 

     // Display search results for assignments
     if(isset($results['Assignments']) && !empty($results['Assignments'])){
        echo "<div class='search-results--result'>";
        echo "<h2>Assignments:</h2>";
        
        foreach ($results['Assignments'] as $assignment) {
            echo '<div class="assignment-section container1">';
            echo '<div class="flex-title assignment-title"><span>' . $assignment['assi_title'] . '</span>';
            echo '<span class="date">';
            
            if($assignment['user_id'] == $_SESSION['user_id']){
                echo '<a onclick="return confirm(\'Are you sure to delete?\')"  href="manage/delete.php?a=swastik_assignments&b=assi_id&c=' . $assignment['assi_id'] . '"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>';
            }
            
            $time = $obj_admin->time_ago($assignment['assi_date']);
            echo $time;
            echo '</span></div>';
            echo '<div class="assignment-desc">' . $assignment['assi_desc'] . '</div>';
            echo '<div class="assignment-author">Posted By ' . $assignment['assi_author'] . '</div>';
            
            if($assignment['assi_file'] != NULL){
                echo '<form method="post">';
                echo '<input type="hidden" name="id" value="' . $assignment['assi_id'] . '">';
                echo '<div class="flex-buttons">';
                echo '<input type="submit" name="open" value="Open">';
                echo '<input type="submit" name="download" value="Download">';
                echo '</div>';
                echo '</form>';
            }
            
            echo '<div class="submission-date">Due Date: <span style="color:green"><b>' . $assignment['assi_due_date'] . '</b> ( ';
            
            $time = $obj_admin->time_left($assignment['assi_due_date']);
            echo $time;
            
            echo ' ) </span></div>';
            echo '</div>';
        }
        echo "</div>";
    } 

     // Display search results for Notes
     // Display search results for notes
    if(isset($results['Notes']) && !empty($results['Notes'])){
        echo "<div class='search-results--result'>";
        echo "<h2>Notes:</h2>";
        
        foreach ($results['Notes'] as $note) {
            echo '<div class="notes-section container1">';
            echo '<div class="flex-title note-title"><span>' . $note['note_title'] . '</span>';
            echo '<span class="date">';
            
            if($note['user_id'] == $_SESSION['user_id']){
                echo '<a onclick="return confirm(\'Are you sure to delete?\')"  href="manage/delete.php?a=swastik_notes&b=note_id&c=' . $note['note_id'] . '"><i style="color: #a6414a;" class="fa fa-trash" aria-hidden="true"></i> | </a>';
            }
            
            $time = $obj_admin->time_ago($note['note_date']);
            echo $time;
            echo '</span></div>';
            echo '<div class="notice-author">Uploaded by ' . $note['note_author'] . '.</div>';
            echo '<div class="notes-buttons">';
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="' . $note['note_id'] . '">';
            echo '<div class="flex-buttons">';
            echo '<input type="submit" name="open" value="Open">';
            echo '<input type="submit" name="download" value="Download">';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }

        echo "</div>";
    } 

    ?>


    </div>

                


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