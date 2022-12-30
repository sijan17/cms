<?php 

ob_start();
session_start();
require '../../classes/control_class.php';
$obj_admin = new control_Class();
$auth = $obj_admin->auth();
$admin = $obj_admin->admincheck();
if(isset($_GET['logout'])){
	$obj_admin->admin_logout();
}
?>