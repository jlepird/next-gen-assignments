<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isAirman'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}

include '../include/head_common.php';

$sql->execute("delete from airmanPrefs where username = '" . $_SESSION["uname"] . "';"); 
for ($i = 1; $i <= 10; $i++){
	$billet = $sql->sanitize($_POST["billets" . $i]);
	if ($billet != "") {
		$sql->execute("insert into airmanPrefs values ('" . $_SESSION["uname"] . "','" . $billet . "', " . $i . ");");
	}
}

$_SESSION["justSubmitted"] = True; 

header("Location: officer_preference.php");

?>