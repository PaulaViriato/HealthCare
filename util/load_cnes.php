<?php
require_once('content.php');
require_once('../model/cnes.php');
require_once('../dao/cnes_DAO.php');

class Load_CNES {
	// Propriedades
	private $DAOCNES;
	private $batch;
	private $last_time;
	private $last_memory;

	// Construtor
	function __construct(){
		$this->DAOCNES = new CNES_DAO();
		$this->batch = 200;
		$this->last_time = null;
		$this->last_memory = null;
	}

	public function set_batch ($batch){ $this->batch = $batch; }
	public function get_batch (){ return $this->batch; }
	public function get_last_time (){ return $this->last_time; }
	public function get_last_memory (){ return $this->last_memory; }
	private function convert_data ($data){
		if ((strpos ($data, ":") === false)&&(strpos ($data, "-") === false)){
			return substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);
		} else { return $data; }
	}

	public function load ($fileName){
		$time = microtime(1);
		$mem = memory_get_usage();
		$this->dbh = getDbh();

		$this->init_read = false;
		$this->curr_batch = 0;

		$this->sql_insert = "";
		$this->sql_update = "";

		$this->column_initial = -1;
		$this->ids = array();

		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		set_time_limit(0);

		$CONTENT = new Content();
		$CONTENT->get_content ($fileName, $this);

		if (($this->init_read == true)&&($this->curr_batch > 0)){
			if (!empty($this->sql_insert)){
				$this->sql_insert .= "; ";
				$this->sql_update = $this->sql_insert.$this->sql_update;
			}
			exec_query ($this->sql_update, true);
		}

		$this->last_time = floatval((1000 * (microtime(1) - $time))/1000);
		$this->last_memory = ((memory_get_usage() - $mem) / (1024 * 1024));
		$this->dbh->close();
	}

	public function set_line ($values){
		if ($this->init_read == false){
			if (in_array ("CO_CNES", $values)){
				$this->init_read = true;
				$this->column_initial = intval (array_search ("CO_CNES", $values));
			}
		} else {
			$objcnes = new CNES();

			if (count($values) > 57){
				$objcnes->set_id ($values[$this->column_initial + 0]);
				$objcnes->set_ativo ((strcasecmp ($values[$this->column_initial + 1], "SIM") == 0));
				$objcnes->set_razao_social ($values[$this->column_initial + 2]);
				$objcnes->set_no_fantasia ($values[$this->column_initial + 3]);
				$objcnes->set_tipo_estabelecimento ($values[$this->column_initial + 4]);
				$objcnes->set_convenio ($values[$this->column_initial + 5]);
				$objcnes->set_natureza_juridica ($values[$this->column_initial + 6]);
				$objcnes->set_atendimento_prestado ($values[$this->column_initial + 7]);
				$objcnes->set_cnpj ($values[$this->column_initial + 8]);
				$objcnes->set_cpf ($values[$this->column_initial + 9]);
				$objcnes->set_cd_municipio ($values[$this->column_initial + 10]);
				$objcnes->set_nm_municipio ($values[$this->column_initial + 11]);
				$objcnes->set_uf ($values[$this->column_initial + 12]);
				$objcnes->set_cep ($values[$this->column_initial + 13]);
				$objcnes->set_inclusao ($this->convert_data($values[$this->column_initial + 14]));
				$objcnes->set_equipo_odontologico ((strcasecmp ($values[$this->column_initial + 15], "X") == 0));
				$objcnes->set_cirurgiao_dentista ((strcasecmp ($values[$this->column_initial + 16], "X") == 0));
				$objcnes->set_urgencia_emergencia ((strcasecmp ($values[$this->column_initial + 17], "X") == 0));
				$objcnes->set_leitos_clinica ($values[$this->column_initial + 18]);
				$objcnes->set_leitos_cirurgia ($values[$this->column_initial + 19]);
				$objcnes->set_leitos_obstetricia ($values[$this->column_initial + 20]);
				$objcnes->set_leitos_pediatria ($values[$this->column_initial + 21]);
				$objcnes->set_leitos_psiquiatria ($values[$this->column_initial + 22]);
				$objcnes->set_leitos_uti_adulto ($values[$this->column_initial + 23]);
				$objcnes->set_leitos_uti_pediatrica ($values[$this->column_initial + 24]);
				$objcnes->set_leitos_uti_neonatal ($values[$this->column_initial + 25]);
				$objcnes->set_leitos_unidade_interm_neo ($values[$this->column_initial + 26]);
				$objcnes->set_anatomopatologia ((strcasecmp ($values[$this->column_initial + 27], "X") == 0));
				$objcnes->set_colposcopia ((strcasecmp ($values[$this->column_initial + 28], "X") == 0));
				$objcnes->set_eletrocardiograma ((strcasecmp ($values[$this->column_initial + 29], "X") == 0));
				$objcnes->set_fisioterapia ((strcasecmp ($values[$this->column_initial + 30], "X") == 0));
				$objcnes->set_patologia_clinica ((strcasecmp ($values[$this->column_initial + 31], "X") == 0));
				$objcnes->set_radiodiagnostico ((strcasecmp ($values[$this->column_initial + 32], "X") == 0));
				$objcnes->set_ultra_sonografia ((strcasecmp ($values[$this->column_initial + 33], "X") == 0));
				$objcnes->set_ecocardiografia ((strcasecmp ($values[$this->column_initial + 34], "X") == 0));
				$objcnes->set_endoscopia_vdigestivas ((strcasecmp ($values[$this->column_initial + 35], "X") == 0));
				$objcnes->set_hemoterapia_ambulatorial ((strcasecmp ($values[$this->column_initial + 36], "X") == 0));
				$objcnes->set_holter ((strcasecmp ($values[$this->column_initial + 37], "X") == 0));
				$objcnes->set_litotripsia_extracorporea ((strcasecmp ($values[$this->column_initial + 38], "X") == 0));
				$objcnes->set_mamografia ((strcasecmp ($values[$this->column_initial + 39], "X") == 0));
				$objcnes->set_psicoterapia ((strcasecmp ($values[$this->column_initial + 40], "X") == 0));
				$objcnes->set_terapia_renalsubst ((strcasecmp ($values[$this->column_initial + 41], "X") == 0));
				$objcnes->set_teste_ergometrico ((strcasecmp ($values[$this->column_initial + 42], "X") == 0));
				$objcnes->set_tomografia_computadorizada ((strcasecmp ($values[$this->column_initial + 43], "X") == 0));
				$objcnes->set_atendimento_hospitaldia ((strcasecmp ($values[$this->column_initial + 44], "X") == 0));
				$objcnes->set_endoscopia_vaereas ((strcasecmp ($values[$this->column_initial + 45], "X") == 0));
				$objcnes->set_hemodinamica ((strcasecmp ($values[$this->column_initial + 46], "X") == 0));
				$objcnes->set_medicina_nuclear ((strcasecmp ($values[$this->column_initial + 47], "X") == 0));
				$objcnes->set_quimioterapia ((strcasecmp ($values[$this->column_initial + 48], "X") == 0));
				$objcnes->set_radiologia_intervencionista ((strcasecmp ($values[$this->column_initial + 49], "X") == 0));
				$objcnes->set_radioterapia ((strcasecmp ($values[$this->column_initial + 50], "X") == 0));
				$objcnes->set_ressonancia_nmagnetica ((strcasecmp ($values[$this->column_initial + 51], "X") == 0));
				$objcnes->set_ultrassonografia_doppler ((strcasecmp ($values[$this->column_initial + 52], "X") == 0));
				$objcnes->set_videocirurgia ((strcasecmp ($values[$this->column_initial + 53], "X") == 0));
				$objcnes->set_odontologia_basica ((strcasecmp ($values[$this->column_initial + 54], "X") == 0));
				$objcnes->set_raiox_dentario ((strcasecmp ($values[$this->column_initial + 55], "X") == 0));
				$objcnes->set_endodontia ((strcasecmp ($values[$this->column_initial + 56], "X") == 0));
				$objcnes->set_periodontia ((strcasecmp ($values[$this->column_initial + 57], "X") == 0));

				$exist = $this->DAOCNES->exist_id ($objcnes->get_id(), $this->dbh);
				if ((in_array ($objcnes->get_id(), $this->ids))||($exist == true)){
					if (in_array ($objcnes->get_id(), $this->ids)){ $this->sql_update .= $this->DAOCNES->get_updateap ($objcnes)." "; }
					else { $this->sql_update = $this->DAOCNES->get_update ($objcnes)." "; }
					$this->curr_batch = $this->curr_batch + 1;
				} else {
					if (empty($this->sql_insert)){ $this->sql_insert .= $this->DAOCNES->get_insert ($objcnes, false, true, true); }
					else { $this->sql_insert .= ", ".$this->DAOCNES->get_insert ($objcnes, false, false, true); }
					$this->curr_batch = $this->curr_batch + 1;
				}
				array_push ($this->ids, $objcnes->get_id());

				if ($this->curr_batch >= $this->batch){
					if (!empty($this->sql_insert)){
						$this->sql_insert .= "; ";
						$this->sql_update = $this->sql_insert.$this->sql_update;
					}
					$this->sql_insert = "";

					exec_query ($this->sql_update, true);
					$this->sql_update = "";
					$this->curr_batch = 0;
				}
			}
		}
	}
}
?>
