<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/arquivo.php');

class ArquivoTest {
	// Métodos de Teste
	public function test_id (){
		$arquivo = new Arquivo();
		$initial_id = 123456;
		$arquivo->set_id($initial_id);
		$final_id = $arquivo->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_file_type (){
		$arquivo = new Arquivo();
		$initial_file_type = 1;
		$arquivo->set_file_type($initial_file_type);
		$final_file_type = $arquivo->get_file_type();

		if (strcmp("".$initial_file_type, "".$final_file_type) == 0){
			if (intval($final_file_type) == $initial_file_type){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_caminho (){
		$arquivo = new Arquivo();
		$initial_caminho = "C:/arquivo.csv";
		$arquivo->set_caminho($initial_caminho);
		$final_caminho = $arquivo->get_caminho();

		if (strcmp("".$initial_caminho, "".$final_caminho) == 0){ return true; }
		else { return false; }
	}

	public function test_tab_type (){
		$arquivo = new Arquivo();
		$initial_tab_type = 2;
		$arquivo->set_tab_type($initial_tab_type);
		$final_tab_type = $arquivo->get_tab_type();

		if (strcmp("".$initial_tab_type, "".$final_tab_type) == 0){
			if (intval($final_tab_type) == $initial_tab_type){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MEDTAB (){
		$arquivo = new Arquivo();
		$initial_medtab = new MedTab();
		$initial_medtab->set_id(123456);
		$arquivo->set_MEDTAB($initial_medtab);
		$final_medtab = $arquivo->get_MEDTAB();

		if (strcmp("".$initial_medtab->get_id(), "".$final_medtab->get_id()) == 0){
			if (intval($final_medtab->get_id()) == intval($initial_medtab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MATTAB (){
		$arquivo = new Arquivo();
		$initial_mattab = new MatTab();
		$initial_mattab->set_id(123456);
		$arquivo->set_MATTAB($initial_mattab);
		$final_mattab = $arquivo->get_MATTAB();

		if (strcmp("".$initial_mattab->get_id(), "".$final_mattab->get_id()) == 0){
			if (intval($final_mattab->get_id()) == intval($initial_mattab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_status (){
		$arquivo = new Arquivo();
		$initial_status = 3;
		$arquivo->set_status($initial_status);
		$final_status = $arquivo->get_status();

		if (strcmp("".$initial_status, "".$final_status) == 0){
			if (intval($final_status) == $initial_status){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_data (){
		$arquivo = new Arquivo();
		$initial_data = "01-01-1970 00:00:01";
		$arquivo->set_data($initial_data);
		$final_data = $arquivo->get_data();

		if (strcmp("".$initial_data, "".$final_data) == 0){ return true; }
		else { return false; }
	}

	public function test_linha (){
		$arquivo = new Arquivo();
		$initial_linha = 4;
		$arquivo->set_linha($initial_linha);
		$final_linha = $arquivo->get_linha();

		if (strcmp("".$initial_linha, "".$final_linha) == 0){
			if (intval($final_linha) == $initial_linha){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_coluna (){
		$arquivo = new Arquivo();
		$initial_coluna = 5;
		$arquivo->set_coluna($initial_coluna);
		$final_coluna = $arquivo->get_coluna();

		if (strcmp("".$initial_coluna, "".$final_coluna) == 0){
			if (intval($final_coluna) == $initial_coluna){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_file_type()){
				if ($this->test_caminho()){
					if ($this->test_tab_type()){
						if ($this->test_MEDTAB()){
							if ($this->test_MATTAB()){
								if ($this->test_status()){
									if ($this->test_data()){
										if ($this->test_linha()){
											if ($this->test_coluna()){
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
		}

		return false;
	}
}
?>