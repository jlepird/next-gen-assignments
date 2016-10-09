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
    <script type = "text/javascript"> 
    var data = <?php
    	$billet = $_GET['billet']; 
    	$data = $sql->queryJSON("select posn, tkey, val from nextGen.billetData where posn = '" . $billet . "';");
        echo $data; 

    ?>; 
    </script>
<body>
<?php include '../banner.php'; ?>

<div class="col-md-3">  </div>

<div class = "col-md-5" > 





</div>