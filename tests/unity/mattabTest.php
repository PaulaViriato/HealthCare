<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/mattab.php');

class MatTabTest {
	// Métodos de Teste
	public function test_id (){
		$mattab = new MatTab();
		$initial_id = 123456;
		$mattab->set_id($initial_id);
		$final_id = $mattab->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_nome (){
		$mattab = new MatTab();
		$initial_nome = "Nome de Tabela de Materiais";
		$mattab->set_nome($initial_nome);
		$final_nome = $mattab->get_nome();

		if (strcmp("".$initial_nome, "".$final_nome) == 0){ return true; }
		else { return false; }
	}

	public function test_deflator (){
		$mattab = new MatTab();
		$initial_deflator = 1.2;
		$mattab->set_deflator($initial_deflator);
		$final_deflator = $mattab->get_deflator();

		if (strcmp("".$initial_deflator, "".$final_deflator) == 0){
			if (floatval($final_deflator) == $initial_deflator){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_OPERADORA (){
		$mattab = new MatTab();
		$initial_operadora = new Operadora();
		$initial_operadora->set_id(123456);
		$mattab->set_OPERADORA($initial_operadora);
		$final_operadora = $mattab->get_OPERADORA();

		if (strcmp("".$initial_operadora->get_id(), "".$final_operadora->get_id()) == 0){
			if (intval($final_operadora->get_id()) == intval($initial_operadora->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MATTAB (){
		$mattab = new MatTab();
		$initial_mattab = new MatTab();
		$initial_mattab->set_id(123456);
		$mattab->set_MATTAB($initial_mattab);
		$final_mattab = $mattab->get_MATTAB();

		if (strcmp("".$initial_mattab->get_id(), "".$final_mattab->get_id()) == 0){
			if (intval($final_mattab->get_id()) == intval($initial_mattab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_data (){
		$mattab = new MatTab();
		$initial_data = "01-01-1970 00:00:01";
		$mattab->set_data($initial_data);
		$final_data = $mattab->get_data();

		if (strcmp("".$initial_data, "".$final_data) == 0){ return true; }
		else { return false; }
	}

	public function test_fields (){
		$mattab = new MatTab();
		$initial_fields = "id, cnpj, fabricante, nome_tecnico";
		$mattab->set_fields($initial_fields);
		$final_fields = $mattab->get_fields();

		if (strcmp("".$initial_fields, "".$final_fields) == 0){ return true; }
		else { return false; }
	}

	public function test_format_type (){
		$mattab = new MatTab();
		$initial_format_type = 1;
		$mattab->set_format_type($initial_format_type);
		$final_format_type = $mattab->get_format_type();

		if (strcmp("".$initial_format_type, "".$final_format_type) == 0){
			if (intval($final_format_type) == $initial_format_type){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_active (){
		$mattab = new MatTab();
		$initial_active = true;
		$mattab->set_active($initial_active);
		$final_active = $mattab->get_active();

		if (strcmp("".$initial_active, "".$final_active) == 0){
			if ($initial_active == $final_active){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_nome()){
				if ($this->test_deflator()){
					if ($this->test_OPERADORA()){
						if ($this->test_MATTAB()){
							if ($this->test_data()){
								if ($this->test_fields()){
									if ($this->test_format_type()){
										if ($this->test_active()){
											return true;
										}
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