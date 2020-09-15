<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/mattnum.php');
require_once('material_DAO.php');
require_once('mattab_DAO.php');

class MatTnum_DAO {
	// Propriedades
	private $DAOMaterial;
	private $DAOMatTab;

	// Construtor
	function __construct(){
		$this->DAOMaterial = new Material_DAO();
		$this->DAOMatTab = new MatTab_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_mattnum (id_material, id_mattab, nome, cod_tiss, nome_comercial, observaces, cod_anterior, 
			ref_tamanhomodelo, tipo_codificacao, inicio_vigencia, fim_vigencia, motivo_insercao, fim_implantacao, cod_simpro, 
			descricaoproduto_simpro, equivalencia_tecnica) VALUES (
			".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "null" : "'".$objeto_recebido->get_MATERIAL()->get_id()."'").", 
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
			".(is_null($objeto_recebido->get_cod_tiss()) ? "null" : $objeto_recebido->get_cod_tiss()).", 
			".(is_null($objeto_recebido->get_nome_comercial()) ? "null" : "'".$objeto_recebido->get_nome_comercial()."'").", 
			".(is_null($objeto_recebido->get_observaces()) ? "null" : "'".$objeto_recebido->get_observaces()."'").", 
			".(is_null($objeto_recebido->get_cod_anterior()) ? "null" : $objeto_recebido->get_cod_anterior()).", 
			".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "null" : "'".$objeto_recebido->get_ref_tamanhomodelo()."'").", 
			".(is_null($objeto_recebido->get_tipo_codificacao()) ? "null" : "'".$objeto_recebido->get_tipo_codificacao()."'").", 
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
			".(is_null($objeto_recebido->get_motivo_insercao()) ? "null" : "'".$objeto_recebido->get_motivo_insercao()."'").", 
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").", 
			".(is_null($objeto_recebido->get_cod_simpro()) ? "null" : $objeto_recebido->get_cod_simpro()).", 
			".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "null" : "'".$objeto_recebido->get_descricaoproduto_simpro()."'").", 
			".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "null" : "'".$objeto_recebido->get_equivalencia_tecnica()."'").");";
		} else {
			if ($intro == true){
				$sql .= "INSERT INTO tb_mattnum (id_material, id_mattab, nome, cod_tiss, nome_comercial, observaces, cod_anterior, 
				ref_tamanhomodelo, tipo_codificacao, inicio_vigencia, fim_vigencia, motivo_insercao, fim_implantacao, cod_simpro, 
				descricaoproduto_simpro, equivalencia_tecnica) VALUES ";
			}
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "null" : "'".$objeto_recebido->get_MATERIAL()->get_id()."'").", 
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
				".(is_null($objeto_recebido->get_cod_tiss()) ? "null" : $objeto_recebido->get_cod_tiss()).", 
				".(is_null($objeto_recebido->get_nome_comercial()) ? "null" : "'".$objeto_recebido->get_nome_comercial()."'").", 
				".(is_null($objeto_recebido->get_observaces()) ? "null" : "'".$objeto_recebido->get_observaces()."'").", 
				".(is_null($objeto_recebido->get_cod_anterior()) ? "null" : $objeto_recebido->get_cod_anterior()).", 
				".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "null" : "'".$objeto_recebido->get_ref_tamanhomodelo()."'").", 
				".(is_null($objeto_recebido->get_tipo_codificacao()) ? "null" : "'".$objeto_recebido->get_tipo_codificacao()."'").", 
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "null" : "'".$objeto_recebido->get_inicio_vigencia()."'").", 
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "null" : "'".$objeto_recebido->get_fim_vigencia()."'").", 
				".(is_null($objeto_recebido->get_motivo_insercao()) ? "null" : "'".$objeto_recebido->get_motivo_insercao()."'").", 
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "null" : "'".$objeto_recebido->get_fim_implantacao()."'").", 
				".(is_null($objeto_recebido->get_cod_simpro()) ? "null" : $objeto_recebido->get_cod_simpro()).", 
				".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "null" : "'".$objeto_recebido->get_descricaoproduto_simpro()."'").", 
				".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "null" : "'".$objeto_recebido->get_equivalencia_tecnica()."'").")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_mattnum SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "" : ", id_material = '".$objeto_recebido->get_MATERIAL()->get_id()."'")."
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
		".(is_null($objeto_recebido->get_nome()) ? "" : ", nome = '".$objeto_recebido->get_nome()."'")."
		".(is_null($objeto_recebido->get_cod_tiss()) ? "" : ", cod_tiss = ".$objeto_recebido->get_cod_tiss())."
		".(is_null($objeto_recebido->get_nome_comercial()) ? "" : ", nome_comercial = '".$objeto_recebido->get_nome_comercial()."'")."
		".(is_null($objeto_recebido->get_observaces()) ? "" : ", observaces = '".$objeto_recebido->get_observaces()."'")."
		".(is_null($objeto_recebido->get_cod_anterior()) ? "" : ", cod_anterior = ".$objeto_recebido->get_cod_anterior())."
		".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "" : ", ref_tamanhomodelo = '".$objeto_recebido->get_ref_tamanhomodelo()."'")."
		".(is_null($objeto_recebido->get_tipo_codificacao()) ? "" : ", tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")."
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
		".(is_null($objeto_recebido->get_motivo_insercao()) ? "" : ", motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")."
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
		".(is_null($objeto_recebido->get_cod_simpro()) ? "" : ", cod_simpro = ".$objeto_recebido->get_cod_simpro())."
		".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "" : ", descricaoproduto_simpro = '".$objeto_recebido->get_descricaoproduto_simpro()."'")."
		".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "" : ", equivalencia_tecnica = '".$objeto_recebido->get_equivalencia_tecnica()."'")." 
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
			$sql = "SELECT id FROM tb_mattnum WHERE 
			".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "isnull(id_material)" : "id_material = '".$objeto_recebido->get_MATERIAL()->get_id()."'")." AND
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
			".(is_null($objeto_recebido->get_cod_tiss()) ? "isnull(cod_tiss)" : "cod_tiss = ".$objeto_recebido->get_cod_tiss())." AND
			".(is_null($objeto_recebido->get_nome_comercial()) ? "isnull(nome_comercial)" : "nome_comercial = '".$objeto_recebido->get_nome_comercial()."'")." AND
			".(is_null($objeto_recebido->get_observaces()) ? "isnull(observaces)" : "observaces = '".$objeto_recebido->get_observaces()."'")." AND
			".(is_null($objeto_recebido->get_cod_anterior()) ? "isnull(cod_anterior)" : "cod_anterior = ".$objeto_recebido->get_cod_anterior())." AND
			".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "isnull(ref_tamanhomodelo)" : "ref_tamanhomodelo = '".$objeto_recebido->get_ref_tamanhomodelo()."'")." AND
			".(is_null($objeto_recebido->get_tipo_codificacao()) ? "isnull(tipo_codificacao)" : "tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")." AND
			".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
			".(is_null($objeto_recebido->get_motivo_insercao()) ? "isnull(motivo_insercao)" : "motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")." AND
			".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")." AND
			".(is_null($objeto_recebido->get_cod_simpro()) ? "isnull(cod_simpro)" : "cod_simpro = ".$objeto_recebido->get_cod_simpro())." AND
			".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "isnull(descricaoproduto_simpro)" : "descricaoproduto_simpro = '".$objeto_recebido->get_descricaoproduto_simpro()."'")." AND
			".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "isnull(equivalencia_tecnica)" : "equivalencia_tecnica = '".$objeto_recebido->get_equivalencia_tecnica()."'")." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_mattnum WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "isnull(id_material)" : "id_material = '".$objeto_recebido->get_MATERIAL()->get_id()."'")." AND
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
		".(is_null($objeto_recebido->get_cod_tiss()) ? "isnull(cod_tiss)" : "cod_tiss = ".$objeto_recebido->get_cod_tiss())." AND
		".(is_null($objeto_recebido->get_nome_comercial()) ? "isnull(nome_comercial)" : "nome_comercial = '".$objeto_recebido->get_nome_comercial()."'")." AND
		".(is_null($objeto_recebido->get_observaces()) ? "isnull(observaces)" : "observaces = '".$objeto_recebido->get_observaces()."'")." AND
		".(is_null($objeto_recebido->get_cod_anterior()) ? "isnull(cod_anterior)" : "cod_anterior = ".$objeto_recebido->get_cod_anterior())." AND
		".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "isnull(ref_tamanhomodelo)" : "ref_tamanhomodelo = '".$objeto_recebido->get_ref_tamanhomodelo()."'")." AND
		".(is_null($objeto_recebido->get_tipo_codificacao()) ? "isnull(tipo_codificacao)" : "tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")." AND
		".(is_null($objeto_recebido->get_inicio_vigencia()) ? "isnull(inicio_vigencia)" : "inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_fim_vigencia()) ? "isnull(fim_vigencia)" : "fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")." AND
		".(is_null($objeto_recebido->get_motivo_insercao()) ? "isnull(motivo_insercao)" : "motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")." AND
		".(is_null($objeto_recebido->get_fim_implantacao()) ? "isnull(fim_implantacao)" : "fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")." AND
		".(is_null($objeto_recebido->get_cod_simpro()) ? "isnull(cod_simpro)" : "cod_simpro = ".$objeto_recebido->get_cod_simpro())." AND
		".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "isnull(descricaoproduto_simpro)" : "descricaoproduto_simpro = '".$objeto_recebido->get_descricaoproduto_simpro()."'")." AND
		".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "isnull(equivalencia_tecnica)" : "equivalencia_tecnica = '".$objeto_recebido->get_equivalencia_tecnica()."'").";";
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
		$sql = "DELETE FROM tb_mattnum WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new MatTnum();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["id_material"])){ $new_object->set_MATERIAL($this->DAOMaterial->select_id($row["id_material"], $dbh)); }
		if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->DAOMatTab->select_id($row["id_mattab"], $dbh)); }
		if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
		if (isset($row["cod_tiss"])){ $new_object->set_cod_tiss($row["cod_tiss"]); }
		if (isset($row["nome_comercial"])){ $new_object->set_nome_comercial($row["nome_comercial"]); }
		if (isset($row["observaces"])){ $new_object->set_observaces($row["observaces"]); }
		if (isset($row["cod_anterior"])){ $new_object->set_cod_anterior($row["cod_anterior"]); }
		if (isset($row["ref_tamanhomodelo"])){ $new_object->set_ref_tamanhomodelo($row["ref_tamanhomodelo"]); }
		if (isset($row["tipo_codificacao"])){ $new_object->set_tipo_codificacao($row["tipo_codificacao"]); }
		if (isset($row["inicio_vigencia"])){ $new_object->set_inicio_vigencia($row["inicio_vigencia"]); }
		if (isset($row["fim_vigencia"])){ $new_object->set_fim_vigencia($row["fim_vigencia"]); }
		if (isset($row["motivo_insercao"])){ $new_object->set_motivo_insercao($row["motivo_insercao"]); }
		if (isset($row["fim_implantacao"])){ $new_object->set_fim_implantacao($row["fim_implantacao"]); }
		if (isset($row["cod_simpro"])){ $new_object->set_cod_simpro($row["cod_simpro"]); }
		if (isset($row["descricaoproduto_simpro"])){ $new_object->set_descricaoproduto_simpro($row["descricaoproduto_simpro"]); }
		if (isset($row["equivalencia_tecnica"])){ $new_object->set_equivalencia_tecnica($row["equivalencia_tecnica"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_mattnum SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "" : ", id_material = '".$objeto_recebido->get_MATERIAL()->get_id()."'")."
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
				".(is_null($objeto_recebido->get_nome()) ? "" : ", nome = '".$objeto_recebido->get_nome()."'")."
				".(is_null($objeto_recebido->get_cod_tiss()) ? "" : ", cod_tiss = ".$objeto_recebido->get_cod_tiss())."
				".(is_null($objeto_recebido->get_nome_comercial()) ? "" : ", nome_comercial = '".$objeto_recebido->get_nome_comercial()."'")."
				".(is_null($objeto_recebido->get_observaces()) ? "" : ", observaces = '".$objeto_recebido->get_observaces()."'")."
				".(is_null($objeto_recebido->get_cod_anterior()) ? "" : ", cod_anterior = ".$objeto_recebido->get_cod_anterior())."
				".(is_null($objeto_recebido->get_ref_tamanhomodelo()) ? "" : ", ref_tamanhomodelo = '".$objeto_recebido->get_ref_tamanhomodelo()."'")."
				".(is_null($objeto_recebido->get_tipo_codificacao()) ? "" : ", tipo_codificacao = '".$objeto_recebido->get_tipo_codificacao()."'")."
				".(is_null($objeto_recebido->get_inicio_vigencia()) ? "" : ", inicio_vigencia = '".$objeto_recebido->get_inicio_vigencia()."'")."
				".(is_null($objeto_recebido->get_fim_vigencia()) ? "" : ", fim_vigencia = '".$objeto_recebido->get_fim_vigencia()."'")."
				".(is_null($objeto_recebido->get_motivo_insercao()) ? "" : ", motivo_insercao = '".$objeto_recebido->get_motivo_insercao()."'")."
				".(is_null($objeto_recebido->get_fim_implantacao()) ? "" : ", fim_implantacao = '".$objeto_recebido->get_fim_implantacao()."'")."
				".(is_null($objeto_recebido->get_cod_simpro()) ? "" : ", cod_simpro = ".$objeto_recebido->get_cod_simpro())."
				".(is_null($objeto_recebido->get_descricaoproduto_simpro()) ? "" : ", descricaoproduto_simpro = '".$objeto_recebido->get_descricaoproduto_simpro()."'")."
				".(is_null($objeto_recebido->get_equivalencia_tecnica()) ? "" : ", equivalencia_tecnica = '".$objeto_recebido->get_equivalencia_tecnica()."'")." 
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_mattnum WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_mattnum";
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
		$sql = "SELECT id FROM tb_mattnum WHERE 
		".(is_null($objeto_recebido->get_MATERIAL()->get_id()) ? "isnull(id_material)" : "id_material = '".$objeto_recebido->get_MATERIAL()->get_id()."'")." AND 
		".(is_null($objeto_recebido->get_cod_tiss()) ? "isnull(cod_tiss)" : "cod_tiss = ".$objeto_recebido->get_cod_tiss())." AND 
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id()).";";

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
		$sql = "SELECT * FROM tb_mattnum WHERE id = ".$id.";";

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
		if (is_null($fields)){ $sql .= "* FROM tb_mattnum"; }
		else{ $sql .= $fields." FROM tb_mattnum"; }
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

	public function select_by_Material ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_mattnum WHERE id_material = '".$id."';";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MatTab ($id, $database = null, $wherecl = null, $fields = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$array_return = array ();
		$currtab = $this->DAOMatTab->select_id ($id, $dbh);
		if (!is_null($currtab->get_MATTAB())){
			$array_return = $this->select_by_MatTab ($currtab->get_MATTAB()->get_id(), $dbh, $wherecl);
		}

		$sql = "SELECT ";
		if (!is_null($fields)){ $sql .= $fields." "; }
		else{ $sql .= "tb_mattnum.* "; }
		$sql .= "FROM (tb_material JOIN tb_mattnum ON tb_mattnum.id_material = tb_material.id) 
		WHERE tb_mattnum.id_mattab = ".$id;
		if (!is_null($wherecl)){ $sql .= " AND (".$wherecl.")"; }
		$sql .= ";";

		$result = $dbh->query($sql);
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			$hasMat = false;

			for ($i = 0; $i < count($array_return); $i ++){
				if ((!is_null($array_return[$i]->get_cod_tiss()))&&(!is_null($new_object->get_cod_tiss()))){
					if (strcasecmp ("".$array_return[$i]->get_cod_tiss(), "".$new_object->get_cod_tiss()) == 0){
						if (!is_null($new_object->get_nome())){
							if (strcasecmp ("".$new_object->get_nome(), "!!!DELETEDITEM!!!") == 0){ unset ($array_return[$i]); }
							else { $array_return[$i] = $new_object; }
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
