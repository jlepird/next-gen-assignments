<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 1 ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}
include '../include/head_common.php';
$res = $sql->execute("select posn from nextGen.billetOwners where user = '" . $_SESSION["uname"] . "';"); 

$authorized = false; 
while ($row = $res->fetch_row()){
	if ($row[0] == $_GET["billet"]){
		$authorized = true;
		break; 
	}
}
if (! $authorized){
	die("You don't have privileges to set preferences for billet " . $_GET["billet"] . ". If you think this is in error, please contact us."); 
}

?>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
    <script>
    	// Get list of airmen
	    var airmen = <?php echo $sql->queryJSON("select distinct name from nextGen.names;"); ?>;

	    var initialPrefs = <?php echo $sql->queryJSON("select name, pref from nextGen.billetPrefs where posn = '" . $_GET["billet"] . "';"); ?>; 

	    // After page load, populate datalist with options
	    $(function(){
		    d3.select("#airmen")
		      .selectAll("option")
		      .data(airmen)
		      .enter()
		      .append("option")
		      .attr("value", function(x){
		      	return x.name;
		      });

		    initialPrefs.forEach(function(x){
		    	$("#airman" + x.pref)[0].value = x.name; 
		    });

		  });

	    var numPrefs = 10; 


	    // Make array of billet names for enforcement later 
	    var airmenNames = []; 
	    airmen.forEach(function(x, i ){
	    	airmenNames.push(x.name); 
	    }); 

	    var verify = function(x){
	    	myId = +x.id.substr(7); // Get our preference number

	    	var foundError = false; 
	    	// Validate each element in our list 
	    	for (var i = 1; i <= numPrefs; ++i){
	
	    		var val = $("#airman" + i)[0].value;

	    		// Verify each billet 
	    		if (val){ // if nonempty 

	    			// Ensure it's an allowable one 
	    			if (airmenNames.indexOf(val) == -1){ 
	    				foundError = true; 
	    				$("#row" + i)[0].innerHTML = "&larr; Unknown Airman " + val;
	    				break;
	    			}
	    			// Make sure it's not a duplicate of a one before it. 
	    			$("#row" + i)[0].innerHTML = "";
	    			for (var j = 1; j < i; ++j){
		    			if (val == $("#airman" + j)[0].value) {
		    				$("#row" + i)[0].innerHTML = "&larr; Repeat of Preference #" + j;
		    				foundError = true;
		    				break;
		    			}
		    		}
	    		}
	    	}
			if (foundError){
				$("#submit")[0].disabled = "disabled"; 
				//$("#submit")[0].style.background = "#7a7d82"; 
			} else {
				$("#submit")[0].disabled = ""; 
				//$("#submit")[0].style.background = "#286090"; 
			}

	    }

    </script>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br>
    <h3> My Preference List </h3>
    <p> <?php echo $_SESSION['uname'] ?>, enter your preferences below for billet <b> <?php echo $_GET["billet"]; ?>: </p>

    <datalist id = "airmen"> </datalist> <!-- Javascript will fill in -->

    <form action = <?php echo "submitBillet.php?billet=" . $_GET["billet"]; ?> method = "POST">
    <fieldset id = "prefs">
    	<table> 
    			<tr> <td> Preference #1: </td> <td> 
    	<input list = "airmen" id = "airman1" name = "airman1" onchange = "verify(this);"> </td> <td id = "row1"> </td></tr>
    			<tr> <td> Preference #2: </td> <td> 
    	<input list = "airmen" id = "airman2" name = "airman2" onchange = "verify(this);"> </td> <td id = "row2"> </td</tr>
    	    	<tr> <td> Preference #3: </td> <td> 
    	<input list = "airmen" id = "airman3" name = "airman3" onchange = "verify(this);"> </td> <td id = "row3"> </td</tr>
    	    	<tr> <td> Preference #4: </td> <td> 
    	<input list = "airmen" id = "airman4" name = "airman4" onchange = "verify(this);"> </td> <td id = "row4"> </td</tr>
    	    	<tr> <td> Preference #5: </td> <td> 
    	<input list = "airmen" id = "airman5" name = "airman5" onchange = "verify(this);"> </td> <td id = "row5"> </td</tr>
    	    	<tr> <td> Preference #6: </td> <td> 
    	<input list = "airmen" id = "airman6" name = "airman6" onchange = "verify(this);"> </td> <td id = "row6"> </td</tr>
    	    	<tr> <td> Preference #7: </td> <td> 
    	<input list = "airmen" id = "airman7" name = "airman7" onchange = "verify(this);"> </td> <td id = "row7"> </td</tr>
    	    	<tr> <td> Preference #8: </td> <td> 
    	<input list = "airmen" id = "airman8" name = "airman8" onchange = "verify(this);"> </td> <td id = "row8"> </td</tr>
    	    	<tr> <td> Preference #9: </td> <td> 
    	<input list = "airmen" id = "airman9" name = "airman9" onchange = "verify(this);"> </td> <td id = "row9"> </td</tr>
    	    	<tr> <td> Preference #10: </td> <td> 
    	<input list = "airmen" id = "airman10" name = "airman10" onchange = "verify(this);"> </td> <td id = "row10"> </td</tr>

    	</table>
    </fieldset>
    	<fieldset>
    		<center> <input class = "btn btn-primary" id = "submit" type = "submit"> </center>
    	</fieldset>
    </form>

    </div>

</div>


</body>
</html>
