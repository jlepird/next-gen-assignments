<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}

include '../include/head_common.php';


if ($_POST["case"] == "true"){
	$sql->execute("insert into amnfavorites values ('" . $_SESSION["uname"] . "', '" . $_POST["officer"] . "');");
} else {
	$sql->execute("delete from amnfavorites where username = '" . $_SESSION["uname"] . "' and id = '" . $_POST["officer"] . "';");
}

?>