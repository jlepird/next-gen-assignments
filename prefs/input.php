<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
include '../include/head_common.php'; 
echo $sql->queryJSON("select posn from billetOwners where username = '" . $_SESSION["uname"] . "';");

if ($_SESSION['isOwner']){
    header("Location: ./select_role.php");
} elseif ($_SESSION['isAirman']) { // if they are an owner, then display a page to submit a preference list of officers
    header("Location: ./officer_preference.php");
//} elseif ($_SESSION['isOwner']) { // if they are an officer, then display a page to submit a preference list of assignments
//    header("Location: ./assignments_preference.php"); 
} else {
    die("Error-- Something has gone horribly wrong, and you don't have a role assigned to you."); 
}
?>

