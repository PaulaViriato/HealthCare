<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('cmed_DAO.php');
require_once('medtuss_DAO.php');
require_once('medtnum_DAO.php');
require_once('tabela_DAO.php');
require_once('arquivo_DAO.php');
require_once($path.'/medtab.php');
require_once('operadora_DAO.php');

class MedTab_DAO {
	// Propriedades
	private $DAOOperadora;
	private $DAOCMED;
	private $DAOMedTuss;
	private $DAOMedTnum;
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
		$sql = "INSERT INTO tb_medtab (nome, deflator, pf_alicota, pmc_alicota, pmvg_alicota, id_operadora, id_medtab, data) VALUES (
		".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
		".(is_null($objeto_recebido->get_deflator()) ? "1" : $objeto_recebido->get_deflator()).", 
		".(is_null($objeto_recebido->get_pf_alicota()) ? "null" : $objeto_recebido->get_pf_alicota()).", 
		".(is_null($objeto_recebido->get_pmc_alicota()) ? "null" : $objeto_recebido->get_pmc_alicota()).", 
		".(is_null($objeto_recebido->get_pmvg_alicota()) ? "null" : $objeto_recebido->get_pmvg_alicota()).", 
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "null" : $objeto_recebido->get_OPERADORA()->get_id()).", 
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
		".(is_null($objeto_recebido->get_data()) ? "null" : "'".$objeto_recebido->get_data()."'").");";
		$query_result = $dbh->query ($sql);

		$id = -1;
		if ($query_result){
			$sql = "SELECT id FROM tb_medtab WHERE 
			".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
			".(is_null($objeto_recebido->get_deflator()) ? "deflator = 1" : "deflator = ".$objeto_recebido->get_deflator())." AND
			".(is_null($objeto_recebido->get_pf_alicota()) ? "isnull(pf_alicota)" : "pf_alicota = ".$objeto_recebido->get_pf_alicota())." AND
			".(is_null($objeto_recebido->get_pmc_alicota()) ? "isnull(pmc_alicota)" : "pmc_alicota = ".$objeto_recebido->get_pmc_alicota())." AND
			".(is_null($objeto_recebido->get_pmvg_alicota()) ? "isnull(pmvg_alicota)" : "pmvg_alicota = ".$objeto_recebido->get_pmvg_alicota())." AND
			".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
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

		$sql = "SELECT COUNT(id) AS count FROM tb_medtab WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
		".(is_null($objeto_recebido->get_deflator()) ? "deflator = 1" : "deflator = ".$objeto_recebido->get_deflator())." AND
		".(is_null($objeto_recebido->get_pf_alicota()) ? "isnull(pf_alicota)" : "pf_alicota = ".$objeto_recebido->get_pf_alicota())." AND
		".(is_null($objeto_recebido->get_pmc_alicota()) ? "isnull(pmc_alicota)" : "pmc_alicota = ".$objeto_recebido->get_pmc_alicota())." AND
		".(is_null($objeto_recebido->get_pmvg_alicota()) ? "isnull(pmvg_alicota)" : "pmvg_alicota = ".$objeto_recebido->get_pmvg_alicota())." AND
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "isnull(id_operadora)" : "id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
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
		$sql = "UPDATE tb_medtab SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_nome()) ? "" : "nome = '".$objeto_recebido->get_nome()."'")."
		".(is_null($objeto_recebido->get_deflator()) ? "" : ", deflator = ".$objeto_recebido->get_deflator())."
		".(is_null($objeto_recebido->get_pf_alicota()) ? "" : ", pf_alicota = ".$objeto_recebido->get_pf_alicota())."
		".(is_null($objeto_recebido->get_pmc_alicota()) ? "" : ", pmc_alicota = ".$objeto_recebido->get_pmc_alicota())."
		".(is_null($objeto_recebido->get_pmvg_alicota()) ? "" : ", pmvg_alicota = ".$objeto_recebido->get_pmvg_alicota())."
		".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
		WHERE id = ".$objeto_recebido->get_id().";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	public function delete ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "UPDATE tb_medtab SET id_medtab = null WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		$DAOCMED = new CMED_DAO();
		$DAOMedTuss = new MedTuss_DAO();
		$DAOMedTnum = new MedTnum_DAO();
		$DAOTabela = new Tabela_DAO();
		$DAOArquivo = new Arquivo_DAO();

		$cmeds = $DAOCMED->select_by_MedTab($id, $dbh);
		$medtusss = $DAOMedTuss->select_by_MedTab($id, $dbh);
		$medtnums = $DAOMedTnum->select_by_MedTab($id, $dbh);
		$tabelas = $DAOTabela->select_by_MedTab($id, $dbh);
		$arquivos = $DAOArquivo->select_by_MedTab($id, $dbh);

		foreach ($cmeds as $cmed){ $DAOCMED->delete($cmed->get_id(), $dbh); }
		foreach ($medtusss as $medtuss){ $DAOMedTuss->delete($medtuss->get_id(), $dbh); }
		foreach ($medtnums as $medtnum){ $DAOMedTnum->delete($medtnum->get_id(), $dbh); }
		foreach ($tabelas as $tabela){ $DAOTabela->delete($tabela->get_id(), $dbh); }
		foreach ($arquivos as $arquivo){ $DAOArquivo->delete($arquivo->get_id(), $dbh); }

		$medtabs = $this->select_by_MedTab($id, $dbh);
		foreach ($medtabs as $medtab){ $this->delete($id, $dbh); }

		$sql = "DELETE FROM tb_medtab WHERE id = ".$id.";";
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
				$sql = "UPDATE tb_medtab SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_nome()) ? "" : "nome = '".$objeto_recebido->get_nome()."'")."
				".(is_null($objeto_recebido->get_deflator()) ? "" : ", deflator = ".$objeto_recebido->get_deflator())."
				".(is_null($objeto_recebido->get_pf_alicota()) ? "" : ", pf_alicota = ".$objeto_recebido->get_pf_alicota())."
				".(is_null($objeto_recebido->get_pmc_alicota()) ? "" : ", pmc_alicota = ".$objeto_recebido->get_pmc_alicota())."
				".(is_null($objeto_recebido->get_pmvg_alicota()) ? "" : ", pmvg_alicota = ".$objeto_recebido->get_pmvg_alicota())."
				".(is_null($objeto_recebido->get_OPERADORA()->get_id()) ? "" : ", id_operadora = ".$objeto_recebido->get_OPERADORA()->get_id())."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_data()) ? "" : ", data = '".$objeto_recebido->get_data()."'")."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_medtab WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_medtab";
				if (is_null($wherecl) == false){ $sql = $sql." WHERE ".$wherecl; }
				if (is_null($ordercl) == false){ $sql = $sql." ORDER BY ".$ordercl; }
				$sql = $sql.";";

				$result = $dbh->query($sql);
				$resreturn = array ();
				while($row = $result->fetch_assoc()){
					$new_object = new MedTab();
					if (isset($row["id"])){ $new_object->set_id($row["id"]); }
					if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
					if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
					if (isset($row["pf_alicota"])){ $new_object->set_pf_alicota($row["pf_alicota"]); }
					if (isset($row["pmc_alicota"])){ $new_object->set_pmc_alicota($row["pmc_alicota"]); }
					if (isset($row["pmvg_alicota"])){ $new_object->set_pmvg_alicota($row["pmvg_alicota"]); }
					if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
					if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->select_id($row["id_medtab"], $dbh)); }
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_medtab WHERE id = ".$id.";";

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
		$sql = "SELECT * FROM tb_medtab WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = new MedTab();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
		if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
		if (isset($row["pf_alicota"])){ $new_object->set_pf_alicota($row["pf_alicota"]); }
		if (isset($row["pmc_alicota"])){ $new_object->set_pmc_alicota($row["pmc_alicota"]); }
		if (isset($row["pmvg_alicota"])){ $new_object->set_pmvg_alicota($row["pmvg_alicota"]); }
		if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["data"])){ $new_object->set_data($row["data"]); }

		if (is_null ($database)){ $dbh = null; }
		return $new_object;
	}

	public function select_all ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_medtab;";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MedTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["pf_alicota"])){ $new_object->set_pf_alicota($row["pf_alicota"]); }
			if (isset($row["pmc_alicota"])){ $new_object->set_pmc_alicota($row["pmc_alicota"]); }
			if (isset($row["pmvg_alicota"])){ $new_object->set_pmvg_alicota($row["pmvg_alicota"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->select_id($row["id_medtab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_Operadora ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT * FROM tb_medtab WHERE ";
		if (!is_null($id)){ $sql .= "id_operadora = ".$id.";"; }
		else { $sql .= "isnull(id_operadora);"; }

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MedTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["pf_alicota"])){ $new_object->set_pf_alicota($row["pf_alicota"]); }
			if (isset($row["pmc_alicota"])){ $new_object->set_pmc_alicota($row["pmc_alicota"]); }
			if (isset($row["pmvg_alicota"])){ $new_object->set_pmvg_alicota($row["pmvg_alicota"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->select_id($row["id_medtab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}

	public function select_by_MedTab ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_medtab WHERE id_medtab = ".$id.";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = new MedTab();
			if (isset($row["id"])){ $new_object->set_id($row["id"]); }
			if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
			if (isset($row["deflator"])){ $new_object->set_deflator($row["deflator"]); }
			if (isset($row["pf_alicota"])){ $new_object->set_pf_alicota($row["pf_alicota"]); }
			if (isset($row["pmc_alicota"])){ $new_object->set_pmc_alicota($row["pmc_alicota"]); }
			if (isset($row["pmvg_alicota"])){ $new_object->set_pmvg_alicota($row["pmvg_alicota"]); }
			if (isset($row["id_operadora"])){ $new_object->set_OPERADORA($this->DAOOperadora->select_id($row["id_operadora"], $dbh)); }
			if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->select_id($row["id_medtab"], $dbh)); }
			if (isset($row["data"])){ $new_object->set_data($row["data"]); }

			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>
