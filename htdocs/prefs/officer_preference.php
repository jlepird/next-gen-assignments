<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
<body>
<?php include '../banner.php'; ?>

    <br> <br> <br>
    <p> You are a billet owner, so you will submit a preference list of officers you want. </p>


    </div>

</div>


</body>
</html>