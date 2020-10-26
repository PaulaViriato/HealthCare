<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/administrador.php');

class AdministradorTest {
	// Métodos de Teste
	public function test_id (){
		$administrador = new Administrador();
		$initial_id = 123456;
		$administrador->set_id($initial_id);
		$final_id = $administrador->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_nome (){
		$administrador = new Administrador();
		$initial_nome = "Alguém dos Santos Silva";
		$administrador->set_nome($initial_nome);
		$final_nome = $administrador->get_nome();

		if (strcmp("".$initial_nome, "".$final_nome) == 0){ return true; }
		else { return false; }
	}

	public function test_email (){
		$administrador = new Administrador();
		$initial_email = "alguem@email.com";
		$administrador->set_email($initial_email);
		$final_email = $administrador->get_email();

		if (strcmp("".$initial_email, "".$final_email) == 0){ return true; }
		else { return false; }
	}

	public function test_login (){
		$administrador = new Administrador();
		$initial_login = "AlguemSilva";
		$administrador->set_login($initial_login);
		$final_login = $administrador->get_login();

		if (strcmp("".$initial_login, "".$final_login) == 0){ return true; }
		else { return false; }
	}

	public function test_senha (){
		$administrador = new Administrador();
		$initial_senha = "Alguem123456";
		$administrador->set_senha($initial_senha);
		$final_senha = $administrador->get_senha();

		if (strcmp("".$initial_senha, "".$final_senha) == 0){ return true; }
		else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_nome()){
				if ($this->test_email()){
					if ($this->test_login()){
						if ($this->test_senha()){
							return true;
						}
					}
				}
			}
		}

		return false;
	}
}
?>
