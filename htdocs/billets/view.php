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

    // Run on page load 
    $(function(){
	    /* Update the values that we have */ 
		var toUpdate = document.getElementsByClassName("autopop");
		for (var i = 0; i < toUpdate.length; ++i){
			var row = data.filter(function(x){
				return x.tkey == toUpdate[i].name; 
			})
			toUpdate[i].value = row[0].val;
			toUpdate[i].disabled = "disabled";
		}

		document.getElementById("desc").value = '<?php echo $sql->queryValue("select txt from nextGen.billetDescs where posn = '" . $billet . "';") ?>'; 
		document.getElementById("desc").disabled = "disabled";

    })



    </script>
<body>
<?php include '../banner.php'; ?>

<div class="col-md-3">  </div>

<div class = "col-md-5" > 

<br> <br> <br> 
<h4> Billet # <?php echo $billet ?> </h4>
<?php include "table.html"; ?>


</div>