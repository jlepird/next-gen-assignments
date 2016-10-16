<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if (!$_SESSION['isOwner'] != 1){
	header("Location: ./input.php"); // Unless user owns billets, they have no reason to be on this page. 
}
?>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br>
    <p> Pref List Filler Text </p>


    </div>

</div>


</body>
</html>
