<?php
require 'credentials.php';
$connection = mysql_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db($DB_DATABASE) or die( "Unable to select database");

/******Adding Users To The Database And Updating Their Info If They Are Already Registered**************/

function checkAndAddUser($Fuid,$fname,$lname,$gender,$email,$fullname,$fblink,$dp,$referal){
    $check = mysql_query("select * from users where email='$email'");
	$check = mysql_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record		
	$query = "INSERT INTO users (Fuid,fname,lname,email,fullname,fblink,gender,dp,lastlogin,referal) VALUES ('$Fuid','$fname','$lname','$email','$fullname','$fblink','$gender','$dp',now(),'$referal')";
	mysql_query($query);	
	$_SESSION['user_check']=$email;
	} else {   // If Returned user . update the user record	
	$_SESSION['user_check']=$email;
	$query = "UPDATE Users SET  lastlogin=now() WHERE email='$email' ";
	mysql_query($query);
	}
}?>
