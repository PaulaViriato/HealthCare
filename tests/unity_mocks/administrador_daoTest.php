<?php

$path = dirname (__FILE__);
$path = str_replace ("tests/unity_mocks", "dao", $path);
$path = str_replace ("tests\unity_mocks", "dao", $path);
require_once($path.'/administrador_DAO.php');

class Administrador_DAOTest {
	// Propriedades
	private $DAOAdministrador;
	private $mock_a;
	private $mock_b;

	// Construtor
	function __construct(){
		$this->DAOAdministrador = new Administrador_DAO();
		$this->mock_a = new Administrador();
		$this->mock_a->set_id(123456);
		$this->mock_a->set_nome("Alguém dos Santos Silva");
		$this->mock_a->set_email("alguem@email.com");
		$this->mock_a->set_login("!AlguemSilva!");
		$this->mock_a->set_senha("!Alguem123456!");

		$this->mock_b = new Administrador();
		$this->mock_b->set_id(123457);
		$this->mock_b->set_nome("Fulano dos Santos Silva");
		$this->mock_b->set_email("fulano@email.com");
		$this->mock_b->set_login("!FulanoSilva!");
		$this->mock_b->set_senha("!Fulano123456!");
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

	private function compareAdministrador ($adm_a, $adm_b){
		if ((strcmp("".$adm_a->get_id(), "".$adm_b->get_id()) == 0)&&
			(strcmp("".$adm_a->get_nome(), "".$adm_b->get_nome()) == 0)&&
			(strcmp("".$adm_a->get_email(), "".$adm_b->get_email()) == 0)&&
			(strcmp("".$adm_a->get_login(), "".$adm_b->get_login()) == 0)){
			if ((strcmp("".$adm_a->get_senha(), "".$adm_b->get_senha()) == 0)||
				(strcmp("".md5($adm_a->get_senha()), "".$adm_b->get_senha()) == 0)||
				(strcmp("".$adm_a->get_senha(), "".md5($adm_b->get_senha())) == 0)||
				(strcmp("".md5($adm_a->get_senha()), "".md5($adm_b->get_senha())) == 0)){
				return true;
			}
		}
		return false;
	}

	public function test_get_insert (){
		$result = false;
		$dbh = $this->getDbh();
		$sql = $this->DAOAdministrador->get_insert ($this->mock_a);
		$query_result = $dbh->query ($sql);

		if ($query_result){
			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
			if ($query_result){
				$sql = $this->DAOAdministrador->get_insert ($this->mock_a, false, true, false);
				$sql .= $this->DAOAdministrador->get_insert ($this->mock_a, false, false, true);
				$sql .= ", ".$this->DAOAdministrador->get_insert ($this->mock_b, false, false, true);
				$query_result = $dbh->multi_query ($sql.";");
				if ($query_result){
					$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
					$query_result = $dbh->query ($sql);
					if ($query_result){
						$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());

			$dbh = $this->getDbh();
			$sql = $this->DAOAdministrador->get_update ($this->mock_b);
			$query_result = $dbh->query ($sql);
			if ($query_result){ $result = true; }

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$inserted = $this->DAOAdministrador->select_id ($id, $dbh);
			if ($this->compareAdministrador($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_unmodified (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOAdministrador->unmodified($this->mock_a, $dbh)){
				$name_mock_a = $this->mock_a->get_nome();
				$this->mock_a->set_nome ($this->mock_b->get_nome());
				if ($this->DAOAdministrador->unmodified($this->mock_a, $dbh) == false){ $result = true; }
				$this->mock_a->set_nome ($name_mock_a);
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_update (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			if ($this->DAOAdministrador->update ($this->mock_b, $dbh)){
				$updated = $this->DAOAdministrador->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareAdministrador($updated, $this->mock_b)){ $result = true; }
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_b->get_id().";";
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
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			if ($this->DAOAdministrador->delete ($id, $dbh)){
				$inserted = $this->DAOAdministrador->select_id ($id, $dbh);
				if ($this->compareAdministrador($inserted, $this->mock_a) == false){
					$result = true;
				}
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	private function get_object (){
		$result = false;
		$dbh = $this->getDbh();
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$sql = "SELECT * FROM tb_administrador WHERE id = ".$id.";";
			$result = $dbh->query($sql);
			$row = $result->fetch_assoc();
			$inserted = $this->DAOAdministrador->get_object ($row, $dbh);
			if ($this->compareAdministrador($inserted, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_where_order_clause (){
		$dbh = $this->getDbh();

		$result_a = false;
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$id_mock_b = $this->mock_b->get_id();
			$this->mock_b->set_id ($this->mock_a->get_id());
			$wherecl = "id = ".$this->mock_a->get_id();
			if ($this->DAOAdministrador->where_order_clause (0, $wherecl, null, $this->mock_b, $dbh)){
				$updated = $this->DAOAdministrador->select_id ($this->mock_b->get_id(), $dbh);
				if ($this->compareAdministrador($updated, $this->mock_b)){ $result_a = true; }
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_b->get_id().";";
			$query_result = $dbh->query ($sql);
			$this->mock_b->set_id ($id_mock_b);
		}

		$result_b = false;
		$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
		if ($id != -1){
			$wherecl = "id = ".$id;
			if ($this->DAOAdministrador->where_order_clause (1, $wherecl, null, null, $dbh)){
				$inserted = $this->DAOAdministrador->select_id ($id, $dbh);
				if ($this->compareAdministrador($inserted, $this->mock_a) == false){
					$result_b = true;
				}
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}

		$result_c = false;
		$wherecl = "id != 0";
		$ordercl = "id";

		$values = $this->DAOAdministrador->where_order_clause (2, $wherecl, $ordercl, null, $dbh);
		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareAdministrador($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			$values = $this->DAOAdministrador->where_order_clause (2, $wherecl, $ordercl, null, $dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareAdministrador($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result_c = true; }
			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
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
		if ($this->DAOAdministrador->exist_id ($this->mock_a->get_id(), $dbh) == false){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			if ($this->DAOAdministrador->exist_id ($this->mock_a->get_id(), $dbh)){ $result = true; }

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_exist_login (){
		$result = false;
		$dbh = $this->getDbh();
		if ($this->DAOAdministrador->exist_login ($this->mock_a->get_login(), $dbh, true) == false){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			if ($this->DAOAdministrador->exist_login ($this->mock_a->get_login(), $dbh, true)){
				$result = true;
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_login (){
		$result = false;
		$dbh = $this->getDbh();
		if (is_null($this->DAOAdministrador->login ($this->mock_a->get_login(), $this->mock_a->get_senha(), $dbh))){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			if (!is_null($this->DAOAdministrador->login ($this->mock_a->get_login(), $this->mock_a->get_senha(), $dbh))){
				$result = true;
			}

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_id (){
		$result = false;
		$dbh = $this->getDbh();
		$selected = $this->DAOAdministrador->select_id ($this->mock_a->get_id(), $dbh);
		if ($this->compareAdministrador($selected, $this->mock_a) == false){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			$selected = $this->DAOAdministrador->select_id ($this->mock_a->get_id(), $dbh);
			if ($this->compareAdministrador($selected, $this->mock_a)){ $result = true; }

			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
		}
		
		$dbh->close(); 
		$dbh = null;
		return $result;
	}

	public function test_select_all (){
		$result = false;
		$dbh = $this->getDbh();
		$values = $this->DAOAdministrador->select_all ($dbh);

		$has_mock_a = false;
		foreach ($values as $selected){
			if ($this->compareAdministrador($selected, $this->mock_a)){
				$has_mock_a = true;
			}
		}

		if (!$has_mock_a){
			$id = $this->DAOAdministrador->insert ($this->mock_a, $dbh);
			$values = $this->DAOAdministrador->select_all ($dbh);

			$has_mock_a = false;
			foreach ($values as $selected){
				if ($this->compareAdministrador($selected, $this->mock_a)){
					$has_mock_a = true;
				}
			}

			if ($has_mock_a){ $result = true; }
			$sql = "DELETE FROM tb_administrador WHERE id = ".$this->mock_a->get_id().";";
			$query_result = $dbh->query ($sql);
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
										if ($this->test_exist_login()){
											if ($this->test_login()){
												if ($this->test_select_id()){
													if ($this->test_select_all()){
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
		}
		return $result;
	}
}
?>
