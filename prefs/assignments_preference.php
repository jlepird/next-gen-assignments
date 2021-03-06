<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 't' ){
	header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}
if (!isset($_GET["billet"])){
	header("Location: ./select_role.php");
}

include '../include/head_common.php';
$res = $sql->execute("select posn from billetOwners where username = '" . $_SESSION["uname"] . "';"); 

$authorized = false; 
while ($row = pg_fetch_row($res)){
	if ($row[0] == $_GET["billet"]){
		$authorized = true;
		break; 
	}
}
if (! $authorized){
	die("You don't have privileges to set preferences for billet " . $_GET["billet"] . ". If you think this is in error, please contact us."); 
}

?>
<!DOCTYPE html> 
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    
    <script type="text/javascript">
    <?php
    	if (isset($_SESSION["justSubmitted"]) and $_SESSION["justSubmitted"]){
    		echo '$(function(){swal("Success!", "Preferences Successfully Submitted.", "success");});';
    		$_SESSION["justSubmitted"] = False;
    	} 
    ?>
    </script>
    </head>
    <script>
    	// Get list of airmen 
    	// In postgres, || is string concatenation!
	    var airmen = <?php echo $sql->queryJSON("select distinct grd, ri_person_id as name from officers order by name ;"); ?>; 

	    var initialPrefs = <?php echo $sql->queryJSON("select id as name, pref from billetPrefs where posn = '" . $_GET["billet"] . "';"); ?>; 

	   	// Get how many people have priorized each billet
	    var amnPriors = <?php echo $sql->queryJSON("select id as name, count(*) as val from billetprefs where posn != '" . $_GET["billet"] . "' group by id;"); ?>;
	    var maxPref = d3.max(amnPriors, function(x){
	    	return +x.val;
	    })

	    var amnFavs = <?php echo $sql->queryJSON("select id from amnfavorites where username = '". $_SESSION["uname"] . "';"); ?>;

	    $(airmen).each(function(i, airman){
	    	airman.favorite = false;
	    	$(amnFavs).each(function(j, amn){
	    		if (airman.name == amn.id){
	    			airman.favorite = true;
	    		}
	    	})
	    })

	    // Re-order the array so that the favorites come first
	    airmen = airmen.sort(function(a,b){ // sort expects a compare function
	    	return (b.favorite) - (a.favorite);
	    });

	    var options = "";
	    options += "<option value=''>Any Officer</option>";
    	options += "<optgroup label='Favorites'>";

		// build out the options string
		var haveMoreFavorites = true;
		$(airmen).each(function(i, airman){
			if (haveMoreFavorites & !airman.favorite){
				haveMoreFavorites = false;
				options += "</optgroup>";
				options += "<optgroup label = 'Others'>";
			}
			options += "<option value='" + airman.name + "'>" + airman.grd + " " + airman.name + "</option>";
		});
		options += "</optgroup>";


	    // Define the color scale we'll use to code the prior preferences
	    var scale = d3.scale.linear()
	                        .domain([0, maxPref])
	                        .range(["#42f483", "#d66464"]);

	    // After page load, populate datalist with options
	    $(function(){
	    	// Add options
	    	$(".chosen-select").each(function(i, x){
	    		$(x).append(options);
	    	});

		    initialPrefs.forEach(function(x){
		    	$("#airman" + x.pref)[0].value = x.name; 
		    });
			
			$(".chosen-select").chosen({width: "200"});

			showOthers();
			
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
	    		var val = $("#airman" + i).val();
	    		if (val != ""){
	    			var subset = amnPriors.filter(function(x){
	    				return x.name == val;
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
    <div class="col-md-5">
    <br> <br> <br>
    <h3> My Preference List </h3>
    <p> <?php echo $_SESSION['uname'] ?>, enter your preferences below for billet <b> <?php echo $_GET["billet"]; ?></b>: </p>

    <div style="background-color: #42f483">
    <p> This billet has been ranked by <?php echo str_replace('"', "", $sql->queryValue("select count(*) from airmanPrefs where posn='" . $_GET["billet"] . "';")); ?> Airmen (<?php echo str_replace('"', "", $sql->queryValue("select count(distinct username) from airmanPrefs;"));?>/<?php echo str_replace('"', "", $sql->queryValue("select count(distinct username) from users where officer;"));?> Airmen have submitted preferences). </p>
    </div>

    <datalist id = "airmen"> </datalist> <!-- Javascript will fill in -->

    <form action = <?php echo "submitBillet.php?billet=" . $_GET["billet"]; ?> method = "POST">
    <fieldset id = "prefs">
    	<table> 
    			<tr> <td> Preference #1: </td> <td> 
    	<select class = "chosen-select" id = "airman1" name = "airman1" onchange = "verify(this);"> </td> <td id = "row1"> </td></tr>
    			<tr> <td> Preference #2: </td> <td> 
    	<select class = "chosen-select" id = "airman2" name = "airman2" onchange = "verify(this);"> </td> <td id = "row2"> </td</tr>
    	    	<tr> <td> Preference #3: </td> <td> 
    	<select class = "chosen-select" id = "airman3" name = "airman3" onchange = "verify(this);"> </td> <td id = "row3"> </td</tr>
    	    	<tr> <td> Preference #4: </td> <td> 
    	<select class = "chosen-select" id = "airman4" name = "airman4" onchange = "verify(this);"> </td> <td id = "row4"> </td</tr>
    	    	<tr> <td> Preference #5: </td> <td> 
    	<select class = "chosen-select" id = "airman5" name = "airman5" onchange = "verify(this);"> </td> <td id = "row5"> </td</tr>
    	    	<tr> <td> Preference #6: </td> <td> 
    	<select class = "chosen-select" id = "airman6" name = "airman6" onchange = "verify(this);"> </td> <td id = "row6"> </td</tr>
    	    	<tr> <td> Preference #7: </td> <td> 
    	<select class = "chosen-select" id = "airman7" name = "airman7" onchange = "verify(this);"> </td> <td id = "row7"> </td</tr>
    	    	<tr> <td> Preference #8: </td> <td> 
    	<select class = "chosen-select" id = "airman8" name = "airman8" onchange = "verify(this);"> </td> <td id = "row8"> </td</tr>
    	    	<tr> <td> Preference #9: </td> <td> 
    	<select class = "chosen-select" id = "airman9" name = "airman9" onchange = "verify(this);"> </td> <td id = "row9"> </td</tr>
    	    	<tr> <td> Preference #10: </td> <td> 
    	<select class = "chosen-select" id = "airman10" name = "airman10" onchange = "verify(this);"> </td> <td id = "row10"> </td</tr>

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
