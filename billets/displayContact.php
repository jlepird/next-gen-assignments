<?php
try{
	$allowed = $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='contact?'"); 
} catch (Exception $e){
	$allowed = "no";
}
if ($allowed == '"yes"'){
	echo "<td> <p> Last Occupied By:</p> </td> ";
	$email = str_replace('"', '', $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='lastOccupantEmail';"));
	echo "<td colspan=2>"; 
	if (strpos($email, "@") !== false) {
		echo "<a href=mailto:" . $email . ">";
	}
	echo str_replace('"', '', $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='lastOccupant';"));
	//if (strpos($email, "@") !== false){
		echo "</a>";
	//} 
	echo  "</td>";
	echo "<td> <p> Point of Contact:</p> </td> "; 

	$email = str_replace('"', '', $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='pocEmail';"));
	echo "<td colspan=2>"; 
	if (strpos($email, "@") !== false){
		echo "<a href=mailto:" . $email . ">";
	}
	echo str_replace('"', '', $sql->queryValue("select val from billetData where posn = '" . $_GET["billet"] . "' and tkey='poc';"));
	if (strpos($email, "@") !== false){
		echo "</a>";
	} 
} else {
	echo "<tr> <td colspan = \"4\"> <p> <em> The billet owner has requested that you not contact him/her regarding this posting. </em> </p> </td> </tr>"; 
}

?>