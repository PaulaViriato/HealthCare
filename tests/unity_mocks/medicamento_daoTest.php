<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity_mocks", "dao", $path);
$path = str_replace ("tests\unity_mocks", "dao", $path);
require_once($path.'/medicamento_DAO.php');
require_once($path.'/cmed_DAO.php');

class Medicamento_DAOTest {
	// Propriedades
	private $DAOMedicamento;
	private $DAOCMED;
	private $mock_a;
	private $mock_b;

	// Construtor
	function __construct(){
		$this->DAOMedicamento = new Medicamento_DAO();
		$this->DAOCMED = new CMED_DAO();

		$this->mock_a = new Medicamento();
		$this->mock_a->set_id ("0000000000001");
		$this->mock_a->set_substancia ("Substancia 1");
		$this->mock_a->set_cnpj ("01.234.567/8901-23");
		$this->mock_a->set_laboratorio ("Laboratorio 1");
		$this->mock_a->set_codggrem ("000000000000001");
		$this->mock_a->set_produto ("Produto 1");
		$this->mock_a->set_apresentacao ("Apresentacao 1");
		$this->mock_a->set_classe_terapeutica ("Classe Terapeutica 1");
		$this->mock_a->set_tipo_produto ("Tipo Produto 1");
		$this->mock_a->set_tarja ("Tarja 1");
		$this->mock_a->set_cod_termo ("00000001");
		$this->mock_a->set_generico (false);
		$this->mock_a->set_grupo_farmacologico ("Grupo Farmacologico 1");
		$this->mock_a->set_classe_farmacologica ("Classe Farmacologica 1");
		$this->mock_a->set_forma_farmaceutica ("Forma Farmaceutica 1");
		$this->mock_a->set_unidmin_fracao ("UNID");

		$this->mock_b = new Medicamento();
		$this->mock_b->set_id ("0000000000002");
		$this->mock_b->set_substancia ("Substancia 2");
		$this->mock_b->set_cnpj ("98.765.432/1098-76");
		$this->mock_b->set_laboratorio ("Laboratorio 2");
		$this->mock_b->set_codggrem ("000000000000002");
		$this->mock_b->set_produto ("Produto 2");
		$this->mock_b->set_apresentacao ("Apresentacao 2");
		$this->mock_b->set_classe_terapeutica ("Classe Terapeutica 2");
		$this->mock_b->set_tipo_produto ("Tipo Produto 2");
		$this->mock_b->set_tarja ("Tarja 2");
		$this->mock_b->set_cod_termo ("00000002");
		$this->mock_b->set_generico (true);
		$this->mock_b->set_grupo_farmacologico ("Grupo Farmacologico 2");
		$this->mock_b->set_classe_farmacologica ("Classe Farmacologica 2");
		$this->mock_b->set_forma_farmaceutica ("Forma Farmaceutica 2");
		$this->mock_b->set_unidmin_fracao ("MINUND");
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

	private function compareMedicamento ($med_a, $med_b){
		if ((strcmp("".$med_a->get_id(), "".$med_b->get_id()) == 0)&&
			(strcmp("".$med_a->get_substancia(), "".$med_b->get_substancia()) == 0)&&
			(strcmp("".$med_a->get_cnpj(), "".$med_b->get_cnpj()) == 0)&&
			(strcmp("".$med_a->get_laboratorio(), "".$med_b->get_laboratorio()) == 0)&&
			(strcmp("".$med_a->get_codggrem(), "".$med_b->get_codggrem()) == 0)&&
			(strcmp("".$med_a->get_produto(), "".$med_b->get_produto()) == 0)&&
			(strcmp("".$med_a->get_apresentacao(), "".$med_b->get_apresentacao()) == 0)&&
			(strcmp("".$med_a->get_classe_terapeutica(), "".$med_b->get_classe_terapeutica()) == 0)&&
			(strcmp("".$med_a->get_tipo_produto(), "".$med_b->get_tipo_produto()) == 0)&&
			(strcmp("".$med_a->get_tarja(), "".$med_b->get_tarja()) == 0)&&
			(strcmp("".$med_a->get_cod_termo(), "".$med_b->get_cod_termo()) == 0)&&
			($med_a->get_generico() == $med_b->get_generico())&&
			(strcmp("".$med_a->get_grupo_farmacologico(), "".$med_b->get_grupo_farmacologico()) == 0)&&
			(strcmp("".$med_a->get_classe_farmacologica(), "".$med_b->get_classe_farmacologica()) == 0)&&
			(strcmp("".$med_a->get_forma_farmaceutica(), "".$med_b->get_forma_farmaceutica()) == 0)&&
			(strcmp("".$med_a->get_unidmin_fracao(), "".$med_b->get_unidmin_fracao()) == 0)){
			return true;
		}
		return false;
	}

	public function test_get_insert (){
		$result = false;
		$dbh = $this->getDbh();
		$sql = $this->DAOMedicamento->get_insert ($this->mock_a);
		$query_result = $dbh->query ($sql);

		if ($query_result){
			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
			if ($query_result){
				$sql = $this->DAOMedicamento->get_insert ($this->mock_a, false, true, false);
				$sql .= $this->DAOMedicamento->get_insert ($this->mock_a, false, false, true);
				$sql .= ", ".$this->DAOMedicamento->get_insert ($this->mock_b, false, false, true);
				$query_result = $dbh->multi_query ($sql.";");
				if ($query_result){
					$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
					$query_result = $dbh->query ($sql);
					if ($query_result){
						$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());

			$dbh = $this->getDbh();
			$sql = $this->DAOMedicamento->get_update ($this->mock_b);
			$query_result = $dbh->query ($sql);
			if ($query_result){ $result = true; }

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$inserted = $this->DAOMedicamento->select_id ($id, $dbh);
			if ($this->compareMedicamento($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_unmodified (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOMedicamento->unmodified($this->mock_a, $dbh)){
				$substancia_mock_a = $this->mock_a->get_substancia();
				$this->mock_a->set_substancia ($this->mock_b->get_substancia());
				if ($this->DAOMedicamento->unmodified($this->mock_a, $dbh) == false){ $result = true; }
				$this->mock_a->set_substancia ($substancia_mock_a);
			}

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_update (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			if ($this->DAOMedicamento->update ($this->mock_b, $dbh)){
				$updated = $this->DAOMedicamento->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareMedicamento($updated, $this->mock_b)){ $result = true; }
			}

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOMedicamento->delete ($id, $dbh)){
				$inserted = $this->DAOMedicamento->select_id ($id, $dbh);
				if ($this->compareMedicamento($inserted, $this->mock_a) == false){
					$result = true;
				}
			}

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	private function get_object (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$sql = "SELECT * FROM tb_medicamento WHERE id = ".$id.";";
			$result = $dbh->query($sql);
			$row = $result->fetch_assoc();
			$inserted = $this->DAOMedicamento->get_object ($row, $dbh);
			if ($this->compareMedicamento($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_where_order_clause (){
		$dbh = $this->getDbh();

		$result_a = false;
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			$wherecl = "id = ".$this->mock_a->get_id();
			if ($this->DAOMedicamento->where_order_clause (0, $wherecl, null, $this->mock_b, $dbh)){
				$updated = $this->DAOMedicamento->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareMedicamento($updated, $this->mock_b)){ $result_a = true; }
			}

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_b->get_id().";";
			$query_result = $dbh->query ($sql);
			$this->mock_b->set_id ($id_mock_b);
		}

		$result_b = false;
		$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$wherecl = "id = ".$id;
			if ($this->DAOMedicamento->where_order_clause (1, $wherecl, null, null, $dbh)){
				$inserted = $this->DAOMedicamento->select_id ($id, $dbh);
				if ($this->compareMedicamento($inserted, $this->mock_a) == false){
					$result_b = true;
				}
			}

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$result_c = false;
		$wherecl = "id != 0";
		$ordercl = "id";

		$values = $this->DAOMedicamento->where_order_clause (2, $wherecl, $ordercl, null, $dbh);
		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareMedicamento($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
			$values = $this->DAOMedicamento->where_order_clause (2, $wherecl, $ordercl, null, $dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareMedicamento($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result_c = true; }
			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
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
		if ($this->DAOMedicamento->exist_id ($this->mock_a->get_id(), $dbh) == false){
			$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
			if ($this->DAOMedicamento->exist_id ($this->mock_a->get_id(), $dbh)){ $result = true; }

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_id (){
		$result = false;
		$dbh = $this->getDbh();
		$selected = $this->DAOMedicamento->select_id ($this->mock_a->get_id(), $dbh);
		if ($this->compareMedicamento($selected, $this->mock_a) == false){
			$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
			$selected = $this->DAOMedicamento->select_id ($this->mock_a->get_id(), $dbh);
			if ($this->compareMedicamento($selected, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_all (){
		$result = false;
		$dbh = $this->getDbh();
		$values = $this->DAOMedicamento->select_all ($dbh);

		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareMedicamento($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOMedicamento->insert ($this->mock_a, $dbh);
			$values = $this->DAOMedicamento->select_all ($dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareMedicamento($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result = true; }
			$sql = "DELETE FROM tb_medicamento WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_extract_meds (){
		$result = false;
		$dbh = $this->getDbh();
		$values = $this->DAOMedicamento->extract_meds (null, null, null);
		if (count($values) == 0){
			$cmeds = $this->DAOCMED->select_all($dbh, null, "id < 100");
			if (count($cmeds) > 0){
				$values = $this->DAOMedicamento->extract_meds ($cmeds, null, null);
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
												if ($this->test_extract_meds()){
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
