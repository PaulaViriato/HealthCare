<?php
require_once('content.php');
require_once('../model/cmed.php');
require_once('../dao/cmed_DAO.php');
require_once('../model/medicamento.php');
require_once('../dao/medicamento_DAO.php');

class Load_CMED {
	private $DAOCMED;
	private $DAOMedicamento;
	private $batch;
	private $last_time;
	private $last_memory;
	private $authenticate;

	// Construtor
	function __construct(){
		$this->DAOCMED = new CMED_DAO();
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

	public function load ($fileName, $type, $id_medtab){
		$time = microtime(1);
		$mem = memory_get_usage();
		$this->dbh = getDbh();

		$this->init_read = false;
		$this->curr_batch = 0;

		$this->sql_insert_cmed = "";
		$this->sql_insert_medi = "";
		$this->sql_update = "";

		$this->column_initial = -1;
		$this->type = $type;
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
			if (!empty($this->sql_insert_cmed)){
				$this->sql_insert_cmed .= "; ";
				$this->sql_update = $this->sql_insert_cmed.$this->sql_update;
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
			if ((in_array ("PRINCÍPIO ATIVO", $values))||(in_array ("SUBSTÂNCIA", $values))) {
				$this->init_read = true;
				if (in_array ("PRINCÍPIO ATIVO", $values)){ $this->column_initial = intval (array_search ("PRINCÍPIO ATIVO", $values)); }
				else { $this->column_initial = intval (array_search ("SUBSTÂNCIA", $values)); }
			}
		} else {
			if (($this->type == 0)&&(count($values) > 39)){
				if ($this->authenticate == true){
					$objmed = new Medicamento();

					$objmed->set_id ($values[$this->column_initial + 4]);
					$objmed->set_substancia ($values[$this->column_initial + 0]);
					$objmed->set_cnpj ($values[$this->column_initial + 1]);
					$objmed->set_laboratorio ($values[$this->column_initial + 2]);
					$objmed->set_codggrem ($values[$this->column_initial + 3]);
					$objmed->set_produto ($values[$this->column_initial + 8]);
					$objmed->set_apresentacao ($values[$this->column_initial + 9]);
					$objmed->set_classe_terapeutica ($values[$this->column_initial + 10]);
					$objmed->set_tipo_produto ($values[$this->column_initial + 11]);
					$objmed->set_tarja ($values[$this->column_initial + 40]);

					$exist = $this->DAOMedicamento->exist_id ($objmed->get_id(), $this->dbh);
					if ((in_array ($objmed->get_id(), $this->ids))||($exist == true)){
						$this->sql_update .= $this->DAOMedicamento->get_update ($objmed)." ";
						$this->curr_batch = $this->curr_batch + 1;
					} else {
						if (empty($this->sql_insert_medi)){ $this->sql_insert_medi .= $this->DAOMedicamento->get_insert ($objmed, false, true, true); }
						else { $this->sql_insert_medi .= ", ".$this->DAOMedicamento->get_insert ($objmed, false, false, true); }
						$this->curr_batch = $this->curr_batch + 1;
					}
					array_push ($this->ids, $objmed->get_id());
				}

				$objcmed = new CMED();

				$auxmed = new Medicamento();
				$auxtab = new MedTab();
				$auxmed->set_id ($values[$this->column_initial + 4]);
				$auxtab->set_id ($this->id_medtab);

				$restricaohospitalar_value = false;
				$cap_value = false;
				$confazoitosete_value = false;
				$icmszero_value = false;
				$analiserecursal_value = false;
				$comercializacao_value = false;

				if (strcasecmp ($values[$this->column_initial + 33], "Sim") == 0){ $restricaohospitalar_value = true; }
				if (strcasecmp ($values[$this->column_initial + 34], "Sim") == 0){ $cap_value = true; }
				if (strcasecmp ($values[$this->column_initial + 35], "Sim") == 0){ $confazoitosete_value = true; }
				if (strcasecmp ($values[$this->column_initial + 36], "Sim") == 0){ $icmszero_value = true; }
				if (strcasecmp ($values[$this->column_initial + 37], "Sim") == 0){ $analiserecursal_value = true; }
				if (strcasecmp ($values[$this->column_initial + 39], "Sim") == 0){ $comercializacao_value = true; }

				$objcmed->set_MEDICAMENTO ($auxmed);
				$objcmed->set_MEDTAB ($auxtab);
				$objcmed->set_ean_um ($values[$this->column_initial + 5]);
				$objcmed->set_ean_dois ($values[$this->column_initial + 6]);
				$objcmed->set_ean_tres ($values[$this->column_initial + 7]);
				$objcmed->set_regime_preco ($values[$this->column_initial + 12]);
				$objcmed->set_pf_semimpostos ($values[$this->column_initial + 13]);
				$objcmed->set_pf_zero ($values[$this->column_initial + 14]);
				$objcmed->set_pf_doze ($values[$this->column_initial + 15]);
				$objcmed->set_pf_dezessete ($values[$this->column_initial + 16]);
				$objcmed->set_pf_dezessete_alc ($values[$this->column_initial + 17]);
				$objcmed->set_pf_dezessetemeio ($values[$this->column_initial + 18]);
				$objcmed->set_pf_dezessetemeio_alc ($values[$this->column_initial + 19]);
				$objcmed->set_pf_dezoito ($values[$this->column_initial + 20]);
				$objcmed->set_pf_dezoito_alc ($values[$this->column_initial + 21]);
				$objcmed->set_pf_vinte ($values[$this->column_initial + 22]);
				$objcmed->set_pmvg_semimpostos ($values[$this->column_initial + 23]);
				$objcmed->set_pmvg_zero ($values[$this->column_initial + 24]);
				$objcmed->set_pmvg_doze ($values[$this->column_initial + 25]);
				$objcmed->set_pmvg_dezessete ($values[$this->column_initial + 26]);
				$objcmed->set_pmvg_dezessete_alc ($values[$this->column_initial + 27]);
				$objcmed->set_pmvg_dezessetemeio ($values[$this->column_initial + 28]);
				$objcmed->set_pmvg_dezessetemeio_alc ($values[$this->column_initial + 29]);
				$objcmed->set_pmvg_dezoito ($values[$this->column_initial + 30]);
				$objcmed->set_pmvg_dezoito_alc ($values[$this->column_initial + 31]);
				$objcmed->set_pmvg_vinte ($values[$this->column_initial + 32]);
				$objcmed->set_restricao_hospitalar ($restricaohospitalar_value);
				$objcmed->set_cap ($cap_value);
				$objcmed->set_confaz_oitosete ($confazoitosete_value);
				$objcmed->set_icms_zero ($icmszero_value);
				$objcmed->set_analise_recursal ($analiserecursal_value);
				$objcmed->set_lista_ctributario ($values[$this->column_initial + 38]);
				$objcmed->set_comercializacao ($comercializacao_value);

				$exist = $this->DAOCMED->exist_id ($objcmed, $this->dbh);
				if (is_null ($exist)){
					if (empty($this->sql_insert_cmed)){ $this->sql_insert_cmed .= $this->DAOCMED->get_insert ($objcmed, false, true, true); }
					else { $this->sql_insert_cmed .= ", ".$this->DAOCMED->get_insert ($objcmed, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					$objcmed->set_id ($exist);
					$this->sql_update .= $this->DAOCMED->get_update ($objcmed)." ";
					$this->curr_batch = $this->curr_batch + 1;
				}
			}

			if (($this->type == 1)&&(count($values) > 38)){
				if ($this->authenticate == true){
					$objmed = new Medicamento();

					$objmed->set_id ($values[$this->column_initial + 4]);
					$objmed->set_substancia ($values[$this->column_initial + 0]);
					$objmed->set_cnpj ($values[$this->column_initial + 1]);
					$objmed->set_laboratorio ($values[$this->column_initial + 2]);
					$objmed->set_codggrem ($values[$this->column_initial + 3]);
					$objmed->set_produto ($values[$this->column_initial + 8]);
					$objmed->set_apresentacao ($values[$this->column_initial + 9]);
					$objmed->set_classe_terapeutica ($values[$this->column_initial + 10]);
					$objmed->set_tipo_produto ($values[$this->column_initial + 11]);
					$objmed->set_tarja ($values[$this->column_initial + 39]);

					$exist = $this->DAOMedicamento->exist_id ($objmed->get_id(), $this->dbh);
					if ((in_array ($objmed->get_id(), $this->ids))||($exist == true)){
						$this->sql_update .= $this->DAOMedicamento->get_update ($objmed)." ";
						$this->curr_batch = $this->curr_batch + 1;
					} else {
						if (empty($this->sql_insert_medi)){ $this->sql_insert_medi .= $this->DAOMedicamento->get_insert ($objmed, false, true, true); }
						else { $this->sql_insert_medi .= ", ".$this->DAOMedicamento->get_insert ($objmed, false, false, true); }
						$this->curr_batch = $this->curr_batch + 1;
					}
					array_push ($this->ids, $objmed->get_id());
				}

				$objcmed = new CMED();

				$auxmed = new Medicamento();
				$auxtab = new MedTab();
				$auxmed->set_id ($values[$this->column_initial + 4]);
				$auxtab->set_id ($this->id_medtab);

				$restricaohospitalar_value = false;
				$cap_value = false;
				$confazoitosete_value = false;
				$icmszero_value = false;
				$analiserecursal_value = false;
				$comercializacao_value = false;

				if (strcasecmp ($values[$this->column_initial + 32], "Sim") == 0){ $restricaohospitalar_value = true; }
				if (strcasecmp ($values[$this->column_initial + 33], "Sim") == 0){ $cap_value = true; }
				if (strcasecmp ($values[$this->column_initial + 34], "Sim") == 0){ $confazoitosete_value = true; }
				if (strcasecmp ($values[$this->column_initial + 35], "Sim") == 0){ $icmszero_value = true; }
				if (strcasecmp ($values[$this->column_initial + 36], "Sim") == 0){ $analiserecursal_value = true; }
				if (strcasecmp ($values[$this->column_initial + 38], "Sim") == 0){ $comercializacao_value = true; }

				$objcmed->set_MEDICAMENTO ($auxmed);
				$objcmed->set_MEDTAB ($auxtab);
				$objcmed->set_ean_um ($values[$this->column_initial + 5]);
				$objcmed->set_ean_dois ($values[$this->column_initial + 6]);
				$objcmed->set_ean_tres ($values[$this->column_initial + 7]);
				$objcmed->set_regime_preco ($values[$this->column_initial + 12]);
				$objcmed->set_pf_semimpostos ($values[$this->column_initial + 13]);
				$objcmed->set_pf_zero ($values[$this->column_initial + 14]);
				$objcmed->set_pf_doze ($values[$this->column_initial + 15]);
				$objcmed->set_pf_dezessete ($values[$this->column_initial + 16]);
				$objcmed->set_pf_dezessete_alc ($values[$this->column_initial + 17]);
				$objcmed->set_pf_dezessetemeio ($values[$this->column_initial + 18]);
				$objcmed->set_pf_dezessetemeio_alc ($values[$this->column_initial + 19]);
				$objcmed->set_pf_dezoito ($values[$this->column_initial + 20]);
				$objcmed->set_pf_dezoito_alc ($values[$this->column_initial + 21]);
				$objcmed->set_pf_vinte ($values[$this->column_initial + 22]);
				$objcmed->set_pmc_zero ($values[$this->column_initial + 23]);
				$objcmed->set_pmc_doze ($values[$this->column_initial + 24]);
				$objcmed->set_pmc_dezessete ($values[$this->column_initial + 25]);
				$objcmed->set_pmc_dezessete_alc ($values[$this->column_initial + 26]);
				$objcmed->set_pmc_dezessetemeio ($values[$this->column_initial + 27]);
				$objcmed->set_pmc_dezessetemeio_alc ($values[$this->column_initial + 28]);
				$objcmed->set_pmc_dezoito ($values[$this->column_initial + 29]);
				$objcmed->set_pmc_dezoito_alc ($values[$this->column_initial + 30]);
				$objcmed->set_pmc_vinte ($values[$this->column_initial + 31]);
				$objcmed->set_restricao_hospitalar ($restricaohospitalar_value);
				$objcmed->set_cap ($cap_value);
				$objcmed->set_confaz_oitosete ($confazoitosete_value);
				$objcmed->set_icms_zero ($icmszero_value);
				$objcmed->set_analise_recursal ($analiserecursal_value);
				$objcmed->set_lista_ctributario ($values[$this->column_initial + 37]);
				$objcmed->set_comercializacao ($comercializacao_value);

				$exist = $this->DAOCMED->exist_id ($objcmed, $this->dbh);
				if (is_null ($exist)){
					if (empty($this->sql_insert_cmed)){ $this->sql_insert_cmed .= $this->DAOCMED->get_insert ($objcmed, false, true, true); }
					else { $this->sql_insert_cmed .= ", ".$this->DAOCMED->get_insert ($objcmed, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					$objcmed->set_id ($exist);
					$this->sql_update .= $this->DAOCMED->get_update ($objcmed)." ";
					$this->curr_batch = $this->curr_batch + 1;
				}
			}

			if ($this->curr_batch >= $this->batch){
				if (!empty($this->sql_insert_cmed)){
					$this->sql_insert_cmed .= "; ";
					$this->sql_update = $this->sql_insert_cmed.$this->sql_update;
				}

				if (!empty($this->sql_insert_medi)){
					$this->sql_insert_medi .= "; ";
					$this->sql_update = $this->sql_insert_medi.$this->sql_update;
				}

				$this->sql_insert_cmed = "";
				$this->sql_insert_medi = "";

				exec_query ($this->sql_update, true);
				$this->sql_update = "";
				$this->curr_batch = 0;
			}
		}
	}
}
?>