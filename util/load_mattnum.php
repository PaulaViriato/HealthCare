<?php
require_once('content.php');
require_once('../model/mattnum.php');
require_once('../dao/mattnum_DAO.php');
require_once('../model/material.php');
require_once('../dao/material_DAO.php');

class Load_MatTnum {
	private $DAOMatTnum;
	private $DAOMaterial;
	private $batch;
	private $last_time;
	private $last_memory;
	private $authenticate;

	// Construtor
	function __construct(){
		$this->DAOMatTnum = new MatTnum_DAO();
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

		$this->sql_insert_tnum = "";
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
			if (!empty($this->sql_insert_tnum)){
				$this->sql_insert_tnum .= "; ";
				$this->sql_update = $this->sql_insert_tnum.$this->sql_update;
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
			if (in_array ("Código - versão TISS 3.04.00", $values)){
				$this->init_read = true;
				$this->column_initial = intval (array_search ("Código - versão TISS 3.04.00", $values));
			}
		} else {
			if (count($values) > 21){
				if ($this->authenticate == true){
					$objmat = new Material();

					$objmat->set_id ($values[$this->column_initial + 9]);
					$objmat->set_cnpj ($values[$this->column_initial + 7]);
					$objmat->set_descricao_produto ($values[$this->column_initial + 2]);
					$objmat->set_especialidade_produto ($values[$this->column_initial + 3]);
					$objmat->set_classificacao_produto ($values[$this->column_initial + 4]);
					$objmat->set_unidmin_fracao ($values[$this->column_initial + 6]);
					$objmat->set_tipo_produto ($values[$this->column_initial + 13]);

					$exist = $this->DAOMaterial->exist_id ($objmat->get_id(), $this->dbh);
					if ((in_array ($objmat->get_id(), $this->ids))||($exist == true)){
						$this->sql_update .= $this->DAOMaterial->get_update ($objmat)." ";
						$this->curr_batch = $this->curr_batch + 1;
					} else {
						$objmat->set_fabricante ($values[$this->column_initial + 8]);
						$objmat->set_nome_tecnico ($values[$this->column_initial + 5]);

						if (empty($this->sql_insert_mate)){ $this->sql_insert_mate .= $this->DAOMaterial->get_insert ($objmat, false, true, true); }
						else { $this->sql_insert_mate .= ", ".$this->DAOMaterial->get_insert ($objmat, false, false, true); }
						$this->curr_batch = $this->curr_batch + 1;
					}
					array_push ($this->ids, $objmat->get_id());
				}

				$objmatt = new MatTnum ();

				$auxmat = new Material();
				$auxtab = new MatTab();
				$auxmat->set_id ($values[$this->column_initial + 9]);
				$auxtab->set_id ($this->id_mattab);

				$objmatt->set_MATERIAL ($auxmat);
				$objmatt->set_MATTAB ($auxtab);

				$objmatt->set_nome ($values[$this->column_initial + 1]);
				$objmatt->set_cod_tiss ($values[$this->column_initial + 0]);
				$objmatt->set_nome_comercial ($values[$this->column_initial + 1]);
				if (!empty($values[$this->column_initial + 10])){ $objmatt->set_observaces ($values[$this->column_initial + 10]); }
				if (!empty($values[$this->column_initial + 11])){ $objmatt->set_cod_anterior ($values[$this->column_initial + 11]); }
				if (!empty($values[$this->column_initial + 12])){ $objmatt->set_ref_tamanhomodelo ($values[$this->column_initial + 12]); }
				$objmatt->set_tipo_codificacao ($values[$this->column_initial + 14]);
				if (!empty($values[$this->column_initial + 15])){ $objmatt->set_inicio_vigencia ($this->convert_data($values[$this->column_initial + 15])); }
				if (!empty($values[$this->column_initial + 16])){ $objmatt->set_fim_vigencia ($this->convert_data($values[$this->column_initial + 16])); }
				if (!empty($values[$this->column_initial + 17])){ $objmatt->set_motivo_insercao ($values[$this->column_initial + 17]); }
				if (!empty($values[$this->column_initial + 18])){ $objmatt->set_fim_implantacao ($this->convert_data($values[$this->column_initial + 18])); }
				if (!empty($values[$this->column_initial + 19])){ $objmatt->set_cod_simpro ($values[$this->column_initial + 19]); }
				if (!empty($values[$this->column_initial + 20])){ $objmatt->set_descricaoproduto_simpro ($values[$this->column_initial + 20]); }
				if (!empty($values[$this->column_initial + 21])){ $objmatt->set_equivalencia_tecnica ($values[$this->column_initial + 21]); }

				$exist = $this->DAOMatTnum->exist_id ($objmatt, $this->dbh);
				if (is_null ($exist)){
					if (empty($this->sql_insert_tnum)){ $this->sql_insert_tnum .= $this->DAOMatTnum->get_insert ($objmatt, false, true, true); }
					else { $this->sql_insert_tnum .= ", ".$this->DAOMatTnum->get_insert ($objmatt, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					$objmatt->set_id ($exist);
					$this->sql_update .= $this->DAOMatTnum->get_update ($objmatt)." ";
					$this->curr_batch = $this->curr_batch + 1;
				}

				if ($this->curr_batch >= $this->batch){
					if (!empty($this->sql_insert_tnum)){
						$this->sql_insert_tnum .= "; ";
						$this->sql_update = $this->sql_insert_tnum.$this->sql_update;
					}

					if (!empty($this->sql_insert_mate)){
						$this->sql_insert_mate .= "; ";
						$this->sql_update = $this->sql_insert_mate.$this->sql_update;
					}

					$this->sql_insert_tnum = "";
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