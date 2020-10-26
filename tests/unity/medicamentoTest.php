<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/medicamento.php');

class MedicamentoTest {
	// Métodos de Teste
	public function test_id (){
		$medicamento = new Medicamento();
		$initial_id = "1002001360010";
		$medicamento->set_id($initial_id);
		$final_id = $medicamento->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){ return true; }
		else { return false; }
	}

	public function test_substancia (){
		$medicamento = new Medicamento();
		$initial_substancia = "DIENOGESTE";
		$medicamento->set_substancia($initial_substancia);
		$final_substancia = $medicamento->get_substancia();

		if (strcmp("".$initial_substancia, "".$final_substancia) == 0){ return true; }
		else { return false; }
	}

	public function test_cnpj (){
		$medicamento = new Medicamento();
		$initial_cnpj = "56.990.534/0001-67";
		$medicamento->set_cnpj($initial_cnpj);
		$final_cnpj = $medicamento->get_cnpj();

		if (strcmp("".$initial_cnpj, "".$final_cnpj) == 0){ return true; }
		else { return false; }
	}

	public function test_laboratorio (){
		$medicamento = new Medicamento();
		$initial_laboratorio = "SCHERING DO BRASIL QUÍMICA E FARMACÊUTICA LTDA";
		$medicamento->set_laboratorio($initial_laboratorio);
		$final_laboratorio = $medicamento->get_laboratorio();

		if (strcmp("".$initial_laboratorio, "".$final_laboratorio) == 0){ return true; }
		else { return false; }
	}

	public function test_codggrem (){
		$medicamento = new Medicamento();
		$initial_codggrem = "530916050012404";
		$medicamento->set_codggrem($initial_codggrem);
		$final_codggrem = $medicamento->get_codggrem();

		if (strcmp("".$initial_codggrem, "".$final_codggrem) == 0){ return true; }
		else { return false; }
	}

	public function test_produto (){
		$medicamento = new Medicamento();
		$initial_produto = "VISABELLE";
		$medicamento->set_produto($initial_produto);
		$final_produto = $medicamento->get_produto();

		if (strcmp("".$initial_produto, "".$final_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_apresentacao (){
		$medicamento = new Medicamento();
		$initial_apresentacao = "2 MG COM CT BL AL PLAS VERDE X 28";
		$medicamento->set_apresentacao($initial_apresentacao);
		$final_apresentacao = $medicamento->get_apresentacao();

		if (strcmp("".$initial_apresentacao, "".$final_apresentacao) == 0){ return true; }
		else { return false; }
	}

	public function test_classe_terapeutica (){
		$medicamento = new Medicamento();
		$initial_classe_terapeutica = "G03D0 - PROGESTÓGENOS EXCLUINDO G3A, G3F";
		$medicamento->set_classe_terapeutica($initial_classe_terapeutica);
		$final_classe_terapeutica = $medicamento->get_classe_terapeutica();

		if (strcmp("".$initial_classe_terapeutica, "".$final_classe_terapeutica) == 0){ return true; }
		else { return false; }
	}

	public function test_tipo_produto (){
		$medicamento = new Medicamento();
		$initial_tipo_produto = "Similar";
		$medicamento->set_tipo_produto($initial_tipo_produto);
		$final_tipo_produto = $medicamento->get_tipo_produto();

		if (strcmp("".$initial_tipo_produto, "".$final_tipo_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_tarja (){
		$medicamento = new Medicamento();
		$initial_tarja = "Tarja Vermelha";
		$medicamento->set_tarja($initial_tarja);
		$final_tarja = $medicamento->get_tarja();

		if (strcmp("".$initial_tarja, "".$final_tarja) == 0){ return true; }
		else { return false; }
	}

	public function test_cod_termo (){
		$medicamento = new Medicamento();
		$initial_cod_termo = "90355539";
		$medicamento->set_cod_termo($initial_cod_termo);
		$final_cod_termo = $medicamento->get_cod_termo();

		if (strcmp("".$initial_cod_termo, "".$final_cod_termo) == 0){ return true; }
		else { return false; }
	}

	public function test_generico (){
		$medicamento = new Medicamento();
		$initial_generico = false;
		$medicamento->set_generico($initial_generico);
		$final_generico = $medicamento->get_generico();

		if ($initial_generico == $final_generico){ return true; }
		else { return false; }
	}

	public function test_grupo_farmacologico (){
		$medicamento = new Medicamento();
		$initial_grupo_farmacologico = "SISTEMA GENITO URINARIO E HORMONIOS SEXUAIS";
		$medicamento->set_grupo_farmacologico($initial_grupo_farmacologico);
		$final_grupo_farmacologico = $medicamento->get_grupo_farmacologico();

		if (strcmp("".$initial_grupo_farmacologico, "".$final_grupo_farmacologico) == 0){ return true; }
		else { return false; }
	}

	public function test_classe_farmacologica (){
		$medicamento = new Medicamento();
		$initial_classe_farmacologica = "HORMONIOS SEXUAIS E MODULADORES DO SISTEMA GENITAL";
		$medicamento->set_classe_farmacologica($initial_classe_farmacologica);
		$final_classe_farmacologica = $medicamento->get_classe_farmacologica();

		if (strcmp("".$initial_classe_farmacologica, "".$final_classe_farmacologica) == 0){ return true; }
		else { return false; }
	}

	public function test_forma_farmaceutica (){
		$medicamento = new Medicamento();
		$initial_forma_farmaceutica = "COMPRIMIDO";
		$medicamento->set_forma_farmaceutica($initial_forma_farmaceutica);
		$final_forma_farmaceutica = $medicamento->get_forma_farmaceutica();

		if (strcmp("".$initial_forma_farmaceutica, "".$final_forma_farmaceutica) == 0){ return true; }
		else { return false; }
	}

	public function test_unidmin_fracao (){
		$medicamento = new Medicamento();
		$initial_unidmin_fracao = "COM";
		$medicamento->set_unidmin_fracao($initial_unidmin_fracao);
		$final_unidmin_fracao = $medicamento->get_unidmin_fracao();

		if (strcmp("".$initial_unidmin_fracao, "".$final_unidmin_fracao) == 0){ return true; }
		else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_substancia()){
				if ($this->test_cnpj()){
					if ($this->test_laboratorio()){
						if ($this->test_codggrem()){
							if ($this->test_produto()){
								if ($this->test_apresentacao()){
									if ($this->test_classe_terapeutica()){
										if ($this->test_tipo_produto()){
											if ($this->test_tarja()){
												if ($this->test_cod_termo()){
													if ($this->test_generico()){
														if ($this->test_grupo_farmacologico()){
															if ($this->test_classe_farmacologica()){
																if ($this->test_forma_farmaceutica()){
																	if ($this->test_unidmin_fracao()){
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
					}
				}
			}
		}

		return false;
	}
}
?>