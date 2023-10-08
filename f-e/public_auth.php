<?php 

ob_start();
session_start();
require '../classes/control_class.php';
$obj_admin = new control_Class();
if($_SESSION['admin']==true){
			header('Location: ../admin/home.php');
		}
			else if($_SESSION['login']==true){
			header('Location: home.php');
		}