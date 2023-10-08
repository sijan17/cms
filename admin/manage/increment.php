<?php
require 'auth.php';
$a = $_GET['key'];
$update = $obj_admin->increment($a);
header('Location:../home.php');


?>