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
var billets = <?php echo $sql->queryJSON("select posn from billetOwners where username = '" . $_SESSION["uname"] . "';"); ?>; 

function goTo(value){
	window.location.href = value;
}

// Populate after page load. 
$(function(){
	billets.forEach(function(x){
	$("#switch tr:last").after("<option value='./assignments_preference.php?billet=" + x.posn + "'> Billet " + x.posn + "</option>" );
	});
	$("#switch").chosen();
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
<select id = "switch" onchange="goTo(this.value);">
<?php if ($_SESSION["isAirman"]) {
	echo '<option value="./officer_preference.php"> Self (My Assignment Preferences) </option>'; 
	?>
</select>
</body>
</html>