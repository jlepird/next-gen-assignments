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
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br>
    <p> Pref List Filler Text </p>


     <?php
     $res1 = $sql->queryJSON("select username from nextGen.users where username = '" . $_SESSION["uname"] . "';");
     //$res2 = $sql->queryJSON("select username from nextGen.users where username = '" . $_SESSION["uname"] . "';");
     
        if ($res1 == []) { // if they are an owner, then display a page to submit a preference list of officers
        	include "./officer_preference.php";
        }
        if ($res1 == "a1") { // if they are an officer, then display a page to submit a preference list of assignments
        	include "./assignments_preference.php";
        }
        
    ?>

    </div>

</div>


</body>
</html>
