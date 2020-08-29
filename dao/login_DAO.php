<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/login.php');
require_once('cnes_DAO.php');

class Login_DAO {
	// Propriedades
	private $DAOCNES;

	// Construtor
	function __construct(){
		$this->DAOCNES = new CNES_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_login (first_login, senha, id_cnes) VALUES (
			".(is_null($objeto_recebido->get_first_login()) ? "null" : $objeto_recebido->get_first_login()).", 
			".(is_null($objeto_recebido->get_senha()) ? "null" : "md5('".$objeto_recebido->get_senha()."')").", 
			".(is_null($objeto_recebido->get_CNES()->get_id()) ? "null" : "'".$objeto_recebido->get_CNES()->get_id()."'").");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_login (first_login, senha, id_cnes) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_first_login()) ? "null" : $objeto_recebido->get_first_login()).", 
				".(is_null($objeto_recebido->get_senha()) ? "null" : "md5('".$objeto_recebido->get_senha()."')").", 
				".(is_null($objeto_recebido->get_CNES()->get_id()) ? "null" : "'".$objeto_recebido->get_CNES()->get_id()."'").")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido, $database = null){
		$sql = "UPDATE tb_login SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_first_login()) ? "" : ", first_login = ".$objeto_recebido->get_first_login())."
		".(is_null($objeto_recebido->get_senha()) ? "" : ", senha = md5('".$objeto_recebido->get_senha()."')")."
		".(is_null($objeto_recebido->get_CNES()->get_id()) ? "" : ", id_cnes = '".$objeto_recebido->get_CNES()->get_id()."'")."
		WHERE id = ".$objeto_recebido->get_id().";";
		return $sql;
	}

	public function insert ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$id = -1;
		if ((is_null($objeto_recebido->get_first_login()))||(intval($objeto_recebido->get_first_login()) == 1)){
			$id = $this->first_insert ($objeto_recebido, $dbh);
		} else {
			$sql = $this->get_insert ($objeto_recebido);
			$query_result = $dbh->query ($sql);

			if ($query_result){
				$sql = "SELECT id FROM tb_login WHERE 
				".(is_null($objeto_recebido->get_first_login()) ? "isnull(first_login)" : "first_login = ".$objeto_recebido->get_first_login())." AND
				".(is_null($objeto_recebido->get_senha()) ? "isnull(senha)" : "senha = md5('".$objeto_recebido->get_senha()."')")." AND
				".(is_null($objeto_recebido->get_CNES()->get_id()) ? "isnull(id_cnes)" : "id_cnes = '".$objeto_recebido->get_CNES()->get_id()."'")." 
				ORDER BY id DESC;";
				$result = $dbh->query($sql);
				$row = $result->fetch_assoc();
				$id = $row["id"];
			}
		}

		if (is_null ($database)){ $dbh = null; }
		return $id;
	}

	public function first_insert ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "INSERT INTO tb_login (first_login, senha, id_cnes) VALUES (1, 
		".(is_null($objeto_recebido->get_senha()) ? "null" : "'".$objeto_recebido->get_senha()."'").", 
		".(is_null($objeto_recebido->get_CNES()->get_id()) ? "null" : "'".$objeto_recebido->get_CNES()->get_id()."'").");";
		$query_result = $dbh->query ($sql);

		$id = -1;
		if ($query_result){
			$sql = "SELECT id FROM tb_login WHERE first_login = 1 AND 
			".(is_null($objeto_recebido->get_senha()) ? "isnull(senha)" : "senha = '".$objeto_recebido->get_senha()."'")." AND
			".(is_null($objeto_recebido->get_CNES()->get_id()) ? "isnull(id_cnes)" : "id_cnes = '".$objeto_recebido->get_CNES()->get_id()."'")." 
			ORDER BY id DESC;";
			$result = $dbh->query($sql);
			$row = $result->fetch_assoc();
			$id = $row["id"];
		}

		if (is_null ($database)){ $dbh = null; }
		return $id;
	}

	public function unmodified ($objeto_recebido, $database = null){
		$dbh = $database;
		$result = false;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT COUNT(id) AS count FROM tb_login WHERE 
		".(is_null($objeto_recebido->get_first_login()) ? "isnull(first_login)" : "first_login = ".$objeto_recebido->get_first_login())." AND
		".(is_null($objeto_recebido->get_senha()) ? "isnull(senha)" : "senha = md5('".$objeto_recebido->get_senha()."')")." AND
		".(is_null($objeto_recebido->get_CNES()->get_id()) ? "isnull(id_cnes)" : "id_cnes = '".$objeto_recebido->get_CNES()->get_id()."'").";";
		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();
		if (intval($row["count"]) > 0){ $result = true; }

		if (is_null ($database)){ $dbh->close(); }
		return $result;
	}

	public function update ($objeto_recebido, $database = null){
		$sql = $this->get_update ($objeto_recebido);
		exec_query ($sql, false, $database);
		return true;
	}

	public function delete ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "DELETE FROM tb_login WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	public function delete_prestadora ($id_cnes, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT COUNT(id) AS qtd FROM tb_prestadora WHERE id_cnes = '".$id_cnes."';";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$query_result = false;
		if (isset($row)){
			if (intval($row["qtd"]) <= 1){
				$sql2 = "DELETE FROM tb_login WHERE id_cnes = '".$id_cnes."';";
				$query_result = $dbh->query ($sql2);
			}
		}

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Login();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["first_login"])){ $new_object->set_first_login($row["first_login"]); }
		if (isset($row["senha"])){ $new_object->set_senha($row["senha"]); }
		if (isset($row["id_cnes"])){ $new_object->set_CNES($this->DAOCNES->select_id($row["id_cnes"], $dbh)); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_login SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_first_login()) ? "" : ", first_login = ".$objeto_recebido->get_first_login())."
				".(is_null($objeto_recebido->get_senha()) ? "" : ", senha = md5('".$objeto_recebido->get_senha()."')")."
				".(is_null($objeto_recebido->get_CNES()->get_id()) ? "" : ", id_cnes = '".$objeto_recebido->get_CNES()->get_id()."'")."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_login WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_login";
				if (is_null($wherecl) == false){ $sql = $sql." WHERE ".$wherecl; }
				if (is_null($ordercl) == false){ $sql = $sql." ORDER BY ".$ordercl; }
				$sql = $sql.";";

				$result = $dbh->query($sql);
				$resreturn = array ();
				while($row = $result->fetch_assoc()){
					$new_object = $this->get_object ($row, $dbh);
					array_push ($resreturn, $new_object);
				}
			}
		}

		if (is_null ($database)){ $dbh = null; }
		return $resreturn;
	}

	public function exist_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(id) AS qtd FROM tb_login WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = false;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){ $res_result = true; }
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function login ($login, $senha, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(tb_login.id) AS qtd FROM (tb_login JOIN tb_cnes ON tb_cnes.id = tb_login.id_cnes) WHERE 
		(tb_cnes.cnpj = '".$login."' OR tb_cnes.cpf = '".$login."') AND tb_login.senha = md5('".$senha."');";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){
				$sql2 = "SELECT tb_login.* FROM (tb_login JOIN tb_cnes ON tb_cnes.id = tb_login.id_cnes) WHERE 
				(tb_cnes.cnpj = '".$login."' OR tb_cnes.cpf = '".$login."') AND tb_login.senha = md5('".$senha."');";
				$result2 = $dbh->query($sql2);
				$row2 = $result2->fetch_assoc();
				$res_result = $this->get_object ($row2, $dbh);
			}
		}

		if (is_null ($res_result)){ $res_result = $this->first_login ($login, $senha, $dbh); }
		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function first_login ($login, $senha, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(tb_login.id) AS qtd FROM (tb_login JOIN tb_cnes ON tb_cnes.id = tb_login.id_cnes) WHERE (tb_cnes.cnpj 
		= '".$login."' OR tb_cnes.cpf = '".$login."') AND tb_login.senha = '".$senha."' AND tb_login.first_login = 1;";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){
				$sql2 = "SELECT tb_login.* FROM (tb_login JOIN tb_cnes ON tb_cnes.id = tb_login.id_cnes) WHERE (tb_cnes.cnpj 
				= '".$login."' OR tb_cnes.cpf = '".$login."') AND tb_login.senha = '".$senha."' AND tb_login.first_login = 1;";
				$result2 = $dbh->query($sql2);
				$row2 = $result2->fetch_assoc();
				$res_result = $this->get_object ($row2, $dbh);
			}
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_login WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null, $columns = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_login;";
		if (!is_null ($columns)){ $sql = "SELECT ".$columns." FROM tb_login;"; }

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_CNES ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_login WHERE id_cnes = '".$id."';";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>
