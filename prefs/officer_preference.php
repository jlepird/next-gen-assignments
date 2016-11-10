<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isAirman'] != 't' ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}
?>
<!DOCTYPE html> 
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>

    <script type="text/javascript">
    <?php
    	if ($_SESSION["justSubmitted"]){
    		echo "alert('Preferences Successfully Submitted!');";
    		$_SESSION["justSubmitted"] = False;
    	} 
    ?>
    </script>
    </head>
    <script>
    // First, we need a list of all the billets we can populate. 

    	
    	// Get names of available billets. Need to do this in case other fields are missing for some reason 
	    var rawBillets = <?php echo $sql->queryJSON("select distinct posn from billetOwners;"); ?>;
		
	    // Get a list of their locations. 
	    var billetLocs = <?php echo $sql->queryJSON("select posn, val from billetData where tkey = 'location';"); ?>;
	    // Rename key for merge
	    billetLocs = $(billetLocs).each(function(i, x){
	    	x.location = x.val;
	    	delete x.val;
	    });

	    // Get the units of available billets 
	    var billetUnits = <?php echo $sql->queryJSON("select posn, val from billetData where tkey = 'unit';"); ?>;
	    // Rename key 
	    billetUnits = $(billetUnits).each(function(i, x){
	    	x.unit = x.val;
	    	delete x.val;
	    });

	    // Get the duty titles of available billets 
	    var billetTitles = <?php echo $sql->queryJSON("select posn, val from billetData where tkey = 'dutyTitle';"); ?>;
	    // Rename key 
	    billetTitles = $(billetTitles).each(function(i, x){
	    	x.title = x.val;
	    	delete x.val;
	    });

	    // Get list of billets the user has favorited
	    var billetFavs = <?php echo $sql->queryJSON("select posn from favorites where username = '". $_SESSION["uname"] . "';"); ?>;

	    // Merge the objects. 
	    billets = $.extend(true, {}, rawBillets, billetLocs, billetUnits, billetTitles);

	    $(billets).each(function(i,x){
	    	x.favorite = false; 
	    	$(billetFavs).each(function(i, y){
	    		if (x.posn == y.posn) {
	    			x.favorite = true;
	    		}
	    	})
	    })

	    // Re-order the array so that the favorites come first
	    billets = billets.sort(function(a,b){ // sort expects a compare function
	    	return (b.favorite) - (a.favorite);
	    })

	    // Get the list of preferences the user has (if any)
	    var initialPrefs = <?php echo $sql->queryJSON("select posn, pref from airmanPrefs where username = '" . $_SESSION["uname"] . "';"); ?>; 

	    // After page load, populate datalist with options
	    $(function(){
	    	// Define available otpions 
	    	var options = "";
    		options += "<option value=''>No Preference</option>";
    		options += "<optgroup label='Favorites'>";

    		// build out the options string
    		var haveMoreFavorites = true;
    		$(billets).each(function(i, billet){
    			if (haveMoreFavorites & !billet.favorite){
    				haveMoreFavorites = false;
    				options += "</optgroup>";
    				options += "<optgroup label = 'Others'>";
    			}
    			options += "<option value='" + billet.posn + "'>#" + billet.posn + ' - ' + billet.title + ' - ' + billet.unit + ' - ' + billet.location + "</option>";
    		});
    		options += "</optgroup>";

	    	// Add options
	    	$(".chosen-select").each(function(i, x){
	    		$(x).append(options);	    		
	    	});

		    initialPrefs.forEach(function(x){
		    	$("#billets" + x.pref)[0].value = x.posn; 
		    });
		    
		    $(".chosen-select").chosen({width: "400px"});

		  });

	    // Hard-coded value for number of preferences available
	    var numPrefs = 10; 


	    // Make array of billet names for enforcement later 
	    var billetNames = []; 
	    billets.each(function(i, x ){
	    	billetNames.push(x.posn); 
	    }); 

	    // This function ensures that the preferences are sensible
	    var verify = function(x){
	    	myId = +x.id.substr(7); // Get our preference number

	    	var foundError = false; 
	    	// Validate each element in our list 
	    	for (var i = 1; i <= numPrefs; ++i){
	
	    		var val = $("#billets" + i)[0].value;

	    		// Verify each billet 
	    		if (val){ // if nonempty 

	    			// Ensure it's an allowable one 
	    			if (billetNames.indexOf(val) == -1){ 
	    				foundError = true; 
	    				$("#row" + i)[0].innerHTML = "&larr; Unknown Billet Number " + val;
	    				break;
	    			}
	    			// Make sure it's not a duplicate of a one before it. 
	    			$("#row" + i)[0].innerHTML = "";
	    			for (var j = 1; j < i; ++j){
		    			if (val == $("#billets" + j)[0].value) {
		    				$("#row" + i)[0].innerHTML = "&larr; Repeat of #" + j;
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
    <div class="col-md-6">
    <br> <br> <br>
    <h3> My Preference List </h3>
    <p> <?php echo $_SESSION['uname'] ?>, enter your preferences below: </p>

    <datalist id = "billets"> </datalist> <!-- Javascript will fill in -->

    <form action = "submitOfficer.php" method = "POST">
    <fieldset id = "prefs">
    	<table> 
    			<tr> <td> Preference #1: </td> <td> 
    	<select class = "chosen-select" id = "billets1" name = "billets1" onchange = "verify(this);"> </td> <td id = "row1"> </td></tr>
    			<tr> <td> Preference #2: </td> <td> 
    	<select class = "chosen-select" id = "billets2" name = "billets2" onchange = "verify(this);"> </td> <td id = "row2"> </td</tr>
    	    	<tr> <td> Preference #3: </td> <td> 
    	<select class = "chosen-select" id = "billets3" name = "billets3" onchange = "verify(this);"> </td> <td id = "row3"> </td</tr>
    	    	<tr> <td> Preference #4: </td> <td> 
    	<select class = "chosen-select" id = "billets4" name = "billets4" onchange = "verify(this);"> </td> <td id = "row4"> </td</tr>
    	    	<tr> <td> Preference #5: </td> <td> 
    	<select class = "chosen-select" id = "billets5" name = "billets5" onchange = "verify(this);"> </td> <td id = "row5"> </td</tr>
    	    	<tr> <td> Preference #6: </td> <td> 
    	<select class = "chosen-select" id = "billets6" name = "billets6" onchange = "verify(this);"> </td> <td id = "row6"> </td</tr>
    	    	<tr> <td> Preference #7: </td> <td> 
    	<select class = "chosen-select" id = "billets7" name = "billets7" onchange = "verify(this);"> </td> <td id = "row7"> </td</tr>
    	    	<tr> <td> Preference #8: </td> <td> 
    	<select class = "chosen-select" id = "billets8" name = "billets8" onchange = "verify(this);"> </td> <td id = "row8"> </td</tr>
    	    	<tr> <td> Preference #9: </td> <td> 
    	<select class = "chosen-select" id = "billets9" name = "billets9" onchange = "verify(this);"> </td> <td id = "row9"> </td</tr>
    	    	<tr> <td> Preference #10: </td> <td> 
    	<select class = "chosen-select" id = "billets10" name = "billets10" onchange = "verify(this);"> </td> <td id = "row10"> </td</tr>

    	</table>
    </fieldset>
    	<fieldset>
    		<center> <input class = "btn btn-primary" id = "submit" type = "submit" value = "Submit"> </center>
    	</fieldset>
    </form>

    </div>

</div>


</body>
</html>
