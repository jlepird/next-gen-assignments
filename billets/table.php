<script> 
function toggleHours(value){
	if (value == "yes"){
		$('.toggle-hours').css("visibility", "visible")
	} else {
		$('.toggle-hours').css("visibility", "hidden")
	}
}

$(function(){
		$(".chosen-select-large").chosen({width: "200px", allow_single_deselect: true});
		$(".chosen-select-medium").chosen({width: "150px", allow_single_deselect: true});
		$(".chosen-select-small").chosen({width: "100px", allow_single_deselect: true});
		$(".chosen-disabled").removeClass("chosen-disabled"); 
		toggleHours($("#regularHours").val());
}); 
</script>

<table class="table-display"> 
	<tr> <td colspan="4">  <h5> <i> General Information </i> </h5>  </td> </tr>
	<tr> <td colspan="2" > <i> Duty Title: </i> </td> <td colspan = "3" > <input type = "text" name = "dutyTitle" size = "35" value = "" class = "autopop"> </td></tr>
	<tr> 
		<td> <p> Allowable AFSCs: </p> </td> 
		<td> <select name = "afsc[]" value = "" class = "autopop chosen-select-medium" multiple>
						<?php
				$res = $sql->execute("select afsc, txt from coreCodes;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . $row[0] . ": " . $row[1] . "</option>";  
				}
				pg_free_result($res); 
			?>
			</select
		 </td> 
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
	<?php
		if (strpos($_SERVER['REQUEST_URI'], "manage.php") !== false){
			include "./contactInput.php"; 
		} else {
			include "./displayContact.php"; 
		}
	?>
</table>
</fieldset>
<fieldset>
<table class="table-display"> 
	<tr> <td colspan="4"> <h5> <i> Degrees and Certifications </i> </h5>  </td> </tr>
	<tr> 
		<td> <p> Preferred Education Level: </p> </td>
		<td> <select name = "aadLevel[]" class = "autopop chosen-select-large" data-placeholder="Select AAD Level" multiple> 
			<option value = "bs"> None </option>
			<option value = "ms"> Master's </option>
			<option value = "phd"> PhD </option>
		</select> </td>
	</tr>
	<tr> 
		<td> <p> Preferred Academic Degree: </p> </td>
		<td> <select  = "100" id = "aadDegree" multiple name = "aadDegree[]" class = "autopop chosen-select-large" data-placeholder="None">
			<?php
				$res = $sql->execute("select code, degree from allowableDegrees;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . $row[0]. ": " . $row[1] . "</option>";  
				}
				pg_free_result($res); 
			?>
			</select> </td>
	</tr>
	<tr> 
		<td> <p>Acquisition Level: </p> </td>
		<td> <select name = "acqLevel" class = "autopop chosen-select-large" >
			<?php
				$res = $sql->execute("select code, level from acqLevels;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . $row[1] . "</option>";  
				}
				pg_free_result($res); 
			?>
		</select> </td>
	</tr>
	<tr>
		<td> Security Clearance Required: </td> 
		<td> 
		<select id = "ts" name = "ts" class = "autopop chosen-select-large">
			<option val = "s"> Secret </option>
			<option val = "ts"> Top Secret or Higher </option>
		</select>
		</td>
	</tr>
</table>
</fieldset>
<fieldset>
<table class="table-display" style="table-layout:fixed;"> 
	<tr> <td colspan="4"> <h5> <i> Lifestyle </i> </h5>  </td> </tr>
<tr>
	<td style="width:200px;" colspan="3"> <p>Percentage of Time TDY (Approximate): </p> </td>
	<td> <select name = "tdy" class = "autopop chosen-select-small">
			 <option value = "0"> 0% </option>
			 <option value = "5"> 5% </option>
			 <option value = "10"> 10% </option>
			 <option value = "25"> 25% </option>
			 <option value = ">25"> More than 25% </option>
		 </select>
	</td> 
	<td colspan=1 style = "text-align: right; padding-right: 2px;"> 	<p>Deployable: </p> </td>
	<td > 
		<select name = "deployable" class = "autopop chosen-select-small">
			<option value = "yes"> Yes </option>
			<option value = "no"> No </option>
		</select>
	</td>
</tr>
<tr> <td colspan="4"><p> <em> Typical Hours </em> </p> </td> </tr>
<tr> 
	<td> Predictable Work Hours </td> <td> 
	<select onChange="toggleHours(this.value)" name="regularHours" id = "regularHours" class = "autopop chosen-select-small">
		<option value = "yes"> Yes </option>
		<option value = "no"> No </option>
	</select> </td>
	<td style="text-align: right;" class = "toggle-hours"> <div style="float: left;"></div>Start Time: </td> 
	<td> <div style="float: left;"></div><input  type = "text" name = "start" size = "4" id = "start" class = "toggle-hours autopop" value = ""> </td>
	<td style="align: right;" class = "toggle-hours"> <div style="float: left;"></div>Stop Time: </td> 
	<td> <div style="float: left;"></div><input type = "text" name = "stop" id = "stop" size = "4" class = "toggle-hours autopop" value = ""> </td>
</tr>
	</table>
</fieldset>
<fieldset>
<table class="table-display">
	<tr> <td> <h5> <i> Job Description </i> </h5> </td> </tr>
	<tr> <td> <textarea id = "desc" name = "desc" cols = "100" rows = "10"> </textarea> </td> </tr>
</table>
</fieldset>
