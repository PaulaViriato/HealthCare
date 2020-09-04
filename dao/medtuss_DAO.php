<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/medtuss.php');
require_once('medicamento_DAO.php');
require_once('medtab_DAO.php');

class MedTuss_DAO {
	// Propriedades
	private $DAOMedicamento;
	private $DAOMedTab;

	// Construtor
	function __construct(){
		$this->DAOMedicamento = new Medicamento_DAO();
		$this->DAOMedTab = new MedTab_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_medtuss (id_medicamento, id_medtab, inicio_vigencia, fim_vigencia, fim_implantacao) VALUES (
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_medtuss (id_medicamento, id_medtab, inicio_vigencia, fim_vigencia, fim_implantacao) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_medtuss SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
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
			$sql = "SELECT id FROM tb_medtuss WHERE 
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_medtuss WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'").";";
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
		$sql = "DELETE FROM tb_medtuss WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new MedTuss();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["id_medicamento"])){ $new_object->set_MEDICAMENTO($this->DAOMedicamento->select_id($row["id_medicamento"], $dbh)); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->DAOMedTab->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["inicio_vigencia"])){ $new_object->set_inicio_vigencia($row["inicio_vigencia"]); }
		if (isset($row["fim_vigencia"])){ $new_object->set_fim_vigencia($row["fim_vigencia"]); }
		if (isset($row["fim_implantacao"])){ $new_object->set_fim_implantacao($row["fim_implantacao"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_medtuss SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_medtuss WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_medtuss";
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

	public function exist_id ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT id FROM tb_medtuss WHERE 
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND 
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id()).";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){ if (isset($row["id"])){ $res_result = "".$row["id"]; }}
		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_medtuss WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null, $fields = null, $wherecl = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT ";
		if (is_null($fields)){ $sql .= "* FROM tb_medtuss"; }
		else{ $sql .= $fields." FROM tb_medtuss"; }
		if (!is_null($wherecl)){ $sql .= " WHERE ".$wherecl; }
		$sql .= ";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_Medicamento ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_medtuss WHERE id_medicamento = '".$id."';";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MedTab ($id, $database = null, $wherecl = null, $fields = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$array_return = array ();
		$currtab = $this->DAOMedTab->select_id ($id, $dbh);
		if (!is_null($currtab->get_MEDTAB())){
			$array_return = $this->select_by_MedTab ($currtab->get_MEDTAB()->get_id(), $dbh, $wherecl);
		}

		$sql = "SELECT ";
		if (!is_null($fields)){ $sql .= $fields." "; }
		else{ $sql .= "tb_medtuss.* "; }
		$sql .= "FROM (tb_medicamento JOIN tb_medtuss ON tb_medtuss.id_medicamento = tb_medicamento.id) 
		WHERE tb_medtuss.id_medtab = ".$id;
		if (!is_null($wherecl)){ $sql .= " AND (".$wherecl.")"; }
		$sql .= ";";

		$result = $dbh->query($sql);
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			$hasMat = false;

			for ($i = 0; $i < count($array_return); $i ++){
				$medid = $array_return[$i]->get_MEDICAMENTO()->get_id();
				if (strcasecmp ("".$medid, "".$new_object->get_MEDICAMENTO()->get_id()) == 0){
					if (!is_null($new_object->get_fim_implantacao())){
						if (strcasecmp ("".$new_object->get_fim_implantacao(), "1970-01-01") == 0){
							unset ($array_return[$i]);
						} else { $array_return[$i] = $new_object; }
					} else { $array_return[$i] = $new_object; }

					$hasMat = true;
					$i = count($array_return) + 1;
				}
			}

			if (!$hasMat){ array_push ($array_return, $new_object); }
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>