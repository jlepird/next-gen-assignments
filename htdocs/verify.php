<?php
session_start();
include_once("./include/funs.php");
$uname    = $_POST['uname'];
$password = md5($_POST['password']);

$email = $sql->queryValue("select email from nextGen.users where username = '" . $uname . 
	                     "' and password = '" . $password . "';"
);

if ($email == "ERROR-- no rows returned") { 
	die("Incorrect Login");
} else { 
	$_SESSION['uname'] = $uname; 
	$_SESSION['email'] = $email;
	header("Location: index.php");
}

?>