<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/medtuss.php');

class MedTussTest {
	// Métodos de Teste
	public function test_id (){
		$medtuss = new MedTuss();
		$initial_id = 123456;
		$medtuss->set_id($initial_id);
		$final_id = $medtuss->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){
			if (intval($final_id) == $initial_id){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_MEDICAMENTO (){
		$medtuss = new MedTuss();
		$initial_medicamento = new Medicamento();
		$initial_medicamento->set_id("1002001360010");
		$medtuss->set_MEDICAMENTO($initial_medicamento);
		$final_medicamento = $medtuss->get_MEDICAMENTO();

		if (strcmp("".$initial_medicamento->get_id(), "".$final_medicamento->get_id()) == 0){ return true; }
		else { return false; }
	}

	public function test_MEDTAB (){
		$medtuss = new MedTuss();
		$initial_medtab = new MedTab();
		$initial_medtab->set_id(123456);
		$medtuss->set_MEDTAB($initial_medtab);
		$final_medtab = $medtuss->get_MEDTAB();

		if (strcmp("".$initial_medtab->get_id(), "".$final_medtab->get_id()) == 0){
			if (intval($final_medtab->get_id()) == intval($initial_medtab->get_id())){ return true; }
			else { return false; }
		} else { return false; }
	}

	public function test_inicio_vigencia (){
		$medtuss = new MedTuss();
		$initial_inicio_vigencia = "01-01-1970 00:00:01";
		$medtuss->set_inicio_vigencia($initial_inicio_vigencia);
		$final_inicio_vigencia = $medtuss->get_inicio_vigencia();

		if (strcmp("".$initial_inicio_vigencia, "".$final_inicio_vigencia) == 0){ return true; }
		else { return false; }
	}

	public function test_fim_vigencia (){
		$medtuss = new MedTuss();
		$initial_fim_vigencia = "01-01-1970 00:00:01";
		$medtuss->set_fim_vigencia($initial_fim_vigencia);
		$final_fim_vigencia = $medtuss->get_fim_vigencia();

		if (strcmp("".$initial_fim_vigencia, "".$final_fim_vigencia) == 0){ return true; }
		else { return false; }
	}

	public function test_fim_implantacao (){
		$medtuss = new MedTuss();
		$initial_fim_implantacao = "01-01-1970 00:00:01";
		$medtuss->set_fim_implantacao($initial_fim_implantacao);
		$final_fim_implantacao = $medtuss->get_fim_implantacao();

		if (strcmp("".$initial_fim_implantacao, "".$final_fim_implantacao) == 0){ return true; }
		else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_MEDICAMENTO()){
				if ($this->test_MEDTAB()){
					if ($this->test_inicio_vigencia()){
						if ($this->test_fim_vigencia()){
							if ($this->test_fim_implantacao()){
								return true;
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
