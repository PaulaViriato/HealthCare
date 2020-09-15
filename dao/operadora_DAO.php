<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('prestadora_DAO.php');
require_once('medtab_DAO.php');
require_once('mattab_DAO.php');
require_once('rotina_DAO.php');
require_once('administrador_DAO.php');
require_once($path.'/operadora.php');

class Operadora_DAO {
	// Propriedades
	private $DAOPrestadora;
	private $DAOMedTab;
	private $DAOMatTab;
	private $DAORotina;
	private $DAOAdministrador;

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_operadora (nome, codans, cnpj, email, contato, login, senha) VALUES (
			".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
			".(is_null($objeto_recebido->get_codans()) ? "null" : "'".$objeto_recebido->get_codans()."'").", 
			".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
			".(is_null($objeto_recebido->get_email()) ? "null" : "'".$objeto_recebido->get_email()."'").", 
			".(is_null($objeto_recebido->get_contato()) ? "null" : "'".$objeto_recebido->get_contato()."'").", 
			".(is_null($objeto_recebido->get_login()) ? "null" : "'".$objeto_recebido->get_login()."'").", 
			".(is_null($objeto_recebido->get_senha()) ? "null" : "md5 ('".$objeto_recebido->get_senha()."')").");";
		} else {
			if ($intro == true){ $sql .= "INSERT INTO tb_operadora (nome, codans, cnpj, email, contato, login, senha) VALUES "; }
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_nome()) ? "null" : "'".$objeto_recebido->get_nome()."'").", 
				".(is_null($objeto_recebido->get_codans()) ? "null" : "'".$objeto_recebido->get_codans()."'").", 
				".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
				".(is_null($objeto_recebido->get_email()) ? "null" : "'".$objeto_recebido->get_email()."'").", 
				".(is_null($objeto_recebido->get_contato()) ? "null" : "'".$objeto_recebido->get_contato()."'").", 
				".(is_null($objeto_recebido->get_login()) ? "null" : "'".$objeto_recebido->get_login()."'").", 
				".(is_null($objeto_recebido->get_senha()) ? "null" : "md5 ('".$objeto_recebido->get_senha()."')").")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_operadora SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_nome()) ? "" : ", nome = '".$objeto_recebido->get_nome()."'")."
		".(is_null($objeto_recebido->get_codans()) ? "" : ", codans = '".$objeto_recebido->get_codans()."'")."
		".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
		".(is_null($objeto_recebido->get_email()) ? "" : ", email = '".$objeto_recebido->get_email()."'")."
		".(is_null($objeto_recebido->get_contato()) ? "" : ", contato = '".$objeto_recebido->get_contato()."'")."
		".(is_null($objeto_recebido->get_login()) ? "" : ", login = '".$objeto_recebido->get_login()."'")."
		".(is_null($objeto_recebido->get_senha()) ? "" : ", senha = md5 ('".$objeto_recebido->get_senha()."')")."
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
			$sql = "SELECT id FROM tb_operadora WHERE 
			".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
			".(is_null($objeto_recebido->get_codans()) ? "isnull(codans)" : "codans = '".$objeto_recebido->get_codans()."'")." AND
			".(is_null($objeto_recebido->get_cnpj()) ? "isnull(cnpj)" : "cnpj = '".$objeto_recebido->get_cnpj()."'")." AND
			".(is_null($objeto_recebido->get_email()) ? "isnull(email)" : "email = '".$objeto_recebido->get_email()."'")." AND
			".(is_null($objeto_recebido->get_contato()) ? "isnull(contato)" : "contato = '".$objeto_recebido->get_contato()."'")." AND
			".(is_null($objeto_recebido->get_login()) ? "isnull(login)" : "login = '".$objeto_recebido->get_login()."'")." AND
			".(is_null($objeto_recebido->get_senha()) ? "isnull(senha)" : "senha = md5 ('".$objeto_recebido->get_senha()."')")." 
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

		$sql = "SELECT COUNT(id) AS count FROM tb_operadora WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_nome()) ? "isnull(nome)" : "nome = '".$objeto_recebido->get_nome()."'")." AND
		".(is_null($objeto_recebido->get_codans()) ? "isnull(codans)" : "codans = '".$objeto_recebido->get_codans()."'")." AND
		".(is_null($objeto_recebido->get_cnpj()) ? "isnull(cnpj)" : "cnpj = '".$objeto_recebido->get_cnpj()."'")." AND
		".(is_null($objeto_recebido->get_email()) ? "isnull(email)" : "email = '".$objeto_recebido->get_email()."'")." AND
		".(is_null($objeto_recebido->get_contato()) ? "isnull(contato)" : "contato = '".$objeto_recebido->get_contato()."'")." AND
		".(is_null($objeto_recebido->get_login()) ? "isnull(login)" : "login = '".$objeto_recebido->get_login()."'")." AND
		".(is_null($objeto_recebido->get_senha()) ? "isnull(senha)" : "senha = md5 ('".$objeto_recebido->get_senha()."')").";";
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

		$DAOPrestadora = new Prestadora_DAO();
		$DAOMedTab = new MedTab_DAO();
		$DAOMatTab = new MatTab_DAO();
		$DAORotina = new Rotina_DAO();
		$prestadoras = $DAOPrestadora->select_by_Operadora($id, $dbh);
		$medtabs = $DAOMedTab->select_by_Operadora($id, $dbh);
		$mattabs = $DAOMatTab->select_by_Operadora($id, $dbh);
		$rotinas = $DAORotina->select_by_Operadora($id, $dbh);
		foreach ($prestadoras as $prestadora){ $DAOPrestadora->delete($prestadora->get_id(), $dbh); }
		foreach ($medtabs as $medtab){ $DAOMedTab->delete($medtab->get_id(), $dbh); }
		foreach ($mattabs as $mattab){ $DAOMatTab->delete($mattab->get_id(), $dbh); }
		foreach ($rotinas as $rotina){ $DAORotina->delete($rotina->get_id(), $dbh); }

		$sql = "DELETE FROM tb_operadora WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh = null; }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new Operadora();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["nome"])){ $new_object->set_nome($row["nome"]); }
		if (isset($row["codans"])){ $new_object->set_codans($row["codans"]); }
		if (isset($row["cnpj"])){ $new_object->set_cnpj($row["cnpj"]); }
		if (isset($row["email"])){ $new_object->set_email($row["email"]); }
		if (isset($row["contato"])){ $new_object->set_contato($row["contato"]); }
		if (isset($row["login"])){ $new_object->set_login($row["login"]); }
		if (isset($row["senha"])){ $new_object->set_senha($row["senha"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_operadora SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_nome()) ? "" : ", nome = '".$objeto_recebido->get_nome()."'")."
				".(is_null($objeto_recebido->get_codans()) ? "" : ", codans = '".$objeto_recebido->get_codans()."'")."
				".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
				".(is_null($objeto_recebido->get_email()) ? "" : ", email = '".$objeto_recebido->get_email()."'")."
				".(is_null($objeto_recebido->get_contato()) ? "" : ", contato = '".$objeto_recebido->get_contato()."'")."
				".(is_null($objeto_recebido->get_login()) ? "" : ", login = '".$objeto_recebido->get_login()."'")."
				".(is_null($objeto_recebido->get_senha()) ? "" : ", senha = md5 ('".$objeto_recebido->get_senha()."')")."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_operadora WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_operadora";
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
		$sql = "SELECT COUNT(id) AS qtd FROM tb_operadora WHERE id = ".$id.";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = false;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){ $res_result = true; }
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function exist_login ($login, $database = null, $tested = false){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(id) AS qtd FROM tb_operadora WHERE login = '".$login."';";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = false;
		$DAOAdministrador = new Administrador_DAO();
		if (isset($row)){
			if (intval($row["qtd"]) > 0){ $res_result = true; }
			else { if (!$tested){ $res_result = $DAOAdministrador->exist_login ($login, $dbh, true); } }
		} else { if (!$tested){ $res_result = $DAOAdministrador->exist_login ($login, $dbh, true); } }

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function login ($login, $senha, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(id) AS qtd FROM tb_operadora WHERE login = '".$login."' AND senha = md5('".$senha."');";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){
				$sql2 = "SELECT * FROM tb_operadora WHERE login = '".$login."' AND senha = md5('".$senha."');";
				$result2 = $dbh->query($sql2);
				$row2 = $result2->fetch_assoc();
				$res_result = $this->get_object ($row2, $dbh);
			}
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_operadora WHERE id = ".$id.";";

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
		if (is_null($fields)){ $sql .= "* FROM tb_operadora"; }
		else{ $sql .= $fields." FROM tb_operadora"; }
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
}
?>
