<script> 
$(function(){
	// {width: "95%"}
	$(".chosen-select-large").chosen({width: "200"});
	$(".chosen-select-small").chosen({width: "100"});
}); 
</script>

<table> 
	<tr> <td colspan="4">  <h5> <i> General Information </i> </h5>  </td> </tr>
	<tr> <td colspan="2" > <i> Duty Title: </i> </td> <td colspan = "3" > <input type = "text" name = "dutyTitle" size = "35" value = "" class = "autopop"> </td></tr>
	<tr> 
		<td> <p> Billet AFSC: </p> </td> 
		<td> <input type = "text" name = "afsc" value = "" size = "3" class = "autopop"> </td> 
		<td> <p> Grade: </p> </td> 
		<td> <select name = "grade[]" value = "" class = "autopop chosen-select-large" multiple data-placeholder="Select Allowable Grades">
			<option value = "O1"> 2nd Lieutenent </option>
			<option value = "O2"> 1st Lieutenent </option>
			<option value = "O3"> Captain </option>
			<option value = "O4"> Major </option>
			<option value = "O5"> Lieutenent Colonel </option>
		</select>
		</td>
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
		<select name = "contact?" class = "autopop chosen-select-small"> 
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
		<td> <select name = "aadLevel[]" class = "autopop chosen-select-large" data-placeholder="Select AAD Level" multiple> 
			<option value = "bs"> None </option>
			<option value = "ms"> Master's </option>
			<option value = "phd"> PhD </option>
		</select> </td>
	</tr>
	<tr> 
		<td> <p> Advanced Academic Degree Requirement (Degree): </p> </td>
		<td> <select  = "100" id = "aadDegree" multiple name = "aadDegree[]" class = "autopop chosen-select-large" data-placeholder="None">
			<?php
				$res = $sql->execute("select code, degree from nextGen.allowableDegrees;");
				while ($row = $res->fetch_array()){
					echo "<option value = '" . $row[0] . "'> " . $row[0]. ": " . $row[1] . "</option>";  
				}
				$res->free(); 
			?>
			</select> </td>
	</tr>
	<tr> 
		<td> <p>Acquisition Level: </p> </td>
		<td> <select name = "acqLevel" class = "autopop chosen-select-large" >
			<?php
				$res = $sql->execute("select code, level from nextGen.acqLevels;");
				while ($row = $res->fetch_array()){
					echo "<option value = '" . $row[0] . "'> " . $row[1] . "</option>";  
				}
				$res->free(); 
			?>
		</select> </td>
	</tr>
</table>
</fieldset>
<fieldset>
<table> 
	<tr> <td colspan="4"> <h5> <i> Lifestyle </i> </h5>  </td> </tr>
<tr>
	<td> <p>Percentage of Time TDY (Approximate): </p> </td>
	<td> <select name = "tdy" class = "autopop chosen-select-small">
			 <option value = "0"> 0% </option>
			 <option value = "5"> 5% </option>
			 <option value = "10"> 10% </option>
			 <option value = "25"> 25% </option>
			 <option value = ">25"> More than 25% </option>
		 </select>
	</td>
	<td style = "padding: 0 30px 0 30px;"> 	<p>Deployable: </p> </td>
	<td> 
		<select name = "deployable" class = "autopop chosen-select-small">
			<option value = "yes"> Yes </option>
			<option value = "no"> No </option>
		</select>
	</td>
</tr>
<tr> <td colspan="4"><p> Typical Hours </p> </td> </tr>
<tr> 
	<td> Start: </td> 
	<td> <input type = "text" name = "start" size = "4" id = "start" class = "autopop" value = ""> </td>
	<td> Stop: </td> 
	<td> <input type = "text" name = "stop" id = "stop" size = "4" class = "autopop" value = ""> </td>
</tr>
	</table>
</fieldset>
<fieldset>
<table>
	<tr> <td> <h5> <i> Job Description </i> </h5> </td> </tr>
	<tr> <td> <textarea id = "desc" name = "desc" cols = "100" rows = "10"> </textarea> </td> </tr>
</table>
</fieldset>
