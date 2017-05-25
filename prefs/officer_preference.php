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
    		echo '$(function(){swal("Success!", "Preferences Successfully Submitted.", "success");});';
    		$_SESSION["justSubmitted"] = False;
    	} 
    ?>
    </script>
    </head>
    <script>

	    // Get how many people have priorized each billet
	    var billetPriors = <?php echo $sql->queryJSON("select posn, count(*) as val from airmanprefs where username != '" . $_SESSION["uname"] . "' group by posn;"); ?>;
	    var maxPref = d3.max(billetPriors, function(x){
	    	return +x.val;
	    })

	    // Define the color scale we'll use to code the prior preferences
	    var scale = d3.scale.linear()
	                        .domain([0, maxPref])
	                        .range(["#42f483", "#d66464"]);

	    // Get list of billets the user has favorited
	    var billetFavs = <?php echo $sql->queryJSON("select posn from favorites where username = '". $_SESSION["uname"] . "';"); ?>;

	    // Get our display list of billets
	    billets = <?php echo $sql->queryJSON("select posns.posn, location, unit, title from 
(select posn from billetDescs) posns 
left outer join 
(select posn, val as location from billetdata where tkey = 'Location') locs on posns.posn = locs.posn
left outer join 
(select posn, val as unit from billetdata where tkey = 'Unit') units on posns.posn = units.posn
left outer join
(select posn, val as title from billetData where tkey = 'DutyTitle') titles on posns.posn = titles.posn;
"); ?>;

	    $(billets).each(function(i,x){
	    	x.favorite = false; 
	    	$(billetFavs).each(function(i, y){
	    		if (x.posn == y.posn) {
	    			x.favorite = true;
	    		}
	    	})
	    });

	    // Re-order the array so that the favorites come first
	    billets = billets.sort(function(a,b){ // sort expects a compare function
	    	return (b.favorite) - (a.favorite);
	    });

	    // Get the list of preferences the user has (if any)
	    var initialPrefs = <?php echo $sql->queryJSON("select posn, pref from airmanPrefs where username = '" . $_SESSION["uname"] . "';"); ?>; 

	    // After page load, populate datalist with options
	    $(function(){
	    	// Define available otpions 
	    	var options = "";
    		options += "<option value=''>Needs of the Air Force</option>";
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

		    showOthers();
		  });

	    // Hard-coded value for number of preferences available
	    var numPrefs = 10; 


	    // Make array of billet names for enforcement later 
	    var billetNames = []; 
	    $(billets).each(function(i, x ){
	    	billetNames.push(x.posn); 
	    }); 

	    // This function ensures that the preferences are sensible
	    var verify = function(x){
	    	myId = +x.id.substr(7); // Get our preference number

	    	var foundError = false; 
	    	// Validate each element in our list 
	    	for (var i = 1; i <= numPrefs; ++i){
	
	    		var val = $("#billets" + i)[0].value;

    			// Reset row text
    			$("#row" + i)[0].innerHTML = "";
    			$("#count" + i).remove(); // ensure count is removed

	    		// Verify each billet 
	    		if (val){ // if nonempty 

	    			// Ensure it's an allowable one 
	    			if (billetNames.indexOf(val) == -1){ 
	    				foundError = true; 
	    				$("#row" + i)[0].innerHTML = "&larr; Unknown Billet Number " + val;
	    				break;
	    			}



	    			// Make sure it's not a duplicate of a one before it. 
	    			
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
				showOthers();
			}

	    }

	    var showOthers = function(){
	    	for(var i = 1; i <= numPrefs; ++i){
	    		var val = $("#billets" + i).val();
	    		if (val != ""){
	    			var subset = billetPriors.filter(function(x){
	    				return x.posn == val;
	    			}); 

	    			var count = 0; 
	    			if (subset.length > 0){
	    				count = subset[0].val; 
	    			}

	    			$("#row" + i)[0].innerHTML = "<div class=update-prefs id=count" + i + "> &larr; Already ranked by " + count + " other(s). </div>";
	    			$("#count" + i).css("background-color", scale(count));
	    		} else {
	    			$("#count" + i).remove();
	    		}
	    	}
	    }

    </script>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-6">
    <br> <br> <br>
    <h3> My Preference List </h3>
    <p> <?php echo $_SESSION['uname'] ?>, enter your preferences below.</p>

    <div style="background-color: #42f483">
    <p> You have been ranked by <?php echo str_replace('"', "", $sql->queryValue("select count(*) from billetPrefs left outer join users on billetPrefs.name = users.name where username='" . $_SESSION['uname'] . "';")); ?> billets (<?php echo str_replace('"', "", $sql->queryValue("select count(distinct posn) from billetPrefs;"));?>/<?php echo str_replace('"', "", $sql->queryValue("select count(distinct posn) from billetOwners;"));?> billets have submitted preferences). </p>
    </div>

    <datalist id = "billets"> </datalist> <!-- Javascript will fill in -->

    <form action = "submitOfficer.php" method = "POST">
    <fieldset id = "prefs">
    	<table> 
    			<tr> <td> Preference #1: </td> <td> 
    	<select class = "chosen-select" id = "billets1" name = "billets1" onchange = "verify(this);"> </td> <td id = "row1"> </td></tr>
    			<tr> <td> Preference #2: </td> <td> 
    	<select class = "chosen-select" id = "billets2" name = "billets2" onchange = "verify(this);"> </td> <td id = "row2"> </td></tr>
    	    	<tr> <td> Preference #3: </td> <td> 
    	<select class = "chosen-select" id = "billets3" name = "billets3" onchange = "verify(this);"> </td> <td id = "row3"> </td></tr>
    	    	<tr> <td> Preference #4: </td> <td> 
    	<select class = "chosen-select" id = "billets4" name = "billets4" onchange = "verify(this);"> </td> <td id = "row4"> </td></tr>
    	    	<tr> <td> Preference #5: </td> <td> 
    	<select class = "chosen-select" id = "billets5" name = "billets5" onchange = "verify(this);"> </td> <td id = "row5"> </td></tr>
    	    	<tr> <td> Preference #6: </td> <td> 
    	<select class = "chosen-select" id = "billets6" name = "billets6" onchange = "verify(this);"> </td> <td id = "row6"> </td></tr>
    	    	<tr> <td> Preference #7: </td> <td> 
    	<select class = "chosen-select" id = "billets7" name = "billets7" onchange = "verify(this);"> </td> <td id = "row7"> </td></tr>
    	    	<tr> <td> Preference #8: </td> <td> 
    	<select class = "chosen-select" id = "billets8" name = "billets8" onchange = "verify(this);"> </td> <td id = "row8"> </td></tr>
    	    	<tr> <td> Preference #9: </td> <td> 
    	<select class = "chosen-select" id = "billets9" name = "billets9" onchange = "verify(this);"> </td> <td id = "row9"> </td></tr>
    	    	<tr> <td> Preference #10: </td> <td> 
    	<select class = "chosen-select" id = "billets10" name = "billets10" onchange = "verify(this);"> </td> <td id = "row10"> </td> </tr>

    	</table>
    </fieldset>
    	<fieldset>
    		<center> <input class = "btn btn-primary" id = "submit" type = "submit" value = "Submit"> </center>
    	</fieldset>
    </form>

    </div>

</div>

<div id = "footer"> For Official Use Only (FOUO) </div>
</body>
</html>
