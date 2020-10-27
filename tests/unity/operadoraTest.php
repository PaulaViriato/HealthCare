<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/operadora.php');

class OperadoraTest {
	// Métodos de Teste
	public function test_id (){
		$operadora = new Operadora();
		$initial_id = 123456;
		$operadora->set_id($initial_id);
		$final_id = $operadora->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_nome (){
		$operadora = new Operadora();
		$initial_nome = "Nome da Operadora de Plano de Saúde";
		$operadora->set_nome($initial_nome);
		$final_nome = $operadora->get_nome();

		if (strcmp("".$initial_nome, "".$final_nome) == 0){ return true; }
		else { return false; }
	}

	public function test_codans (){
		$operadora = new Operadora();
		$initial_codans = 123456;
		$operadora->set_codans($initial_codans);
		$final_codans = $operadora->get_codans();

		if (strcmp("".$initial_codans, "".$final_codans) == 0){
			if (intval($final_codans) == $initial_codans){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_cnpj (){
		$operadora = new Operadora();
		$initial_cnpj = "01.234.567/8901-23";
		$operadora->set_cnpj($initial_cnpj);
		$final_cnpj = $operadora->get_cnpj();

		if (strcmp("".$initial_cnpj, "".$final_cnpj) == 0){ return true; }
		else { return false; }
	}

	public function test_email (){
		$operadora = new Operadora();
		$initial_email = "operadora@email.com";
		$operadora->set_email($initial_email);
		$final_email = $operadora->get_email();

		if (strcmp("".$initial_email, "".$final_email) == 0){ return true; }
		else { return false; }
	}

	public function test_contato (){
		$operadora = new Operadora();
		$initial_contato = "(00) 9 9999-9999";
		$operadora->set_contato($initial_contato);
		$final_contato = $operadora->get_contato();

		if (strcmp("".$initial_contato, "".$final_contato) == 0){ return true; }
		else { return false; }
	}

	public function test_login (){
		$operadora = new Operadora();
		$initial_login = "OperadoraPlano";
		$operadora->set_login($initial_login);
		$final_login = $operadora->get_login();

		if (strcmp("".$initial_login, "".$final_login) == 0){ return true; }
		else { return false; }
	}

	public function test_senha (){
		$operadora = new Operadora();
		$initial_senha = "Operadora123456";
		$operadora->set_senha($initial_senha);
		$final_senha = $operadora->get_senha();

		if (strcmp("".$initial_senha, "".$final_senha) == 0){ return true; }
		else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_nome()){
				if ($this->test_codans()){
					if ($this->test_cnpj()){
						if ($this->test_email()){
							if ($this->test_contato()){
								if ($this->test_login()){
									if ($this->test_senha()){
										return true;
									}
								}
							}
						}
					}
				}
			}
		}

		return false;
	}
}
?>
