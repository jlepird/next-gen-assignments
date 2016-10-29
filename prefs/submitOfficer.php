<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isAirman'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}

include '../include/head_common.php';

$sql->execute("delete from nextGen.airmanPrefs where user = '" . $_SESSION["uname"] . "';"); 
for ($i = 1; $i <= 10; $i++){
	$billet = $sql->sanitize($_POST["billets" . $i]);
	if ($billet != "") {
		$sql->execute("insert into nextGen.airmanPrefs values ('" . $_SESSION["uname"] . "','" . $billet . "', " . $i . ");");
	}
}

header("Location: officer_preference.php");

?>