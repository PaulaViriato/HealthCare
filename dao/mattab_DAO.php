<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('mattuss_DAO.php');
require_once('mattnum_DAO.php');
require_once('tabela_DAO.php');
require_once('arquivo_DAO.php');
require_once($path.'/mattab.php');
require_once('operadora_DAO.php');

class MatTab_DAO {
	// Propriedades
	private $DAOOperadora;
	private $DAOMatTuss;
	private $DAOMatTnum;
	private $DAOTabela;
	private $DAOArquivo;

	// Construtor
	function __construct(){
		$this->DAOOperadora = new Operadora_DAO();
	}

	// Métodos
	public function insert ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "INSERT INTO tb_mattab (nome, deflator, id_operadora, id_mattab, data) VALUES (
		".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
		".(is_null($objeto_recebido->get_deflator()) ? "1" : $objeto_recebido->get_deflator()).", 
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "null" : $objeto_recebido->get_OPERADORA()->get_id()).", 
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "null" : $objeto_recebido->get_MATTAB()->get_id()).", 
		".(is_null($objeto_recebido->get_data()) ? "null" : "'".$objeto_recebido->get_data()."'").");";
		$query_result = $dbh->query ($sql);

		$id = -1;
		if ($query_result){
			$sql = "SELECT id FROM tb_mattab WHERE 
			".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
			".(is_null($objeto_recebido->get_deflator()) ? "deflator = 1" : "deflator = ".$objeto_recebido->get_deflator())." AND
			".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())." AND
			".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_data()) ? "isnull(data)" : "data = '".$objeto_recebido->get_data()."'")." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_mattab WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
		".(is_null($objeto_recebido->get_deflator()) ? "deflator = 1" : "deflator = ".$objeto_recebido->get_deflator())." AND
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())." AND
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "isnull(id_mattab)" : "id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_data()) ? "isnull(data)" : "data = '".$objeto_recebido->get_data()."'").";";
		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();
		if (intval($row["count"]) > 0){ $result = true; }

		if (is_null ($database)){ $dbh->close(); }
		return $result;
	}

	public function update ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "UPDATE tb_mattab SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_nome()) ? "" : "nome = '".$objeto_recebido->get_nome()."'")."
		".(is_null($objeto_recebido->get_deflator()) ? "" : ", deflator = ".$objeto_recebido->get_deflator())."
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
		".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
		".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
		WHERE id = ".$objeto_recebido->get_id().";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	public function delete ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "UPDATE tb_mattab SET id_mattab = null WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		$DAOMatTuss = new MatTuss_DAO();
		$DAOMatTnum = new MatTnum_DAO();
		$DAOTabela = new Tabela_DAO();
		$DAOArquivo = new Arquivo_DAO();
		$mattusss = $DAOMatTuss->select_by_MatTab($id, $dbh);
		$mattnums = $DAOMatTnum->select_by_MatTab($id, $dbh);
		$tabelas = $DAOTabela->select_by_MatTab($id, $dbh);
		$arquivos = $DAOArquivo->select_by_MatTab($id, $dbh);
		foreach ($mattusss as $mattuss){ $DAOMatTuss->delete($mattuss->get_id(), $dbh); }
		foreach ($mattnums as $mattnum){ $DAOMatTnum->delete($mattnum->get_id(), $dbh); }
		foreach ($tabelas as $tabela){ $DAOTabela->delete($tabela->get_id(), $dbh); }
		foreach ($arquivos as $arquivo){ $DAOArquivo->delete($arquivo->get_id(), $dbh); }

		$mattabs = $this->select_by_MatTab($id, $dbh);
		foreach ($mattabs as $mattab){ $this->delete($mattab->get_id(), $dbh); }

		$sql = "DELETE FROM tb_mattab WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_mattab SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_nome()) ? "" : "nome = '".$objeto_recebido->get_nome()."'")."
				".(is_null($objeto_recebido->get_deflator()) ? "" : ", deflator = ".$objeto_recebido->get_deflator())."
				".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
				".(is_null($objeto_recebido->get_MATTAB()->get_id()) ? "" : ", id_mattab = ".$objeto_recebido->get_MATTAB()->get_id())."
				".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_mattab WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_mattab";
				if (is_null($wherecl) == false){ $sql = $sql." WHERE ".$wherecl; }
				if (is_null($ordercl) == false){ $sql = $sql." ORDER BY ".$ordercl; }
				$sql = $sql.";";

				$result = $dbh->query($sql);
				$resreturn = array ();
				while($row = $result->fetch_assoc()){
					$new_object = new MatTab();
					if (isset($row["id"])){ $new_object->set_id($row["id"]); }
					if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
					if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
					if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
					if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->select_id($row["id_mattab"], $dbh)); }
					if (isset($row["data"])){ $new_object->set_data($row["data"]); }

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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_mattab WHERE id = ".$id.";";

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
		$sql = "SELECT * FROM tb_mattab WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = new MatTab();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
		if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
		if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
		if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->select_id($row["id_mattab"], $dbh)); }
		if (isset($row["data"])){ $new_object->set_data($row["data"]); }

		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_mattab;";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MatTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->select_id($row["id_mattab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_Operadora ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT * FROM tb_mattab WHERE ";
		if (!is_null($id)){ $sql .= "id_operadora = ".$id.";"; }
		else { $sql .= "isnull(id_operadora);"; }

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MatTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->select_id($row["id_mattab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MatTab ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_mattab WHERE id_mattab = ".$id.";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MatTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_mattab"])){ $new_object->set_MATTAB($this->select_id($row["id_mattab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>