<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}

include '../include/head_common.php';

// Need to validate that this user owns this billet 
$res = $sql->queryValue("select 1 from nextGen.billetOwners where user = '" . $_SESSION["uname"] . "' and posn = '" . $_GET["billet"] . "';"); 
if ($res == "ERROR-- no rows returned"){
	die("Access forbidden"); 
}

$sql->execute("delete from nextGen.billetPrefs where posn = '" . $_GET["billet"] . "';"); 
for ($i = 1; $i <= 10; $i++){
	$airman = $sql->sanitize($_POST["airman" . $i]);
	if ($airman != "") {
		$sql->execute("insert into nextGen.billetPrefs values ('" . $airman . "','" . $_GET["billet"] . "', " . $i . ");");
	}
}

header("Location: assignments_preference.php?billet=" . $_GET["billet"]);
?>