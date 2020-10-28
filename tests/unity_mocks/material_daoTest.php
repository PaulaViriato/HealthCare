<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity_mocks", "dao", $path);
$path = str_replace ("tests\unity_mocks", "dao", $path);
require_once($path.'/material_DAO.php');
require_once($path.'/mattuss_DAO.php');

class Material_DAOTest {
	// Propriedades
	private $DAOMaterial;
	private $DAOMatTuss;
	private $mock_a;
	private $mock_b;

	// Construtor
	function __construct(){
		$this->DAOMaterial = new Material_DAO();
		$this->DAOMatTuss = new MatTuss_DAO();
		$this->mock_a = new Material();
		$this->mock_a->set_id ("0000000000001");
		$this->mock_a->set_cnpj ("01.234.567/8901-23");
		$this->mock_a->set_fabricante ("Fabricante 1");
		$this->mock_a->set_classe_risco ("I");
		$this->mock_a->set_descricao_produto ("Descricao Produto 1");
		$this->mock_a->set_especialidade_produto ("Especialidade Produto 1");
		$this->mock_a->set_classificacao_produto ("Classificacao Produto 1");
		$this->mock_a->set_nome_tecnico ("Nome Tecnico 1");
		$this->mock_a->set_unidmin_fracao ("UNID");
		$this->mock_a->set_tipo_produto ("Tipo Produto 1");

		$this->mock_b = new Material();
		$this->mock_b->set_id ("0000000000002");
		$this->mock_b->set_cnpj ("98.765.432/1098-76");
		$this->mock_b->set_fabricante ("Fabricante 2");
		$this->mock_b->set_classe_risco ("II");
		$this->mock_b->set_descricao_produto ("Descricao Produto 2");
		$this->mock_b->set_especialidade_produto ("Especialidade Produto 2");
		$this->mock_b->set_classificacao_produto ("Classificacao Produto 2");
		$this->mock_b->set_nome_tecnico ("Nome Tecnico 2");
		$this->mock_b->set_unidmin_fracao ("MINUND");
		$this->mock_b->set_tipo_produto ("Tipo Produto 2");
	}

	// Métodos
	private function getDbh(){	
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "lemed_db";
		$dbh = new mysqli($servername, $username, $password, $dbname);
		$dbh->set_charset("utf8");
		return $dbh;
	}

	private function compareMaterial ($mat_a, $mat_b){
		if ((strcmp("".$mat_a->get_id(), "".$mat_b->get_id()) == 0)&&
			(strcmp("".$mat_a->get_cnpj(), "".$mat_b->get_cnpj()) == 0)&&
			(strcmp("".$mat_a->get_fabricante(), "".$mat_b->get_fabricante()) == 0)&&
			(strcmp("".$mat_a->get_classe_risco(), "".$mat_b->get_classe_risco()) == 0)&&
			(strcmp("".$mat_a->get_descricao_produto(), "".$mat_b->get_descricao_produto()) == 0)&&
			(strcmp("".$mat_a->get_especialidade_produto(), "".$mat_b->get_especialidade_produto()) == 0)&&
			(strcmp("".$mat_a->get_classificacao_produto(), "".$mat_b->get_classificacao_produto()) == 0)&&
			(strcmp("".$mat_a->get_nome_tecnico(), "".$mat_b->get_nome_tecnico()) == 0)&&
			(strcmp("".$mat_a->get_unidmin_fracao(), "".$mat_b->get_unidmin_fracao()) == 0)&&
			(strcmp("".$mat_a->get_tipo_produto(), "".$mat_b->get_tipo_produto()) == 0)){
			return true;
		}
		return false;
	}

