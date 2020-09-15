<?php
require_once (str_replace("util", "dao", dirname (__FILE__)).'/operadora_DAO.php');
require_once (str_replace("util", "dao", dirname (__FILE__)).'/administrador_DAO.php');
require_once (str_replace("util", "dao", dirname (__FILE__)).'/login_DAO.php');

$login_return = true;
if (!isset($_SESSION["healthcare-type-user"])){
	session_start();
	if ((isset($_POST["login"]))&&(isset($_POST["senha"]))){
		$login = $_POST["login"];
		$senha = $_POST["senha"];
		$_SESSION["healthcare-login"] = $login;
		$_SESSION["healthcare-password"] = $senha;
		header('Location: '.$_SERVER['PHP_SELF']);
		exit ();
	}else{
		if ((!isset($_SESSION["healthcare-login"]))||(!isset($_SESSION["healthcare-password"]))){
			header("Location: ../view/login.php");
			exit ();
		} else {
			$login = $_SESSION["healthcare-login"];
			$senha = $_SESSION["healthcare-password"];
		}
	}
	session_commit();

	$DAOOperadora = new Operadora_DAO();
	$DAOAdministrador = new Administrador_DAO();
	$DAOLogin = new Login_DAO();

	session_start();
	$user = $DAOOperadora->login ($login, $senha);
	if (!is_null($user)){
		$_SESSION["healthcare-user"]["id"] = $user->get_id();
		$_SESSION["healthcare-user"]["nome"] = $user->get_nome();
		$_SESSION["healthcare-user"]["email"] = $user->get_email();
		$_SESSION["healthcare-user"]["contato"] = $user->get_contato();
		$_SESSION["healthcare-user"]["login"] = $user->get_login();
		$_SESSION["healthcare-user"]["senha"] = $user->get_senha();
		$_SESSION["healthcare-type-user"] = 1;
	} else {
		$user = $DAOAdministrador->login ($login, $senha);
		if (!is_null($user)){
			$_SESSION["healthcare-user"]["id"] = $user->get_id();
			$_SESSION["healthcare-user"]["nome"] = $user->get_nome();
			$_SESSION["healthcare-user"]["email"] = $user->get_email();
			$_SESSION["healthcare-user"]["login"] = $user->get_login();
			$_SESSION["healthcare-user"]["senha"] = $user->get_senha();
			$_SESSION["healthcare-type-user"] = 0;
		} else {
			$user = $DAOLogin->login ($login, $senha);
			if (!is_null($user)){
				$_SESSION["healthcare-user"]["id"] = $user->get_id();
				$_SESSION["healthcare-user"]["first_login"] = $user->get_first_login();
				$_SESSION["healthcare-user"]["senha"] = $user->get_senha();
				$_SESSION["healthcare-user"]["id_cnes"] = $user->get_CNES()->get_id();
				$_SESSION["healthcare-user"]["nome"] = $user->get_CNES()->get_no_fantasia();
				$_SESSION["healthcare-user"]["currop"] = null;
				$_SESSION["healthcare-type-user"] = 2;
			} else { $login_return = false; }
		}
	}

	session_commit();
	if ($login_return){ header("Location: ../view/login.php"); }
	else { header("Location: logout.php?invalido=1"); }
}
?>