
<?php
	require 'auth.php';
	$a = $_GET['a'];
	$b = $_GET['b'];
	$c = $_GET['c'];
	$verify = $obj_admin->delete($a,$b,$c);

	if($a=="swastik_users_tbv"){
		header('Location: ../home.php');
	}
	elseif($a=="swastik_replies"){
		header('Location: ../replies.php');
	}
	else{
		header('Location: ../manage.php');
	}

?>
