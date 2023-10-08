<?php 
require 'auth.php';
	if(isset($_POST['submit'])){
	$post = $obj_admin->post_resource($_POST);
}
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
  <li><a href="../home.php">Home</a></li>
   <li><a href="../manage.php">Manage</a></li>
   <li><a href="../public.php">Public Info</a></li>
   <li><a href="../users.php">Users</a></li>
   <li><a href="../feedback.php">Feedback</a></li>
    <li><a class="active" href="#">Add</a></li>
  <li style="float:right"><a href="../../f-e/logout.php" onclick="confirm('Are you sure you want to logout?')">Logout</a></li>
</ul>

<div class="form">
	<form method="post">
				<label>Resource Name</label><br>
				<textarea name="name" ></textarea>  <br><br>

				<label>Resource Link</label><br>
				<textarea name="link" ></textarea>  <br><br>

				<?php echo $post ?>


<input type="submit" name="submit" value="submit">
</form>


</div>


</body>
</html>
