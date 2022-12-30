<?php
	 include 'auth.php';
	$id = $_GET['id'];
	$active = $obj_admin->notActive($id);
	header('Location:../users.php')

?>