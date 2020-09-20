<?php
	session_start();
	unset($_SESSION["healthcare-login"]);
	unset($_SESSION["healthcare-senha"]);
	unset($_SESSION["healthcare-type-user"]);
	
	if(isset($_GET["invalido"])) {
		$_SESSION["healthcare-invalido"] = 1;
		header ("Location: ../view/login.php");
	} else { header ("Location: ../view/login.php"); }
	session_commit();
?>
