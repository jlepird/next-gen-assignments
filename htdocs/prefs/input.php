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

    <?php $res = $sql->queryJSON("select posn from nextGen.billetOwners where user = '" . $_SESSION["uname"] . "';");
        if ($res == "[]") { // // if they don't own a billet and therefore an officer, then they are redirected to a page to submit a preference list of assignments
        	include "./assignments_preference.php";
        } else { // if they own a billet, then they are redirected to a page to submit a preference list of officers
        	$data = $sql->queryJSON("select nextGen.billetOwners.posn, tkey, val from nextGen.billetData " . 
    	                    "left outer join nextGen.billetOwners on nextGen.billetData.posn = nextGen.billetOwners.posn" . 
    	                    " where user = '" . $_SESSION["uname"] . "';");
        	$descs = $sql->queryJSON("select nextGen.billetOwners.posn, txt from nextGen.billetDescs " . 
    	                    "left outer join nextGen.billetOwners on nextGen.billetDescs.posn = nextGen.billetOwners.posn" . 
    	                    " where user = '" . $_SESSION["uname"] . "';");
        	include "./officer_preference.php";
        }
    
        ?>

    </div>

</div>


</body>
</html>
