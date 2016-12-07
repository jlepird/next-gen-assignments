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
var billets = <?php echo $sql->queryJSON("select posn from billetOwners where username = '" . $_SESSION["uname"] . "';") .";"; 
?>


// Populate after page load. 
$(function(){
	billets.forEach(function(x){
	$("#switch option:last").after("<option value='./assignments_preference.php?billet=" + x.posn + "'> Billet " + x.posn + "</option>" );
	});
	$("#switch").chosen();
});

</script>
</head>
<body> 
<?php include '../banner.php'; ?>

<div class="col-md-3">  </div>
<div class="col-md-5">
<br> <br> <br> <br> <br><br>

<h3>Instructions</h3>
<ul>
    <li>If you are an officer searching for assignments, click on "Self (My Assignment Preferences)" to input your ranked list of preferred assignments.</li>
    <li>If you are a billet owner, click on all billets listed to ensure each one has an associated list of officers that are best suited for that particular assignment.</li>
</ul>
<h5 style="display: inline;"> Select your Role: </h5>
<select id = "switch">
<?php if ($_SESSION["isAirman"]) {
	echo '<option value="./officer_preference.php"> Self (My Assignment Preferences) </option>'; 
	}?>
</select>
<button class="btn-primary" onclick="window.location.href = $('#switch').val();">
    Go!
</button>
</body>
</html>