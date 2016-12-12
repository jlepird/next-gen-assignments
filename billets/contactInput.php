	<tr> 
		<td> <p> Last Occupied By:</p> </td> 
		<td> <input type = "text" name = "lastOccupant" value = "" class = "autopop"> </td>
		<td> Email: </td> 
		<td colspan="2"> <input type = "email" name = "lastOccupantEmail" value = "" class = "autopop"> </td>
	</tr>
	<tr> 
		<td> <p> Point of Contact:</p> </td> 
		<td> <input type = "text" name = "poc" value = "" class = "autopop"> </td>
		<td> Email: </td> 
		<td colspan="2"> <input type = "email" name = "pocEmail" 
			value = <?php echo "\"" . $sql->queryValue("select email from users where username = '" . $_SESSION["uname"] . "';") . "\""; 
					?>
		 	class = "autopop"> </td>
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