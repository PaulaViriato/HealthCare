<?php
$path = dirname (__FILE__);
$path = str_replace ("dao", "model", $path);
require_once('Connection.php');
require_once($path.'/cmed.php');
require_once('medicamento_DAO.php');
require_once('medtab_DAO.php');

class CMED_DAO {
	// Propriedades
	private $DAOMedicamento;
	private $DAOMedTab;

	// Construtor
	function __construct(){
		$this->DAOMedicamento = new Medicamento_DAO();
		$this->DAOMedTab = new MedTab_DAO();
	}

	// Métodos
	public function get_insert ($objeto_recebido, $whole = true, $intro = false, $instance = false){
		$sql = "";
		if ($whole == true){
			$sql .= "INSERT INTO tb_cmed (id_medicamento, id_medtab, ean_um, ean_dois, ean_tres, regime_preco, pf_semimpostos, pf_zero, pf_doze, 
			pf_dezessete, pf_dezessete_alc, pf_dezessetemeio, pf_dezessetemeio_alc, pf_dezoito, pf_dezoito_alc, pf_vinte, pmc_zero, pmc_doze, 
			pmc_dezessete, pmc_dezessete_alc, pmc_dezessetemeio, pmc_dezessetemeio_alc, pmc_dezoito, pmc_dezoito_alc, pmc_vinte, pmvg_semimpostos, 
			pmvg_zero, pmvg_doze, pmvg_dezessete, pmvg_dezessete_alc, pmvg_dezessetemeio, pmvg_dezessetemeio_alc, pmvg_dezoito, pmvg_dezoito_alc, 
			pmvg_vinte, restricao_hospitalar, cap, confaz_oitosete, icms_zero, analise_recursal, lista_ctributario, comercializacao) VALUES (
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
			".(is_null($objeto_recebido->get_ean_um()) ? "null" : "'".$objeto_recebido->get_ean_um()."'").", 
			".(is_null($objeto_recebido->get_ean_dois()) ? "null" : "'".$objeto_recebido->get_ean_dois()."'").", 
			".(is_null($objeto_recebido->get_ean_tres()) ? "null" : "'".$objeto_recebido->get_ean_tres()."'").", 
			".(is_null($objeto_recebido->get_regime_preco()) ? "null" : "'".$objeto_recebido->get_regime_preco()."'").", 
			".(is_null($objeto_recebido->get_pf_semimpostos()) ? "null" : $objeto_recebido->get_pf_semimpostos()).", 
			".(is_null($objeto_recebido->get_pf_zero()) ? "null" : $objeto_recebido->get_pf_zero()).", 
			".(is_null($objeto_recebido->get_pf_doze()) ? "null" : $objeto_recebido->get_pf_doze()).", 
			".(is_null($objeto_recebido->get_pf_dezessete()) ? "null" : $objeto_recebido->get_pf_dezessete()).", 
			".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "null" : $objeto_recebido->get_pf_dezessete_alc()).", 
			".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "null" : $objeto_recebido->get_pf_dezessetemeio()).", 
			".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pf_dezessetemeio_alc()).", 
			".(is_null($objeto_recebido->get_pf_dezoito()) ? "null" : $objeto_recebido->get_pf_dezoito()).", 
			".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "null" : $objeto_recebido->get_pf_dezoito_alc()).", 
			".(is_null($objeto_recebido->get_pf_vinte()) ? "null" : $objeto_recebido->get_pf_vinte()).", 
			".(is_null($objeto_recebido->get_pmc_zero()) ? "null" : $objeto_recebido->get_pmc_zero()).", 
			".(is_null($objeto_recebido->get_pmc_doze()) ? "null" : $objeto_recebido->get_pmc_doze()).", 
			".(is_null($objeto_recebido->get_pmc_dezessete()) ? "null" : $objeto_recebido->get_pmc_dezessete()).", 
			".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "null" : $objeto_recebido->get_pmc_dezessete_alc()).", 
			".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "null" : $objeto_recebido->get_pmc_dezessetemeio()).", 
			".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pmc_dezessetemeio_alc()).", 
			".(is_null($objeto_recebido->get_pmc_dezoito()) ? "null" : $objeto_recebido->get_pmc_dezoito()).", 
			".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "null" : $objeto_recebido->get_pmc_dezoito_alc()).", 
			".(is_null($objeto_recebido->get_pmc_vinte()) ? "null" : $objeto_recebido->get_pmc_vinte()).", 
			".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "null" : $objeto_recebido->get_pmvg_semimpostos()).", 
			".(is_null($objeto_recebido->get_pmvg_zero()) ? "null" : $objeto_recebido->get_pmvg_zero()).", 
			".(is_null($objeto_recebido->get_pmvg_doze()) ? "null" : $objeto_recebido->get_pmvg_doze()).", 
			".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "null" : $objeto_recebido->get_pmvg_dezessete()).", 
			".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "null" : $objeto_recebido->get_pmvg_dezessete_alc()).", 
			".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "null" : $objeto_recebido->get_pmvg_dezessetemeio()).", 
			".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pmvg_dezessetemeio_alc()).", 
			".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "null" : $objeto_recebido->get_pmvg_dezoito()).", 
			".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "null" : $objeto_recebido->get_pmvg_dezoito_alc()).", 
			".(is_null($objeto_recebido->get_pmvg_vinte()) ? "null" : $objeto_recebido->get_pmvg_vinte()).", 
			".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "null" : $objeto_recebido->get_restricao_hospitalar()).", 
			".(is_null($objeto_recebido->get_cap()) ? "null" : $objeto_recebido->get_cap()).", 
			".(is_null($objeto_recebido->get_confaz_oitosete()) ? "null" : $objeto_recebido->get_confaz_oitosete()).", 
			".(is_null($objeto_recebido->get_icms_zero()) ? "null" : $objeto_recebido->get_icms_zero()).", 
			".(is_null($objeto_recebido->get_analise_recursal()) ? "null" : $objeto_recebido->get_analise_recursal()).", 
			".(is_null($objeto_recebido->get_lista_ctributario()) ? "null" : "'".$objeto_recebido->get_lista_ctributario()."'").", 
			".(is_null($objeto_recebido->get_comercializacao()) ? "null" : $objeto_recebido->get_comercializacao()).");";
		} else {
			if ($intro == true){
				$sql .= "INSERT INTO tb_cmed (id_medicamento, id_medtab, ean_um, ean_dois, ean_tres, regime_preco, pf_semimpostos, pf_zero, pf_doze, 
				pf_dezessete, pf_dezessete_alc, pf_dezessetemeio, pf_dezessetemeio_alc, pf_dezoito, pf_dezoito_alc, pf_vinte, pmc_zero, pmc_doze, 
				pmc_dezessete, pmc_dezessete_alc, pmc_dezessetemeio, pmc_dezessetemeio_alc, pmc_dezoito, pmc_dezoito_alc, pmc_vinte, pmvg_semimpostos, 
				pmvg_zero, pmvg_doze, pmvg_dezessete, pmvg_dezessete_alc, pmvg_dezessetemeio, pmvg_dezessetemeio_alc, pmvg_dezoito, pmvg_dezoito_alc, 
				pmvg_vinte, restricao_hospitalar, cap, confaz_oitosete, icms_zero, analise_recursal, lista_ctributario, comercializacao) VALUES ";
			}
			if ($instance == true){
				$sql .= "(".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "null" : "'".$objeto_recebido->get_MEDICAMENTO()->get_id()."'").", 
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "null" : $objeto_recebido->get_MEDTAB()->get_id()).", 
				".(is_null($objeto_recebido->get_ean_um()) ? "null" : "'".$objeto_recebido->get_ean_um()."'").", 
				".(is_null($objeto_recebido->get_ean_dois()) ? "null" : "'".$objeto_recebido->get_ean_dois()."'").", 
				".(is_null($objeto_recebido->get_ean_tres()) ? "null" : "'".$objeto_recebido->get_ean_tres()."'").", 
				".(is_null($objeto_recebido->get_regime_preco()) ? "null" : "'".$objeto_recebido->get_regime_preco()."'").", 
				".(is_null($objeto_recebido->get_pf_semimpostos()) ? "null" : $objeto_recebido->get_pf_semimpostos()).", 
				".(is_null($objeto_recebido->get_pf_zero()) ? "null" : $objeto_recebido->get_pf_zero()).", 
				".(is_null($objeto_recebido->get_pf_doze()) ? "null" : $objeto_recebido->get_pf_doze()).", 
				".(is_null($objeto_recebido->get_pf_dezessete()) ? "null" : $objeto_recebido->get_pf_dezessete()).", 
				".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "null" : $objeto_recebido->get_pf_dezessete_alc()).", 
				".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "null" : $objeto_recebido->get_pf_dezessetemeio()).", 
				".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pf_dezessetemeio_alc()).", 
				".(is_null($objeto_recebido->get_pf_dezoito()) ? "null" : $objeto_recebido->get_pf_dezoito()).", 
				".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "null" : $objeto_recebido->get_pf_dezoito_alc()).", 
				".(is_null($objeto_recebido->get_pf_vinte()) ? "null" : $objeto_recebido->get_pf_vinte()).", 
				".(is_null($objeto_recebido->get_pmc_zero()) ? "null" : $objeto_recebido->get_pmc_zero()).", 
				".(is_null($objeto_recebido->get_pmc_doze()) ? "null" : $objeto_recebido->get_pmc_doze()).", 
				".(is_null($objeto_recebido->get_pmc_dezessete()) ? "null" : $objeto_recebido->get_pmc_dezessete()).", 
				".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "null" : $objeto_recebido->get_pmc_dezessete_alc()).", 
				".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "null" : $objeto_recebido->get_pmc_dezessetemeio()).", 
				".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pmc_dezessetemeio_alc()).", 
				".(is_null($objeto_recebido->get_pmc_dezoito()) ? "null" : $objeto_recebido->get_pmc_dezoito()).", 
				".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "null" : $objeto_recebido->get_pmc_dezoito_alc()).", 
				".(is_null($objeto_recebido->get_pmc_vinte()) ? "null" : $objeto_recebido->get_pmc_vinte()).", 
				".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "null" : $objeto_recebido->get_pmvg_semimpostos()).", 
				".(is_null($objeto_recebido->get_pmvg_zero()) ? "null" : $objeto_recebido->get_pmvg_zero()).", 
				".(is_null($objeto_recebido->get_pmvg_doze()) ? "null" : $objeto_recebido->get_pmvg_doze()).", 
				".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "null" : $objeto_recebido->get_pmvg_dezessete()).", 
				".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "null" : $objeto_recebido->get_pmvg_dezessete_alc()).", 
				".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "null" : $objeto_recebido->get_pmvg_dezessetemeio()).", 
				".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "null" : $objeto_recebido->get_pmvg_dezessetemeio_alc()).", 
				".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "null" : $objeto_recebido->get_pmvg_dezoito()).", 
				".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "null" : $objeto_recebido->get_pmvg_dezoito_alc()).", 
				".(is_null($objeto_recebido->get_pmvg_vinte()) ? "null" : $objeto_recebido->get_pmvg_vinte()).", 
				".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "null" : $objeto_recebido->get_restricao_hospitalar()).", 
				".(is_null($objeto_recebido->get_cap()) ? "null" : $objeto_recebido->get_cap()).", 
				".(is_null($objeto_recebido->get_confaz_oitosete()) ? "null" : $objeto_recebido->get_confaz_oitosete()).", 
				".(is_null($objeto_recebido->get_icms_zero()) ? "null" : $objeto_recebido->get_icms_zero()).", 
				".(is_null($objeto_recebido->get_analise_recursal()) ? "null" : $objeto_recebido->get_analise_recursal()).", 
				".(is_null($objeto_recebido->get_lista_ctributario()) ? "null" : "'".$objeto_recebido->get_lista_ctributario()."'").", 
				".(is_null($objeto_recebido->get_comercializacao()) ? "null" : $objeto_recebido->get_comercializacao()).")";
			}
		}
		return $sql;
	}

	public function get_update ($objeto_recebido){
		$sql = "UPDATE tb_cmed SET 
		".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
		".(is_null($objeto_recebido->get_ean_um()) ? "" : ", ean_um = '".$objeto_recebido->get_ean_um()."'")."
		".(is_null($objeto_recebido->get_ean_dois()) ? "" : ", ean_dois = '".$objeto_recebido->get_ean_dois()."'")."
		".(is_null($objeto_recebido->get_ean_tres()) ? "" : ", ean_tres = '".$objeto_recebido->get_ean_tres()."'")."
		".(is_null($objeto_recebido->get_regime_preco()) ? "" : ", regime_preco = '".$objeto_recebido->get_regime_preco()."'")."
		".(is_null($objeto_recebido->get_pf_semimpostos()) ? "" : ", pf_semimpostos = ".$objeto_recebido->get_pf_semimpostos())."
		".(is_null($objeto_recebido->get_pf_zero()) ? "" : ", pf_zero = ".$objeto_recebido->get_pf_zero())."
		".(is_null($objeto_recebido->get_pf_doze()) ? "" : ", pf_doze = ".$objeto_recebido->get_pf_doze())."
		".(is_null($objeto_recebido->get_pf_dezessete()) ? "" : ", pf_dezessete = ".$objeto_recebido->get_pf_dezessete())."
		".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "" : ", pf_dezessete_alc = ".$objeto_recebido->get_pf_dezessete_alc())."
		".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "" : ", pf_dezessetemeio = ".$objeto_recebido->get_pf_dezessetemeio())."
		".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "" : ", pf_dezessetemeio_alc = ".$objeto_recebido->get_pf_dezessetemeio_alc())."
		".(is_null($objeto_recebido->get_pf_dezoito()) ? "" : ", pf_dezoito = ".$objeto_recebido->get_pf_dezoito())."
		".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "" : ", pf_dezoito_alc = ".$objeto_recebido->get_pf_dezoito_alc())."
		".(is_null($objeto_recebido->get_pf_vinte()) ? "" : ", pf_vinte = ".$objeto_recebido->get_pf_vinte())."
		".(is_null($objeto_recebido->get_pmc_zero()) ? "" : ", pmc_zero = ".$objeto_recebido->get_pmc_zero())."
		".(is_null($objeto_recebido->get_pmc_doze()) ? "" : ", pmc_doze = ".$objeto_recebido->get_pmc_doze())."
		".(is_null($objeto_recebido->get_pmc_dezessete()) ? "" : ", pmc_dezessete = ".$objeto_recebido->get_pmc_dezessete())."
		".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "" : ", pmc_dezessete_alc = ".$objeto_recebido->get_pmc_dezessete_alc())."
		".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "" : ", pmc_dezessetemeio = ".$objeto_recebido->get_pmc_dezessetemeio())."
		".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "" : ", pmc_dezessetemeio_alc = ".$objeto_recebido->get_pmc_dezessetemeio_alc())."
		".(is_null($objeto_recebido->get_pmc_dezoito()) ? "" : ", pmc_dezoito = ".$objeto_recebido->get_pmc_dezoito())."
		".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "" : ", pmc_dezoito_alc = ".$objeto_recebido->get_pmc_dezoito_alc())."
		".(is_null($objeto_recebido->get_pmc_vinte()) ? "" : ", pmc_vinte = ".$objeto_recebido->get_pmc_vinte())."
		".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "" : ", pmvg_semimpostos = ".$objeto_recebido->get_pmvg_semimpostos())."
		".(is_null($objeto_recebido->get_pmvg_zero()) ? "" : ", pmvg_zero = ".$objeto_recebido->get_pmvg_zero())."
		".(is_null($objeto_recebido->get_pmvg_doze()) ? "" : ", pmvg_doze = ".$objeto_recebido->get_pmvg_doze())."
		".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "" : ", pmvg_dezessete = ".$objeto_recebido->get_pmvg_dezessete())."
		".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "" : ", pmvg_dezessete_alc = ".$objeto_recebido->get_pmvg_dezessete_alc())."
		".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "" : ", pmvg_dezessetemeio = ".$objeto_recebido->get_pmvg_dezessetemeio())."
		".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "" : ", pmvg_dezessetemeio_alc = ".$objeto_recebido->get_pmvg_dezessetemeio_alc())."
		".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "" : ", pmvg_dezoito = ".$objeto_recebido->get_pmvg_dezoito())."
		".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "" : ", pmvg_dezoito_alc = ".$objeto_recebido->get_pmvg_dezoito_alc())."
		".(is_null($objeto_recebido->get_pmvg_vinte()) ? "" : ", pmvg_vinte = ".$objeto_recebido->get_pmvg_vinte())."
		".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "" : ", restricao_hospitalar = ".$objeto_recebido->get_restricao_hospitalar())."
		".(is_null($objeto_recebido->get_cap()) ? "" : ", cap = ".$objeto_recebido->get_cap())."
		".(is_null($objeto_recebido->get_confaz_oitosete()) ? "" : ", confaz_oitosete = ".$objeto_recebido->get_confaz_oitosete())."
		".(is_null($objeto_recebido->get_icms_zero()) ? "" : ", icms_zero = ".$objeto_recebido->get_icms_zero())."
		".(is_null($objeto_recebido->get_analise_recursal()) ? "" : ", analise_recursal = ".$objeto_recebido->get_analise_recursal())."
		".(is_null($objeto_recebido->get_lista_ctributario()) ? "" : ", lista_ctributario = '".$objeto_recebido->get_lista_ctributario()."'")."
		".(is_null($objeto_recebido->get_comercializacao()) ? "" : ", comercializacao = ".$objeto_recebido->get_comercializacao())." 
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
			$sql = "SELECT id FROM tb_cmed WHERE 
			".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
			".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
			".(is_null($objeto_recebido->get_ean_um()) ? "isnull(ean_um)" : "ean_um = '".$objeto_recebido->get_ean_um()."'")." AND
			".(is_null($objeto_recebido->get_ean_dois()) ? "isnull(ean_dois)" : "ean_dois = '".$objeto_recebido->get_ean_dois()."'")." AND
			".(is_null($objeto_recebido->get_ean_tres()) ? "isnull(ean_tres)" : "ean_tres = '".$objeto_recebido->get_ean_tres()."'")." AND
			".(is_null($objeto_recebido->get_regime_preco()) ? "isnull(regime_preco)" : "regime_preco = '".$objeto_recebido->get_regime_preco()."'")." AND
			".(is_null($objeto_recebido->get_pf_semimpostos()) ? "isnull(pf_semimpostos)" : "pf_semimpostos = ".$objeto_recebido->get_pf_semimpostos())." AND
			".(is_null($objeto_recebido->get_pf_zero()) ? "isnull(pf_zero)" : "pf_zero = ".$objeto_recebido->get_pf_zero())." AND
			".(is_null($objeto_recebido->get_pf_doze()) ? "isnull(pf_doze)" : "pf_doze = ".$objeto_recebido->get_pf_doze())." AND
			".(is_null($objeto_recebido->get_pf_dezessete()) ? "isnull(pf_dezessete)" : "pf_dezessete = ".$objeto_recebido->get_pf_dezessete())." AND
			".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "isnull(pf_dezessete_alc)" : "pf_dezessete_alc = ".$objeto_recebido->get_pf_dezessete_alc())." AND
			".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "isnull(pf_dezessetemeio)" : "pf_dezessetemeio = ".$objeto_recebido->get_pf_dezessetemeio())." AND
			".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "isnull(pf_dezessetemeio_alc)" : "pf_dezessetemeio_alc = ".$objeto_recebido->get_pf_dezessetemeio_alc())." AND
			".(is_null($objeto_recebido->get_pf_dezoito()) ? "isnull(pf_dezoito)" : "pf_dezoito = ".$objeto_recebido->get_pf_dezoito())." AND
			".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "isnull(pf_dezoito_alc)" : "pf_dezoito_alc = ".$objeto_recebido->get_pf_dezoito_alc())." AND
			".(is_null($objeto_recebido->get_pf_vinte()) ? "isnull(pf_vinte)" : "pf_vinte = ".$objeto_recebido->get_pf_vinte())." AND
			".(is_null($objeto_recebido->get_pmc_zero()) ? "isnull(pmc_zero)" : "pmc_zero = ".$objeto_recebido->get_pmc_zero())." AND
			".(is_null($objeto_recebido->get_pmc_doze()) ? "isnull(pmc_doze)" : "pmc_doze = ".$objeto_recebido->get_pmc_doze())." AND
			".(is_null($objeto_recebido->get_pmc_dezessete()) ? "isnull(pmc_dezessete)" : "pmc_dezessete = ".$objeto_recebido->get_pmc_dezessete())." AND
			".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "isnull(pmc_dezessete_alc)" : "pmc_dezessete_alc = ".$objeto_recebido->get_pmc_dezessete_alc())." AND
			".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "isnull(pmc_dezessetemeio)" : "pmc_dezessetemeio = ".$objeto_recebido->get_pmc_dezessetemeio())." AND
			".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "isnull(pmc_dezessetemeio_alc)" : "pmc_dezessetemeio_alc = ".$objeto_recebido->get_pmc_dezessetemeio_alc())." AND
			".(is_null($objeto_recebido->get_pmc_dezoito()) ? "isnull(pmc_dezoito)" : "pmc_dezoito = ".$objeto_recebido->get_pmc_dezoito())." AND
			".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "isnull(pmc_dezoito_alc)" : "pmc_dezoito_alc = ".$objeto_recebido->get_pmc_dezoito_alc())." AND
			".(is_null($objeto_recebido->get_pmc_vinte()) ? "isnull(pmc_vinte)" : "pmc_vinte = ".$objeto_recebido->get_pmc_vinte())." AND
			".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "isnull(pmvg_semimpostos)" : "pmvg_semimpostos = ".$objeto_recebido->get_pmvg_semimpostos())." AND
			".(is_null($objeto_recebido->get_pmvg_zero()) ? "isnull(pmvg_zero)" : "pmvg_zero = ".$objeto_recebido->get_pmvg_zero())." AND
			".(is_null($objeto_recebido->get_pmvg_doze()) ? "isnull(pmvg_doze)" : "pmvg_doze = ".$objeto_recebido->get_pmvg_doze())." AND
			".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "isnull(pmvg_dezessete)" : "pmvg_dezessete = ".$objeto_recebido->get_pmvg_dezessete())." AND
			".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "isnull(pmvg_dezessete_alc)" : "pmvg_dezessete_alc = ".$objeto_recebido->get_pmvg_dezessete_alc())." AND
			".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "isnull(pmvg_dezessetemeio)" : "pmvg_dezessetemeio = ".$objeto_recebido->get_pmvg_dezessetemeio())." AND
			".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "isnull(pmvg_dezessetemeio_alc)" : "pmvg_dezessetemeio_alc = ".$objeto_recebido->get_pmvg_dezessetemeio_alc())." AND
			".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "isnull(pmvg_dezoito)" : "pmvg_dezoito = ".$objeto_recebido->get_pmvg_dezoito())." AND
			".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "isnull(pmvg_dezoito_alc)" : "pmvg_dezoito_alc = ".$objeto_recebido->get_pmvg_dezoito_alc())." AND
			".(is_null($objeto_recebido->get_pmvg_vinte()) ? "isnull(pmvg_vinte)" : "pmvg_vinte = ".$objeto_recebido->get_pmvg_vinte())." AND
			".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "isnull(restricao_hospitalar)" : "restricao_hospitalar = ".$objeto_recebido->get_restricao_hospitalar())." AND
			".(is_null($objeto_recebido->get_cap()) ? "isnull(cap)" : "cap = ".$objeto_recebido->get_cap())." AND
			".(is_null($objeto_recebido->get_confaz_oitosete()) ? "isnull(confaz_oitosete)" : "confaz_oitosete = ".$objeto_recebido->get_confaz_oitosete())." AND
			".(is_null($objeto_recebido->get_icms_zero()) ? "isnull(icms_zero)" : "icms_zero = ".$objeto_recebido->get_icms_zero())." AND
			".(is_null($objeto_recebido->get_analise_recursal()) ? "isnull(analise_recursal)" : "analise_recursal = ".$objeto_recebido->get_analise_recursal())." AND
			".(is_null($objeto_recebido->get_lista_ctributario()) ? "isnull(lista_ctributario)" : "lista_ctributario = '".$objeto_recebido->get_lista_ctributario()."'")." AND
			".(is_null($objeto_recebido->get_comercializacao()) ? "isnull(comercializacao)" : "comercializacao = ".$objeto_recebido->get_comercializacao())." 
			ORDER BY id DESC;";
			$result = $dbh->query($sql);
			$row = $result->fetch_assoc();
			$id = $row["id"];
		}

		if (is_null ($database)){ $dbh->close(); }
		return $id;
	}

	public function unmodified ($objeto_recebido, $database = null){
		$dbh = $database;
		$result = false;
		if (is_null ($database)){ $dbh = getDbh(); }

		$sql = "SELECT COUNT(id) AS count FROM tb_cmed WHERE 
		".(is_null($objeto_recebido->get_id()) ? "isnull(id)" : "id = ".$objeto_recebido->get_id())." AND
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())." AND
		".(is_null($objeto_recebido->get_ean_um()) ? "isnull(ean_um)" : "ean_um = '".$objeto_recebido->get_ean_um()."'")." AND
		".(is_null($objeto_recebido->get_ean_dois()) ? "isnull(ean_dois)" : "ean_dois = '".$objeto_recebido->get_ean_dois()."'")." AND
		".(is_null($objeto_recebido->get_ean_tres()) ? "isnull(ean_tres)" : "ean_tres = '".$objeto_recebido->get_ean_tres()."'")." AND
		".(is_null($objeto_recebido->get_regime_preco()) ? "isnull(regime_preco)" : "regime_preco = '".$objeto_recebido->get_regime_preco()."'")." AND
		".(is_null($objeto_recebido->get_pf_semimpostos()) ? "isnull(pf_semimpostos)" : "pf_semimpostos = ".$objeto_recebido->get_pf_semimpostos())." AND
		".(is_null($objeto_recebido->get_pf_zero()) ? "isnull(pf_zero)" : "pf_zero = ".$objeto_recebido->get_pf_zero())." AND
		".(is_null($objeto_recebido->get_pf_doze()) ? "isnull(pf_doze)" : "pf_doze = ".$objeto_recebido->get_pf_doze())." AND
		".(is_null($objeto_recebido->get_pf_dezessete()) ? "isnull(pf_dezessete)" : "pf_dezessete = ".$objeto_recebido->get_pf_dezessete())." AND
		".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "isnull(pf_dezessete_alc)" : "pf_dezessete_alc = ".$objeto_recebido->get_pf_dezessete_alc())." AND
		".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "isnull(pf_dezessetemeio)" : "pf_dezessetemeio = ".$objeto_recebido->get_pf_dezessetemeio())." AND
		".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "isnull(pf_dezessetemeio_alc)" : "pf_dezessetemeio_alc = ".$objeto_recebido->get_pf_dezessetemeio_alc())." AND
		".(is_null($objeto_recebido->get_pf_dezoito()) ? "isnull(pf_dezoito)" : "pf_dezoito = ".$objeto_recebido->get_pf_dezoito())." AND
		".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "isnull(pf_dezoito_alc)" : "pf_dezoito_alc = ".$objeto_recebido->get_pf_dezoito_alc())." AND
		".(is_null($objeto_recebido->get_pf_vinte()) ? "isnull(pf_vinte)" : "pf_vinte = ".$objeto_recebido->get_pf_vinte())." AND
		".(is_null($objeto_recebido->get_pmc_zero()) ? "isnull(pmc_zero)" : "pmc_zero = ".$objeto_recebido->get_pmc_zero())." AND
		".(is_null($objeto_recebido->get_pmc_doze()) ? "isnull(pmc_doze)" : "pmc_doze = ".$objeto_recebido->get_pmc_doze())." AND
		".(is_null($objeto_recebido->get_pmc_dezessete()) ? "isnull(pmc_dezessete)" : "pmc_dezessete = ".$objeto_recebido->get_pmc_dezessete())." AND
		".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "isnull(pmc_dezessete_alc)" : "pmc_dezessete_alc = ".$objeto_recebido->get_pmc_dezessete_alc())." AND
		".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "isnull(pmc_dezessetemeio)" : "pmc_dezessetemeio = ".$objeto_recebido->get_pmc_dezessetemeio())." AND
		".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "isnull(pmc_dezessetemeio_alc)" : "pmc_dezessetemeio_alc = ".$objeto_recebido->get_pmc_dezessetemeio_alc())." AND
		".(is_null($objeto_recebido->get_pmc_dezoito()) ? "isnull(pmc_dezoito)" : "pmc_dezoito = ".$objeto_recebido->get_pmc_dezoito())." AND
		".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "isnull(pmc_dezoito_alc)" : "pmc_dezoito_alc = ".$objeto_recebido->get_pmc_dezoito_alc())." AND
		".(is_null($objeto_recebido->get_pmc_vinte()) ? "isnull(pmc_vinte)" : "pmc_vinte = ".$objeto_recebido->get_pmc_vinte())." AND
		".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "isnull(pmvg_semimpostos)" : "pmvg_semimpostos = ".$objeto_recebido->get_pmvg_semimpostos())." AND
		".(is_null($objeto_recebido->get_pmvg_zero()) ? "isnull(pmvg_zero)" : "pmvg_zero = ".$objeto_recebido->get_pmvg_zero())." AND
		".(is_null($objeto_recebido->get_pmvg_doze()) ? "isnull(pmvg_doze)" : "pmvg_doze = ".$objeto_recebido->get_pmvg_doze())." AND
		".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "isnull(pmvg_dezessete)" : "pmvg_dezessete = ".$objeto_recebido->get_pmvg_dezessete())." AND
		".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "isnull(pmvg_dezessete_alc)" : "pmvg_dezessete_alc = ".$objeto_recebido->get_pmvg_dezessete_alc())." AND
		".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "isnull(pmvg_dezessetemeio)" : "pmvg_dezessetemeio = ".$objeto_recebido->get_pmvg_dezessetemeio())." AND
		".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "isnull(pmvg_dezessetemeio_alc)" : "pmvg_dezessetemeio_alc = ".$objeto_recebido->get_pmvg_dezessetemeio_alc())." AND
		".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "isnull(pmvg_dezoito)" : "pmvg_dezoito = ".$objeto_recebido->get_pmvg_dezoito())." AND
		".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "isnull(pmvg_dezoito_alc)" : "pmvg_dezoito_alc = ".$objeto_recebido->get_pmvg_dezoito_alc())." AND
		".(is_null($objeto_recebido->get_pmvg_vinte()) ? "isnull(pmvg_vinte)" : "pmvg_vinte = ".$objeto_recebido->get_pmvg_vinte())." AND
		".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "isnull(restricao_hospitalar)" : "restricao_hospitalar = ".$objeto_recebido->get_restricao_hospitalar())." AND
		".(is_null($objeto_recebido->get_cap()) ? "isnull(cap)" : "cap = ".$objeto_recebido->get_cap())." AND
		".(is_null($objeto_recebido->get_confaz_oitosete()) ? "isnull(confaz_oitosete)" : "confaz_oitosete = ".$objeto_recebido->get_confaz_oitosete())." AND
		".(is_null($objeto_recebido->get_icms_zero()) ? "isnull(icms_zero)" : "icms_zero = ".$objeto_recebido->get_icms_zero())." AND
		".(is_null($objeto_recebido->get_analise_recursal()) ? "isnull(analise_recursal)" : "analise_recursal = ".$objeto_recebido->get_analise_recursal())." AND
		".(is_null($objeto_recebido->get_lista_ctributario()) ? "isnull(lista_ctributario)" : "lista_ctributario = '".$objeto_recebido->get_lista_ctributario()."'")." AND
		".(is_null($objeto_recebido->get_comercializacao()) ? "isnull(comercializacao)" : "comercializacao = ".$objeto_recebido->get_comercializacao()).";";
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
		$sql = "DELETE FROM tb_cmed WHERE id = ".$id.";";
		$query_result = $dbh->query ($sql);

		if (is_null ($database)){ $dbh->close(); }
		return $query_result;
	}

	private function get_object ($row, $dbh){
		$new_object = new CMED();

		if (isset($row["id"])){ $new_object->set_id($row["id"]); }
		if (isset($row["id_medicamento"])){ $new_object->set_MEDICAMENTO($this->DAOMedicamento->select_id($row["id_medicamento"], $dbh)); }
		if (isset($row["id_medtab"])){ $new_object->set_MEDTAB($this->DAOMedTab->select_id($row["id_medtab"], $dbh)); }
		if (isset($row["ean_um"])){ $new_object->set_ean_um($row["ean_um"]); }
		if (isset($row["ean_dois"])){ $new_object->set_ean_dois($row["ean_dois"]); }
		if (isset($row["ean_tres"])){ $new_object->set_ean_tres($row["ean_tres"]); }
		if (isset($row["regime_preco"])){ $new_object->set_regime_preco($row["regime_preco"]); }
		if (isset($row["pf_semimpostos"])){ $new_object->set_pf_semimpostos($row["pf_semimpostos"]); }
		if (isset($row["pf_zero"])){ $new_object->set_pf_zero($row["pf_zero"]); }
		if (isset($row["pf_doze"])){ $new_object->set_pf_doze($row["pf_doze"]); }
		if (isset($row["pf_dezessete"])){ $new_object->set_pf_dezessete($row["pf_dezessete"]); }
		if (isset($row["pf_dezessete_alc"])){ $new_object->set_pf_dezessete_alc($row["pf_dezessete_alc"]); }
		if (isset($row["pf_dezessetemeio"])){ $new_object->set_pf_dezessetemeio($row["pf_dezessetemeio"]); }
		if (isset($row["pf_dezessetemeio_alc"])){ $new_object->set_pf_dezessetemeio_alc($row["pf_dezessetemeio_alc"]); }
		if (isset($row["pf_dezoito"])){ $new_object->set_pf_dezoito($row["pf_dezoito"]); }
		if (isset($row["pf_dezoito_alc"])){ $new_object->set_pf_dezoito_alc($row["pf_dezoito_alc"]); }
		if (isset($row["pf_vinte"])){ $new_object->set_pf_vinte($row["pf_vinte"]); }
		if (isset($row["pmc_zero"])){ $new_object->set_pmc_zero($row["pmc_zero"]); }
		if (isset($row["pmc_doze"])){ $new_object->set_pmc_doze($row["pmc_doze"]); }
		if (isset($row["pmc_dezessete"])){ $new_object->set_pmc_dezessete($row["pmc_dezessete"]); }
		if (isset($row["pmc_dezessete_alc"])){ $new_object->set_pmc_dezessete_alc($row["pmc_dezessete_alc"]); }
		if (isset($row["pmc_dezessetemeio"])){ $new_object->set_pmc_dezessetemeio($row["pmc_dezessetemeio"]); }
		if (isset($row["pmc_dezessetemeio_alc"])){ $new_object->set_pmc_dezessetemeio_alc($row["pmc_dezessetemeio_alc"]); }
		if (isset($row["pmc_dezoito"])){ $new_object->set_pmc_dezoito($row["pmc_dezoito"]); }
		if (isset($row["pmc_dezoito_alc"])){ $new_object->set_pmc_dezoito_alc($row["pmc_dezoito_alc"]); }
		if (isset($row["pmc_vinte"])){ $new_object->set_pmc_vinte($row["pmc_vinte"]); }
		if (isset($row["pmvg_semimpostos"])){ $new_object->set_pmvg_semimpostos($row["pmvg_semimpostos"]); }
		if (isset($row["pmvg_zero"])){ $new_object->set_pmvg_zero($row["pmvg_zero"]); }
		if (isset($row["pmvg_doze"])){ $new_object->set_pmvg_doze($row["pmvg_doze"]); }
		if (isset($row["pmvg_dezessete"])){ $new_object->set_pmvg_dezessete($row["pmvg_dezessete"]); }
		if (isset($row["pmvg_dezessete_alc"])){ $new_object->set_pmvg_dezessete_alc($row["pmvg_dezessete_alc"]); }
		if (isset($row["pmvg_dezessetemeio"])){ $new_object->set_pmvg_dezessetemeio($row["pmvg_dezessetemeio"]); }
		if (isset($row["pmvg_dezessetemeio_alc"])){ $new_object->set_pmvg_dezessetemeio_alc($row["pmvg_dezessetemeio_alc"]); }
		if (isset($row["pmvg_dezoito"])){ $new_object->set_pmvg_dezoito($row["pmvg_dezoito"]); }
		if (isset($row["pmvg_dezoito_alc"])){ $new_object->set_pmvg_dezoito_alc($row["pmvg_dezoito_alc"]); }
		if (isset($row["pmvg_vinte"])){ $new_object->set_pmvg_vinte($row["pmvg_vinte"]); }
		if (isset($row["restricao_hospitalar"])){ $new_object->set_restricao_hospitalar($row["restricao_hospitalar"]); }
		if (isset($row["cap"])){ $new_object->set_cap($row["cap"]); }
		if (isset($row["confaz_oitosete"])){ $new_object->set_confaz_oitosete($row["confaz_oitosete"]); }
		if (isset($row["icms_zero"])){ $new_object->set_icms_zero($row["icms_zero"]); }
		if (isset($row["analise_recursal"])){ $new_object->set_analise_recursal($row["analise_recursal"]); }
		if (isset($row["lista_ctributario"])){ $new_object->set_lista_ctributario($row["lista_ctributario"]); }
		if (isset($row["comercializacao"])){ $new_object->set_comercializacao($row["comercializacao"]); }

		return $new_object;
	}

	public function where_order_clause ($type, $wherecl = null, $ordercl = null, $objeto_recebido = null, $database = null){
		$resreturn = null;
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		if ($type == 0){
			if ((is_null($objeto_recebido) == false)&&(is_null($wherecl) == false)){
				$sql = "UPDATE tb_cmed SET 
				".(is_null($objeto_recebido->get_id()) ? "" : "id = ".$objeto_recebido->get_id())."
				".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "" : ", id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")."
				".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "" : ", id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id())."
				".(is_null($objeto_recebido->get_ean_um()) ? "" : ", ean_um = '".$objeto_recebido->get_ean_um()."'")."
				".(is_null($objeto_recebido->get_ean_dois()) ? "" : ", ean_dois = '".$objeto_recebido->get_ean_dois()."'")."
				".(is_null($objeto_recebido->get_ean_tres()) ? "" : ", ean_tres = '".$objeto_recebido->get_ean_tres()."'")."
				".(is_null($objeto_recebido->get_regime_preco()) ? "" : ", regime_preco = '".$objeto_recebido->get_regime_preco()."'")."
				".(is_null($objeto_recebido->get_pf_semimpostos()) ? "" : ", pf_semimpostos = ".$objeto_recebido->get_pf_semimpostos())."
				".(is_null($objeto_recebido->get_pf_zero()) ? "" : ", pf_zero = ".$objeto_recebido->get_pf_zero())."
				".(is_null($objeto_recebido->get_pf_doze()) ? "" : ", pf_doze = ".$objeto_recebido->get_pf_doze())."
				".(is_null($objeto_recebido->get_pf_dezessete()) ? "" : ", pf_dezessete = ".$objeto_recebido->get_pf_dezessete())."
				".(is_null($objeto_recebido->get_pf_dezessete_alc()) ? "" : ", pf_dezessete_alc = ".$objeto_recebido->get_pf_dezessete_alc())."
				".(is_null($objeto_recebido->get_pf_dezessetemeio()) ? "" : ", pf_dezessetemeio = ".$objeto_recebido->get_pf_dezessetemeio())."
				".(is_null($objeto_recebido->get_pf_dezessetemeio_alc()) ? "" : ", pf_dezessetemeio_alc = ".$objeto_recebido->get_pf_dezessetemeio_alc())."
				".(is_null($objeto_recebido->get_pf_dezoito()) ? "" : ", pf_dezoito = ".$objeto_recebido->get_pf_dezoito())."
				".(is_null($objeto_recebido->get_pf_dezoito_alc()) ? "" : ", pf_dezoito_alc = ".$objeto_recebido->get_pf_dezoito_alc())."
				".(is_null($objeto_recebido->get_pf_vinte()) ? "" : ", pf_vinte = ".$objeto_recebido->get_pf_vinte())."
				".(is_null($objeto_recebido->get_pmc_zero()) ? "" : ", pmc_zero = ".$objeto_recebido->get_pmc_zero())."
				".(is_null($objeto_recebido->get_pmc_doze()) ? "" : ", pmc_doze = ".$objeto_recebido->get_pmc_doze())."
				".(is_null($objeto_recebido->get_pmc_dezessete()) ? "" : ", pmc_dezessete = ".$objeto_recebido->get_pmc_dezessete())."
				".(is_null($objeto_recebido->get_pmc_dezessete_alc()) ? "" : ", pmc_dezessete_alc = ".$objeto_recebido->get_pmc_dezessete_alc())."
				".(is_null($objeto_recebido->get_pmc_dezessetemeio()) ? "" : ", pmc_dezessetemeio = ".$objeto_recebido->get_pmc_dezessetemeio())."
				".(is_null($objeto_recebido->get_pmc_dezessetemeio_alc()) ? "" : ", pmc_dezessetemeio_alc = ".$objeto_recebido->get_pmc_dezessetemeio_alc())."
				".(is_null($objeto_recebido->get_pmc_dezoito()) ? "" : ", pmc_dezoito = ".$objeto_recebido->get_pmc_dezoito())."
				".(is_null($objeto_recebido->get_pmc_dezoito_alc()) ? "" : ", pmc_dezoito_alc = ".$objeto_recebido->get_pmc_dezoito_alc())."
				".(is_null($objeto_recebido->get_pmc_vinte()) ? "" : ", pmc_vinte = ".$objeto_recebido->get_pmc_vinte())."
				".(is_null($objeto_recebido->get_pmvg_semimpostos()) ? "" : ", pmvg_semimpostos = ".$objeto_recebido->get_pmvg_semimpostos())."
				".(is_null($objeto_recebido->get_pmvg_zero()) ? "" : ", pmvg_zero = ".$objeto_recebido->get_pmvg_zero())."
				".(is_null($objeto_recebido->get_pmvg_doze()) ? "" : ", pmvg_doze = ".$objeto_recebido->get_pmvg_doze())."
				".(is_null($objeto_recebido->get_pmvg_dezessete()) ? "" : ", pmvg_dezessete = ".$objeto_recebido->get_pmvg_dezessete())."
				".(is_null($objeto_recebido->get_pmvg_dezessete_alc()) ? "" : ", pmvg_dezessete_alc = ".$objeto_recebido->get_pmvg_dezessete_alc())."
				".(is_null($objeto_recebido->get_pmvg_dezessetemeio()) ? "" : ", pmvg_dezessetemeio = ".$objeto_recebido->get_pmvg_dezessetemeio())."
				".(is_null($objeto_recebido->get_pmvg_dezessetemeio_alc()) ? "" : ", pmvg_dezessetemeio_alc = ".$objeto_recebido->get_pmvg_dezessetemeio_alc())."
				".(is_null($objeto_recebido->get_pmvg_dezoito()) ? "" : ", pmvg_dezoito = ".$objeto_recebido->get_pmvg_dezoito())."
				".(is_null($objeto_recebido->get_pmvg_dezoito_alc()) ? "" : ", pmvg_dezoito_alc = ".$objeto_recebido->get_pmvg_dezoito_alc())."
				".(is_null($objeto_recebido->get_pmvg_vinte()) ? "" : ", pmvg_vinte = ".$objeto_recebido->get_pmvg_vinte())."
				".(is_null($objeto_recebido->get_restricao_hospitalar()) ? "" : ", restricao_hospitalar = ".$objeto_recebido->get_restricao_hospitalar())."
				".(is_null($objeto_recebido->get_cap()) ? "" : ", cap = ".$objeto_recebido->get_cap())."
				".(is_null($objeto_recebido->get_confaz_oitosete()) ? "" : ", confaz_oitosete = ".$objeto_recebido->get_confaz_oitosete())."
				".(is_null($objeto_recebido->get_icms_zero()) ? "" : ", icms_zero = ".$objeto_recebido->get_icms_zero())."
				".(is_null($objeto_recebido->get_analise_recursal()) ? "" : ", analise_recursal = ".$objeto_recebido->get_analise_recursal())."
				".(is_null($objeto_recebido->get_lista_ctributario()) ? "" : ", lista_ctributario = '".$objeto_recebido->get_lista_ctributario()."'")."
				".(is_null($objeto_recebido->get_comercializacao()) ? "" : ", comercializacao = ".$objeto_recebido->get_comercializacao())." 
				WHERE ".$wherecl.";";
				$sql = str_replace (" ,", "", $sql);
				$sql = str_replace (",  WHERE ", " WHERE ", $sql);
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 1){
			if (is_null($wherecl) == false){
				$sql = "DELETE FROM tb_cmed WHERE ".$wherecl.";";
				$resreturn = $dbh->query ($sql);
			}
		}

		if ($type == 2){
			if ((is_null($wherecl) == false)||(is_null($ordercl) == false)){
				$sql = "SELECT * FROM tb_cmed";
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

	public function exist_id ($objeto_recebido, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT id FROM tb_cmed WHERE 
		".(is_null($objeto_recebido->get_MEDICAMENTO()->get_id()) ? "isnull(id_medicamento)" : "id_medicamento = '".$objeto_recebido->get_MEDICAMENTO()->get_id()."'")." AND 
		".(is_null($objeto_recebido->get_MEDTAB()->get_id()) ? "isnull(id_medtab)" : "id_medtab = ".$objeto_recebido->get_MEDTAB()->get_id()).";";

		$result = $dbh->query($sql);
		$row = $result->fetch_assoc();

		$res_result = null;
		if (isset($row)){ if (isset($row["id"])){ $res_result = "".$row["id"]; }}
		if (is_null ($database)){ $dbh->close(); }
		return $res_result;
	}

	public function select_id ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_cmed WHERE id = ".$id.";";

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
		if (is_null($fields)){ $sql .= "* FROM tb_cmed"; }
		else{ $sql .= $fields." FROM tb_cmed"; }
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

	public function select_by_Medicamento ($id, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		$sql = "SELECT * FROM tb_cmed WHERE id_medicamento = '".$id."';";

		$result = $dbh->query($sql);
		$array_return = array ();
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			array_push ($array_return, $new_object);
		}

		if (is_null ($database)){ $dbh->close(); }
		return $array_return;
	}

	public function select_by_MedTab ($id, $database = null, $wherecl = null, $fields = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }

		$array_return = array ();
		$currtab = $this->DAOMedTab->select_id ($id, $dbh);
		if (!is_null($currtab->get_MEDTAB())){
			$array_return = $this->select_by_MedTab ($currtab->get_MEDTAB()->get_id(), $dbh, $wherecl);
		}

		$sql = "SELECT ";
		if (!is_null($fields)){ $sql .= $fields." "; }
		else{ $sql .= "tb_cmed.* "; }
		$sql .= "FROM (tb_medicamento JOIN tb_cmed ON tb_cmed.id_medicamento = tb_medicamento.id) 
		WHERE tb_cmed.id_medtab = ".$id;
		if (!is_null($wherecl)){ $sql .= " AND (".$wherecl.")"; }
		$sql .= ";";

		$result = $dbh->query($sql);
		while($row = $result->fetch_assoc()){
			$new_object = $this->get_object ($row, $dbh);
			$hasMat = false;

			for ($i = 0; $i < count($array_return); $i ++){
				$medid = $array_return[$i]->get_MEDICAMENTO()->get_id();
				if (strcasecmp ("".$medid, "".$new_object->get_MEDICAMENTO()->get_id()) == 0){
					if (!is_null($new_object->get_ean_um())){
						if (strcasecmp ("".$new_object->get_ean_um(), "!!!DELETEDITEM!!!") == 0){ unset ($array_return[$i]); }
						else { $array_return[$i] = $new_object; }
					} else { $array_return[$i] = $new_object; }

					$hasMat = true;
					$i = count($array_return) + 1;
				}
			}

			if (!$hasMat){ array_push ($array_return, $new_object); }
		}

		if (is_null ($database)){ $dbh = null; }
		return $array_return;
	}
}
?>