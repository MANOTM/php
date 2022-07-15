<?php
session_start();
session_destroy();
setcookie('profile','null',time());
header('location:../index.php');
?>
