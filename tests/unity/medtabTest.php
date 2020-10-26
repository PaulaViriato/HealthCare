<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/medtab.php');

class MedTabTest {
	// Métodos de Teste
	public function test_id (){
		$medtab = new MedTab();
		$initial_id = 123456;
		$medtab->set_id($initial_id);
		$final_id = $medtab->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_nome (){
		$medtab = new MedTab();
		$initial_nome = "Nome de Tabela de Medicamentos";
		$medtab->set_nome($initial_nome);
		$final_nome = $medtab->get_nome();

		if (strcmp("".$initial_nome, "".$final_nome) == 0){ return true; }
		else { return false; }
	}

	public function test_deflator (){
		$medtab = new MedTab();
		$initial_deflator = 1.2;
		$medtab->set_deflator($initial_deflator);
		$final_deflator = $medtab->get_deflator();

		if (strcmp("".$initial_deflator, "".$final_deflator) == 0){
			if (floatval($final_deflator) == $initial_deflator){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_pf_alicota (){
		$medtab = new MedTab();
		$initial_pf_alicota = 1;
		$medtab->set_pf_alicota($initial_pf_alicota);
		$final_pf_alicota = $medtab->get_pf_alicota();

		if (strcmp("".$initial_pf_alicota, "".$final_pf_alicota) == 0){
			if (intval($final_pf_alicota) == $initial_pf_alicota){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_pmc_alicota (){
		$medtab = new MedTab();
		$initial_pmc_alicota = 2;
		$medtab->set_pmc_alicota($initial_pmc_alicota);
		$final_pmc_alicota = $medtab->get_pmc_alicota();

		if (strcmp("".$initial_pmc_alicota, "".$final_pmc_alicota) == 0){
			if (intval($final_pmc_alicota) == $initial_pmc_alicota){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_pmvg_alicota (){
		$medtab = new MedTab();
		$initial_pmvg_alicota = 3;
		$medtab->set_pmvg_alicota($initial_pmvg_alicota);
		$final_pmvg_alicota = $medtab->get_pmvg_alicota();

		if (strcmp("".$initial_pmvg_alicota, "".$final_pmvg_alicota) == 0){
			if (intval($final_pmvg_alicota) == $initial_pmvg_alicota){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_OPERADORA (){
		$medtab = new MedTab();
		$initial_operadora = new Operadora();
		$initial_operadora->set_id(123456);
		$medtab->set_OPERADORA($initial_operadora);
		$final_operadora = $medtab->get_OPERADORA();

		if (strcmp("".$initial_operadora->get_id(), "".$final_operadora->get_id()) == 0){
			if (intval($final_operadora->get_id()) == intval($initial_operadora->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MEDTAB (){
		$medtab = new MedTab();
		$initial_medtab = new MedTab();
		$initial_medtab->set_id(123456);
		$medtab->set_MEDTAB($initial_medtab);
		$final_medtab = $medtab->get_MEDTAB();

		if (strcmp("".$initial_medtab->get_id(), "".$final_medtab->get_id()) == 0){
			if (intval($final_medtab->get_id()) == intval($initial_medtab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_data (){
		$medtab = new MedTab();
		$initial_data = "01-01-1970 00:00:01";
		$medtab->set_data($initial_data);
		$final_data = $medtab->get_data();

		if (strcmp("".$initial_data, "".$final_data) == 0){ return true; }
		else { return false; }
	}

	public function test_fields (){
		$medtab = new MedTab();
		$initial_fields = "id, substancia, cnpj, laboratorio, produto";
		$medtab->set_fields($initial_fields);
		$final_fields = $medtab->get_fields();

		if (strcmp("".$initial_fields, "".$final_fields) == 0){ return true; }
		else { return false; }
	}

	public function test_format_type (){
		$medtab = new MedTab();
		$initial_format_type = 1;
		$medtab->set_format_type($initial_format_type);
		$final_format_type = $medtab->get_format_type();

		if (strcmp("".$initial_format_type, "".$final_format_type) == 0){
			if (intval($final_format_type) == $initial_format_type){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_active (){
		$medtab = new MedTab();
		$initial_active = true;
		$medtab->set_active($initial_active);
		$final_active = $medtab->get_active();

		if (strcmp("".$initial_active, "".$final_active) == 0){
			if ($initial_active == $final_active){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_nome()){
				if ($this->test_deflator()){
					if ($this->test_pf_alicota()){
						if ($this->test_pmc_alicota()){
							if ($this->test_pmvg_alicota()){
								if ($this->test_OPERADORA()){
									if ($this->test_MEDTAB()){
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
				}
			}
		}

		return false;
	}
}
?>