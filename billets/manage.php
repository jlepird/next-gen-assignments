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
    <p>As part of this test, you are requested to submit detailed information on each of your billets.  This information will be searchable and read by potential officers on the VML to inform their assignment preference list.


    <br> <br> <br>
    <?php $res = $sql->queryJSON("select posn from billetOwners where user = '" . $_SESSION["uname"] . "';");
    if ($res == "[]") {
    	include "./nobillets.php";
    } else {
    	$data = $sql->queryJSON("select billetOwners.posn, tkey, val from billetData " . 
	                    "left outer join billetOwners on billetData.posn = billetOwners.posn" . 
	                    " where user = '" . $_SESSION["uname"] . "';");
    	$descs = $sql->queryJSON("select billetOwners.posn, txt from billetDescs " . 
	                    "left outer join billetOwners on nextGen.billetDescs.posn = nextGen.billetOwners.posn" . 
	                    " where user = '" . $_SESSION["uname"] . "';");
    	$_SESSION["billets"] = $res;
    	include "./yesbillets.php";
    }

    ?>
    </div>

</div>


</body>
</html>
