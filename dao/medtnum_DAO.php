<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/medtnum.php');
require_once('medicamento_DAO.php');
require_once('medtab_DAO.php');

class MedTnum_DAO {
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
			$sql .= "INSERT INTO tb_medtnum (id_medicamento, id_medtab, cod_tiss, observacoes, cod_anterior, tipo_produto, 
			tipo_codificacao, inicio_vigencia, fim_vigencia, motivo_insercao, fim_implantacao, cod_tissbrasindice, 
			descricao_brasindice, apresentacao_brasindice, pertence_confaz) VALUES (
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_cod_tiss()) ? "null" : $objeto_recebido->get_cod_tiss()).", 
			".(is_null($objeto_recebido->get_observacoes()) ? "null" : "'".$objeto_recebido->get_observacoes()."'").", 
			".(is_null($objeto_recebido->get_cod_anterior()) ? "null" : $objeto_recebido->get_cod_anterior()).", 
			".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").", 
			".(is_null($objeto_recebido->get_tipo_codificacao()) ? "null" : "'".$objeto_recebido->get_tipo_codificacao()."'").", 
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
			".(is_null($objeto_recebido->get_motivo_insercao()) ? "null" : "'".$objeto_recebido->get_motivo_insercao()."'").", 
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").", 
			".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "null" : $objeto_recebido->get_cod_tissbrasindice()).", 
			".(is_null($objeto_recebido->get_descricao_brasindice()) ? "null" : "'".$objeto_recebido->get_descricao_brasindice()."'").", 
			".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "null" : "'".$objeto_recebido->get_apresentacao_brasindice()."'").", 
			".(is_null($objeto_recebido->get_pertence_confaz()) ? "null" : $objeto_recebido->get_pertence_confaz()).");";
		} else {
			if ($intro == true){
				$sql .= "INSERT INTO tb_medtnum (id_medicamento, id_medtab, cod_tiss, observacoes, cod_anterior, tipo_produto, 
				tipo_codificacao, inicio_vigencia, fim_vigencia, motivo_insercao, fim_implantacao, cod_tissbrasindice, 
				descricao_brasindice, apresentacao_brasindice, pertence_confaz) VALUES ";
			}
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_cod_tiss()) ? "null" : $objeto_recebido->get_cod_tiss()).", 
				".(is_null($objeto_recebido->get_observacoes()) ? "null" : "'".$objeto_recebido->get_observacoes()."'").", 
				".(is_null($objeto_recebido->get_cod_anterior()) ? "null" : $objeto_recebido->get_cod_anterior()).", 
				".(is_null($objeto_recebido->get_tipo_produto()) ? "null" : "'".$objeto_recebido->get_tipo_produto()."'").", 
				".(is_null($objeto_recebido->get_tipo_codificacao()) ? "null" : "'".$objeto_recebido->get_tipo_codificacao()."'").", 
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
				".(is_null($objeto_recebido->get_motivo_insercao()) ? "null" : "'".$objeto_recebido->get_motivo_insercao()."'").", 
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").", 
				".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "null" : $objeto_recebido->get_cod_tissbrasindice()).", 
				".(is_null($objeto_recebido->get_descricao_brasindice()) ? "null" : "'".$objeto_recebido->get_descricao_brasindice()."'").", 
				".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "null" : "'".$objeto_recebido->get_apresentacao_brasindice()."'").", 
				".(is_null($objeto_recebido->get_pertence_confaz()) ? "null" : $objeto_recebido->get_pertence_confaz()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_medtnum SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_cod_tiss()) ? "" : ", cod_tiss = ".$objeto_recebido->get_cod_tiss())."
		".(is_null($objeto_recebido->get_observacoes()) ? "" : ", observacoes = '".$objeto_recebido->get_observacoes()."'")."
		".(is_null($objeto_recebido->get_cod_anterior()) ? "" : ", cod_anterior = ".$objeto_recebido->get_cod_anterior())."
		".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")."
		".(is_null($objeto_recebido->get_tipo_codificacao()) ? "" : ", tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")."
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
		".(is_null($objeto_recebido->get_motivo_insercao()) ? "" : ", motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")."
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
		".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "" : ", cod_tissbrasindice = ".$objeto_recebido->get_cod_tissbrasindice())."
		".(is_null($objeto_recebido->get_descricao_brasindice()) ? "" : ", descricao_brasindice = '".$objeto_recebido->get_descricao_brasindice()."'")."
		".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "" : ", apresentacao_brasindice = '".$objeto_recebido->get_apresentacao_brasindice()."'")."
		".(is_null($objeto_recebido->get_pertence_confaz()) ? "" : ", pertence_confaz = ".$objeto_recebido->get_pertence_confaz())."
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
			$sql = "SELECT id FROM tb_medtnum WHERE 
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_cod_tiss()) ? "isnull(cod_tiss)" : "cod_tiss = ".$objeto_recebido->get_cod_tiss())." AND
			".(is_null($objeto_recebido->get_observacoes()) ? "isnull(observacoes)" : "observacoes = '".$objeto_recebido->get_observacoes()."'")." AND
			".(is_null($objeto_recebido->get_cod_anterior()) ? "isnull(cod_anterior)" : "cod_anterior = ".$objeto_recebido->get_cod_anterior())." AND
			".(is_null($objeto_recebido->get_tipo_produto()) ? "isnull(tipo_produto)" : "tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")." AND
			".(is_null($objeto_recebido->get_tipo_codificacao()) ? "isnull(tipo_codificacao)" : "tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")." AND
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_motivo_insercao()) ? "isnull(motivo_insercao)" : "motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")." AND
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")." AND
			".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "isnull(cod_tissbrasindice)" : "cod_tissbrasindice = ".$objeto_recebido->get_cod_tissbrasindice())." AND
			".(is_null($objeto_recebido->get_descricao_brasindice()) ? "isnull(descricao_brasindice)" : "descricao_brasindice = '".$objeto_recebido->get_descricao_brasindice()."'")." AND
			".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "isnull(apresentacao_brasindice)" : "apresentacao_brasindice = '".$objeto_recebido->get_apresentacao_brasindice()."'")." AND
			".(is_null($objeto_recebido->get_pertence_confaz()) ? "isnull(pertence_confaz)" : "pertence_confaz = ".$objeto_recebido->get_pertence_confaz())." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_medtnum WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_cod_tiss()) ? "isnull(cod_tiss)" : "cod_tiss = ".$objeto_recebido->get_cod_tiss())." AND
		".(is_null($objeto_recebido->get_observacoes()) ? "isnull(observacoes)" : "observacoes = '".$objeto_recebido->get_observacoes()."'")." AND
		".(is_null($objeto_recebido->get_cod_anterior()) ? "isnull(cod_anterior)" : "cod_anterior = ".$objeto_recebido->get_cod_anterior())." AND
		".(is_null($objeto_recebido->get_tipo_produto()) ? "isnull(tipo_produto)" : "tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")." AND
		".(is_null($objeto_recebido->get_tipo_codificacao()) ? "isnull(tipo_codificacao)" : "tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")." AND
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_motivo_insercao()) ? "isnull(motivo_insercao)" : "motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")." AND
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")." AND
		".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "isnull(cod_tissbrasindice)" : "cod_tissbrasindice = ".$objeto_recebido->get_cod_tissbrasindice())." AND
		".(is_null($objeto_recebido->get_descricao_brasindice()) ? "isnull(descricao_brasindice)" : "descricao_brasindice = '".$objeto_recebido->get_descricao_brasindice()."'")." AND
		".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "isnull(apresentacao_brasindice)" : "apresentacao_brasindice = '".$objeto_recebido->get_apresentacao_brasindice()."'")." AND
		".(is_null($objeto_recebido->get_pertence_confaz()) ? "isnull(pertence_confaz)" : "pertence_confaz = ".$objeto_recebido->get_pertence_confaz()).";";
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
		$sql = "DELETE FROM tb_medtnum WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new MedTnum();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["id_medicamento"])){ $new_object->set_MEDICAMENTO($this->DAOMedicamento->select_id($row["id_medicamento"], $dbh)); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->DAOMedTab->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["cod_tiss"])){ $new_object->set_cod_tiss($row["cod_tiss"]); }
		if (isset($row["observacoes"])){ $new_object->set_observacoes($row["observacoes"]); }
		if (isset($row["cod_anterior"])){ $new_object->set_cod_anterior($row["cod_anterior"]); }
		if (isset($row["tipo_produto"])){ $new_object->set_tipo_produto($row["tipo_produto"]); }
		if (isset($row["tipo_codificacao"])){ $new_object->set_tipo_codificacao($row["tipo_codificacao"]); }
		if (isset($row["inicio_vigencia"])){ $new_object->set_inicio_vigencia($row["inicio_vigencia"]); }
		if (isset($row["fim_vigencia"])){ $new_object->set_fim_vigencia($row["fim_vigencia"]); }
		if (isset($row["motivo_insercao"])){ $new_object->set_motivo_insercao($row["motivo_insercao"]); }
		if (isset($row["fim_implantacao"])){ $new_object->set_fim_implantacao($row["fim_implantacao"]); }
		if (isset($row["cod_tissbrasindice"])){ $new_object->set_cod_tissbrasindice($row["cod_tissbrasindice"]); }
		if (isset($row["descricao_brasindice"])){ $new_object->set_descricao_brasindice($row["descricao_brasindice"]); }
		if (isset($row["apresentacao_brasindice"])){ $new_object->set_apresentacao_brasindice($row["apresentacao_brasindice"]); }
		if (isset($row["pertence_confaz"])){ $new_object->set_pertence_confaz($row["pertence_confaz"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_medtnum SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_cod_tiss()) ? "" : ", cod_tiss = ".$objeto_recebido->get_cod_tiss())."
				".(is_null($objeto_recebido->get_observacoes()) ? "" : ", observacoes = '".$objeto_recebido->get_observacoes()."'")."
				".(is_null($objeto_recebido->get_cod_anterior()) ? "" : ", cod_anterior = ".$objeto_recebido->get_cod_anterior())."
				".(is_null($objeto_recebido->get_tipo_produto()) ? "" : ", tipo_produto = '".$objeto_recebido->get_tipo_produto()."'")."
				".(is_null($objeto_recebido->get_tipo_codificacao()) ? "" : ", tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")."
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
				".(is_null($objeto_recebido->get_motivo_insercao()) ? "" : ", motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")."
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
				".(is_null($objeto_recebido->get_cod_tissbrasindice()) ? "" : ", cod_tissbrasindice = ".$objeto_recebido->get_cod_tissbrasindice())."
				".(is_null($objeto_recebido->get_descricao_brasindice()) ? "" : ", descricao_brasindice = '".$objeto_recebido->get_descricao_brasindice()."'")."
				".(is_null($objeto_recebido->get_apresentacao_brasindice()) ? "" : ", apresentacao_brasindice = '".$objeto_recebido->get_apresentacao_brasindice()."'")."
				".(is_null($objeto_recebido->get_pertence_confaz()) ? "" : ", pertence_confaz = ".$objeto_recebido->get_pertence_confaz())."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_medtnum WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_medtnum";
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
		$sql = "SELECT id FROM tb_medtnum WHERE 
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
		$sql = "SELECT * FROM tb_medtnum WHERE id = ".$id.";";

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
		if (is_null($fields)){ $sql .= "* FROM tb_medtnum"; }
		else{ $sql .= $fields." FROM tb_medtnum"; }
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
		$sql = "SELECT * FROM tb_medtnum WHERE id_medicamento = '".$id."';";

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
		else{ $sql .= "tb_medtnum.* "; }
		$sql .= "FROM (tb_medicamento JOIN tb_medtnum ON tb_medtnum.id_medicamento = tb_medicamento.id) 
		WHERE tb_medtnum.id_medtab = ".$id;
		if (!is_null($wherecl)){ $sql .= " AND ".$wherecl; }
		$sql .= ";";

		$result = $dbh->query($sql);
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			$hasMat = false;

			for ($i = 0; $i < count($array_return); $i ++){
				if ((!is_null($array_return[$i]->get_cod_tiss()))&&(!is_null($new_object->get_cod_tiss()))){
					if (strcasecmp ("".$array_return[$i]->get_cod_tiss(), "".$new_object->get_cod_tiss()) == 0){
						if (!is_null($new_object->get_observacoes())){
							if (strcasecmp ("".$new_object->get_observacoes(), "!!!DELETEDITEM!!!") == 0){
								unset ($array_return[$i]);
							} else { $array_return[$i] = $new_object; }
						} else { $array_return[$i] = $new_object; }

						$hasMat = true;
						$i = count($array_return) + 1;
					}
				}
			}

			if (!$hasMat){ array_push ($array_return, $new_object); }
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>