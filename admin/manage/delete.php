
<?php
	require 'auth.php';
	$a = $_GET['a'];
	$b = $_GET['b'];
	$c = $_GET['c'];
	$d = $_GET['d'];

	$delete = $obj_admin->delete($a,$b,$c);
	
	if($a == 'swastik_resources'){
		header('Location: ../public.php');
	}
	elseif($a=="swastik_replies"){
		header('Location: ../replies.php?q='.$d);
	}
	elseif($a=="swastik_feedback"){
		header('Location: ../feedback.php');
	}
	elseif($a=="swastik_codes"){
		header('Location: ../codes.php');

	}elseif($a=="swastik_users"){
		header('Location: ../users.php');
	}
	else{
	header('Location: ../manage.php'); }

?>
