<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 't' ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}
include $_SERVER['DOCUMENT_ROOT'] . '/include/head_common.php';

$res = $sql->execute("select surf from surfs where ri_person_id = '" . $_GET["id"] . "';");

echo pg_fetch_row($res)[0];


?>

