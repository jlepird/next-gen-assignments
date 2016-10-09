<?php
session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}

include '../include/head_common.php';

$id = $_POST["id"];

// Ensure owner actually owns the position! 
$owner = $sql->queryValue("select user from nextGen.billetOwners where posn = '" . $id . "'; ");
if ($owner != $_SESSION["uname"]) {
	die("User " . $_SESSION["uname"] . " not authorized to make changes to billet " . $id . ".");
}

// Iterate over each POSTed value, and then update the SQL database appropriately. 
foreach ($_POST as $key => $value) {
	echo "Key: " . $key . " Value: " . $value . "<br>";
	if ($key == "desc"){
		$sql->execute("update nextGen.billetDescs set txt = '" . $value . "' where posn = '" . $id . "'; ");
	} elseif ($key == "id"){
		continue; 
	} else {
		$sql->execute("update nextGen.billetData set val = '" . $value . "' where posn = '" . $id . "' and tkey = '" . $key . "'; ");	
	}
}
$_SESSION["lastViewed"] = $id; 
header("Location: manage.php"); 
?> 