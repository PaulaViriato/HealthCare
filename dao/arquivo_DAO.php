<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/arquivo.php');
require_once('medtab_DAO.php');
require_once('mattab_DAO.php');

class Arquivo_DAO {
	// Propriedades
	private $DAOMedTab;
	private $DAOMatTab;

	// Construtor
	function __construct(){
		$this->DAOMedTab = new MedTab_DAO();
		$this->DAOMatTab = new MatTab_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_arquivo (file_type, caminho, tab_type, id_medtab, id_mattab, data, status) VALUES (
			".(is_null($objeto_recebido->get_file_type()) ? "null" : $objeto_recebido->get_file_type()).", 
			".(is_null($objeto_recebido->get_caminho()) ? "null" : "'".$objeto_recebido->get_caminho()."'").", 
			".(is_null($objeto_recebido->get_tab_type()) ? "null" : $objeto_recebido->get_tab_type()).", 
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_data()) ? "null" : "'".$objeto_recebido->get_data()."'").", 
			".(is_null($objeto_recebido->get_status()) ? "null" : $objeto_recebido->get_status()).");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_arquivo (file_type, caminho, tab_type, id_medtab, id_mattab, data, status) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_file_type()) ? "null" : $objeto_recebido->get_file_type()).", 
				".(is_null($objeto_recebido->get_caminho()) ? "null" : "'".$objeto_recebido->get_caminho()."'").", 
				".(is_null($objeto_recebido->get_tab_type()) ? "null" : $objeto_recebido->get_tab_type()).", 
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_data()) ? "null" : "'".$objeto_recebido->get_data()."'").", 
				".(is_null($objeto_recebido->get_status()) ? "null" : $objeto_recebido->get_status()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_arquivo SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_file_type()) ? "" : ", file_type = ".$objeto_recebido->get_file_type())."
		".(is_null($objeto_recebido->get_caminho()) ? "" : ", caminho = '".$objeto_recebido->get_caminho()."'")."
		".(is_null($objeto_recebido->get_tab_type()) ? "" : ", tab_type = ".$objeto_recebido->get_tab_type())."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
		".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
		".(is_null($objeto_recebido->get_status()) ? "" : ", status = ".$objeto_recebido->get_status())."
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
			$sql = "SELECT id FROM tb_arquivo WHERE 
			".(is_null($objeto_recebido->get_file_type()) ? "isnull(file_type)" : "file_type = ".$objeto_recebido->get_file_type())." AND
			".(is_null($objeto_recebido->get_caminho()) ? "isnull(caminho)" : "caminho = '".$objeto_recebido->get_caminho()."'")." AND
			".(is_null($objeto_recebido->get_tab_type()) ? "isnull(tab_type)" : "tab_type = ".$objeto_recebido->get_tab_type())." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_data()) ? "isnull(data)" : "data = '".$objeto_recebido->get_data()."'")." AND
			".(is_null($objeto_recebido->get_status()) ? "isnull(status)" : "status = ".$objeto_recebido->get_status())." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_arquivo WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_file_type()) ? "isnull(file_type)" : "file_type = ".$objeto_recebido->get_file_type())." AND
		".(is_null($objeto_recebido->get_caminho()) ? "isnull(caminho)" : "caminho = '".$objeto_recebido->get_caminho()."'")." AND
		".(is_null($objeto_recebido->get_tab_type()) ? "isnull(tab_type)" : "tab_type = ".$objeto_recebido->get_tab_type())." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_data()) ? "isnull(data)" : "data = '".$objeto_recebido->get_data()."'")." AND
		".(is_null($objeto_recebido->get_status()) ? "isnull(status)" : "status = ".$objeto_recebido->get_status()).";";
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
		$sql = "DELETE FROM tb_arquivo WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Arquivo();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["file_type"])){ $new_object->set_file_type($row["file_type"]); }
		if (isset($row["caminho"])){ $new_object->set_caminho($row["caminho"]); }
		if (isset($row["tab_type"])){ $new_object->set_tab_type($row["tab_type"]); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->DAOMedTab->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->DAOMatTab->select_id($row["id_mattab"], $dbh)); }
		if (isset($row["data"])){ $new_object->set_data($row["data"]); }
		if (isset($row["status"])){ $new_object->set_status($row["status"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_arquivo SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_file_type()) ? "" : ", file_type = ".$objeto_recebido->get_file_type())."
				".(is_null($objeto_recebido->get_caminho()) ? "" : ", caminho = '".$objeto_recebido->get_caminho()."'")."
				".(is_null($objeto_recebido->get_tab_type()) ? "" : ", tab_type = ".$objeto_recebido->get_tab_type())."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
				".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
				".(is_null($objeto_recebido->get_status()) ? "" : ", status = ".$objeto_recebido->get_status())."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_arquivo WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_arquivo";
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_arquivo WHERE id = ".$id.";";

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
		$sql = "SELECT * FROM tb_arquivo WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_arquivo;";

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
		$sql = "SELECT * FROM tb_arquivo WHERE id_medtab = ".$id.";";

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
		$sql = "SELECT * FROM tb_arquivo WHERE id_mattab = ".$id.";";

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
