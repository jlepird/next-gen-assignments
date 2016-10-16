<?php
session_start();
include_once("./include/funs.php");
$uname    = $sql->sanitize($_POST['uname']);
$password = md5($_POST['password']);

$email = $sql->queryValue("select email from nextGen.users where username = '" . $uname . 
	                     "' and password = '" . $password . "';"
);

if ($email == "ERROR-- no rows returned") { 
	die("Incorrect Login");
} else { 

	// Populate session variables and redirect user to main page
	$_SESSION['uname'] = $uname; 
	$_SESSION['email'] = $email;
	$_SESSION['isOwner'] = $sql->queryValue("select owner from nextGen.users where username = '" . $uname . "' and password = '" . $password . "';");
	$_SESSION['isAirman'] = $sql->queryValue("select officer from nextGen.users where username = '" . $uname . "' and password = '" . $password . "';");

	header("Location: index.php");
}

?>