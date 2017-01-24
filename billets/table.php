<script> 
function toggleHours(value){
	if (value == "yes"){
		$('.toggle-hours').css("visibility", "visible")
	} else {
		$('.toggle-hours').css("visibility", "hidden")
	}
}


$(function(){
		$(".chosen-select-large").chosen(  {width: "200px", allow_single_deselect: true});
		$(".chosen-select-medium").chosen( {width: "150px", allow_single_deselect: true});
		$(".chosen-select-small").chosen(  {width: "100px", allow_single_deselect: true});
		$(".chosen-select-dynamic").chosen({width: "100%",  allow_single_deselect: true});
		$(".chosen-disabled").removeClass("chosen-disabled"); 
		toggleHours($("#regularHours").val());
		$("#report").datepicker();
}); 
</script>

<table class="table-display"> 
	<tr> <td colspan="3">  <h5> <i> General Information </i> </h5>  </td> </tr>
	<tr> <td colspan="1" > <p> <i> Duty Title: </i> </p> </td> <td colspan = "4" > <input type = "text" name = "dutyTitle" size = "45" value = "" class = "autopop"> </td></tr>
	<tr> 
		<td > <p> Allowable AFSCs: </p> </td> 
		<td colspan> <select name = "afsc[]" value = "" class = "autopop chosen-select-large" multiple>
						<?php
				$res = $sql->execute("select afsc, txt from coreCodes;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . $row[0] . ": " . ucwords(strtolower($row[1])) . "</option>";  
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
		<td> <p> Unit: </p> </td> 
		<td> <input type = "text" name = "unit" value = "" class = "autopop"></td>
		<td> <p> Report Date: </p></td>
		<td> <input name="report" id="report" type="text" class = "autopop"> </td>
		</tr>
		<tr>
		<td> <p> Location: </p> </td> 
		<td> <input type = "text" name = "location" class = "autopop" value = "" style="width:120px;"> </td> 
		<td> <select name = "state" class = "autopop chosen-select-dynamic">
			<option value="AL">AL</option>
			<option value="AK">AK</option>
			<option value="AZ">AZ</option>
			<option value="AR">AR</option>
			<option value="CA">CA</option>
			<option value="CO">CO</option>
			<option value="CT">CT</option>
			<option value="DE">DE</option>
			<option value="DC">DC</option>
			<option value="FL">FL</option>
			<option value="GA">GA</option>
			<option value="HI">HI</option>
			<option value="ID">ID</option>
			<option value="IL">IL</option>
			<option value="IN">IN</option>
			<option value="IA">IA</option>
			<option value="KS">KS</option>
			<option value="KY">KY</option>
			<option value="LA">LA</option>
			<option value="ME">ME</option>
			<option value="MD">MD</option>
			<option value="MA">MA</option>
			<option value="MI">MI</option>
			<option value="MN">MN</option>
			<option value="MS">MS</option>
			<option value="MO">MO</option>
			<option value="MT">MT</option>
			<option value="NE">NE</option>
			<option value="NV">NV</option>
			<option value="NH">NH</option>
			<option value="NJ">NJ</option>
			<option value="NM">NM</option>
			<option value="NY">NY</option>
			<option value="NC">NC</option>
			<option value="ND">ND</option>
			<option value="OH">OH</option>
			<option value="OK">OK</option>
			<option value="OR">OR</option>
			<option value="PA">PA</option>
			<option value="RI">RI</option>
			<option value="SC">SC</option>
			<option value="SD">SD</option>
			<option value="TN">TN</option>
			<option value="TX">TX</option>
			<option value="UT">UT</option>
			<option value="VT">VT</option>
			<option value="VA">VA</option>
			<option value="WA">WA</option>
			<option value="WV">WV</option>
			<option value="WI">WI</option>
			<option value="WY">WY</option>
			<option value="OCONUS"> Other OCONUS </option>
		</select></td>
	</tr>
	<tr>
		<td> <p> Tour Length: </p> </td> 
		<td>
			<select name="length" id = "length" class = "chosen-select-medium autopop">
				<option value="1">1 Year </option>
				<option value="2">2 Years </option>
				<option value="3" selected>3 Years </option>
				<option value="4">4 or More Years </option>
			</select>
		</td>
		<td> <p> Joint Billet </p> </td> <td>
			<select id ="joint" name = "joint" class = "chosen-select-small autopop">
				<option value="no">No </option>
				<option value="yes"> Yes</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan = 1> <p> Prioritization Level  <img src="../images/help.jpg"  style="width:20px;height:20px; cursor: pointer;" onclick="helpNRPP();"></p> </td>
		<td colspan = 1> <select name = "nrpp" id="nrpp" class = "autopop chosen-select-large" disabled=disabled>
			<option value="ent">Entitlement </option>
			<option value="ent+"> Priority </option>
			<option value="mf"> Must-Fill </option>
		</select>
		</td>
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
		<td> <p> Preferred Education Levels: </p> </td>
		<td> <select name = "aadLevel[]" class = "autopop chosen-select-large" data-placeholder="Select AAD Level" multiple> 
			<option value = "bs"> None </option>
			<option value = "ms"> Master's </option>
			<option value = "phd"> PhD </option>
		</select> </td>
	</tr>
	<tr> 
		<td> <p> Preferred Academic Degrees: </p> </td>
		<td> <select  = "100" id = "aadDegree" multiple name = "aadDegree[]" class = "autopop chosen-select-large" data-placeholder="None">
			<?php
				$res = $sql->execute("select code, degree from allowableDegrees;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . $row[0]. ": " . ucwords(strtolower($row[1])) . "</option>";  
				}
				pg_free_result($res); 
			?>
			</select> </td>
	</tr>
	<tr> 
		<td> <p>Minimum Acquisition Level: </p> </td>
		<td> <select name = "acqLevel" class = "autopop chosen-select-large" >
			<?php
				$res = $sql->execute("select code, level from acqLevels;");
				while ($row = pg_fetch_array($res)){
					echo "<option value = '" . $row[0] . "'> " . ucwords(strtolower($row[1])) . "</option>";  
				}
				pg_free_result($res); 
			?>
		</select> </td>
	</tr>
	<tr>
		<td> <p> Security Clearance Required: </p> </td> 
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
<tr>
	<td> Typical Workweek:</td>
	<td> <select name="workweek" id = "workweek" class = "autopop chosen-select-large">
		<option value="m-f"> Monday-Friday </option>
		<option value="m-sa"> Monday-Saturday</option>
		<option value="m-su"> Monday-Sunday </option>
		<option value="irr"> Irregular Workdays</option>
	</select></td>
</tr>
<tr> 
	<td> Predictable Work Hours: </td> <td> 
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
<table class="table-display" style="margin-bottom: 1cm;">
	<tr> <td> <h5> <i> Job Description </i> </h5> </td> </tr>
	<tr> <td> <textarea id = "desc" name = "desc" cols = "100" rows = "10" spellcheck="true"> </textarea> </td> </tr>
</table>
</fieldset>
