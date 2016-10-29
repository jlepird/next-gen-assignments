<?php 
// This tiny file just resets everything and brings the user back to normal. 
session_start(); 
$_SESSION = array(); 
header("Location: index.php");
?>