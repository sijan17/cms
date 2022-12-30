<?php 
require 'auth.php';
$a = $_GET['a'];
$b = $_GET['b'];
$c = $_GET['c'];
$d = $_GET['d'];



if(isset($_POST['submit'])){
	$data = "";
	foreach($_POST as $k => $v){
		 if($k !== 'submit') {
		if(!empty($data)) $data .=", ";
        $data .= "`{$k}` = '{$v}'";
    }
    
    
	$post = $obj_admin->update($b,$data,$c, $d);
	if($b == 'swastik_users'){
		header('Location: ../users.php');
	} else if($b == 'swastik_resources' ||$b == 'swastik_contact' ){
		header('Location: ../public.php');
	}
		else{
	header('Location:../manage.php');
}
}

}
$res = $obj_admin->edit($a, $b, $c, $d);

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../style/admin.css">
	<style type="text/css">
		.form{
			width: 30%;
			margin: 0 auto;
			padding: 30px;
			border: 1px solid black;
			margin-top: 20px;
		}
		textarea{
			width: 100%;
			resize: none;
		}
	</style>
</head>
<body>

<ul>
  <li><a href="home.php">Home</a></li>
   <li><a href="manage.php">Manage</a></li>
   <li><a href="public.php">Public Info</a></li>
   <li><a href="users.php">Users</a></li>
   <li><a href="feedback.php">Feedback</a></li>
    <li><a class="active" href="home.php">Edit</a></li>
  <li style="float:right"><a href="../f-e/logout.php" onclick="confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>

<div class="form">
	<form method="post">
	<?php
	
		foreach ($res as $key => $value) {
			 if(is_int($key) != 1){
				?>
				<label><?php echo $key; ?></label><br>
				<textarea name="<?php echo $key ?>" value="<?php echo $value ?>"><?php echo $value ?></textarea>  <br><br>



				<?php
			}	
		}
			?>
			
<input type="submit" name="submit" value="submit">
</form>


</div>


</body>
</html>
