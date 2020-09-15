<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once('prestadora_DAO.php');
require_once('login_DAO.php');
require_once($path.'/cnes.php');

class CNES_DAO {
	// Propriedades
	private $DAOPrestadora;
	private $DAOLogin;

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_cnes (id, ativo, razao_social, no_fantasia, tipo_estabelecimento, convenio, natureza_juridica, atendimento_prestado, 
			cnpj, cpf, cd_municipio, nm_municipio, uf, cep, inclusao, equipo_odontologico, cirurgiao_dentista, urgencia_emergencia, leitos_clinica, 
			leitos_cirurgia, leitos_obstetricia, leitos_pediatria, leitos_psiquiatria, leitos_uti_adulto, leitos_uti_pediatrica, leitos_uti_neonatal, 
			leitos_unidade_interm_neo, anatomopatologia, colposcopia, eletrocardiograma, fisioterapia, patologia_clinica, radiodiagnostico, 
			ultra_sonografia, ecocardiografia, endoscopia_vdigestivas, hemoterapia_ambulatorial, holter, litotripsia_extracorporea, mamografia, 
			psicoterapia, terapia_renalsubst, teste_ergometrico, tomografia_computadorizada, atendimento_hospitaldia, endoscopia_vaereas, hemodinamica, 
			medicina_nuclear, quimioterapia, radiologia_intervencionista, radioterapia, ressonancia_nmagnetica, ultrassonografia_doppler, videocirurgia, 
			odontologia_basica, raiox_dentario, endodontia, periodontia) VALUES (
			".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
			".(is_null($objeto_recebido->get_ativo()) ? "null" : $objeto_recebido->get_ativo()).", 
			".(is_null($objeto_recebido->get_razao_social()) ? "null" : "'".$objeto_recebido->get_razao_social()."'").", 
			".(is_null($objeto_recebido->get_no_fantasia()) ? "null" : "'".$objeto_recebido->get_no_fantasia()."'").", 
			".(is_null($objeto_recebido->get_tipo_estabelecimento()) ? "null" : "'".$objeto_recebido->get_tipo_estabelecimento()."'").", 
			".(is_null($objeto_recebido->get_convenio()) ? "null" : "'".$objeto_recebido->get_convenio()."'").", 
			".(is_null($objeto_recebido->get_natureza_juridica()) ? "null" : "'".$objeto_recebido->get_natureza_juridica()."'").", 
			".(is_null($objeto_recebido->get_atendimento_prestado()) ? "null" : "'".$objeto_recebido->get_atendimento_prestado()."'").", 
			".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
			".(is_null($objeto_recebido->get_cpf()) ? "null" : "'".$objeto_recebido->get_cpf()."'").", 
			".(is_null($objeto_recebido->get_cd_municipio()) ? "null" : $objeto_recebido->get_cd_municipio()).", 
			".(is_null($objeto_recebido->get_nm_municipio()) ? "null" : "'".$objeto_recebido->get_nm_municipio()."'").", 
			".(is_null($objeto_recebido->get_uf()) ? "null" : "'".$objeto_recebido->get_uf()."'").", 
			".(is_null($objeto_recebido->get_cep()) ? "null" : "'".$objeto_recebido->get_cep()."'").", 
			".(is_null($objeto_recebido->get_inclusao()) ? "null" : "'".$objeto_recebido->get_inclusao()."'").", 
			".(is_null($objeto_recebido->get_equipo_odontologico()) ? "null" : $objeto_recebido->get_equipo_odontologico()).", 
			".(is_null($objeto_recebido->get_cirurgiao_dentista()) ? "null" : $objeto_recebido->get_cirurgiao_dentista()).", 
			".(is_null($objeto_recebido->get_urgencia_emergencia()) ? "null" : $objeto_recebido->get_urgencia_emergencia()).", 
			".(is_null($objeto_recebido->get_leitos_clinica()) ? "null" : $objeto_recebido->get_leitos_clinica()).", 
			".(is_null($objeto_recebido->get_leitos_cirurgia()) ? "null" : $objeto_recebido->get_leitos_cirurgia()).", 
			".(is_null($objeto_recebido->get_leitos_obstetricia()) ? "null" : $objeto_recebido->get_leitos_obstetricia()).", 
			".(is_null($objeto_recebido->get_leitos_pediatria()) ? "null" : $objeto_recebido->get_leitos_pediatria()).", 
			".(is_null($objeto_recebido->get_leitos_psiquiatria()) ? "null" : $objeto_recebido->get_leitos_psiquiatria()).", 
			".(is_null($objeto_recebido->get_leitos_uti_adulto()) ? "null" : $objeto_recebido->get_leitos_uti_adulto()).", 
			".(is_null($objeto_recebido->get_leitos_uti_pediatrica()) ? "null" : $objeto_recebido->get_leitos_uti_pediatrica()).", 
			".(is_null($objeto_recebido->get_leitos_uti_neonatal()) ? "null" : $objeto_recebido->get_leitos_uti_neonatal()).", 
			".(is_null($objeto_recebido->get_leitos_unidade_interm_neo()) ? "null" : $objeto_recebido->get_leitos_unidade_interm_neo()).", 
			".(is_null($objeto_recebido->get_anatomopatologia()) ? "null" : $objeto_recebido->get_anatomopatologia()).", 
			".(is_null($objeto_recebido->get_colposcopia()) ? "null" : $objeto_recebido->get_colposcopia()).", 
			".(is_null($objeto_recebido->get_eletrocardiograma()) ? "null" : $objeto_recebido->get_eletrocardiograma()).", 
			".(is_null($objeto_recebido->get_fisioterapia()) ? "null" : $objeto_recebido->get_fisioterapia()).", 
			".(is_null($objeto_recebido->get_patologia_clinica()) ? "null" : $objeto_recebido->get_patologia_clinica()).", 
			".(is_null($objeto_recebido->get_radiodiagnostico()) ? "null" : $objeto_recebido->get_radiodiagnostico()).", 
			".(is_null($objeto_recebido->get_ultra_sonografia()) ? "null" : $objeto_recebido->get_ultra_sonografia()).", 
			".(is_null($objeto_recebido->get_ecocardiografia()) ? "null" : $objeto_recebido->get_ecocardiografia()).", 
			".(is_null($objeto_recebido->get_endoscopia_vdigestivas()) ? "null" : $objeto_recebido->get_endoscopia_vdigestivas()).", 
			".(is_null($objeto_recebido->get_hemoterapia_ambulatorial()) ? "null" : $objeto_recebido->get_hemoterapia_ambulatorial()).", 
			".(is_null($objeto_recebido->get_holter()) ? "null" : $objeto_recebido->get_holter()).", 
			".(is_null($objeto_recebido->get_litotripsia_extracorporea()) ? "null" : $objeto_recebido->get_litotripsia_extracorporea()).", 
			".(is_null($objeto_recebido->get_mamografia()) ? "null" : $objeto_recebido->get_mamografia()).", 
			".(is_null($objeto_recebido->get_psicoterapia()) ? "null" : $objeto_recebido->get_psicoterapia()).", 
			".(is_null($objeto_recebido->get_terapia_renalsubst()) ? "null" : $objeto_recebido->get_terapia_renalsubst()).", 
			".(is_null($objeto_recebido->get_teste_ergometrico()) ? "null" : $objeto_recebido->get_teste_ergometrico()).", 
			".(is_null($objeto_recebido->get_tomografia_computadorizada()) ? "null" : $objeto_recebido->get_tomografia_computadorizada()).", 
			".(is_null($objeto_recebido->get_atendimento_hospitaldia()) ? "null" : $objeto_recebido->get_atendimento_hospitaldia()).", 
			".(is_null($objeto_recebido->get_endoscopia_vaereas()) ? "null" : $objeto_recebido->get_endoscopia_vaereas()).", 
			".(is_null($objeto_recebido->get_hemodinamica()) ? "null" : $objeto_recebido->get_hemodinamica()).", 
			".(is_null($objeto_recebido->get_medicina_nuclear()) ? "null" : $objeto_recebido->get_medicina_nuclear()).", 
			".(is_null($objeto_recebido->get_quimioterapia()) ? "null" : $objeto_recebido->get_quimioterapia()).", 
			".(is_null($objeto_recebido->get_radiologia_intervencionista()) ? "null" : $objeto_recebido->get_radiologia_intervencionista()).", 
			".(is_null($objeto_recebido->get_radioterapia()) ? "null" : $objeto_recebido->get_radioterapia()).", 
			".(is_null($objeto_recebido->get_ressonancia_nmagnetica()) ? "null" : $objeto_recebido->get_ressonancia_nmagnetica()).", 
			".(is_null($objeto_recebido->get_ultrassonografia_doppler()) ? "null" : $objeto_recebido->get_ultrassonografia_doppler()).", 
			".(is_null($objeto_recebido->get_videocirurgia()) ? "null" : $objeto_recebido->get_videocirurgia()).", 
			".(is_null($objeto_recebido->get_odontologia_basica()) ? "null" : $objeto_recebido->get_odontologia_basica()).", 
			".(is_null($objeto_recebido->get_raiox_dentario()) ? "null" : $objeto_recebido->get_raiox_dentario()).", 
			".(is_null($objeto_recebido->get_endodontia()) ? "null" : $objeto_recebido->get_endodontia()).", 
			".(is_null($objeto_recebido->get_periodontia()) ? "null" : $objeto_recebido->get_periodontia()).");";
		} else {
			if ($intro == true){
				$sql .= "INSERT INTO tb_cnes (id, ativo, razao_social, no_fantasia, tipo_estabelecimento, convenio, natureza_juridica, atendimento_prestado, 
				cnpj, cpf, cd_municipio, nm_municipio, uf, cep, inclusao, equipo_odontologico, cirurgiao_dentista, urgencia_emergencia, leitos_clinica, 
				leitos_cirurgia, leitos_obstetricia, leitos_pediatria, leitos_psiquiatria, leitos_uti_adulto, leitos_uti_pediatrica, leitos_uti_neonatal, 
				leitos_unidade_interm_neo, anatomopatologia, colposcopia, eletrocardiograma, fisioterapia, patologia_clinica, radiodiagnostico, 
				ultra_sonografia, ecocardiografia, endoscopia_vdigestivas, hemoterapia_ambulatorial, holter, litotripsia_extracorporea, mamografia, 
				psicoterapia, terapia_renalsubst, teste_ergometrico, tomografia_computadorizada, atendimento_hospitaldia, endoscopia_vaereas, hemodinamica, 
				medicina_nuclear, quimioterapia, radiologia_intervencionista, radioterapia, ressonancia_nmagnetica, ultrassonografia_doppler, videocirurgia, 
				odontologia_basica, raiox_dentario, endodontia, periodontia) VALUES ";
			}
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_id()) ? "null" : "'".$objeto_recebido->get_id()."'").", 
				".(is_null($objeto_recebido->get_ativo()) ? "null" : $objeto_recebido->get_ativo()).", 
				".(is_null($objeto_recebido->get_razao_social()) ? "null" : "'".$objeto_recebido->get_razao_social()."'").", 
				".(is_null($objeto_recebido->get_no_fantasia()) ? "null" : "'".$objeto_recebido->get_no_fantasia()."'").", 
				".(is_null($objeto_recebido->get_tipo_estabelecimento()) ? "null" : "'".$objeto_recebido->get_tipo_estabelecimento()."'").", 
				".(is_null($objeto_recebido->get_convenio()) ? "null" : "'".$objeto_recebido->get_convenio()."'").", 
				".(is_null($objeto_recebido->get_natureza_juridica()) ? "null" : "'".$objeto_recebido->get_natureza_juridica()."'").", 
				".(is_null($objeto_recebido->get_atendimento_prestado()) ? "null" : "'".$objeto_recebido->get_atendimento_prestado()."'").", 
				".(is_null($objeto_recebido->get_cnpj()) ? "null" : "'".$objeto_recebido->get_cnpj()."'").", 
				".(is_null($objeto_recebido->get_cpf()) ? "null" : "'".$objeto_recebido->get_cpf()."'").", 
				".(is_null($objeto_recebido->get_cd_municipio()) ? "null" : $objeto_recebido->get_cd_municipio()).", 
				".(is_null($objeto_recebido->get_nm_municipio()) ? "null" : "'".$objeto_recebido->get_nm_municipio()."'").", 
				".(is_null($objeto_recebido->get_uf()) ? "null" : "'".$objeto_recebido->get_uf()."'").", 
				".(is_null($objeto_recebido->get_cep()) ? "null" : "'".$objeto_recebido->get_cep()."'").", 
				".(is_null($objeto_recebido->get_inclusao()) ? "null" : "'".$objeto_recebido->get_inclusao()."'").", 
				".(is_null($objeto_recebido->get_equipo_odontologico()) ? "null" : $objeto_recebido->get_equipo_odontologico()).", 
				".(is_null($objeto_recebido->get_cirurgiao_dentista()) ? "null" : $objeto_recebido->get_cirurgiao_dentista()).", 
				".(is_null($objeto_recebido->get_urgencia_emergencia()) ? "null" : $objeto_recebido->get_urgencia_emergencia()).", 
				".(is_null($objeto_recebido->get_leitos_clinica()) ? "null" : $objeto_recebido->get_leitos_clinica()).", 
				".(is_null($objeto_recebido->get_leitos_cirurgia()) ? "null" : $objeto_recebido->get_leitos_cirurgia()).", 
				".(is_null($objeto_recebido->get_leitos_obstetricia()) ? "null" : $objeto_recebido->get_leitos_obstetricia()).", 
				".(is_null($objeto_recebido->get_leitos_pediatria()) ? "null" : $objeto_recebido->get_leitos_pediatria()).", 
				".(is_null($objeto_recebido->get_leitos_psiquiatria()) ? "null" : $objeto_recebido->get_leitos_psiquiatria()).", 
				".(is_null($objeto_recebido->get_leitos_uti_adulto()) ? "null" : $objeto_recebido->get_leitos_uti_adulto()).", 
				".(is_null($objeto_recebido->get_leitos_uti_pediatrica()) ? "null" : $objeto_recebido->get_leitos_uti_pediatrica()).", 
				".(is_null($objeto_recebido->get_leitos_uti_neonatal()) ? "null" : $objeto_recebido->get_leitos_uti_neonatal()).", 
				".(is_null($objeto_recebido->get_leitos_unidade_interm_neo()) ? "null" : $objeto_recebido->get_leitos_unidade_interm_neo()).", 
				".(is_null($objeto_recebido->get_anatomopatologia()) ? "null" : $objeto_recebido->get_anatomopatologia()).", 
				".(is_null($objeto_recebido->get_colposcopia()) ? "null" : $objeto_recebido->get_colposcopia()).", 
				".(is_null($objeto_recebido->get_eletrocardiograma()) ? "null" : $objeto_recebido->get_eletrocardiograma()).", 
				".(is_null($objeto_recebido->get_fisioterapia()) ? "null" : $objeto_recebido->get_fisioterapia()).", 
				".(is_null($objeto_recebido->get_patologia_clinica()) ? "null" : $objeto_recebido->get_patologia_clinica()).", 
				".(is_null($objeto_recebido->get_radiodiagnostico()) ? "null" : $objeto_recebido->get_radiodiagnostico()).", 
				".(is_null($objeto_recebido->get_ultra_sonografia()) ? "null" : $objeto_recebido->get_ultra_sonografia()).", 
				".(is_null($objeto_recebido->get_ecocardiografia()) ? "null" : $objeto_recebido->get_ecocardiografia()).", 
				".(is_null($objeto_recebido->get_endoscopia_vdigestivas()) ? "null" : $objeto_recebido->get_endoscopia_vdigestivas()).", 
				".(is_null($objeto_recebido->get_hemoterapia_ambulatorial()) ? "null" : $objeto_recebido->get_hemoterapia_ambulatorial()).", 
				".(is_null($objeto_recebido->get_holter()) ? "null" : $objeto_recebido->get_holter()).", 
				".(is_null($objeto_recebido->get_litotripsia_extracorporea()) ? "null" : $objeto_recebido->get_litotripsia_extracorporea()).", 
				".(is_null($objeto_recebido->get_mamografia()) ? "null" : $objeto_recebido->get_mamografia()).", 
				".(is_null($objeto_recebido->get_psicoterapia()) ? "null" : $objeto_recebido->get_psicoterapia()).", 
				".(is_null($objeto_recebido->get_terapia_renalsubst()) ? "null" : $objeto_recebido->get_terapia_renalsubst()).", 
				".(is_null($objeto_recebido->get_teste_ergometrico()) ? "null" : $objeto_recebido->get_teste_ergometrico()).", 
				".(is_null($objeto_recebido->get_tomografia_computadorizada()) ? "null" : $objeto_recebido->get_tomografia_computadorizada()).", 
				".(is_null($objeto_recebido->get_atendimento_hospitaldia()) ? "null" : $objeto_recebido->get_atendimento_hospitaldia()).", 
				".(is_null($objeto_recebido->get_endoscopia_vaereas()) ? "null" : $objeto_recebido->get_endoscopia_vaereas()).", 
				".(is_null($objeto_recebido->get_hemodinamica()) ? "null" : $objeto_recebido->get_hemodinamica()).", 
				".(is_null($objeto_recebido->get_medicina_nuclear()) ? "null" : $objeto_recebido->get_medicina_nuclear()).", 
				".(is_null($objeto_recebido->get_quimioterapia()) ? "null" : $objeto_recebido->get_quimioterapia()).", 
				".(is_null($objeto_recebido->get_radiologia_intervencionista()) ? "null" : $objeto_recebido->get_radiologia_intervencionista()).", 
				".(is_null($objeto_recebido->get_radioterapia()) ? "null" : $objeto_recebido->get_radioterapia()).", 
				".(is_null($objeto_recebido->get_ressonancia_nmagnetica()) ? "null" : $objeto_recebido->get_ressonancia_nmagnetica()).", 
				".(is_null($objeto_recebido->get_ultrassonografia_doppler()) ? "null" : $objeto_recebido->get_ultrassonografia_doppler()).", 
				".(is_null($objeto_recebido->get_videocirurgia()) ? "null" : $objeto_recebido->get_videocirurgia()).", 
				".(is_null($objeto_recebido->get_odontologia_basica()) ? "null" : $objeto_recebido->get_odontologia_basica()).", 
				".(is_null($objeto_recebido->get_raiox_dentario()) ? "null" : $objeto_recebido->get_raiox_dentario()).", 
				".(is_null($objeto_recebido->get_endodontia()) ? "null" : $objeto_recebido->get_endodontia()).", 
				".(is_null($objeto_recebido->get_periodontia()) ? "null" : $objeto_recebido->get_periodontia()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_cnes SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
		".(is_null($objeto_recebido->get_ativo()) ? "" : ", ativo = ".$objeto_recebido->get_ativo())."
		".(is_null($objeto_recebido->get_razao_social()) ? "" : ", razao_social = '".$objeto_recebido->get_razao_social()."'")."
		".(is_null($objeto_recebido->get_no_fantasia()) ? "" : ", no_fantasia = '".$objeto_recebido->get_no_fantasia()."'")."
		".(is_null($objeto_recebido->get_tipo_estabelecimento()) ? "" : ", tipo_estabelecimento = '".$objeto_recebido->get_tipo_estabelecimento()."'")."
		".(is_null($objeto_recebido->get_convenio()) ? "" : ", convenio = '".$objeto_recebido->get_convenio()."'")."
		".(is_null($objeto_recebido->get_natureza_juridica()) ? "" : ", natureza_juridica = '".$objeto_recebido->get_natureza_juridica()."'")."
		".(is_null($objeto_recebido->get_atendimento_prestado()) ? "" : ", atendimento_prestado = '".$objeto_recebido->get_atendimento_prestado()."'")."
		".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
		".(is_null($objeto_recebido->get_cpf()) ? "" : ", cpf = '".$objeto_recebido->get_cpf()."'")."
		".(is_null($objeto_recebido->get_cd_municipio()) ? "" : ", cd_municipio = ".$objeto_recebido->get_cd_municipio())."
		".(is_null($objeto_recebido->get_nm_municipio()) ? "" : ", nm_municipio = '".$objeto_recebido->get_nm_municipio()."'")."
		".(is_null($objeto_recebido->get_uf()) ? "" : ", uf = '".$objeto_recebido->get_uf()."'")."
		".(is_null($objeto_recebido->get_cep()) ? "" : ", cep = '".$objeto_recebido->get_cep()."'")."
		".(is_null($objeto_recebido->get_inclusao()) ? "" : ", inclusao = '".$objeto_recebido->get_inclusao()."'")."
		".(is_null($objeto_recebido->get_equipo_odontologico()) ? "" : ", equipo_odontologico = ".$objeto_recebido->get_equipo_odontologico())."
		".(is_null($objeto_recebido->get_cirurgiao_dentista()) ? "" : ", cirurgiao_dentista = ".$objeto_recebido->get_cirurgiao_dentista())."
		".(is_null($objeto_recebido->get_urgencia_emergencia()) ? "" : ", urgencia_emergencia = ".$objeto_recebido->get_urgencia_emergencia())."
		".(is_null($objeto_recebido->get_leitos_clinica()) ? "" : ", leitos_clinica = ".$objeto_recebido->get_leitos_clinica())."
		".(is_null($objeto_recebido->get_leitos_cirurgia()) ? "" : ", leitos_cirurgia = ".$objeto_recebido->get_leitos_cirurgia())."
		".(is_null($objeto_recebido->get_leitos_obstetricia()) ? "" : ", leitos_obstetricia = ".$objeto_recebido->get_leitos_obstetricia())."
		".(is_null($objeto_recebido->get_leitos_pediatria()) ? "" : ", leitos_pediatria = ".$objeto_recebido->get_leitos_pediatria())."
		".(is_null($objeto_recebido->get_leitos_psiquiatria()) ? "" : ", leitos_psiquiatria = ".$objeto_recebido->get_leitos_psiquiatria())."
		".(is_null($objeto_recebido->get_leitos_uti_adulto()) ? "" : ", leitos_uti_adulto = ".$objeto_recebido->get_leitos_uti_adulto())."
		".(is_null($objeto_recebido->get_leitos_uti_pediatrica()) ? "" : ", leitos_uti_pediatrica = ".$objeto_recebido->get_leitos_uti_pediatrica())."
		".(is_null($objeto_recebido->get_leitos_uti_neonatal()) ? "" : ", leitos_uti_neonatal = ".$objeto_recebido->get_leitos_uti_neonatal())."
		".(is_null($objeto_recebido->get_leitos_unidade_interm_neo()) ? "" : ", leitos_unidade_interm_neo = ".$objeto_recebido->get_leitos_unidade_interm_neo())."
		".(is_null($objeto_recebido->get_anatomopatologia()) ? "" : ", anatomopatologia = ".$objeto_recebido->get_anatomopatologia())."
		".(is_null($objeto_recebido->get_colposcopia()) ? "" : ", colposcopia = ".$objeto_recebido->get_colposcopia())."
		".(is_null($objeto_recebido->get_eletrocardiograma()) ? "" : ", eletrocardiograma = ".$objeto_recebido->get_eletrocardiograma())."
		".(is_null($objeto_recebido->get_fisioterapia()) ? "" : ", fisioterapia = ".$objeto_recebido->get_fisioterapia())."
		".(is_null($objeto_recebido->get_patologia_clinica()) ? "" : ", patologia_clinica = ".$objeto_recebido->get_patologia_clinica())."
		".(is_null($objeto_recebido->get_radiodiagnostico()) ? "" : ", radiodiagnostico = ".$objeto_recebido->get_radiodiagnostico())."
		".(is_null($objeto_recebido->get_ultra_sonografia()) ? "" : ", ultra_sonografia = ".$objeto_recebido->get_ultra_sonografia())."
		".(is_null($objeto_recebido->get_ecocardiografia()) ? "" : ", ecocardiografia = ".$objeto_recebido->get_ecocardiografia())."
		".(is_null($objeto_recebido->get_endoscopia_vdigestivas()) ? "" : ", endoscopia_vdigestivas = ".$objeto_recebido->get_endoscopia_vdigestivas())."
		".(is_null($objeto_recebido->get_hemoterapia_ambulatorial()) ? "" : ", hemoterapia_ambulatorial = ".$objeto_recebido->get_hemoterapia_ambulatorial())."
		".(is_null($objeto_recebido->get_holter()) ? "" : ", holter = ".$objeto_recebido->get_holter())."
		".(is_null($objeto_recebido->get_litotripsia_extracorporea()) ? "" : ", litotripsia_extracorporea = ".$objeto_recebido->get_litotripsia_extracorporea())."
		".(is_null($objeto_recebido->get_mamografia()) ? "" : ", mamografia = ".$objeto_recebido->get_mamografia())."
		".(is_null($objeto_recebido->get_psicoterapia()) ? "" : ", psicoterapia = ".$objeto_recebido->get_psicoterapia())."
		".(is_null($objeto_recebido->get_terapia_renalsubst()) ? "" : ", terapia_renalsubst = ".$objeto_recebido->get_terapia_renalsubst())."
		".(is_null($objeto_recebido->get_teste_ergometrico()) ? "" : ", teste_ergometrico = ".$objeto_recebido->get_teste_ergometrico())."
		".(is_null($objeto_recebido->get_tomografia_computadorizada()) ? "" : ", tomografia_computadorizada = ".$objeto_recebido->get_tomografia_computadorizada())."
		".(is_null($objeto_recebido->get_atendimento_hospitaldia()) ? "" : ", atendimento_hospitaldia = ".$objeto_recebido->get_atendimento_hospitaldia())."
		".(is_null($objeto_recebido->get_endoscopia_vaereas()) ? "" : ", endoscopia_vaereas = ".$objeto_recebido->get_endoscopia_vaereas())."
		".(is_null($objeto_recebido->get_hemodinamica()) ? "" : ", hemodinamica = ".$objeto_recebido->get_hemodinamica())."
		".(is_null($objeto_recebido->get_medicina_nuclear()) ? "" : ", medicina_nuclear = ".$objeto_recebido->get_medicina_nuclear())."
		".(is_null($objeto_recebido->get_quimioterapia()) ? "" : ", quimioterapia = ".$objeto_recebido->get_quimioterapia())."
		".(is_null($objeto_recebido->get_radiologia_intervencionista()) ? "" : ", radiologia_intervencionista = ".$objeto_recebido->get_radiologia_intervencionista())."
		".(is_null($objeto_recebido->get_radioterapia()) ? "" : ", radioterapia = ".$objeto_recebido->get_radioterapia())."
		".(is_null($objeto_recebido->get_ressonancia_nmagnetica()) ? "" : ", ressonancia_nmagnetica = ".$objeto_recebido->get_ressonancia_nmagnetica())."
		".(is_null($objeto_recebido->get_ultrassonografia_doppler()) ? "" : ", ultrassonografia_doppler = ".$objeto_recebido->get_ultrassonografia_doppler())."
		".(is_null($objeto_recebido->get_videocirurgia()) ? "" : ", videocirurgia = ".$objeto_recebido->get_videocirurgia())."
		".(is_null($objeto_recebido->get_odontologia_basica()) ? "" : ", odontologia_basica = ".$objeto_recebido->get_odontologia_basica())."
		".(is_null($objeto_recebido->get_raiox_dentario()) ? "" : ", raiox_dentario = ".$objeto_recebido->get_raiox_dentario())."
		".(is_null($objeto_recebido->get_endodontia()) ? "" : ", endodontia = ".$objeto_recebido->get_endodontia())."
		".(is_null($objeto_recebido->get_periodontia()) ? "" : ", periodontia = ".$objeto_recebido->get_periodontia())."
		WHERE id = '".$objeto_recebido->get_id()."';";
		return $sql;
	}

	public function get_updateap ($objeto_recebido){
		$sql = "UPDATE tb_cnes SET atendimento_prestado = CONCAT (atendimento_prestado, 
		".(is_null($objeto_recebido->get_atendimento_prestado()) ? "''" : "', ".$objeto_recebido->get_atendimento_prestado()."'").") 
		WHERE id = '".$objeto_recebido->get_id()."';";
		return $sql;
	}

	public function insert ($objeto_recebido, $database = null){
		$sql = $this->get_insert ($objeto_recebido);
		$query_result = exec_query ($sql, false, $database);

		$id = -1;
		if ($query_result){ $id = $objeto_recebido->get_id(); }
		return $id;
	}

	public function unmodified ($objeto_recebido, $database = null){
		$dbh = $database;
		$result = false;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT COUNT(id) AS count FROM tb_cnes WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull (id)" : "id = '".$objeto_recebido->get_id()."'")." AND
		".(is_null($objeto_recebido->get_ativo()) ? "isnull (ativo)" : "ativo = ".$objeto_recebido->get_ativo())." AND
		".(is_null($objeto_recebido->get_razao_social()) ? "isnull (razao_social)" : "razao_social = '".$objeto_recebido->get_razao_social()."'")." AND
		".(is_null($objeto_recebido->get_no_fantasia()) ? "isnull (no_fantasia)" : "no_fantasia = '".$objeto_recebido->get_no_fantasia()."'")." AND
		".(is_null($objeto_recebido->get_tipo_estabelecimento()) ? "isnull (tipo_estabelecimento)" : "tipo_estabelecimento = '".$objeto_recebido->get_tipo_estabelecimento()."'")." AND
		".(is_null($objeto_recebido->get_convenio()) ? "isnull (convenio)" : "convenio = '".$objeto_recebido->get_convenio()."'")." AND
		".(is_null($objeto_recebido->get_natureza_juridica()) ? "isnull (natureza_juridica)" : "natureza_juridica = '".$objeto_recebido->get_natureza_juridica()."'")." AND
		".(is_null($objeto_recebido->get_atendimento_prestado()) ? "isnull (atendimento_prestado)" : "atendimento_prestado = '".$objeto_recebido->get_atendimento_prestado()."'")." AND
		".(is_null($objeto_recebido->get_cnpj()) ? "isnull (cnpj)" : "cnpj = '".$objeto_recebido->get_cnpj()."'")." AND
		".(is_null($objeto_recebido->get_cpf()) ? "isnull (cpf)" : "cpf = '".$objeto_recebido->get_cpf()."'")." AND
		".(is_null($objeto_recebido->get_cd_municipio()) ? "isnull (cd_municipio)" : "cd_municipio = ".$objeto_recebido->get_cd_municipio())." AND
		".(is_null($objeto_recebido->get_nm_municipio()) ? "isnull (nm_municipio)" : "nm_municipio = '".$objeto_recebido->get_nm_municipio()."'")." AND
		".(is_null($objeto_recebido->get_uf()) ? "isnull (uf)" : "uf = '".$objeto_recebido->get_uf()."'")." AND
		".(is_null($objeto_recebido->get_cep()) ? "isnull (cep)" : "cep = '".$objeto_recebido->get_cep()."'")." AND
		".(is_null($objeto_recebido->get_inclusao()) ? "isnull (inclusao)" : "inclusao = '".$objeto_recebido->get_inclusao()."'")." AND
		".(is_null($objeto_recebido->get_equipo_odontologico()) ? "isnull (equipo_odontologico)" : "equipo_odontologico = ".$objeto_recebido->get_equipo_odontologico())." AND
		".(is_null($objeto_recebido->get_cirurgiao_dentista()) ? "isnull (cirurgiao_dentista)" : "cirurgiao_dentista = ".$objeto_recebido->get_cirurgiao_dentista())." AND
		".(is_null($objeto_recebido->get_urgencia_emergencia()) ? "isnull (urgencia_emergencia)" : "urgencia_emergencia = ".$objeto_recebido->get_urgencia_emergencia())." AND
		".(is_null($objeto_recebido->get_leitos_clinica()) ? "isnull (leitos_clinica)" : "leitos_clinica = ".$objeto_recebido->get_leitos_clinica())." AND
		".(is_null($objeto_recebido->get_leitos_cirurgia()) ? "isnull (leitos_cirurgia)" : "leitos_cirurgia = ".$objeto_recebido->get_leitos_cirurgia())." AND
		".(is_null($objeto_recebido->get_leitos_obstetricia()) ? "isnull (leitos_obstetricia)" : "leitos_obstetricia = ".$objeto_recebido->get_leitos_obstetricia())." AND
		".(is_null($objeto_recebido->get_leitos_pediatria()) ? "isnull (leitos_pediatria)" : "leitos_pediatria = ".$objeto_recebido->get_leitos_pediatria())." AND
		".(is_null($objeto_recebido->get_leitos_psiquiatria()) ? "isnull (leitos_psiquiatria)" : "leitos_psiquiatria = ".$objeto_recebido->get_leitos_psiquiatria())." AND
		".(is_null($objeto_recebido->get_leitos_uti_adulto()) ? "isnull (leitos_uti_adulto)" : "leitos_uti_adulto = ".$objeto_recebido->get_leitos_uti_adulto())." AND
		".(is_null($objeto_recebido->get_leitos_uti_pediatrica()) ? "isnull (leitos_uti_pediatrica)" : "leitos_uti_pediatrica = ".$objeto_recebido->get_leitos_uti_pediatrica())." AND
		".(is_null($objeto_recebido->get_leitos_uti_neonatal()) ? "isnull (leitos_uti_neonatal)" : "leitos_uti_neonatal = ".$objeto_recebido->get_leitos_uti_neonatal())." AND
		".(is_null($objeto_recebido->get_leitos_unidade_interm_neo()) ? "isnull (leitos_unidade_interm_neo)" : "leitos_unidade_interm_neo = ".$objeto_recebido->get_leitos_unidade_interm_neo())." AND
		".(is_null($objeto_recebido->get_anatomopatologia()) ? "isnull (anatomopatologia)" : "anatomopatologia = ".$objeto_recebido->get_anatomopatologia())." AND
		".(is_null($objeto_recebido->get_colposcopia()) ? "isnull (colposcopia)" : "colposcopia = ".$objeto_recebido->get_colposcopia())." AND
		".(is_null($objeto_recebido->get_eletrocardiograma()) ? "isnull (eletrocardiograma)" : "eletrocardiograma = ".$objeto_recebido->get_eletrocardiograma())." AND
		".(is_null($objeto_recebido->get_fisioterapia()) ? "isnull (fisioterapia)" : "fisioterapia = ".$objeto_recebido->get_fisioterapia())." AND
		".(is_null($objeto_recebido->get_patologia_clinica()) ? "isnull (patologia_clinica)" : "patologia_clinica = ".$objeto_recebido->get_patologia_clinica())." AND
		".(is_null($objeto_recebido->get_radiodiagnostico()) ? "isnull (radiodiagnostico)" : "radiodiagnostico = ".$objeto_recebido->get_radiodiagnostico())." AND
		".(is_null($objeto_recebido->get_ultra_sonografia()) ? "isnull (ultra_sonografia)" : "ultra_sonografia = ".$objeto_recebido->get_ultra_sonografia())." AND
		".(is_null($objeto_recebido->get_ecocardiografia()) ? "isnull (ecocardiografia)" : "ecocardiografia = ".$objeto_recebido->get_ecocardiografia())." AND
		".(is_null($objeto_recebido->get_endoscopia_vdigestivas()) ? "isnull (endoscopia_vdigestivas)" : "endoscopia_vdigestivas = ".$objeto_recebido->get_endoscopia_vdigestivas())." AND
		".(is_null($objeto_recebido->get_hemoterapia_ambulatorial()) ? "isnull (hemoterapia_ambulatorial)" : "hemoterapia_ambulatorial = ".$objeto_recebido->get_hemoterapia_ambulatorial())." AND
		".(is_null($objeto_recebido->get_holter()) ? "isnull (holter)" : "holter = ".$objeto_recebido->get_holter())." AND
		".(is_null($objeto_recebido->get_litotripsia_extracorporea()) ? "isnull (litotripsia_extracorporea)" : "litotripsia_extracorporea = ".$objeto_recebido->get_litotripsia_extracorporea())." AND
		".(is_null($objeto_recebido->get_mamografia()) ? "isnull (mamografia)" : "mamografia = ".$objeto_recebido->get_mamografia())." AND
		".(is_null($objeto_recebido->get_psicoterapia()) ? "isnull (psicoterapia)" : "psicoterapia = ".$objeto_recebido->get_psicoterapia())." AND
		".(is_null($objeto_recebido->get_terapia_renalsubst()) ? "isnull (terapia_renalsubst)" : "terapia_renalsubst = ".$objeto_recebido->get_terapia_renalsubst())." AND
		".(is_null($objeto_recebido->get_teste_ergometrico()) ? "isnull (teste_ergometrico)" : "teste_ergometrico = ".$objeto_recebido->get_teste_ergometrico())." AND
		".(is_null($objeto_recebido->get_tomografia_computadorizada()) ? "isnull (tomografia_computadorizada)" : "tomografia_computadorizada = ".$objeto_recebido->get_tomografia_computadorizada())." AND
		".(is_null($objeto_recebido->get_atendimento_hospitaldia()) ? "isnull (atendimento_hospitaldia)" : "atendimento_hospitaldia = ".$objeto_recebido->get_atendimento_hospitaldia())." AND
		".(is_null($objeto_recebido->get_endoscopia_vaereas()) ? "isnull (endoscopia_vaereas)" : "endoscopia_vaereas = ".$objeto_recebido->get_endoscopia_vaereas())." AND
		".(is_null($objeto_recebido->get_hemodinamica()) ? "isnull (hemodinamica)" : "hemodinamica = ".$objeto_recebido->get_hemodinamica())." AND
		".(is_null($objeto_recebido->get_medicina_nuclear()) ? "isnull (medicina_nuclear)" : "medicina_nuclear = ".$objeto_recebido->get_medicina_nuclear())." AND
		".(is_null($objeto_recebido->get_quimioterapia()) ? "isnull (quimioterapia)" : "quimioterapia = ".$objeto_recebido->get_quimioterapia())." AND
		".(is_null($objeto_recebido->get_radiologia_intervencionista()) ? "isnull (radiologia_intervencionista)" : "radiologia_intervencionista = ".$objeto_recebido->get_radiologia_intervencionista())." AND
		".(is_null($objeto_recebido->get_radioterapia()) ? "isnull (radioterapia)" : "radioterapia = ".$objeto_recebido->get_radioterapia())." AND
		".(is_null($objeto_recebido->get_ressonancia_nmagnetica()) ? "isnull (ressonancia_nmagnetica)" : "ressonancia_nmagnetica = ".$objeto_recebido->get_ressonancia_nmagnetica())." AND
		".(is_null($objeto_recebido->get_ultrassonografia_doppler()) ? "isnull (ultrassonografia_doppler)" : "ultrassonografia_doppler = ".$objeto_recebido->get_ultrassonografia_doppler())." AND
		".(is_null($objeto_recebido->get_videocirurgia()) ? "isnull (videocirurgia)" : "videocirurgia = ".$objeto_recebido->get_videocirurgia())." AND
		".(is_null($objeto_recebido->get_odontologia_basica()) ? "isnull (odontologia_basica)" : "odontologia_basica = ".$objeto_recebido->get_odontologia_basica())." AND
		".(is_null($objeto_recebido->get_raiox_dentario()) ? "isnull (raiox_dentario)" : "raiox_dentario = ".$objeto_recebido->get_raiox_dentario())." AND
		".(is_null($objeto_recebido->get_endodontia()) ? "isnull (endodontia)" : "endodontia = ".$objeto_recebido->get_endodontia())." AND
		".(is_null($objeto_recebido->get_periodontia()) ? "isnull (periodontia)" : "periodontia = ".$objeto_recebido->get_periodontia()).";";
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
		$DAOLogin = new Login_DAO();
		$prestadoras = $DAOPrestadora->select_by_CNES ($id, $dbh);
		$logins = $DAOLogin->select_by_CNES ($id, $dbh);
		foreach ($prestadoras as $prestadora){ $DAOPrestadora->delete ($prestadora->get_id(), $dbh); }
		foreach ($logins as $login){ $DAOLogin->delete ($login->get_id(), $dbh); }
		$sql = "DELETE FROM tb_cnes WHERE id = '".$id."';";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh->close(); }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new CNES();
		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["ativo"])){ $new_object->set_ativo($row["ativo"]); }
		if (isset($row["razao_social"])){ $new_object->set_razao_social($row["razao_social"]); }
		if (isset($row["no_fantasia"])){ $new_object->set_no_fantasia($row["no_fantasia"]); }
		if (isset($row["tipo_estabelecimento"])){ $new_object->set_tipo_estabelecimento($row["tipo_estabelecimento"]); }
		if (isset($row["convenio"])){ $new_object->set_convenio($row["convenio"]); }
		if (isset($row["natureza_juridica"])){ $new_object->set_natureza_juridica($row["natureza_juridica"]); }
		if (isset($row["atendimento_prestado"])){ $new_object->set_atendimento_prestado($row["atendimento_prestado"]); }
		if (isset($row["cnpj"])){ $new_object->set_cnpj($row["cnpj"]); }
		if (isset($row["cpf"])){ $new_object->set_cpf($row["cpf"]); }
		if (isset($row["cd_municipio"])){ $new_object->set_cd_municipio($row["cd_municipio"]); }
		if (isset($row["nm_municipio"])){ $new_object->set_nm_municipio($row["nm_municipio"]); }
		if (isset($row["uf"])){ $new_object->set_uf($row["uf"]); }
		if (isset($row["cep"])){ $new_object->set_cep($row["cep"]); }
		if (isset($row["inclusao"])){ $new_object->set_inclusao($row["inclusao"]); }
		if (isset($row["equipo_odontologico"])){ $new_object->set_equipo_odontologico($row["equipo_odontologico"]); }
		if (isset($row["cirurgiao_dentista"])){ $new_object->set_cirurgiao_dentista($row["cirurgiao_dentista"]); }
		if (isset($row["urgencia_emergencia"])){ $new_object->set_urgencia_emergencia($row["urgencia_emergencia"]); }
		if (isset($row["leitos_clinica"])){ $new_object->set_leitos_clinica($row["leitos_clinica"]); }
		if (isset($row["leitos_cirurgia"])){ $new_object->set_leitos_cirurgia($row["leitos_cirurgia"]); }
		if (isset($row["leitos_obstetricia"])){ $new_object->set_leitos_obstetricia($row["leitos_obstetricia"]); }
		if (isset($row["leitos_pediatria"])){ $new_object->set_leitos_pediatria($row["leitos_pediatria"]); }
		if (isset($row["leitos_psiquiatria"])){ $new_object->set_leitos_psiquiatria($row["leitos_psiquiatria"]); }
		if (isset($row["leitos_uti_adulto"])){ $new_object->set_leitos_uti_adulto($row["leitos_uti_adulto"]); }
		if (isset($row["leitos_uti_pediatrica"])){ $new_object->set_leitos_uti_pediatrica($row["leitos_uti_pediatrica"]); }
		if (isset($row["leitos_uti_neonatal"])){ $new_object->set_leitos_uti_neonatal($row["leitos_uti_neonatal"]); }
		if (isset($row["leitos_unidade_interm_neo"])){ $new_object->set_leitos_unidade_interm_neo($row["leitos_unidade_interm_neo"]); }
		if (isset($row["anatomopatologia"])){ $new_object->set_anatomopatologia($row["anatomopatologia"]); }
		if (isset($row["colposcopia"])){ $new_object->set_colposcopia($row["colposcopia"]); }
		if (isset($row["eletrocardiograma"])){ $new_object->set_eletrocardiograma($row["eletrocardiograma"]); }
		if (isset($row["fisioterapia"])){ $new_object->set_fisioterapia($row["fisioterapia"]); }
		if (isset($row["patologia_clinica"])){ $new_object->set_patologia_clinica($row["patologia_clinica"]); }
		if (isset($row["radiodiagnostico"])){ $new_object->set_radiodiagnostico($row["radiodiagnostico"]); }
		if (isset($row["ultra_sonografia"])){ $new_object->set_ultra_sonografia($row["ultra_sonografia"]); }
		if (isset($row["ecocardiografia"])){ $new_object->set_ecocardiografia($row["ecocardiografia"]); }
		if (isset($row["endoscopia_vdigestivas"])){ $new_object->set_endoscopia_vdigestivas($row["endoscopia_vdigestivas"]); }
		if (isset($row["hemoterapia_ambulatorial"])){ $new_object->set_hemoterapia_ambulatorial($row["hemoterapia_ambulatorial"]); }
		if (isset($row["holter"])){ $new_object->set_holter($row["holter"]); }
		if (isset($row["litotripsia_extracorporea"])){ $new_object->set_litotripsia_extracorporea($row["litotripsia_extracorporea"]); }
		if (isset($row["mamografia"])){ $new_object->set_mamografia($row["mamografia"]); }
		if (isset($row["psicoterapia"])){ $new_object->set_psicoterapia($row["psicoterapia"]); }
		if (isset($row["terapia_renalsubst"])){ $new_object->set_terapia_renalsubst($row["terapia_renalsubst"]); }
		if (isset($row["teste_ergometrico"])){ $new_object->set_teste_ergometrico($row["teste_ergometrico"]); }
		if (isset($row["tomografia_computadorizada"])){ $new_object->set_tomografia_computadorizada($row["tomografia_computadorizada"]); }
		if (isset($row["atendimento_hospitaldia"])){ $new_object->set_atendimento_hospitaldia($row["atendimento_hospitaldia"]); }
		if (isset($row["endoscopia_vaereas"])){ $new_object->set_endoscopia_vaereas($row["endoscopia_vaereas"]); }
		if (isset($row["hemodinamica"])){ $new_object->set_hemodinamica($row["hemodinamica"]); }
		if (isset($row["medicina_nuclear"])){ $new_object->set_medicina_nuclear($row["medicina_nuclear"]); }
		if (isset($row["quimioterapia"])){ $new_object->set_quimioterapia($row["quimioterapia"]); }
		if (isset($row["radiologia_intervencionista"])){ $new_object->set_radiologia_intervencionista($row["radiologia_intervencionista"]); }
		if (isset($row["radioterapia"])){ $new_object->set_radioterapia($row["radioterapia"]); }
		if (isset($row["ressonancia_nmagnetica"])){ $new_object->set_ressonancia_nmagnetica($row["ressonancia_nmagnetica"]); }
		if (isset($row["ultrassonografia_doppler"])){ $new_object->set_ultrassonografia_doppler($row["ultrassonografia_doppler"]); }
		if (isset($row["videocirurgia"])){ $new_object->set_videocirurgia($row["videocirurgia"]); }
		if (isset($row["odontologia_basica"])){ $new_object->set_odontologia_basica($row["odontologia_basica"]); }
		if (isset($row["raiox_dentario"])){ $new_object->set_raiox_dentario($row["raiox_dentario"]); }
		if (isset($row["endodontia"])){ $new_object->set_endodontia($row["endodontia"]); }
		if (isset($row["periodontia"])){ $new_object->set_periodontia($row["periodontia"]); }
		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_cnes SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = '".$objeto_recebido->get_id()."'")."
				".(is_null($objeto_recebido->get_ativo()) ? "" : ", ativo = ".$objeto_recebido->get_ativo())."
				".(is_null($objeto_recebido->get_razao_social()) ? "" : ", razao_social = '".$objeto_recebido->get_razao_social()."'")."
				".(is_null($objeto_recebido->get_no_fantasia()) ? "" : ", no_fantasia = '".$objeto_recebido->get_no_fantasia()."'")."
				".(is_null($objeto_recebido->get_tipo_estabelecimento()) ? "" : ", tipo_estabelecimento = '".$objeto_recebido->get_tipo_estabelecimento()."'")."
				".(is_null($objeto_recebido->get_convenio()) ? "" : ", convenio = '".$objeto_recebido->get_convenio()."'")."
				".(is_null($objeto_recebido->get_natureza_juridica()) ? "" : ", natureza_juridica = '".$objeto_recebido->get_natureza_juridica()."'")."
				".(is_null($objeto_recebido->get_atendimento_prestado()) ? "" : ", atendimento_prestado = '".$objeto_recebido->get_atendimento_prestado()."'")."
				".(is_null($objeto_recebido->get_cnpj()) ? "" : ", cnpj = '".$objeto_recebido->get_cnpj()."'")."
				".(is_null($objeto_recebido->get_cpf()) ? "" : ", cpf = '".$objeto_recebido->get_cpf()."'")."
				".(is_null($objeto_recebido->get_cd_municipio()) ? "" : ", cd_municipio = ".$objeto_recebido->get_cd_municipio())."
				".(is_null($objeto_recebido->get_nm_municipio()) ? "" : ", nm_municipio = '".$objeto_recebido->get_nm_municipio()."'")."
				".(is_null($objeto_recebido->get_uf()) ? "" : ", uf = '".$objeto_recebido->get_uf()."'")."
				".(is_null($objeto_recebido->get_cep()) ? "" : ", cep = '".$objeto_recebido->get_cep()."'")."
				".(is_null($objeto_recebido->get_inclusao()) ? "" : ", inclusao = '".$objeto_recebido->get_inclusao()."'")."
				".(is_null($objeto_recebido->get_equipo_odontologico()) ? "" : ", equipo_odontologico = ".$objeto_recebido->get_equipo_odontologico())."
				".(is_null($objeto_recebido->get_cirurgiao_dentista()) ? "" : ", cirurgiao_dentista = ".$objeto_recebido->get_cirurgiao_dentista())."
				".(is_null($objeto_recebido->get_urgencia_emergencia()) ? "" : ", urgencia_emergencia = ".$objeto_recebido->get_urgencia_emergencia())."
				".(is_null($objeto_recebido->get_leitos_clinica()) ? "" : ", leitos_clinica = ".$objeto_recebido->get_leitos_clinica())."
				".(is_null($objeto_recebido->get_leitos_cirurgia()) ? "" : ", leitos_cirurgia = ".$objeto_recebido->get_leitos_cirurgia())."
				".(is_null($objeto_recebido->get_leitos_obstetricia()) ? "" : ", leitos_obstetricia = ".$objeto_recebido->get_leitos_obstetricia())."
				".(is_null($objeto_recebido->get_leitos_pediatria()) ? "" : ", leitos_pediatria = ".$objeto_recebido->get_leitos_pediatria())."
				".(is_null($objeto_recebido->get_leitos_psiquiatria()) ? "" : ", leitos_psiquiatria = ".$objeto_recebido->get_leitos_psiquiatria())."
				".(is_null($objeto_recebido->get_leitos_uti_adulto()) ? "" : ", leitos_uti_adulto = ".$objeto_recebido->get_leitos_uti_adulto())."
				".(is_null($objeto_recebido->get_leitos_uti_pediatrica()) ? "" : ", leitos_uti_pediatrica = ".$objeto_recebido->get_leitos_uti_pediatrica())."
				".(is_null($objeto_recebido->get_leitos_uti_neonatal()) ? "" : ", leitos_uti_neonatal = ".$objeto_recebido->get_leitos_uti_neonatal())."
				".(is_null($objeto_recebido->get_leitos_unidade_interm_neo()) ? "" : ", leitos_unidade_interm_neo = ".$objeto_recebido->get_leitos_unidade_interm_neo())."
				".(is_null($objeto_recebido->get_anatomopatologia()) ? "" : ", anatomopatologia = ".$objeto_recebido->get_anatomopatologia())."
				".(is_null($objeto_recebido->get_colposcopia()) ? "" : ", colposcopia = ".$objeto_recebido->get_colposcopia())."
				".(is_null($objeto_recebido->get_eletrocardiograma()) ? "" : ", eletrocardiograma = ".$objeto_recebido->get_eletrocardiograma())."
				".(is_null($objeto_recebido->get_fisioterapia()) ? "" : ", fisioterapia = ".$objeto_recebido->get_fisioterapia())."
				".(is_null($objeto_recebido->get_patologia_clinica()) ? "" : ", patologia_clinica = ".$objeto_recebido->get_patologia_clinica())."
				".(is_null($objeto_recebido->get_radiodiagnostico()) ? "" : ", radiodiagnostico = ".$objeto_recebido->get_radiodiagnostico())."
				".(is_null($objeto_recebido->get_ultra_sonografia()) ? "" : ", ultra_sonografia = ".$objeto_recebido->get_ultra_sonografia())."
				".(is_null($objeto_recebido->get_ecocardiografia()) ? "" : ", ecocardiografia = ".$objeto_recebido->get_ecocardiografia())."
				".(is_null($objeto_recebido->get_endoscopia_vdigestivas()) ? "" : ", endoscopia_vdigestivas = ".$objeto_recebido->get_endoscopia_vdigestivas())."
				".(is_null($objeto_recebido->get_hemoterapia_ambulatorial()) ? "" : ", hemoterapia_ambulatorial = ".$objeto_recebido->get_hemoterapia_ambulatorial())."
				".(is_null($objeto_recebido->get_holter()) ? "" : ", holter = ".$objeto_recebido->get_holter())."
				".(is_null($objeto_recebido->get_litotripsia_extracorporea()) ? "" : ", litotripsia_extracorporea = ".$objeto_recebido->get_litotripsia_extracorporea())."
				".(is_null($objeto_recebido->get_mamografia()) ? "" : ", mamografia = ".$objeto_recebido->get_mamografia())."
				".(is_null($objeto_recebido->get_psicoterapia()) ? "" : ", psicoterapia = ".$objeto_recebido->get_psicoterapia())."
				".(is_null($objeto_recebido->get_terapia_renalsubst()) ? "" : ", terapia_renalsubst = ".$objeto_recebido->get_terapia_renalsubst())."
				".(is_null($objeto_recebido->get_teste_ergometrico()) ? "" : ", teste_ergometrico = ".$objeto_recebido->get_teste_ergometrico())."
				".(is_null($objeto_recebido->get_tomografia_computadorizada()) ? "" : ", tomografia_computadorizada = ".$objeto_recebido->get_tomografia_computadorizada())."
				".(is_null($objeto_recebido->get_atendimento_hospitaldia()) ? "" : ", atendimento_hospitaldia = ".$objeto_recebido->get_atendimento_hospitaldia())."
				".(is_null($objeto_recebido->get_endoscopia_vaereas()) ? "" : ", endoscopia_vaereas = ".$objeto_recebido->get_endoscopia_vaereas())."
				".(is_null($objeto_recebido->get_hemodinamica()) ? "" : ", hemodinamica = ".$objeto_recebido->get_hemodinamica())."
				".(is_null($objeto_recebido->get_medicina_nuclear()) ? "" : ", medicina_nuclear = ".$objeto_recebido->get_medicina_nuclear())."
				".(is_null($objeto_recebido->get_quimioterapia()) ? "" : ", quimioterapia = ".$objeto_recebido->get_quimioterapia())."
				".(is_null($objeto_recebido->get_radiologia_intervencionista()) ? "" : ", radiologia_intervencionista = ".$objeto_recebido->get_radiologia_intervencionista())."
				".(is_null($objeto_recebido->get_radioterapia()) ? "" : ", radioterapia = ".$objeto_recebido->get_radioterapia())."
				".(is_null($objeto_recebido->get_ressonancia_nmagnetica()) ? "" : ", ressonancia_nmagnetica = ".$objeto_recebido->get_ressonancia_nmagnetica())."
				".(is_null($objeto_recebido->get_ultrassonografia_doppler()) ? "" : ", ultrassonografia_doppler = ".$objeto_recebido->get_ultrassonografia_doppler())."
				".(is_null($objeto_recebido->get_videocirurgia()) ? "" : ", videocirurgia = ".$objeto_recebido->get_videocirurgia())."
				".(is_null($objeto_recebido->get_odontologia_basica()) ? "" : ", odontologia_basica = ".$objeto_recebido->get_odontologia_basica())."
				".(is_null($objeto_recebido->get_raiox_dentario()) ? "" : ", raiox_dentario = ".$objeto_recebido->get_raiox_dentario())."
				".(is_null($objeto_recebido->get_endodontia()) ? "" : ", endodontia = ".$objeto_recebido->get_endodontia())."
				".(is_null($objeto_recebido->get_periodontia()) ? "" : ", periodontia = ".$objeto_recebido->get_periodontia())."
				WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_cnes WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_cnes";
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

		if (is_null ($database)){ $dbh->close(); }
		return $resreturn;
	}

	public function exist_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT COUNT(id) AS qtd FROM tb_cnes WHERE id = '".$id."';";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = false;
		if (isset($row)){
			if (intval($row["qtd"]) > 0){ $res_result = true; }
		}

		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function next_id ($database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT CAST((MAX(CAST(id AS UNSIGNED))+1) AS CHAR(20)) AS newid FROM tb_cnes;";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){ $res_result = "".$row["newid"]; }
		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function get_cd_municipio ($cidade, $uf, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = 'SELECT DISTINCT(cd_municipio) FROM tb_cnes WHERE UPPER(nm_municipio) LIKE 
		"%'.$cidade.'%" AND UPPER(uf) = "'.$uf.'";';

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = "";
		if (isset($row)){ $res_result = "".$row["cd_municipio"]; }
		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_cnes WHERE id = '".$id."';";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$new_object = $this->get_object ($row, $dbh);
		if (is_null ($database)){ $dbh->close(); }
		return $new_object;
	}

	public function select_all ($database = null, $fields = null, $wherecl = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT ";
		if (is_null($fields)){ $sql .= "* FROM tb_cnes"; }
		else{ $sql .= $fields." FROM tb_cnes"; }
		if (!is_null($wherecl)){ $sql .= " WHERE ".$wherecl; }
		$sql .= ";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}

	public function select_features ($uf, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT id, no_fantasia FROM tb_cnes WHERE ativo = 1 AND uf = '".$uf."';";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$line = array ();
			array_push ($line, $row["id"]);
			array_push ($line, $row["no_fantasia"]);
			array_push ($array_return, $line);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}

	public function select_prestadoras ($database = null, $fields = null, $wherecl = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT ";
		if (is_null($fields)){ $sql .= "tb_cnes.* FROM (tb_cnes JOIN tb_prestadora ON tb_prestadora.id_cnes = tb_cnes.id)"; }
		else{ $sql .= $fields." FROM (tb_cnes JOIN tb_prestadora ON tb_prestadora.id_cnes = tb_cnes.id)"; }
		if (!is_null($wherecl)){ $sql .= " WHERE ".$wherecl; }
		$sql .= ";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}

	public function select_by_Operadora ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT tb_cnes.* FROM (tb_cnes JOIN tb_prestadora ON tb_prestadora.id_cnes = tb_cnes.id) 
		WHERE tb_prestadora.id_operadora = ".$id.";";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}
}
?>