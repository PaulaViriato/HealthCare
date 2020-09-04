<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/rotina.php');
require_once('operadora_DAO.php');

class Rotina_DAO {
	// Propriedades
	private $DAOOperadora;

	// Construtor
	function __construct(){
		$this->DAOOperadora = new Operadora_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_rotina (type, url, periodo, id_operadora) VALUES (
			".(is_null($objeto_recebido->get_type()) ? "null" : $objeto_recebido->get_type()).", 
			".(is_null($objeto_recebido->get_url()) ? "null" : "'".$objeto_recebido->get_url()."'").", 
			".(is_null($objeto_recebido->get_periodo()) ? "null" : $objeto_recebido->get_periodo()).", 
			".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "null" : $objeto_recebido->get_OPERADORA()->get_id()).");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_rotina (type, url, periodo, id_operadora) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_type()) ? "null" : $objeto_recebido->get_type()).", 
				".(is_null($objeto_recebido->get_url()) ? "null" : "'".$objeto_recebido->get_url()."'").", 
				".(is_null($objeto_recebido->get_periodo()) ? "null" : $objeto_recebido->get_periodo()).", 
				".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "null" : $objeto_recebido->get_OPERADORA()->get_id()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_rotina SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_type()) ? "" : ", type = ".$objeto_recebido->get_type())."
		".(is_null($objeto_recebido->get_url()) ? "" : ", url = '".$objeto_recebido->get_url()."'")."
		".(is_null($objeto_recebido->get_periodo()) ? "" : ", periodo = ".$objeto_recebido->get_periodo())."
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
		WHERE id = ".$objeto_recebido->get_id().";";
		return $sql;
	}

	public function insert ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = $this->get_insert ($objeto_recebido);
		$query_result = $dbh->query ($sql);

		$id = -1;
		if ($query_result){
			$sql = "SELECT id FROM tb_rotina WHERE 
			".(is_null($objeto_recebido->get_type()) ? "isnull(type)" : "type = ".$objeto_recebido->get_type())." AND
			".(is_null($objeto_recebido->get_url()) ? "isnull(url)" : "url = '".$objeto_recebido->get_url()."'")." AND
			".(is_null($objeto_recebido->get_periodo()) ? "isnull(periodo)" : "periodo = ".$objeto_recebido->get_periodo())." AND
			".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_rotina WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_type()) ? "isnull(type)" : "type = ".$objeto_recebido->get_type())." AND
		".(is_null($objeto_recebido->get_url()) ? "isnull(url)" : "url = '".$objeto_recebido->get_url()."'")." AND
		".(is_null($objeto_recebido->get_periodo()) ? "isnull(periodo)" : "periodo = ".$objeto_recebido->get_periodo())." AND
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id()).";";
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
		$sql = "DELETE FROM tb_rotina WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Rotina();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["type"])){ $new_object->set_type($row["type"]); }
		if (isset($row["url"])){ $new_object->set_url($row["url"]); }
		if (isset($row["periodo"])){ $new_object->set_periodo($row["periodo"]); }
		if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_rotina SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_type()) ? "" : ", type = ".$objeto_recebido->get_type())."
				".(is_null($objeto_recebido->get_url()) ? "" : ", url = '".$objeto_recebido->get_url()."'")."
				".(is_null($objeto_recebido->get_periodo()) ? "" : ", periodo = ".$objeto_recebido->get_periodo())."
				".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_rotina WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_rotina";
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_rotina WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = false;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){ $res_result = true; }
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_rotina WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_rotina;";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_Operadora ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_rotina WHERE id_operadora = ".$id.";";

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