<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["included"])) {
    die("You don't have the correct permissions to view this page.");
}
?>

<script type = "text/javascript">
	var data  = <?php echo $data;  ?>;
	var descs = <?php echo $descs; ?>;
	
	// Global var showing what we currently have selected. 
	var selected = <?php 
		echo "'" . $billet . "'";
	?>;  

updateBilletData = function(value){ 

	selected = value; 

	// Ensure correct drop down selected-- used when redirected back after submission
	document.getElementById("billetSelector").value = value;


	/* Update the values that we have */ 
	var toUpdate = document.getElementsByClassName("autopop");
	for (var i = 0; i < toUpdate.length; ++i){
		var row = data.filter(function(x){
			return x.tkey == toUpdate[i].name.replace("[]", ""); 
		}); 
		if (row.length == 1) {
			toUpdate[i].value = row[0].val;

		} else { // It's a drop-down with multiple selects 
			// For each value that we found... 
			for (var j = 0; j < row.length; ++j ){

			// For each option, figure out if we have it selected or not
				for (var k = 0; k < toUpdate[i].children.length; ++k){
					if (toUpdate[i].children[k].value == row[j].val){
						toUpdate[i].children[k].selected = true; 
						break;
					}
				}
			}
		} 
	}
	
	/* Update Job description */ 
	document.getElementById("desc").value = descs.filter(function(x){
		return x.posn == value;
	})[0].txt;
}


/* Run on Page Load */ 
$( function(){ 

	// Ensure correct drop down selected-- used when redirected back after submission
	document.getElementById("billetSelector").value = selected;

	/* Initial fill */ 
	updateBilletData(selected);

	});
	
</script>


<form action="upload.php" method = "post"> 
<h5 >Please select your billet:</h5>
<table> 
<tr> 
<td> 
	<select id = "billetSelector" 
			name = "id"
	        onchange = "document.location.href = '/billets/manage.php?billet=' + this.value;" 
	        class = "center chosen-select-large"
	        style = "width: 100px;"
	        >
	<?php // Populate the options for the user. 
		$res = $sql->execute("select posn from billetOwners where username = '" . $_SESSION["uname"] . "';");
		while ($row = pg_fetch_array($res)){
			echo "<option value = '" . $row[0] . "'> " . $row[0]. ": " . $row[1] . "</option>";  
		}
		pg_free_result($res); 
	?> 
	</select>
</td>
<td> <input type = "submit" class = "btn btn-primary" value = "Save Changes"> </td>
<td> <button type = "button" class = "btn btn-primary" onclick = "updateBilletData(selected); "> Reset </button>
<td> 

</td>
</tr>
</table>


<br><br> 
<fieldset>

<?php include "table.php"; ?>

</form>