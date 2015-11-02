<?php
session_start();
//destroy session
$_SESSION['login_status']=false;
//redirect to login
header("Location:landing.html");

?>