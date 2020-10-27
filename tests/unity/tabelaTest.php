<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/tabela.php');

class TabelaTest {
	// Métodos de Teste
	public function test_id (){
		$tabela = new Tabela();
		$initial_id = 123456;
		$tabela->set_id($initial_id);
		$final_id = $tabela->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_type (){
		$tabela = new Tabela();
		$initial_type = 1;
		$tabela->set_type($initial_type);
		$final_type = $tabela->get_type();

		if (strcmp("".$initial_type, "".$final_type) == 0){
			if (intval($final_type) == $initial_type){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_PRESTADORA (){
		$tabela = new Tabela();
		$initial_prestadora = new Prestadora();
		$initial_prestadora->set_id(123456);
		$tabela->set_PRESTADORA($initial_prestadora);
		$final_prestadora = $tabela->get_PRESTADORA();

		if (strcmp("".$initial_prestadora->get_id(), "".$final_prestadora->get_id()) == 0){
			if (intval($final_prestadora->get_id()) == intval($initial_prestadora->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MEDTAB (){
		$tabela = new Tabela();
		$initial_medtab = new MedTab();
		$initial_medtab->set_id(123456);
		$tabela->set_MEDTAB($initial_medtab);
		$final_medtab = $tabela->get_MEDTAB();

		if (strcmp("".$initial_medtab->get_id(), "".$final_medtab->get_id()) == 0){
			if (intval($final_medtab->get_id()) == intval($initial_medtab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MATTAB (){
		$tabela = new Tabela();
		$initial_mattab = new MatTab();
		$initial_mattab->set_id(123456);
		$tabela->set_MATTAB($initial_mattab);
		$final_mattab = $tabela->get_MATTAB();

		if (strcmp("".$initial_mattab->get_id(), "".$final_mattab->get_id()) == 0){
			if (intval($final_mattab->get_id()) == intval($initial_mattab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}


	public function test_all (){
		if ($this->test_id()){
			if ($this->test_type()){
				if ($this->test_PRESTADORA()){
					if ($this->test_MEDTAB()){
						if ($this->test_MATTAB()){
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
