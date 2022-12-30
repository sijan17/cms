<?php
	require 'auth.php';
	$a = $_GET['a'];
	$b = $_GET['b'];
	$c = $_GET['c'];
	$d = $_GET['d'];
	$delete = $obj_admin->delete($a,$b,$c);

	if($a=="swastik_replies"){
		header('Location: ../replies.php?q='.$d);
	}
	if($a=="swastik_notes"){
		header('Location: ../notes.php?q='.$d);
	}
	if($a=="swastik_questions"){
		header('Location: ../home.php');
	}

?>
