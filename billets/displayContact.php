<?php
	$allowed = $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='contact?'"); 
	if ($allowed == "yes"){
		echo "<td> <p> Last Occupied By:</p> </td> ";
		$email = $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='lastOccupantEmail'");
		echo "<td>"; 
		if (strpos($email, "@") !== false) {
			echo "<a href=mailto:" . $email . ">";
		}
		echo $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='lastOccupant'");
		if (strpos($email, "@") !== false){
			echo "</a>";
		} 
		echo  "</td>";
		echo "<td> <p> Point of Contact:</p> </td> "; 

		$email = $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='pocEmail'");
		echo "<td>"; 
		if (strpos($email, "@") !== false){
			echo "<a href=mailto:" . $email . ">";
		}
		echo $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='poc'");
		if (strpos($email, "@") !== false){
			echo "</a>";
		} 
	} else {
		echo "<tr> <td colspan = \"4\"> <p> <em> The billet owner has requested that you not contact him/her regarding this posting. </em> </p> </td> </tr>"; 
	}

?>