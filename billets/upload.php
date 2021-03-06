<?php
session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}

include '../include/head_common.php';

$id = $_POST["id"];

// Ensure owner actually owns the position! 
$owner = $sql->queryValue("select username from billetOwners where posn = '" . $id . "' and username = '" . $_SESSION["uname"] . "'; ");
$owner = str_replace("\"", "",  $owner);
if ($owner != $_SESSION["uname"]) {
	die("User " . $_SESSION["uname"] . "vs" . $owner ." not authorized to make changes to billet " . $id . ".");
}

// Clear saved data
$sql->execute("delete from billetData where posn = '" . $id . "' and tkey != 'nrpp';");

// Iterate over each POSTed value, and then update the SQL database appropriately. 
foreach ($_POST as $key => $value) {
//	echo "Key: " . $key . " Value: " . $value . "<br>"; // for debug
	if ($key == "desc"){
		$value = $sql->sanitize($value); 
		
		$sql->execute("update billetDescs set txt= '" . $value . "' where posn = '" . $id . "';");
		//$sql->execute("delete from billetDescs where posn = '" . $id . "';");
		//$sql->execute("insert into billetDescs values('" . $id . "','" . $value . "');");
	} elseif ($key == "id" or $key == "nrpp"){
		continue; 
	} elseif (is_array($value)) { 
		foreach($value as $val){
			$val = $sql->sanitize($val); 
			$sql->execute("insert into billetData values ('" . $id . "','" . $key . "','" . $val . "'); ");	
		}
	} else { 
		$value = $sql->sanitize($value); 
		$sql->execute("insert into billetData values ('" . $id . "','" . $key . "','" . $value . "'); ");		
	}
}
$_SESSION["uploaded"] = true;
header("Location: manage.php?billet=" . $id ); 
?> 