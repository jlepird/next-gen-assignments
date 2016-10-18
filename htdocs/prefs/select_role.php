<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?> 

<html>
<head> 
<?php include '../include/head_common.php'; ?>
<script>

// Get list of billets assigned to user-- don't need to worry about security, it's verifyied by the php page.  
var billets = <?php echo $sql->queryJSON("select posn from nextGen.billetOwners where user = '" . $_SESSION["uname"] . "';"); ?>; 

// Populate after page load. 
$(function(){
	billets.forEach(function(x){
	$("#switch tr:last").after("<tr> <td> <a href='./assignments_preference.php?billet=" + x.posn + "'> Billet " + x.posn + "</a> </td> </tr>" );
});
});

</script>
</head>
<body> 
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
<div class="col-md-5">
<br> <br> <br> <br> 
<h5> Select your Role: </h5>
<br> 
<table id = "switch" class = "table-bordered">
<tr> <td> <a href="./officer_preference.php"> Self (My Assignment Preferences) </a> </td> </tr>
</table>
</body>
</html>