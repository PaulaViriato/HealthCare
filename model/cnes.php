<?php
class CNES {
	// Propriedades
	private $id;
	private $ativo;
	private $razao_social;
	private $no_fantasia;
	private $tipo_estabelecimento;
	private $convenio;
	private $natureza_juridica;
	private $atendimento_prestado;
	private $cnpj;
	private $cpf;
	private $cd_municipio;
	private $nm_municipio;
	private $uf;
	private $cep;
	private $inclusao;
	private $equipo_odontologico;
	private $cirurgiao_dentista;
	private $urgencia_emergencia;
	private $leitos_clinica;
	private $leitos_cirurgia;
	private $leitos_obstetricia;
	private $leitos_pediatria;
	private $leitos_psiquiatria;
	private $leitos_uti_adulto;
	private $leitos_uti_pediatrica;
	private $leitos_uti_neonatal;
	private $leitos_unidade_interm_neo;
	private $anatomopatologia;
	private $colposcopia;
	private $eletrocardiograma;
	private $fisioterapia;
	private $patologia_clinica;
	private $radiodiagnostico;
	private $ultra_sonografia;
	private $ecocardiografia;
	private $endoscopia_vdigestivas;
	private $hemoterapia_ambulatorial;
	private $holter;
	private $litotripsia_extracorporea;
	private $mamografia;
	private $psicoterapia;
	private $terapia_renalsubst;
	private $teste_ergometrico;
	private $tomografia_computadorizada;
	private $atendimento_hospitaldia;
	private $endoscopia_vaereas;
	private $hemodinamica;
	private $medicina_nuclear;
	private $quimioterapia;
	private $radiologia_intervencionista;
	private $radioterapia;
	private $ressonancia_nmagnetica;
	private $ultrassonografia_doppler;
	private $videocirurgia;
	private $odontologia_basica;
	private $raiox_dentario;
	private $endodontia;
	private $periodontia;


	// Construtor
	function __construct(){
		$this->id = null;
		$this->ativo = null;
		$this->razao_social = null;
		$this->no_fantasia = null;
		$this->tipo_estabelecimento = null;
		$this->convenio = null;
		$this->natureza_juridica = null;
		$this->atendimento_prestado = null;
		$this->cnpj = null;
		$this->cpf = null;
		$this->cd_municipio = null;
		$this->nm_municipio = null;
		$this->uf = null;
		$this->cep = null;
		$this->inclusao = null;
		$this->equipo_odontologico = null;
		$this->cirurgiao_dentista = null;
		$this->urgencia_emergencia = null;
		$this->leitos_clinica = null;
		$this->leitos_cirurgia = null;
		$this->leitos_obstetricia = null;
		$this->leitos_pediatria = null;
		$this->leitos_psiquiatria = null;
		$this->leitos_uti_adulto = null;
		$this->leitos_uti_pediatrica = null;
		$this->leitos_uti_neonatal = null;
		$this->leitos_unidade_interm_neo = null;
		$this->anatomopatologia = null;
		$this->colposcopia = null;
		$this->eletrocardiograma = null;
		$this->fisioterapia = null;
		$this->patologia_clinica = null;
		$this->radiodiagnostico = null;
		$this->ultra_sonografia = null;
		$this->ecocardiografia = null;
		$this->endoscopia_vdigestivas = null;
		$this->hemoterapia_ambulatorial = null;
		$this->holter = null;
		$this->litotripsia_extracorporea = null;
		$this->mamografia = null;
		$this->psicoterapia = null;
		$this->terapia_renalsubst = null;
		$this->teste_ergometrico = null;
		$this->tomografia_computadorizada = null;
		$this->atendimento_hospitaldia = null;
		$this->endoscopia_vaereas = null;
		$this->hemodinamica = null;
		$this->medicina_nuclear = null;
		$this->quimioterapia = null;
		$this->radiologia_intervencionista = null;
		$this->radioterapia = null;
		$this->ressonancia_nmagnetica = null;
		$this->ultrassonografia_doppler = null;
		$this->videocirurgia = null;
		$this->odontologia_basica = null;
		$this->raiox_dentario = null;
		$this->endodontia = null;
		$this->periodontia = null;
	}

