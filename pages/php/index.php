<?php

session_start();
if(isset($_SESSION['login_status'])==false){
	//redirect login
	header("Location:landing.html");
}

echo "Welcome Users";

?>