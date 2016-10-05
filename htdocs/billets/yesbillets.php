<script type="text/javascript">

/* Run on Page Load */ 
$( function(){ 

vals = <?php echo $res; ?>;
data = <?php echo $data; ?>;

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
}

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
		<td> <input type = "text" name = "lastOccupant" value = ""> </td>
		<td> <p> Point of Contact:</p> </td> 
		<td> <input type = "text" name = "poc" value = ""> </td>
	</tr>
</table>
</fieldset>
<fieldset>
	<p> Advanced Academic Degree Requirement (Level): </p>
	<select name = "aad"> 
		<option value = "bs"> None </option>
		<option value = "ms"> Master's </option>
		<option value = "phd"> PhD </option>
	</select>
	<br> <br> 
	<p> Advanced Academic Degree Requirement (Degree): </p>
	<input type = "text" value = "N/A">
</fieldset>
<fieldset>
	<p>Acquisition Level: </p>
	<select name = "acqLevel" >
	<option value = "temp1"> Option 1 </option>
	<option value = "temp2"> Option 2 </option>
	<option value = "temp3"> Option 3 </option>
	</select>
</fieldset>
<fieldset>
<table> 
<tr>
	<td> 
		<p>Percentage of Time TDY (Approximate): </p>
		<select name = "acqLevel" >
		<option value = "0"> 0% </option>
		<option value = "5"> 5% </option>
		<option value = "10"> 10% </option>
		<option value = "25"> 25% </option>
		<option value = ">50"> More than 50% </option>
		</select>
	</td>
	<td style = "padding: 0 30px 0 30px;"> 
		<p>Deployable: </p>
		<select name = "deployable" >
		<option value = "yes"> Yes </option>
		<option value = "no"> No </option>
		</select>
	</td>
</tr>
</table>
</fieldset>
<fieldset>
<p> Typical Hours </p>
	<table> 
		<tr> 
			<td> Start: </td> 
			<td> <input type = "text" name = "start" value = ""> </td>
			<td> Stop: </td> 
			<td> <input type = "text" name = "stop" value = ""> </td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<p> Job Description: </p>
	<textarea name = "desc" cols = "100" rows = "10"> </textarea>
</fieldset>
</form>