<?php
require 'auth.php';
$prefix = "";
$to="";
$from = "";
function codeGen($s,$e,$p){
$number = range($s, $e);
$arr = [];
foreach ($number as $n) {
    $arr[$n]=strtoupper(bin2hex(random_bytes(2)));;
    
}


return $arr;
}

if(isset($_POST['submit'])){
    $to = $_POST['end'];
    $from = $_POST['start'];
    $prefix = strval($_POST['prefix']);

    $code = codeGen($from,$to,$prefix);
    $code;

    $data = "";
foreach ($code as $key => $value) {
    $data.= "('".$prefix.$key."','".$value."')";
    if($code[$key+1]!=NULL){
        $data.=",";
        }
}
}

if (isset($_POST['post'])) {
    $post = $obj_admin->postCode($_POST['data']);
}

$f= $obj_admin->display('swastik_codes','code_id');

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>User Codes</title>
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">

<style>
    thead{
        font-weight: bold;
    }
    .contents{
        display: flex;
    }
    .left-div{
        float: left;
        width: 30vw;
        display: float;
        align-items: center;
        padding-left: 20px;
    }
    .right-div{
        width: 50vw;

        float: right;
        
    }
    input[type='submit'],button{
        margin:  8px 0;
    }

</style>
</head>
<body>

<ul>
  <li><a href="home.php">Home</a></li>
   <li><a   href="manage.php">Manage</a></li>
   <li><a   href="public.php">Public Info</a></li>
   <li><a href="users.php">Users</a></li>
   <li><a   href="feedback.php">Feedback</a></li>
    <li><a  class="active"  href="codes.php">Codes</a></li>
   <li><a href="../f-e/home.php">View as User</a></li>
  
  <li style="float:right"><a href="../f-e/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>


<div class="left">
<div class="contents">
  <!-- -------------------Notices------------------- -->
  <div class="left-div">
  <h2>Codes</h2>
  


                <table>
                    <b>
                    <thead>
                      <td style="width:50px">S.N</td>
                        <td style="width:100px">Reg. No.</td>
                        <td style="width:100px">Code</td>
                        <td style="width:50px">Actions</td>
                        
                    </thead>
                </b>
                    <?php
                    for($i=0; $i<=100; $i++){
                        if($f[$i]['code_id'] != NULL){
                    ?>
                    
                    <tr>
                        <td><?php echo $i+1?></td>  
                        <td><?php echo $f[$i]['reg_no']?></td>
                        <td><?php echo $f[$i]['code']?></td>
                        <td><a onclick="return confirm('Are you sure to delete?')"  href="manage/delete.php?a=swastik_codes&b=code_id&c=<?php echo $f[$i]['code_id'] ?>" style="color:red" class="right">Delete </a></td>
                        
                      </tr>





                    <?php } } ?>
                </table>

    </div>            
    <div class="right-div">
          <h2>Generate Codes</h2>
        <form name="form1" method="post">
    Prefix
    <br>
    <input type="text" name="prefix" placeholder="eg. BCA-2078-" value="<?php echo $prefix ?>"><br>Range<br>
    <input type="text" name="start" placeholder="From" value="<?php echo $from ?>">
    <input type="text" name="end" placeholder="To" value="<?php echo $to ?>">
    <input type="submit" name="submit" value="Generate">
</form>
<?php echo $post ?>
<?php if(isset($code)){ ?>
    <form method="post">
    <input type="hidden" name="data" value="<?php echo $data ?>">
    <input type="submit" name="post" value="Upload to Database"><input style="margin-left: 10px" type="button" value="print" onclick="PrintDiv();" />
</form>
<div id="divToPrint">
<table>
    <tr>
        <td style="width:150px">Reg. No. </td>
        <td style="width:150px">Code</td>
    </tr>
    <?php foreach ($code as $key => $value) {?>
        <tr>
            <td><?php echo $prefix.$key ?> </td>
            <td><?php echo $value ?> </td>
        </tr>
    <?php } ?>
</table>
</div>




<?php } ?>






    </div>
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
 <script type="text/javascript">     
    function PrintDiv() {    
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=300,height=300');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
            }
 </script>



</body>
</html>


