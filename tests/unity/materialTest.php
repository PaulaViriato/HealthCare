<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity", "model", $path);
$path = str_replace ("tests\unity", "model", $path);
require_once($path.'/material.php');

class MaterialTest {
	// Métodos de Teste
	public function test_id (){
		$material = new Material();
		$initial_id = "10002070012";
		$material->set_id($initial_id);
		$final_id = $material->get_id();

		if (strcmp("".$initial_id, "".$final_id) == 0){ return true; }
		else { return false; }
	}

	public function test_cnpj (){
		$material = new Material();
		$initial_cnpj = "45.985.371/0001-08";
		$material->set_cnpj($initial_cnpj);
		$final_cnpj = $material->get_cnpj();

		if (strcmp("".$initial_cnpj, "".$final_cnpj) == 0){ return true; }
		else { return false; }
	}

	public function test_fabricante (){
		$material = new Material();
		$initial_fabricante = "3M DO BRASIL LTDA";
		$material->set_fabricante($initial_fabricante);
		$final_fabricante = $material->get_fabricante();

		if (strcmp("".$initial_fabricante, "".$final_fabricante) == 0){ return true; }
		else { return false; }
	}

	public function test_classe_risco (){
		$material = new Material();
		$initial_classe_risco = "I";
		$material->set_classe_risco($initial_classe_risco);
		$final_classe_risco = $material->get_classe_risco();

		if (strcmp("".$initial_classe_risco, "".$final_classe_risco) == 0){ return true; }
		else { return false; }
	}

	public function test_descricao_produto (){
		$material = new Material();
		$initial_descricao_produto = "ELETRODO MONITORACAO CARDIACA RED DOT 2269T";
		$material->set_descricao_produto($initial_descricao_produto);
		$final_descricao_produto = $material->get_descricao_produto();

		if (strcmp("".$initial_descricao_produto, "".$final_descricao_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_especialidade_produto (){
		$material = new Material();
		$initial_especialidade_produto = "ELETROCARDIOGRAMA";
		$material->set_especialidade_produto($initial_especialidade_produto);
		$final_especialidade_produto = $material->get_especialidade_produto();

		if (strcmp("".$initial_especialidade_produto, "".$final_especialidade_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_classificacao_produto (){
		$material = new Material();
		$initial_classificacao_produto = "MATERIAL DE CONSUMO";
		$material->set_classificacao_produto($initial_classificacao_produto);
		$final_classificacao_produto = $material->get_classificacao_produto();

		if (strcmp("".$initial_classificacao_produto, "".$final_classificacao_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_nome_tecnico (){
		$material = new Material();
		$initial_nome_tecnico = "CABO/ELETRODO PARA ELETROCARDIÓGRAFO";
		$material->set_nome_tecnico($initial_nome_tecnico);
		$final_nome_tecnico = $material->get_nome_tecnico();

		if (strcmp("".$initial_nome_tecnico, "".$final_nome_tecnico) == 0){ return true; }
		else { return false; }
	}

	public function test_unidmin_fracao (){
		$material = new Material();
		$initial_unidmin_fracao = "PC";
		$material->set_unidmin_fracao($initial_unidmin_fracao);
		$final_unidmin_fracao = $material->get_unidmin_fracao();

		if (strcmp("".$initial_unidmin_fracao, "".$final_unidmin_fracao) == 0){ return true; }
		else { return false; }
	}

	public function test_tipo_produto (){
		$material = new Material();
		$initial_tipo_produto = "Material de consumo hospitalar";
		$material->set_tipo_produto($initial_tipo_produto);
		$final_tipo_produto = $material->get_tipo_produto();

		if (strcmp("".$initial_tipo_produto, "".$final_tipo_produto) == 0){ return true; }
		else { return false; }
	}

	public function test_all (){
		if ($this->test_id()){
			if ($this->test_cnpj()){
				if ($this->test_fabricante()){
					if ($this->test_classe_risco()){
						if ($this->test_descricao_produto()){
							if ($this->test_especialidade_produto()){
								if ($this->test_classificacao_produto()){
									if ($this->test_nome_tecnico()){
										if ($this->test_unidmin_fracao()){
											if ($this->test_tipo_produto()){
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