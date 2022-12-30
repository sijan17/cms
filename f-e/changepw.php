<?php
	require 'auth.php';
	$cp = $_POST['cp'];
	$np = $_POST['np'];
	$id = $_SESSION['user_id'];

	$change = $obj_admin->changePw($cp, $np,$id);
	header('Location:profile.php');
?><?php
	require 'auth.php';
	$cp = $_POST['cp'];
	$np = $_POST['np'];
	$id = $_SESSION['user_id'];

	$change = $obj_admin->changePw($cp, $np,$id);
	header('Location:profile.php');
?>