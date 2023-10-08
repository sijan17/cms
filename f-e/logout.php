<?php 
session_start();

session_destroy();
setcookie('c_session','',time()+1, "/","", 0);

header('Location: login.php');