	public function test_get_insert (){
		$result = false;
		$dbh = $this->getDbh();
		$sql = $this->DAOMaterial->get_insert ($this->mock_a);
		$query_result = $dbh->query ($sql);

		if ($query_result){
			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
			if ($query_result){
				$sql = $this->DAOMaterial->get_insert ($this->mock_a, false, true, false);
				$sql .= $this->DAOMaterial->get_insert ($this->mock_a, false, false, true);
				$sql .= ", ".$this->DAOMaterial->get_insert ($this->mock_b, false, false, true);
				$query_result = $dbh->multi_query ($sql.";");
				if ($query_result){
					$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
					$query_result = $dbh->query ($sql);
					if ($query_result){
						$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_b->get_id().";";
						$query_result = $dbh->query ($sql);
						if ($query_result){ $result = true; }
					}
				}
			}
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_get_update (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());

			$dbh = $this->getDbh();
			$sql = $this->DAOMaterial->get_update ($this->mock_b);
			$query_result = $dbh->query ($sql);
			if ($query_result){ $result = true; }

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_b->get_id().";";
			$query_result = $dbh->query ($sql);

			$this->mock_b->set_id ($id_mock_b);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_insert (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$inserted = $this->DAOMaterial->select_id ($id, $dbh);
			if ($this->compareMaterial($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_unmodified (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOMaterial->unmodified($this->mock_a, $dbh)){
				$name_mock_a = $this->mock_a->get_nome_tecnico();
				$this->mock_a->set_nome_tecnico ($this->mock_b->get_nome_tecnico());
				if ($this->DAOMaterial->unmodified($this->mock_a, $dbh) == false){ $result = true; }
				$this->mock_a->set_nome_tecnico ($name_mock_a);
			}

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_update (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			if ($this->DAOMaterial->update ($this->mock_b, $dbh)){
				$updated = $this->DAOMaterial->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareMaterial($updated, $this->mock_b)){ $result = true; }
			}

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_b->get_id().";";
			$query_result = $dbh->query ($sql);
			$this->mock_b->set_id ($id_mock_b);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_delete (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOMaterial->delete ($id, $dbh)){
				$inserted = $this->DAOMaterial->select_id ($id, $dbh);
				if ($this->compareMaterial($inserted, $this->mock_a) == false){
					$result = true;
				}
			}

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	private function get_object (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$sql = "SELECT * FROM tb_material WHERE id = ".$id.";";
			$result = $dbh->query($sql);
			$row = $result->fetch_assoc();
			$inserted = $this->DAOMaterial->get_object ($row, $dbh);
			if ($this->compareMaterial($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_where_order_clause (){
		$dbh = $this->getDbh();

		$result_a = false;
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			$wherecl = "id = ".$this->mock_a->get_id();
			if ($this->DAOMaterial->where_order_clause (0, $wherecl, null, $this->mock_b, $dbh)){
				$updated = $this->DAOMaterial->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareMaterial($updated, $this->mock_b)){ $result_a = true; }
			}

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_b->get_id().";";
			$query_result = $dbh->query ($sql);
			$this->mock_b->set_id ($id_mock_b);
		}

		$result_b = false;
		$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$wherecl = "id = ".$id;
			if ($this->DAOMaterial->where_order_clause (1, $wherecl, null, null, $dbh)){
				$inserted = $this->DAOMaterial->select_id ($id, $dbh);
				if ($this->compareMaterial($inserted, $this->mock_a) == false){
					$result_b = true;
				}
			}

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$result_c = false;
		$wherecl = "id != 0";
		$ordercl = "id";

		$values = $this->DAOMaterial->where_order_clause (2, $wherecl, $ordercl, null, $dbh);
		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareMaterial($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
			$values = $this->DAOMaterial->where_order_clause (2, $wherecl, $ordercl, null, $dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareMaterial($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result_c = true; }
			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$result = false;
		if ($result_a && $result_b && $result_c){ $result = true; }
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_exist_id (){
		$result = false;
		$dbh = $this->getDbh();
		if ($this->DAOMaterial->exist_id ($this->mock_a->get_id(), $dbh) == false){
			$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
			if ($this->DAOMaterial->exist_id ($this->mock_a->get_id(), $dbh)){ $result = true; }

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_id (){
		$result = false;
		$dbh = $this->getDbh();
		$selected = $this->DAOMaterial->select_id ($this->mock_a->get_id(), $dbh);
		if ($this->compareMaterial($selected, $this->mock_a) == false){
			$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
			$selected = $this->DAOMaterial->select_id ($this->mock_a->get_id(), $dbh);
			if ($this->compareMaterial($selected, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_all (){
		$result = false;
		$dbh = $this->getDbh();
		$values = $this->DAOMaterial->select_all ($dbh);

		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareMaterial($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOMaterial->insert ($this->mock_a, $dbh);
			$values = $this->DAOMaterial->select_all ($dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareMaterial($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result = true; }
			$sql = "DELETE FROM tb_material WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_extract_mats (){
		$result = false;
		$dbh = $this->getDbh();
		$values = $this->DAOMaterial->extract_mats (null, null);
		if (count($values) == 0){
			$mattusss = $this->DAOMatTuss->select_all($dbh, null, "((id >= '170000034') AND (id <= '170002320'))");
			if (count($mattusss) > 0){
				$values = $this->DAOMaterial->extract_mats ($mattusss, null);
				if (count($values) > 0){ $result = true; }
			}
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_all (){
		$result = false;
		if ($this->test_get_insert()){
			if ($this->test_get_update()){
				if ($this->test_insert()){
					if ($this->test_unmodified()){
						if ($this->test_update()){
							if ($this->test_delete()){
								if ($this->test_where_order_clause()){
									if ($this->test_exist_id()){
										if ($this->test_select_id()){
											if ($this->test_select_all()){
												if ($this->test_extract_mats()){
													$result = true;
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
		return $result;
	}
}
?>