<?php

$search_value = $_POST["search"];
$conn = mysqli_connect("localhost","swastik","password","cms_swastik") or die("Connection Failed");

$sql = "SELECT * FROM swastik_users WHERE user_fullname LIKE '%{$search_value}%' ";
$result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
$output = "";
$output = '<table border="1" width="100%" cellspacing="0" cellpadding="10px">
              <thead>
                        <td style="width:50px">ID</td>
                        <td style="width:200px">Name</td>
                        <td style="width:200px">Email</td>
                        <td style="width:80px">Role</td>
                        <td style="width:80px">Faculty</td>
                        <td style="width:80px">Semester</td>
                        <td style="width:100px">Reg. No.</td>
                        <td style="width:80px">IsActive</td>
                        
                        <td style="width:150px">Actions</td>
              </thead>';
                if(mysqli_num_rows($result) > 0 ){
                while($row = mysqli_fetch_assoc($result)){
                $output .= "<tr><td align='center'>{$row["user_id"]}</td>
                <td>{$row["user_fullname"]}</td>
                <td> {$row["user_email"]}</td>";

                 if ($row['user_permission'] == 1) {
                            $role= "Teacher";
                          }
                          else if($row['user_permission'] == 10){
                            $role= "Admin";
                          }
                          else{
                            $role = "Student";
                          }
                $output .="
                <td> {$role}</td>";

                if($row['user_faculty']!=NULL){
                           if($row['user_faculty']==1){
                              $f = "CSIT"; }
                          else{
                               $f = "BCA"; 
                             } }
                else{
                        $f = "-";
                        }

                $output .= "
                <td> {$f}</td>
                <td> {$row["user_semester"]}</td>
                <td> {$row["user_code"]}</td><td>
                 {$row["isactive"]}</td><td>
                            <form method='post'>
                            <a href='manage/edit.php?a=user_fullname,user_email,user_permission,user_faculty,user_semester,isactive&b=swastik_users&c=user_id&d={$row["user_id"]}' style='color:green;'>Edit</a> 
                            <a onclick='return confirm('Are you sure this user is not active anymore?') ' href='user/notactive.php?id={$row["user_id"]}'' style='color:red' class=''>Close</a>

                            <a onclick='return confirm('Are you sure to delete?')'  href='manage/delete.php?a=swastik_users&b=user_id&c={$row["user_id"]}'' style='color:red' class='right'>Delete </a>
                        </form>
                        </td></tr>";
              }
              
    $output .= "</table>";
    

    mysqli_close($conn);

    echo $output;
}else{
    $output.="<tr><td colspan='6' align='center'>No record Found.</td></tr> </table>";
    echo $output;
}

?>
