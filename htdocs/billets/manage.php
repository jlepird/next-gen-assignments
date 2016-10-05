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
    <?php $res = $sql->queryJSON("select posn from nextGen.billetOwners where user = '" . $_SESSION["uname"] . "';");
    if ($res == "[]") {
    	include "./nobillets.php";
    } else {
    	$data = $sql->queryJSON("select nextGen.billetOwners.posn, tkey, val from nextGen.billetData " . 
	                    "left outer join nextGen.billetOwners on nextGen.billetData.posn = nextGen.billetOwners.posn" . 
	                    " where user = '" . $_SESSION["uname"] . "';");
    	$descs = $sql->queryJSON("select nextGen.billetOwners.posn, txt from nextGen.billetDescs " . 
	                    "left outer join nextGen.billetOwners on nextGen.billetDescs.posn = nextGen.billetOwners.posn" . 
	                    " where user = '" . $_SESSION["uname"] . "';");
    	include "./yesbillets.php";
    }

    ?>
    </div>

</div>


</body>
</html>
