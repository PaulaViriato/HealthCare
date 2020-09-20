<?php
require_once('content.php');
require_once('../model/medtnum.php');
require_once('../dao/medtnum_DAO.php');
require_once('../model/medicamento.php');
require_once('../dao/medicamento_DAO.php');

class Load_MedTnum {
	private $DAOMedTnum;
	private $DAOMedicamento;
	private $batch;
	private $last_time;
	private $last_memory;
	private $authenticate;

	// Construtor
	function __construct(){
		$this->DAOMedTnum = new MedTnum_DAO();
		$this->DAOMedicamento = new Medicamento_DAO();
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

	public function load ($fileName, $id_medtab){
		$time = microtime(1);
		$mem = memory_get_usage();
		$this->dbh = getDbh();

		$this->init_read = false;
		$this->curr_batch = 0;

		$this->sql_insert_tnum = "";
		$this->sql_insert_medi = "";
		$this->sql_update = "";

		$this->column_initial = -1;
		$this->id_medtab = $id_medtab;
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

			if (!empty($this->sql_insert_medi)){
				$this->sql_insert_medi .= "; ";
				$this->sql_update = $this->sql_insert_medi.$this->sql_update;
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
			if (count($values) > 22){
				if ($this->authenticate == true){
					$objmed = new Medicamento();

					$objmed->set_id ($values[$this->column_initial + 10]);

					$objmed->set_generico (false);
					if (strcasecmp ($values[$this->column_initial + 3], "S") == 0){ $objmed->set_generico (true); }

					$objmed->set_grupo_farmacologico ($values[$this->column_initial + 4]);
					$objmed->set_classe_farmacologica ($values[$this->column_initial + 5]);
					$objmed->set_forma_farmaceutica ($values[$this->column_initial + 6]);
					$objmed->set_unidmin_fracao ($values[$this->column_initial + 7]);

					$exist = $this->DAOMedicamento->exist_id ($objmed->get_id(), $this->dbh);
					if ((in_array ($objmed->get_id(), $this->ids))||($exist == true)){
						$this->sql_update .= $this->DAOMedicamento->get_update ($objmed)." ";
						$this->curr_batch = $this->curr_batch + 1;
					} else {
						$objmed->set_produto ($values[$this->column_initial + 1]);
						$objmed->set_apresentacao ($values[$this->column_initial + 1]);
						$objmed->set_substancia ($values[$this->column_initial + 2]);
						$objmed->set_cnpj ($values[$this->column_initial + 8]);
						$objmed->set_laboratorio ($values[$this->column_initial + 9]);
						$objmed->set_tipo_produto ($values[$this->column_initial + 13]);

						if (empty($this->sql_insert_medi)){ $this->sql_insert_medi .= $this->DAOMedicamento->get_insert ($objmed, false, true, true); }
						else { $this->sql_insert_medi .= ", ".$this->DAOMedicamento->get_insert ($objmed, false, false, true); }
						$this->curr_batch = $this->curr_batch + 1;
					}
					array_push ($this->ids, $objmed->get_id());
				}

				$objmedt = new MedTnum ();

				$auxmed = new Medicamento();
				$auxtab = new MedTab();
				$auxmed->set_id ($values[$this->column_initial + 10]);
				$auxtab->set_id ($this->id_medtab);

				$objmedt->set_MEDICAMENTO ($auxmed);
				$objmedt->set_MEDTAB ($auxtab);

				$objmedt->set_cod_tiss ($values[$this->column_initial + 0]);
				if (!empty($values[$this->column_initial + 11])){ $objmedt->set_observacoes ($values[$this->column_initial + 11]); }
				if (!empty($values[$this->column_initial + 12])){ $objmedt->set_cod_anterior ($values[$this->column_initial + 12]); }
				$objmedt->set_tipo_produto ($values[$this->column_initial + 13]);
				$objmedt->set_tipo_codificacao ($values[$this->column_initial + 14]);
				if (!empty($values[$this->column_initial + 15])){ $objmedt->set_inicio_vigencia ($this->convert_data($values[$this->column_initial + 15])); }
				if (!empty($values[$this->column_initial + 16])){ $objmedt->set_fim_vigencia ($this->convert_data($values[$this->column_initial + 16])); }
				if (!empty($values[$this->column_initial + 17])){ $objmedt->set_motivo_insercao ($values[$this->column_initial + 17]); }
				if (!empty($values[$this->column_initial + 18])){ $objmedt->set_fim_implantacao ($this->convert_data($values[$this->column_initial + 18])); }
				if (!empty($values[$this->column_initial + 19])){ $objmedt->set_cod_tissbrasindice ($values[$this->column_initial + 19]); }
				if (!empty($values[$this->column_initial + 20])){ $objmedt->set_descricao_brasindice ($values[$this->column_initial + 20]); }
				if (!empty($values[$this->column_initial + 21])){ $objmedt->set_apresentacao_brasindice ($values[$this->column_initial + 21]); }

				$objmedt->set_pertence_confaz (false);
				if (strcasecmp ($values[$this->column_initial + 22], "S") == 0){ $objmedt->set_pertence_confaz (true); }

				$exist = $this->DAOMedTnum->exist_id ($objmedt, $this->dbh);
				if (is_null ($exist)){
					if (empty($this->sql_insert_tnum)){ $this->sql_insert_tnum .= $this->DAOMedTnum->get_insert ($objmedt, false, true, true); }
					else { $this->sql_insert_tnum .= ", ".$this->DAOMedTnum->get_insert ($objmedt, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					$objmedt->set_id ($exist);
					$this->sql_update .= $this->DAOMedTnum->get_update ($objmedt)." ";
					$this->curr_batch = $this->curr_batch + 1;
				}

				if ($this->curr_batch >= $this->batch){
					if (!empty($this->sql_insert_tnum)){
						$this->sql_insert_tnum .= "; ";
						$this->sql_update = $this->sql_insert_tnum.$this->sql_update;
					}

					if (!empty($this->sql_insert_medi)){
						$this->sql_insert_medi .= "; ";
						$this->sql_update = $this->sql_insert_medi.$this->sql_update;
					}

					$this->sql_insert_tnum = "";
					$this->sql_insert_medi = "";

					exec_query ($this->sql_update, true);
					$this->sql_update = "";
					$this->curr_batch = 0;
				}
			}
		}
	}
}
?>
