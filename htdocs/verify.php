<?php
session_start();
if ($_POST['uname'] == 'a9' and $_POST['password'] == 'test'){
	$_SESSION['uname'] = $_POST['uname']; 
	header("Location: index.php"); 
} else {
	die("Incorrect Login"); 
}
?>