<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('mattuss_DAO.php');
require_once('mattnum_DAO.php');
require_once($path.'/material.php');

class Material_DAO {
	// Propriedades
	private $DAOMatTuss;
	private $DAOMatTnum;

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_material (id, cnpj, fabricante, classe_risco, descricao_produto, especialidade_produto, 
			classificacao_produto, nome_tecnico, unidmin_fracao, tipo_produto) VALUES (
			".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
			".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
			".(is_null($objeto_recebido->get_fabricante()) ? "null" : "'".$objeto_recebido->get_fabricante()."'").", 
			".(is_null($objeto_recebido->get_classe_risco()) ? "null" : "'".$objeto_recebido->get_classe_risco()."'").", 
			".(is_null($objeto_recebido->get_descricao_produto()) ? "null" : "'".$objeto_recebido->get_descricao_produto()."'").", 
			".(is_null($objeto_recebido->get_especialidade_produto()) ? "null" : "'".$objeto_recebido->get_especialidade_produto()."'").", 
			".(is_null($objeto_recebido->get_classificacao_produto()) ? "null" : "'".$objeto_recebido->get_classificacao_produto()."'").", 
			".(is_null($objeto_recebido->get_nome_tecnico()) ? "null" : "'".$objeto_recebido->get_nome_tecnico()."'").", 
			".(is_null($objeto_recebido->get_unidmin_fracao()) ? "null" : "'".$objeto_recebido->get_unidmin_fracao()."'").", 
			".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").");";
		} else {
			if ($intro == true){
				$sql .= "INSERT INTO tb_material (id, cnpj, fabricante, classe_risco, descricao_produto, especialidade_produto, 
				classificacao_produto, nome_tecnico, unidmin_fracao, tipo_produto) VALUES ";
			}
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
				".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
				".(is_null($objeto_recebido->get_fabricante()) ? "null" : "'".$objeto_recebido->get_fabricante()."'").", 
				".(is_null($objeto_recebido->get_classe_risco()) ? "null" : "'".$objeto_recebido->get_classe_risco()."'").", 
				".(is_null($objeto_recebido->get_descricao_produto()) ? "null" : "'".$objeto_recebido->get_descricao_produto()."'").", 
				".(is_null($objeto_recebido->get_especialidade_produto()) ? "null" : "'".$objeto_recebido->get_especialidade_produto()."'").", 
				".(is_null($objeto_recebido->get_classificacao_produto()) ? "null" : "'".$objeto_recebido->get_classificacao_produto()."'").", 
				".(is_null($objeto_recebido->get_nome_tecnico()) ? "null" : "'".$objeto_recebido->get_nome_tecnico()."'").", 
				".(is_null($objeto_recebido->get_unidmin_fracao()) ? "null" : "'".$objeto_recebido->get_unidmin_fracao()."'").", 
				".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_material SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
		".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
		".(is_null($objeto_recebido->get_fabricante()) ? "" : ", fabricante = '".$objeto_recebido->get_fabricante()."'")."
		".(is_null($objeto_recebido->get_classe_risco()) ? "" : ", classe_risco = '".$objeto_recebido->get_classe_risco()."'")."
		".(is_null($objeto_recebido->get_descricao_produto()) ? "" : ", descricao_produto = '".$objeto_recebido->get_descricao_produto()."'")."
		".(is_null($objeto_recebido->get_especialidade_produto()) ? "" : ", especialidade_produto = '".$objeto_recebido->get_especialidade_produto()."'")."
		".(is_null($objeto_recebido->get_classificacao_produto()) ? "" : ", classificacao_produto = '".$objeto_recebido->get_classificacao_produto()."'")."
		".(is_null($objeto_recebido->get_nome_tecnico()) ? "" : ", nome_tecnico = '".$objeto_recebido->get_nome_tecnico()."'")."
		".(is_null($objeto_recebido->get_unidmin_fracao()) ? "" : ", unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'")."
		".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")." 
		WHERE id = '".$objeto_recebido->get_id()."';";
		return $sql;
	}

	public function insert ($objeto_recebido, $database = null){
		$sql = $this->get_insert ($objeto_recebido);
		exec_query ($sql, false, $database);

		$id = -1;
		if ($query_result){ $id = $objeto_recebido->get_id(); }
		return $id;
	}

	public function unmodified ($objeto_recebido, $database = null){
		$dbh = $database;
		$result = false;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT COUNT(id) AS count FROM tb_material WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull (id)" : "id = '".$objeto_recebido->get_id()."'")." AND
		".(is_null($objeto_recebido->get_cnpj()) ? "isnull (cnpj)" : "cnpj = '".$objeto_recebido->get_cnpj()."'")." AND
		".(is_null($objeto_recebido->get_fabricante()) ? "isnull (fabricante)" : "fabricante = '".$objeto_recebido->get_fabricante()."'")." AND
		".(is_null($objeto_recebido->get_classe_risco()) ? "isnull (classe_risco)" : "classe_risco = '".$objeto_recebido->get_classe_risco()."'")." AND
		".(is_null($objeto_recebido->get_descricao_produto()) ? "isnull (descricao_produto)" : "descricao_produto = '".$objeto_recebido->get_descricao_produto()."'")." AND
		".(is_null($objeto_recebido->get_especialidade_produto()) ? "isnull (especialidade_produto)" : "especialidade_produto = '".$objeto_recebido->get_especialidade_produto()."'")." AND
		".(is_null($objeto_recebido->get_classificacao_produto()) ? "isnull (classificacao_produto)" : "classificacao_produto = '".$objeto_recebido->get_classificacao_produto()."'")." AND
		".(is_null($objeto_recebido->get_nome_tecnico()) ? "isnull (nome_tecnico)" : "nome_tecnico = '".$objeto_recebido->get_nome_tecnico()."'")." AND
		".(is_null($objeto_recebido->get_unidmin_fracao()) ? "isnull (unidmin_fracao)" : "unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'")." AND
		".(is_null($objeto_recebido->get_tipo_produto()) ? "isnull (tipo_produto)" : "tipo_produto = '".$objeto_recebido->get_tipo_produto()."'").";";
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

		$DAOMatTuss = new MatTuss_DAO();
		$DAOMatTnum = new MatTnum_DAO();
		$mattusss = $DAOMatTuss->select_by_Material($id, $dbh);
		$mattnums = $DAOMatTnum->select_by_Material($id, $dbh);
		foreach ($mattusss as $mattuss){ $DAOMatTuss->delete($mattuss->get_id(), $dbh); }
		foreach ($mattnums as $mattnum){ $DAOMatTnum->delete($mattnum->get_id(), $dbh); }

		$sql = "DELETE FROM tb_material WHERE id = '".$id."';";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Material();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["cnpj"])){ $new_object->set_cnpj($row["cnpj"]); }
		if (isset($row["fabricante"])){ $new_object->set_fabricante($row["fabricante"]); }
		if (isset($row["classe_risco"])){ $new_object->set_classe_risco($row["classe_risco"]); }
		if (isset($row["descricao_produto"])){ $new_object->set_descricao_produto($row["descricao_produto"]); }
		if (isset($row["especialidade_produto"])){ $new_object->set_especialidade_produto($row["especialidade_produto"]); }
		if (isset($row["classificacao_produto"])){ $new_object->set_classificacao_produto($row["classificacao_produto"]); }
		if (isset($row["nome_tecnico"])){ $new_object->set_nome_tecnico($row["nome_tecnico"]); }
		if (isset($row["unidmin_fracao"])){ $new_object->set_unidmin_fracao($row["unidmin_fracao"]); }
		if (isset($row["tipo_produto"])){ $new_object->set_tipo_produto($row["tipo_produto"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_material SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
				".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
				".(is_null($objeto_recebido->get_fabricante()) ? "" : ", fabricante = '".$objeto_recebido->get_fabricante()."'")."
				".(is_null($objeto_recebido->get_classe_risco()) ? "" : ", classe_risco = '".$objeto_recebido->get_classe_risco()."'")."
				".(is_null($objeto_recebido->get_descricao_produto()) ? "" : ", descricao_produto = '".$objeto_recebido->get_descricao_produto()."'")."
				".(is_null($objeto_recebido->get_especialidade_produto()) ? "" : ", especialidade_produto = '".$objeto_recebido->get_especialidade_produto()."'")."
				".(is_null($objeto_recebido->get_classificacao_produto()) ? "" : ", classificacao_produto = '".$objeto_recebido->get_classificacao_produto()."'")."
				".(is_null($objeto_recebido->get_nome_tecnico()) ? "" : ", nome_tecnico = '".$objeto_recebido->get_nome_tecnico()."'")."
				".(is_null($objeto_recebido->get_unidmin_fracao()) ? "" : ", unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'")."
				".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")." 
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_material WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_material";
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_material WHERE id = '".$id."';";

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
		$sql = "SELECT * FROM tb_material WHERE id = '".$id."';";

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
		if (is_null($fields)){ $sql .= "* FROM tb_material"; }
		else{ $sql .= $fields." FROM tb_material"; }
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

	public function extract_mats ($mattusss = null, $mattnums = null){
		$materiais = array ();

		if (!is_null($mattusss)){
			foreach ($mattusss as $mtuss){
				$hasMed = false;
				$mtuss->get_MATERIAL()->set_descricao_produto($mtuss->get_MATTAB()->get_id());
				if (in_array ($mtuss->get_MATERIAL(), $materiais)){ $hasMed = true; }
				if (!$hasMed){ array_push ($materiais, $mtuss->get_MATERIAL()); }
			}
		}

		if (!is_null($mattnums)){
			foreach ($mattnums as $mtnum){
				$hasMed = false;
				$mtnum->get_MATERIAL()->set_descricao_produto($mtnum->get_MATTAB()->get_id());
				if (in_array ($mtnum->get_MATERIAL(), $materiais)){ $hasMed = true; }
				if (!$hasMed){ array_push ($materiais, $mtnum->get_MATERIAL()); }
			}
		}

		return $materiais;
	}
}
?>