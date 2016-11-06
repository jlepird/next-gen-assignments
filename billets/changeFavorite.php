<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isAirman'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}

include '../include/head_common.php';

if ($_POST["case"] == "true"){
	$sql->execute("insert into favorites values ('" . $_SESSION["uname"] . "', '" . $_POST["billet"] . "');");
} else {
	$sql->execute("delete from favorites where username = '" . $_SESSION["uname"] . "' and posn = '" . $_POST["billet"] . "';");
}

?>