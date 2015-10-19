<?php

session_start();

$con=mysql_connect("localhost:8889","root","root") or die(mysql_error());
mysql_select_db("Properties",$con);
/*
$AIN=$_POST['AIN'];
$PIN=$_POST['PIN'];

if($AIN=='1234567891' && $PIN=='12345'){
	echo "Logged in";
}
else{
	echo "Wrong Password or Username";
}
*/

$AIN=mysql_real_escape_string($_POST['AIN']);
$PIN=$_POST['PIN'];

$captcha=$_POST['g-recaptcha-response'];

if(!$captcha){
	//echo "Please check the the captcha form.";
	header("Location:landing.html");
}

$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lfw-g0TAAAAABDWhGdHei3Bamv8_BIgvNZ9j7_9&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
if($response.success==false)
{
  //echo "You are spammer!";
  //refill captcha
	header("Location:landing.html");
}

$queary="select id from PropertyData where AIN='$AIN' and PIN='$PIN'";
$q_result=mysql_query($queary,$con);
$rows=mysql_num_rows($q_result);
if($rows!=0){
	//echo "Logged in";
	header("Location:index.php");
	//This is where we should direct to the new page
	$_SESSION['login_status']==true;
}
else{
	header("Location:landing.html");
	//echo "Wrong Password or Username";
}

?>