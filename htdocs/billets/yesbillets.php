<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["billets"])) {
    die("You don't have the correct permissions to view this page.");
}
?>

<script type = "text/javascript">
	var vals  = <?php echo $res;   ?>;
	var data  = <?php echo $data;  ?>;
	var descs = <?php echo $descs; ?>;
	
	// Global var showing what we currently have selected. 
	var selected = <?php 
		if (isset($_SESSION["lastViewed"])){
			echo "'" . $_SESSION["lastViewed"] . "'" ; 
		} else {
			echo "data[0].posn";
		}
	?>;  

/* Run on Page Load */ 
$( function(){ 

// Populate the drop down menu
d3.select("#billetSelector")
  .selectAll("option")
  .data(vals)
  .enter()
  .append("option")
  .text(function(d) {
  	return d.posn;
  })
  .attr("value", function(d) {
  	return d.posn;
  });



updateBilletData = function(value){ 

	selected = value; 

	/* Subset to the data that we need */ 
	var myData = data.filter(function(x) {
		return x.posn == value;
	}); 

	// Ensure correct drop down selected-- used when redirected back after submission
	document.getElementById("billetSelector").value = value;


	/* Update the values that we have */ 
	var toUpdate = document.getElementsByClassName("autopop");
	for (var i = 0; i < toUpdate.length; ++i){
		var row = myData.filter(function(x){
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
	        onchange = "updateBilletData(this.value);" 
	        class = "center chosen-select-large"
	        style = "width: 100px;"
	        >
	<!-- Template, javascript will fill in --> 
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