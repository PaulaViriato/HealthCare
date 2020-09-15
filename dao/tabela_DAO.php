<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/tabela.php');
require_once('prestadora_DAO.php');
require_once('medtab_DAO.php');
require_once('mattab_DAO.php');

class Tabela_DAO {
	// Propriedades
	private $DAOPrestadora;
	private $DAOMedTab;
	private $DAOMatTab;

	// Construtor
	function __construct(){
		$this->DAOPrestadora = new Prestadora_DAO();
		$this->DAOMedTab = new MedTab_DAO();
		$this->DAOMatTab = new MatTab_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_tabela (type, id_prestadora, id_medtab, id_mattab) VALUES (
			".(is_null($objeto_recebido->get_type()) ? "null" : $objeto_recebido->get_type()).", 
			".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "null" : $objeto_recebido->get_PRESTADORA()->get_id()).", 
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_tabela (type, id_prestadora, id_medtab, id_mattab) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_type()) ? "null" : $objeto_recebido->get_type()).", 
				".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "null" : $objeto_recebido->get_PRESTADORA()->get_id()).", 
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_tabela SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_type()) ? "" : ", type = ".$objeto_recebido->get_type())."
		".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "" : ", id_prestadora = ".$objeto_recebido->get_PRESTADORA()->get_id())."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
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
			$sql = "SELECT id FROM tb_tabela WHERE 
			".(is_null($objeto_recebido->get_type()) ? "isnull(type)" : "type = ".$objeto_recebido->get_type())." AND
			".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "isnull(id_prestadora)" : "id_prestadora = ".$objeto_recebido->get_PRESTADORA()->get_id())." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_tabela WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_type()) ? "isnull(type)" : "type = ".$objeto_recebido->get_type())." AND
		".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "isnull(id_prestadora)" : "id_prestadora = ".$objeto_recebido->get_PRESTADORA()->get_id())." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id()).";";
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
		$sql = "DELETE FROM tb_tabela WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Tabela();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["type"])){ $new_object->set_type($row["type"]); }
		if (isset($row["id_prestadora"])){ $new_object->set_PRESTADORA($this->DAOPrestadora->select_id($row["id_prestadora"], $dbh)); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->DAOMedTab->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->DAOMatTab->select_id($row["id_mattab"], $dbh)); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_tabela SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_type()) ? "" : ", type = ".$objeto_recebido->get_type())."
				".(is_null($objeto_recebido->get_PRESTADORA()->get_id()) ? "" : ", id_prestadora = ".$objeto_recebido->get_PRESTADORA()->get_id())."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_tabela WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_tabela";
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_tabela WHERE id = ".$id.";";

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
		$sql = "SELECT * FROM tb_tabela WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_tabela;";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_Prestadora ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_tabela WHERE id_prestadora = ".$id." ORDER BY id DESC;";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MedTab ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_tabela WHERE id_medtab = ".$id.";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MatTab ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_tabela WHERE id_mattab = ".$id.";";

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
