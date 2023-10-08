
<?php
	require 'auth.php';
	$a = $_GET['a'];
	$b = $_GET['b'];
	$c = $_GET['c'];
	$verify = $obj_admin->delete($a,$b,$c);
	header('Location: manage.php');

?>