	private function is_true($val, $return_null=false){
		$boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
		return intval ($boolval===null && !$return_null ? false : $boolval);
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_ativo (){ return $this->ativo; }
	public function get_razao_social (){ return $this->razao_social; }
	public function get_no_fantasia (){ return $this->no_fantasia; }
	public function get_tipo_estabelecimento (){ return $this->tipo_estabelecimento; }
	public function get_convenio (){ return $this->convenio; }
	public function get_natureza_juridica (){ return $this->natureza_juridica; }
	public function get_atendimento_prestado (){ return $this->atendimento_prestado; }
	public function get_cnpj (){ return $this->cnpj; }
	public function get_cpf (){ return $this->cpf; }
	public function get_cd_municipio (){ return $this->cd_municipio; }
	public function get_nm_municipio (){ return $this->nm_municipio; }
	public function get_uf (){ return $this->uf; }
	public function get_cep (){ return $this->cep; }
	public function get_inclusao (){ return $this->inclusao; }
	public function get_equipo_odontologico (){ return $this->equipo_odontologico; }
	public function get_cirurgiao_dentista (){ return $this->cirurgiao_dentista; }
	public function get_urgencia_emergencia (){ return $this->urgencia_emergencia; }
	public function get_leitos_clinica (){ return $this->leitos_clinica; }
	public function get_leitos_cirurgia (){ return $this->leitos_cirurgia; }
	public function get_leitos_obstetricia (){ return $this->leitos_obstetricia; }
	public function get_leitos_pediatria (){ return $this->leitos_pediatria; }
	public function get_leitos_psiquiatria (){ return $this->leitos_psiquiatria; }
	public function get_leitos_uti_adulto (){ return $this->leitos_uti_adulto; }
	public function get_leitos_uti_pediatrica (){ return $this->leitos_uti_pediatrica; }
	public function get_leitos_uti_neonatal (){ return $this->leitos_uti_neonatal; }
	public function get_leitos_unidade_interm_neo (){ return $this->leitos_unidade_interm_neo; }
	public function get_anatomopatologia (){ return $this->anatomopatologia; }
	public function get_colposcopia (){ return $this->colposcopia; }
	public function get_eletrocardiograma (){ return $this->eletrocardiograma; }
	public function get_fisioterapia (){ return $this->fisioterapia; }
	public function get_patologia_clinica (){ return $this->patologia_clinica; }
	public function get_radiodiagnostico (){ return $this->radiodiagnostico; }
	public function get_ultra_sonografia (){ return $this->ultra_sonografia; }
	public function get_ecocardiografia (){ return $this->ecocardiografia; }
	public function get_endoscopia_vdigestivas (){ return $this->endoscopia_vdigestivas; }
	public function get_hemoterapia_ambulatorial (){ return $this->hemoterapia_ambulatorial; }
	public function get_holter (){ return $this->holter; }
	public function get_litotripsia_extracorporea (){ return $this->litotripsia_extracorporea; }
	public function get_mamografia (){ return $this->mamografia; }
	public function get_psicoterapia (){ return $this->psicoterapia; }
	public function get_terapia_renalsubst (){ return $this->terapia_renalsubst; }
	public function get_teste_ergometrico (){ return $this->teste_ergometrico; }
	public function get_tomografia_computadorizada (){ return $this->tomografia_computadorizada; }
	public function get_atendimento_hospitaldia (){ return $this->atendimento_hospitaldia; }
	public function get_endoscopia_vaereas (){ return $this->endoscopia_vaereas; }
	public function get_hemodinamica (){ return $this->hemodinamica; }
	public function get_medicina_nuclear (){ return $this->medicina_nuclear; }
	public function get_quimioterapia (){ return $this->quimioterapia; }
	public function get_radiologia_intervencionista (){ return $this->radiologia_intervencionista; }
	public function get_radioterapia (){ return $this->radioterapia; }
	public function get_ressonancia_nmagnetica (){ return $this->ressonancia_nmagnetica; }
	public function get_ultrassonografia_doppler (){ return $this->ultrassonografia_doppler; }
	public function get_videocirurgia (){ return $this->videocirurgia; }
	public function get_odontologia_basica (){ return $this->odontologia_basica; }
	public function get_raiox_dentario (){ return $this->raiox_dentario; }
	public function get_endodontia (){ return $this->endodontia; }
	public function get_periodontia (){ return $this->periodontia; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_ativo ($ativo){ $this->ativo = $this->is_true($ativo); }
	public function set_razao_social ($razao_social){ $this->razao_social = str_replace("'", "", "".$razao_social); }
	public function set_no_fantasia ($no_fantasia){ $this->no_fantasia = str_replace("'", "", "".$no_fantasia); }
	public function set_tipo_estabelecimento ($tipo_estabelecimento){ $this->tipo_estabelecimento = str_replace("'", "", "".$tipo_estabelecimento); }
	public function set_convenio ($convenio){ $this->convenio = str_replace("'", "", "".$convenio); }
	public function set_natureza_juridica ($natureza_juridica){ $this->natureza_juridica = str_replace("'", "", "".$natureza_juridica); }
	public function set_atendimento_prestado ($atendimento_prestado){ $this->atendimento_prestado = str_replace("	", "", $atendimento_prestado); }
	public function set_cnpj ($cnpj){ $this->cnpj = str_replace("'", "", "".$cnpj); }
	public function set_cpf ($cpf){ $this->cpf = str_replace("'", "", "".$cpf); }
	public function set_cd_municipio ($cd_municipio){ $this->cd_municipio = intval($cd_municipio); }
	public function set_nm_municipio ($nm_municipio){ $this->nm_municipio = str_replace("'", "", "".$nm_municipio); }
	public function set_uf ($uf){ $this->uf = str_replace("'", "", "".$uf); }
	public function set_cep ($cep){ $this->cep = str_replace("'", "", "".$cep); }
	public function set_inclusao ($inclusao){ $this->inclusao = str_replace("'", "", "".$inclusao); }
	public function set_equipo_odontologico ($equipo_odontologico){ $this->equipo_odontologico = $this->is_true($equipo_odontologico); }
	public function set_cirurgiao_dentista ($cirurgiao_dentista){ $this->cirurgiao_dentista = $this->is_true($cirurgiao_dentista); }
	public function set_urgencia_emergencia ($urgencia_emergencia){ $this->urgencia_emergencia = $this->is_true($urgencia_emergencia); }
	public function set_leitos_clinica ($leitos_clinica){ $this->leitos_clinica = intval($leitos_clinica); }
	public function set_leitos_cirurgia ($leitos_cirurgia){ $this->leitos_cirurgia = intval($leitos_cirurgia); }
	public function set_leitos_obstetricia ($leitos_obstetricia){ $this->leitos_obstetricia = intval($leitos_obstetricia); }
	public function set_leitos_pediatria ($leitos_pediatria){ $this->leitos_pediatria = intval($leitos_pediatria); }
	public function set_leitos_psiquiatria ($leitos_psiquiatria){ $this->leitos_psiquiatria = intval($leitos_psiquiatria); }
	public function set_leitos_uti_adulto ($leitos_uti_adulto){ $this->leitos_uti_adulto = intval($leitos_uti_adulto); }
	public function set_leitos_uti_pediatrica ($leitos_uti_pediatrica){ $this->leitos_uti_pediatrica = intval($leitos_uti_pediatrica); }
	public function set_leitos_uti_neonatal ($leitos_uti_neonatal){ $this->leitos_uti_neonatal = intval($leitos_uti_neonatal); }
	public function set_leitos_unidade_interm_neo ($leitos_unidade_interm_neo){ $this->leitos_unidade_interm_neo = intval($leitos_unidade_interm_neo); }
	public function set_anatomopatologia ($anatomopatologia){ $this->anatomopatologia = $this->is_true($anatomopatologia); }
	public function set_colposcopia ($colposcopia){ $this->colposcopia = $this->is_true($colposcopia); }
	public function set_eletrocardiograma ($eletrocardiograma){ $this->eletrocardiograma = $this->is_true($eletrocardiograma); }
	public function set_fisioterapia ($fisioterapia){ $this->fisioterapia = $this->is_true($fisioterapia); }
	public function set_patologia_clinica ($patologia_clinica){ $this->patologia_clinica = $this->is_true($patologia_clinica); }
	public function set_radiodiagnostico ($radiodiagnostico){ $this->radiodiagnostico = $this->is_true($radiodiagnostico); }
	public function set_ultra_sonografia ($ultra_sonografia){ $this->ultra_sonografia = $this->is_true($ultra_sonografia); }
	public function set_ecocardiografia ($ecocardiografia){ $this->ecocardiografia = $this->is_true($ecocardiografia); }
	public function set_endoscopia_vdigestivas ($endoscopia_vdigestivas){ $this->endoscopia_vdigestivas = $this->is_true($endoscopia_vdigestivas); }
	public function set_hemoterapia_ambulatorial ($hemoterapia_ambulatorial){ $this->hemoterapia_ambulatorial = $this->is_true($hemoterapia_ambulatorial); }
	public function set_holter ($holter){ $this->holter = $this->is_true($holter); }
	public function set_litotripsia_extracorporea ($litotripsia_extracorporea){ $this->litotripsia_extracorporea = $this->is_true($litotripsia_extracorporea); }
	public function set_mamografia ($mamografia){ $this->mamografia = $this->is_true($mamografia); }
	public function set_psicoterapia ($psicoterapia){ $this->psicoterapia = $this->is_true($psicoterapia); }
	public function set_terapia_renalsubst ($terapia_renalsubst){ $this->terapia_renalsubst = $this->is_true($terapia_renalsubst); }
	public function set_teste_ergometrico ($teste_ergometrico){ $this->teste_ergometrico = $this->is_true($teste_ergometrico); }
	public function set_tomografia_computadorizada ($tomografia_computadorizada){ $this->tomografia_computadorizada = $this->is_true($tomografia_computadorizada); }
	public function set_atendimento_hospitaldia ($atendimento_hospitaldia){ $this->atendimento_hospitaldia = $this->is_true($atendimento_hospitaldia); }
	public function set_endoscopia_vaereas ($endoscopia_vaereas){ $this->endoscopia_vaereas = $this->is_true($endoscopia_vaereas); }
	public function set_hemodinamica ($hemodinamica){ $this->hemodinamica = $this->is_true($hemodinamica); }
	public function set_medicina_nuclear ($medicina_nuclear){ $this->medicina_nuclear = $this->is_true($medicina_nuclear); }
	public function set_quimioterapia ($quimioterapia){ $this->quimioterapia = $this->is_true($quimioterapia); }
	public function set_radiologia_intervencionista ($radiologia_intervencionista){ $this->radiologia_intervencionista = $this->is_true($radiologia_intervencionista); }
	public function set_radioterapia ($radioterapia){ $this->radioterapia = $this->is_true($radioterapia); }
	public function set_ressonancia_nmagnetica ($ressonancia_nmagnetica){ $this->ressonancia_nmagnetica = $this->is_true($ressonancia_nmagnetica); }
	public function set_ultrassonografia_doppler ($ultrassonografia_doppler){ $this->ultrassonografia_doppler = $this->is_true($ultrassonografia_doppler); }
	public function set_videocirurgia ($videocirurgia){ $this->videocirurgia = $this->is_true($videocirurgia); }
	public function set_odontologia_basica ($odontologia_basica){ $this->odontologia_basica = $this->is_true($odontologia_basica); }
	public function set_raiox_dentario ($raiox_dentario){ $this->raiox_dentario = $this->is_true($raiox_dentario); }
	public function set_endodontia ($endodontia){ $this->endodontia = $this->is_true($endodontia); }
	public function set_periodontia ($periodontia){ $this->periodontia = $this->is_true($periodontia); }
}
?>
