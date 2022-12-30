<?php
	include 'auth.php';

	$id = $_GET['id'];
	
	$verify = $obj_admin->verifyUser($id);
	
	header('Location: ../home.php');

?>