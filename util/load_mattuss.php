<?php
require_once('content.php');
require_once('../model/mattuss.php');
require_once('../dao/mattuss_DAO.php');
require_once('../model/material.php');
require_once('../dao/material_DAO.php');

class Load_MatTuss {
	private $DAOMatTuss;
	private $DAOMaterial;
	private $batch;
	private $last_time;
	private $last_memory;
	private $authenticate;

	// Construtor
	function __construct(){
		$this->DAOMatTuss = new MatTuss_DAO();
		$this->DAOMaterial = new Material_DAO();
		$this->batch = 200;
		$this->last_time = null;
		$this->last_memory = null;
	}

	public function set_batch ($batch){ $this->batch = $batch; }
	public function get_batch (){ return $this->batch; }
	public function get_last_time (){ return $this->last_time; }
	public function get_last_memory (){ return $this->last_memory; }
	public function set_authenticate ($authenticate){ $this->authenticate = $authenticate; }
	public function get_authenticate (){ return $this->authenticate; }
	private function convert_data ($data){
		if ((strpos ($data, ":") === false)&&(strpos ($data, "-") === false)){
			return substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);
		} else { return $data; }
	}

	public function load ($fileName, $id_mattab){
		$time = microtime(1);
		$mem = memory_get_usage();
		$this->dbh = getDbh();

		$this->init_read = false;
		$this->curr_batch = 0;

		$this->sql_insert_tuss = "";
		$this->sql_insert_mate = "";
		$this->sql_update = "";

		$this->column_initial = -1;
		$this->id_mattab = $id_mattab;
		$this->ids = array();

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		set_time_limit(0);

		$CONTENT = new Content();
		for ($i = 0; $i <= 5; $i ++){
			$CONTENT->get_content ($fileName, $this, $i);
			if ($this->init_read == true){ $i = 6; }
		}

		if (($this->init_read == true)&&($this->curr_batch > 0)){
			if (!empty($this->sql_insert_tuss)){
				$this->sql_insert_tuss .= "; ";
				$this->sql_update = $this->sql_insert_tuss.$this->sql_update;
			}

			if (!empty($this->sql_insert_mate)){
				$this->sql_insert_mate .= "; ";
				$this->sql_update = $this->sql_insert_mate.$this->sql_update;
			}

			exec_query ($this->sql_update, true);
		}

		$this->last_time = floatval((1000 * (microtime(1) - $time))/1000);
		$this->last_memory = ((memory_get_usage() - $mem) / (1024 * 1024));
		$this->dbh->close();
	}

	public function set_line ($values){
		if ($this->init_read == false){
			if (in_array ("Código do Termo", $values)){
				$this->init_read = true;
				$this->column_initial = intval (array_search ("Código do Termo", $values));
			}
		} else {
			if (count($values) > 9){
				if ($this->authenticate == true){
					$objmat = new Material();

					$objmat->set_id ($values[$this->column_initial + 7]);
					$objmat->set_fabricante ($values[$this->column_initial + 3]);
					$objmat->set_classe_risco ($values[$this->column_initial + 8]);
					$objmat->set_nome_tecnico ($values[$this->column_initial + 9]);

					$exist = $this->DAOMaterial->exist_id ($objmat->get_id(), $this->dbh);
					if ((in_array ($objmat->get_id(), $this->ids))||($exist == true)){
						$this->sql_update .= $this->DAOMaterial->get_update ($objmat)." ";
						$this->curr_batch = $this->curr_batch + 1;
					} else {
						if (empty($this->sql_insert_mate)){ $this->sql_insert_mate .= $this->DAOMaterial->get_insert ($objmat, false, true, true); }
						else { $this->sql_insert_mate .= ", ".$this->DAOMaterial->get_insert ($objmat, false, false, true); }
						$this->curr_batch = $this->curr_batch + 1;
					}
					array_push ($this->ids, $objmat->get_id());
				}

				$objmatt = new MatTuss ();

				$auxmat = new Material();
				$auxtab = new MatTab();
				$auxmat->set_id ($values[$this->column_initial + 7]);
				$auxtab->set_id ($this->id_mattab);

				$objmatt->set_MATERIAL ($auxmat);
				$objmatt->set_MATTAB ($auxtab);

				$objmatt->set_termo ($values[$this->column_initial + 1]);
				$objmatt->set_modelo ($values[$this->column_initial + 2]);
				$objmatt->set_codigo_termo ($values[$this->column_initial + 0]);
				if (!empty($values[$this->column_initial + 4])){ $objmatt->set_inicio_vigencia ($this->convert_data($values[$this->column_initial + 4])); }
				if (!empty($values[$this->column_initial + 5])){ $objmatt->set_fim_vigencia ($this->convert_data($values[$this->column_initial + 5])); }
				if (!empty($values[$this->column_initial + 6])){ $objmatt->set_fim_implantacao ($this->convert_data($values[$this->column_initial + 6])); }

				$exist = $this->DAOMatTuss->exist_id ($objmatt, $this->dbh);
				if (is_null ($exist)){
					if (empty($this->sql_insert_tuss)){ $this->sql_insert_tuss .= $this->DAOMatTuss->get_insert ($objmatt, false, true, true); }
					else { $this->sql_insert_tuss .= ", ".$this->DAOMatTuss->get_insert ($objmatt, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					$objmatt->set_id ($exist);
					$this->sql_update .= $this->DAOMatTuss->get_update ($objmatt)." ";
					$this->curr_batch = $this->curr_batch + 1;
				}

				if ($this->curr_batch >= $this->batch){
					if (!empty($this->sql_insert_tuss)){
						$this->sql_insert_tuss .= "; ";
						$this->sql_update = $this->sql_insert_tuss.$this->sql_update;
					}

					if (!empty($this->sql_insert_mate)){
						$this->sql_insert_mate .= "; ";
						$this->sql_update = $this->sql_insert_mate.$this->sql_update;
					}

					$this->sql_insert_tuss = "";
					$this->sql_insert_mate = "";

					exec_query ($this->sql_update, true);
					$this->sql_update = "";
					$this->curr_batch = 0;
				}
			}
		}
	}
}
?>