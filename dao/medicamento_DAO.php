<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('cmed_DAO.php');
require_once('medtuss_DAO.php');
require_once('medtnum_DAO.php');
require_once($path.'/medicamento.php');

class Medicamento_DAO {
	// Propriedades
	private $DAOCMED;
	private $DAOMedTuss;
	private $DAOMedTnum;

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		$id = $objeto_recebido->get_id();
		if (!empty($id)){
			if ($whole == true){
				$sql .= "INSERT INTO tb_medicamento (id, substancia, cnpj, laboratorio, codggrem, produto, apresentacao, 
				classe_terapeutica, tipo_produto, tarja, cod_termo, generico, grupo_farmacologico, classe_farmacologica, 
				forma_farmaceutica, unidmin_fracao) VALUES (
				".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
				".(is_null($objeto_recebido->get_substancia()) ? "null" : "'".$objeto_recebido->get_substancia()."'").", 
				".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
				".(is_null($objeto_recebido->get_laboratorio()) ? "null" : "'".$objeto_recebido->get_laboratorio()."'").", 
				".(is_null($objeto_recebido->get_codggrem()) ? "null" : "'".$objeto_recebido->get_codggrem()."'").", 
				".(is_null($objeto_recebido->get_produto()) ? "null" : "'".$objeto_recebido->get_produto()."'").", 
				".(is_null($objeto_recebido->get_apresentacao()) ? "null" : "'".$objeto_recebido->get_apresentacao()."'").", 
				".(is_null($objeto_recebido->get_classe_terapeutica()) ? "null" : "'".$objeto_recebido->get_classe_terapeutica()."'").", 
				".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").", 
				".(is_null($objeto_recebido->get_tarja()) ? "null" : "'".$objeto_recebido->get_tarja()."'").", 
				".(is_null($objeto_recebido->get_cod_termo()) ? "null" : $objeto_recebido->get_cod_termo()).", 
				".(is_null($objeto_recebido->get_generico()) ? "null" : $objeto_recebido->get_generico()).", 
				".(is_null($objeto_recebido->get_grupo_farmacologico()) ? "null" : "'".$objeto_recebido->get_grupo_farmacologico()."'").", 
				".(is_null($objeto_recebido->get_classe_farmacologica()) ? "null" : "'".$objeto_recebido->get_classe_farmacologica()."'").", 
				".(is_null($objeto_recebido->get_forma_farmaceutica()) ? "null" : "'".$objeto_recebido->get_forma_farmaceutica()."'").", 
				".(is_null($objeto_recebido->get_unidmin_fracao()) ? "null" : "'".$objeto_recebido->get_unidmin_fracao()."'").");";
			} else {
				if ($intro == true){
					$sql .= "INSERT INTO tb_medicamento (id, substancia, cnpj, laboratorio, codggrem, produto, apresentacao, 
					classe_terapeutica, tipo_produto, tarja, cod_termo, generico, grupo_farmacologico, classe_farmacologica, 
					forma_farmaceutica, unidmin_fracao) VALUES ";
				}
				if ($instance == true){
					$sql .= "(".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
					".(is_null($objeto_recebido->get_substancia()) ? "null" : "'".$objeto_recebido->get_substancia()."'").", 
					".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
					".(is_null($objeto_recebido->get_laboratorio()) ? "null" : "'".$objeto_recebido->get_laboratorio()."'").", 
					".(is_null($objeto_recebido->get_codggrem()) ? "null" : "'".$objeto_recebido->get_codggrem()."'").", 
					".(is_null($objeto_recebido->get_produto()) ? "null" : "'".$objeto_recebido->get_produto()."'").", 
					".(is_null($objeto_recebido->get_apresentacao()) ? "null" : "'".$objeto_recebido->get_apresentacao()."'").", 
					".(is_null($objeto_recebido->get_classe_terapeutica()) ? "null" : "'".$objeto_recebido->get_classe_terapeutica()."'").", 
					".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").", 
					".(is_null($objeto_recebido->get_tarja()) ? "null" : "'".$objeto_recebido->get_tarja()."'").", 
					".(is_null($objeto_recebido->get_cod_termo()) ? "null" : $objeto_recebido->get_cod_termo()).", 
					".(is_null($objeto_recebido->get_generico()) ? "null" : $objeto_recebido->get_generico()).", 
					".(is_null($objeto_recebido->get_grupo_farmacologico()) ? "null" : "'".$objeto_recebido->get_grupo_farmacologico()."'").", 
					".(is_null($objeto_recebido->get_classe_farmacologica()) ? "null" : "'".$objeto_recebido->get_classe_farmacologica()."'").", 
					".(is_null($objeto_recebido->get_forma_farmaceutica()) ? "null" : "'".$objeto_recebido->get_forma_farmaceutica()."'").", 
					".(is_null($objeto_recebido->get_unidmin_fracao()) ? "null" : "'".$objeto_recebido->get_unidmin_fracao()."'").")";
				}
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "";
		$id = $objeto_recebido->get_id();
		if (!empty($id)){
			$sql = "UPDATE tb_medicamento SET 
			".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
			".(is_null($objeto_recebido->get_substancia()) ? "" : ", substancia = '".$objeto_recebido->get_substancia()."'")."
			".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
			".(is_null($objeto_recebido->get_laboratorio()) ? "" : ", laboratorio = '".$objeto_recebido->get_laboratorio()."'")."
			".(is_null($objeto_recebido->get_codggrem()) ? "" : ", codggrem = '".$objeto_recebido->get_codggrem()."'")."
			".(is_null($objeto_recebido->get_produto()) ? "" : ", produto = '".$objeto_recebido->get_produto()."'")."
			".(is_null($objeto_recebido->get_apresentacao()) ? "" : ", apresentacao = '".$objeto_recebido->get_apresentacao()."'")."
			".(is_null($objeto_recebido->get_classe_terapeutica()) ? "" : ", classe_terapeutica = '".$objeto_recebido->get_classe_terapeutica()."'")."
			".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")."
			".(is_null($objeto_recebido->get_tarja()) ? "" : ", tarja = '".$objeto_recebido->get_tarja()."'")."
			".(is_null($objeto_recebido->get_cod_termo()) ? "" : ", cod_termo = ".$objeto_recebido->get_cod_termo())."
			".(is_null($objeto_recebido->get_generico()) ? "" : ", generico = ".$objeto_recebido->get_generico())."
			".(is_null($objeto_recebido->get_grupo_farmacologico()) ? "" : ", grupo_farmacologico = '".$objeto_recebido->get_grupo_farmacologico()."'")."
			".(is_null($objeto_recebido->get_classe_farmacologica()) ? "" : ", classe_farmacologica = '".$objeto_recebido->get_classe_farmacologica()."'")."
			".(is_null($objeto_recebido->get_forma_farmaceutica()) ? "" : ", forma_farmaceutica = '".$objeto_recebido->get_forma_farmaceutica()."'")."
			".(is_null($objeto_recebido->get_unidmin_fracao()) ? "" : ", unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'")." 
			WHERE id = '".$objeto_recebido->get_id()."';";
			$sql = str_replace (" ,", "", $sql);
			$sql = str_replace (",  WHERE ", " WHERE ", $sql);
		}
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

		$sql = "SELECT COUNT(id) AS count FROM tb_medicamento WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull (id)" : "id = '".$objeto_recebido->get_id()."'")." AND
		".(is_null($objeto_recebido->get_substancia()) ? "isnull (substancia)" : "substancia = '".$objeto_recebido->get_substancia()."'")." AND
		".(is_null($objeto_recebido->get_cnpj()) ? "isnull (cnpj)" : "cnpj = '".$objeto_recebido->get_cnpj()."'")." AND
		".(is_null($objeto_recebido->get_laboratorio()) ? "isnull (laboratorio)" : "laboratorio = '".$objeto_recebido->get_laboratorio()."'")." AND
		".(is_null($objeto_recebido->get_codggrem()) ? "isnull (codggrem)" : "codggrem = '".$objeto_recebido->get_codggrem()."'")." AND
		".(is_null($objeto_recebido->get_produto()) ? "isnull (produto)" : "produto = '".$objeto_recebido->get_produto()."'")." AND
		".(is_null($objeto_recebido->get_apresentacao()) ? "isnull (apresentacao)" : "apresentacao = '".$objeto_recebido->get_apresentacao()."'")." AND
		".(is_null($objeto_recebido->get_classe_terapeutica()) ? "isnull (classe_terapeutica)" : "classe_terapeutica = '".$objeto_recebido->get_classe_terapeutica()."'")." AND
		".(is_null($objeto_recebido->get_tipo_produto()) ? "isnull (tipo_produto)" : "tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")." AND
		".(is_null($objeto_recebido->get_tarja()) ? "isnull (tarja)" : "tarja = '".$objeto_recebido->get_tarja()."'")." AND
		".(is_null($objeto_recebido->get_cod_termo()) ? "isnull (cod_termo)" : "cod_termo = ".$objeto_recebido->get_cod_termo())." AND
		".(is_null($objeto_recebido->get_generico()) ? "isnull (generico)" : "generico = ".$objeto_recebido->get_generico())." AND
		".(is_null($objeto_recebido->get_grupo_farmacologico()) ? "isnull (grupo_farmacologico)" : "grupo_farmacologico = '".$objeto_recebido->get_grupo_farmacologico()."'")." AND
		".(is_null($objeto_recebido->get_classe_farmacologica()) ? "isnull (classe_farmacologica)" : "classe_farmacologica = '".$objeto_recebido->get_classe_farmacologica()."'")." AND
		".(is_null($objeto_recebido->get_forma_farmaceutica()) ? "isnull (forma_farmaceutica)" : "forma_farmaceutica = '".$objeto_recebido->get_forma_farmaceutica()."'")." AND
		".(is_null($objeto_recebido->get_unidmin_fracao()) ? "isnull (unidmin_fracao)" : "unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'").";";
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

		$DAOCMED = new CMED_DAO();
		$DAOMedTuss = new MedTuss_DAO();
		$DAOMedTnum = new MedTnum_DAO();
		$cmeds = $DAOCMED->select_by_Medicamento($id, $dbh);
		$medtusss = $DAOMedTuss->select_by_Medicamento($id, $dbh);
		$medtnums = $DAOMedTnum->select_by_Medicamento($id, $dbh);
		foreach ($cmeds as $cmed){ $DAOCMED->delete($cmed->get_id(), $dbh); }
		foreach ($medtusss as $medtuss){ $DAOMedTuss->delete($medtuss->get_id(), $dbh); }
		foreach ($medtnums as $medtnum){ $DAOMedTnum->delete($medtnum->get_id(), $dbh); }

		$sql = "DELETE FROM tb_medicamento WHERE id = '".$id."';";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh->close(); }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Medicamento();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["substancia"])){ $new_object->set_substancia($row["substancia"]); }
		if (isset($row["cnpj"])){ $new_object->set_cnpj($row["cnpj"]); }
		if (isset($row["laboratorio"])){ $new_object->set_laboratorio($row["laboratorio"]); }
		if (isset($row["codggrem"])){ $new_object->set_codggrem($row["codggrem"]); }
		if (isset($row["produto"])){ $new_object->set_produto($row["produto"]); }
		if (isset($row["apresentacao"])){ $new_object->set_apresentacao($row["apresentacao"]); }
		if (isset($row["classe_terapeutica"])){ $new_object->set_classe_terapeutica($row["classe_terapeutica"]); }
		if (isset($row["tipo_produto"])){ $new_object->set_tipo_produto($row["tipo_produto"]); }
		if (isset($row["tarja"])){ $new_object->set_tarja($row["tarja"]); }
		if (isset($row["cod_termo"])){ $new_object->set_cod_termo($row["cod_termo"]); }
		if (isset($row["generico"])){ $new_object->set_generico($row["generico"]); }
		if (isset($row["grupo_farmacologico"])){ $new_object->set_grupo_farmacologico($row["grupo_farmacologico"]); }
		if (isset($row["classe_farmacologica"])){ $new_object->set_classe_farmacologica($row["classe_farmacologica"]); }
		if (isset($row["forma_farmaceutica"])){ $new_object->set_forma_farmaceutica($row["forma_farmaceutica"]); }
		if (isset($row["unidmin_fracao"])){ $new_object->set_unidmin_fracao($row["unidmin_fracao"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "";
				$id = $objeto_recebido->get_id();
				if (!empty($id)){
					$sql = "UPDATE tb_medicamento SET 
					".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
					".(is_null($objeto_recebido->get_substancia()) ? "" : ", substancia = '".$objeto_recebido->get_substancia()."'")."
					".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
					".(is_null($objeto_recebido->get_laboratorio()) ? "" : ", laboratorio = '".$objeto_recebido->get_laboratorio()."'")."
					".(is_null($objeto_recebido->get_codggrem()) ? "" : ", codggrem = '".$objeto_recebido->get_codggrem()."'")."
					".(is_null($objeto_recebido->get_produto()) ? "" : ", produto = '".$objeto_recebido->get_produto()."'")."
					".(is_null($objeto_recebido->get_apresentacao()) ? "" : ", apresentacao = '".$objeto_recebido->get_apresentacao()."'")."
					".(is_null($objeto_recebido->get_classe_terapeutica()) ? "" : ", classe_terapeutica = '".$objeto_recebido->get_classe_terapeutica()."'")."
					".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")."
					".(is_null($objeto_recebido->get_tarja()) ? "" : ", tarja = '".$objeto_recebido->get_tarja()."'")."
					".(is_null($objeto_recebido->get_cod_termo()) ? "" : ", cod_termo = ".$objeto_recebido->get_cod_termo())."
					".(is_null($objeto_recebido->get_generico()) ? "" : ", generico = ".$objeto_recebido->get_generico())."
					".(is_null($objeto_recebido->get_grupo_farmacologico()) ? "" : ", grupo_farmacologico = '".$objeto_recebido->get_grupo_farmacologico()."'")."
					".(is_null($objeto_recebido->get_classe_farmacologica()) ? "" : ", classe_farmacologica = '".$objeto_recebido->get_classe_farmacologica()."'")."
					".(is_null($objeto_recebido->get_forma_farmaceutica()) ? "" : ", forma_farmaceutica = '".$objeto_recebido->get_forma_farmaceutica()."'")."
					".(is_null($objeto_recebido->get_unidmin_fracao()) ? "" : ", unidmin_fracao = '".$objeto_recebido->get_unidmin_fracao()."'")." 
					WHERE ".$wherecl.";";
					$sql = str_replace (" ,", "", $sql);
					$sql = str_replace (",  WHERE ", " WHERE ", $sql);
				}
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_medicamento WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_medicamento";
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

		if (is_null ($database)){ $dbh->close(); }
		return $resreturn;
	}

	public function exist_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(id) AS qtd FROM tb_medicamento WHERE id = '".$id."';";

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
		$sql = "SELECT * FROM tb_medicamento WHERE id = '".$id."';";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh->close(); }
		return $new_object;
	}

	public function select_all ($database = null, $fields = null, $wherecl = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT ";
		if (is_null($fields)){ $sql .= "* FROM tb_medicamento"; }
		else{ $sql .= $fields." FROM tb_medicamento"; }
		if (!is_null($wherecl)){ $sql .= " WHERE ".$wherecl; }
		$sql .= ";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}

	public function extract_meds ($cmeds = null, $medtusss = null, $medtnums = null){
		$medicamentos = array ();

		if (!is_null($medtusss)){
			foreach ($medtusss as $mtuss){
				$hasMed = false;
				$mtuss->get_MEDICAMENTO()->set_codggrem($mtuss->get_MEDTAB()->get_id());
				$mtuss->get_MEDICAMENTO()->set_tarja(null);
				if (in_array ($mtuss->get_MEDICAMENTO(), $medicamentos)){ $hasMed = true; }
				if (!$hasMed){ array_push ($medicamentos, $mtuss->get_MEDICAMENTO()); }
			}
		}

		if (!is_null($medtnums)){
			foreach ($medtnums as $mtnum){
				$hasMed = false;
				$mtnum->get_MEDICAMENTO()->set_codggrem($mtnum->get_MEDTAB()->get_id());
				$mtnum->get_MEDICAMENTO()->set_tarja(null);
				if (in_array ($mtnum->get_MEDICAMENTO(), $medicamentos)){ $hasMed = true; }
				if (!$hasMed){ array_push ($medicamentos, $mtnum->get_MEDICAMENTO()); }
			}
		}

		if (!is_null($cmeds)){
			foreach ($cmeds as $cmed){
				$hasMed = false;
				$cmed->get_MEDICAMENTO()->set_codggrem($cmed->get_MEDTAB()->get_id());
				$cmed->get_MEDICAMENTO()->set_tarja(null);
				if (in_array ($cmed->get_MEDICAMENTO(), $medicamentos)){ $hasMed = true; }
				if (!$hasMed){ array_push ($medicamentos, $cmed->get_MEDICAMENTO()); }
			}

			foreach ($cmeds as $cmed){
				foreach ($medicamentos as $medicamento){
					if (strcasecmp($cmed->get_MEDICAMENTO()->get_id(), $medicamento->get_id()) == 0){
						$medicamento->set_tarja ("".$cmed->get_pf_semimpostos());
					}
				}
			}
		}

		return $medicamentos;
	}
}
?>