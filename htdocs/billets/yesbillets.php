<script type = "text/javascript">
	/* TODO: Add var declaration to avoid polluting global namespace */ 
	vals = <?php echo $res; ?>;
	data = <?php echo $data; ?>;
	descs = <?php echo $descs; ?>;
	
	
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
	/* Subset to the data that we need */ 
	var myData = data.filter(function(x) {
		return x.posn == value;
	}); 


	/* Update the values that we have */ 
	var toUpdate = document.getElementsByClassName("autopop");
	for (var i = 0; i < toUpdate.length; ++i){
		var row = myData.filter(function(x){
			return x.tkey == toUpdate[i].name; 
		})
		toUpdate[i].value = row[0].val; 
	}
	
	/* Update Job description */ 
	document.getElementById("desc").value = descs.filter(function(x){
		return x.posn == value;
	})[0].txt;
}

toggleSelector = function(val){
	
}

/* Initial fill */ 
updateBilletData(data[0].posn);

});
	
</script>

<h5 >Please select your billet:</h5>
<select id = "billetSelector" onchange="updateBilletData(this.value)" class = "center">
<!-- Template, javascript will fill in --> 
</select>


<form> 
<br><br> 
<fieldset>
<table> 
	<tr> <td colspan="4">  <h5> <i> General Information </i> </h5>  </td> </tr>
	<tr> 
		<td> <p> Billet AFSC: </p> </td> 
		<td> <input type = "text" name = "afsc" value = "" class = "autopop"> </td> 
		<td> <p> Grade: </p> </td> 
		<td> <input type = "text" name = "grade" value = "" class = "autopop"></td>
	</tr>
	<tr> 
		<td> <p> Location: </p> </td> 
		<td> <input type = "text" name = "location" class = "autopop" value = ""> </td> 
		<td> <p> Unit: </p> </td> 
		<td> <input type = "text" name = "unit" value = "" class = "autopop"></td>
	</tr>
	<tr> 
		<td> <p> Last Occupied By:</p> </td> 
		<td> <input type = "text" name = "lastOccupant" value = "" class = "autopop"> </td>
		<td> <p> Point of Contact:</p> </td> 
		<td> <input type = "text" name = "poc" value = "" class = "autopop"> </td>
	</tr>
	<tr>
		<td colspan="2"> <p> Allow Airmen to contact me regarding this billet: </p> </td>
		<td colspan="2"> 
		<select name = "contact?" class = "autopop"> 
			<option value = "yes"> Yes </option>
			<option value = "no" > No  </option>
		</select>
		 </td>
	</tr> 
</table>
</fieldset>
<fieldset>
<table> 
	<tr> <td colspan="4"> <h5> <i> Degrees and Certifications </i> </h5>  </td> </tr>
	<tr> 
		<td> <p> Advanced Academic Degree Requirement (Level): </p> </td>
		<td> <select name = "aadLevel" class = "autopop"> 
			<option value = "bs"> None </option>
			<option value = "ms"> Master's </option>
			<option value = "phd"> PhD </option>
		</select> </td>
	</tr>
	<tr> 
		<td> <p> Advanced Academic Degree Requirement (Degree): </p> </td>
		<td> <input type = "text" name = "aadDegree" class = "autopop" value = "N/A"> </td>
	</tr>
	<tr> 
		<td> <p>Acquisition Level: </p> </td>
		<td> <select name = "acqLevel" >
			<option value = "temp1"> Option 1 </option>
			<option value = "temp2"> Option 2 </option>
			<option value = "temp3"> Option 3 </option>
		</select> </td>
	</tr>
</table>
</fieldset>
<fieldset>
<table> 
	<tr> <td colspan="4"> <h5> <i> Lifestyle </i> </h5>  </td> </tr>
<tr>
	<td> <p>Percentage of Time TDY (Approximate): </p> </td>
	<td> <select name = "tdy" class = "autopop">
			 <option value = "0"> 0% </option>
			 <option value = "5"> 5% </option>
			 <option value = "10"> 10% </option>
			 <option value = "25"> 25% </option>
			 <option value = ">25"> More than 25% </option>
		 </select>
	</td>
	<td style = "padding: 0 30px 0 30px;"> 	<p>Deployable: </p> </td>
	<td> 
		<select name = "deployable" class = "autopop">
			<option value = "yes"> Yes </option>
			<option value = "no"> No </option>
		</select>
	</td>
</tr>
<tr> <td colspan="4"><p> Typical Hours </p> </td> </tr>
<tr> 
	<td> Start: </td> 
	<td> <input type = "text" name = "start" class = "autopop" value = ""> </td>
	<td> Stop: </td> 
	<td> <input type = "text" name = "stop" class = "autopop" value = ""> </td>
</tr>
	</table>
</fieldset>
<fieldset>
<table>
	<tr> <td> <h5> <i> Job Description </i> </h5> </td> </tr>
	<tr> <td> <textarea id = "desc" name = "desc" cols = "100" rows = "10"> </textarea> </td> </tr>
</table>
</fieldset>
</form>