<?php
session_start();



include './include/head_common.php';

$password = md5($_POST["password"]);

$res = $sql->execute("select * from users where username = '" . $_POST["uname"] . "' and password = '" . $password . "';");

if (pg_num_rows($res) !== 1){
	$_SESSION["incorrect"] = true;
	header("Location: changepassword.php");
} else {

	if ($_POST["password1"] !== $_POST["password2"]){
		$_SESSION["nomatch"] = true;
		header("Location: changepassword.php");
	} else {
		$pwd = $_POST["password1"];

		if (strlen($pwd) < 10 or 
			!preg_match("#[0-9]+#", $pwd) or 
			!preg_match("#[a-zA-Z]+#", $pwd)){
			$_SESSION["tooshort"] = true;
			header("Location: changepassword.php");
		} else { 
			$newpassword = md5($_POST["password1"]); 
			$sql->execute("update users set password = '" . $newpassword . "' where username = '" . $_POST["uname"] . "';");
			$_SESSION["updatedpw"] = true;
			header("Location: /");
		}
	}
}
?>