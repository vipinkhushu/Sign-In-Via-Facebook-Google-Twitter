<?php 

/******Logging User Out By Removing All Sessions**************/
session_start();
session_unset();
    $_SESSION['token'] = NULL;
    $_SESSION['user_check']=NULL;
    $_SESSION['Fuid']=NULL;
	$_SESSION['fname']=NULL;
	$_SESSION['lname']=NULL;
	$_SESSION['gender']=NULL;
	$_SESSION['fullname']=NULL;
	$_SESSION['fblink']=NULL;
	$_SESSION['dp']=NULL;
	$_SESSION['referal']=NULL;
header("Location: index.php");       
?>
