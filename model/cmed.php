<?php
require_once('medicamento.php');
require_once('medtab.php');

class CMED {
	// Propriedades
	private $id;
	private $MEDICAMENTO;
	private $MEDTAB;
	private $ean_um;
	private $ean_dois;
	private $ean_tres;
	private $regime_preco;
	private $pf_semimpostos;
	private $pf_zero;
	private $pf_doze;
	private $pf_dezessete;
	private $pf_dezessete_alc;
	private $pf_dezessetemeio;
	private $pf_dezessetemeio_alc;
	private $pf_dezoito;
	private $pf_dezoito_alc;
	private $pf_vinte;
	private $pmc_zero;
	private $pmc_doze;
	private $pmc_dezessete;
	private $pmc_dezessete_alc;
	private $pmc_dezessetemeio;
	private $pmc_dezessetemeio_alc;
	private $pmc_dezoito;
	private $pmc_dezoito_alc;
	private $pmc_vinte;
	private $pmvg_semimpostos;
	private $pmvg_zero;
	private $pmvg_doze;
	private $pmvg_dezessete;
	private $pmvg_dezessete_alc;
	private $pmvg_dezessetemeio;
	private $pmvg_dezessetemeio_alc;
	private $pmvg_dezoito;
	private $pmvg_dezoito_alc;
	private $pmvg_vinte;
	private $restricao_hospitalar;
	private $cap;
	private $confaz_oitosete;
	private $icms_zero;
	private $analise_recursal;
	private $lista_ctributario;
	private $comercializacao;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->MEDICAMENTO = null;
		$this->MEDTAB = null;
		$this->ean_um = null;
		$this->ean_dois = null;
		$this->ean_tres = null;
		$this->regime_preco = null;
		$this->pf_semimpostos = null;
		$this->pf_zero = null;
		$this->pf_doze = null;
		$this->pf_dezessete = null;
		$this->pf_dezessete_alc = null;
		$this->pf_dezessetemeio = null;
		$this->pf_dezessetemeio_alc = null;
		$this->pf_dezoito = null;
		$this->pf_dezoito_alc = null;
		$this->pf_vinte = null;
		$this->pmc_zero = null;
		$this->pmc_doze = null;
		$this->pmc_dezessete = null;
		$this->pmc_dezessete_alc = null;
		$this->pmc_dezessetemeio = null;
		$this->pmc_dezessetemeio_alc = null;
		$this->pmc_dezoito = null;
		$this->pmc_dezoito_alc = null;
		$this->pmc_vinte = null;
		$this->pmvg_semimpostos = null;
		$this->pmvg_zero = null;
		$this->pmvg_doze = null;
		$this->pmvg_dezessete = null;
		$this->pmvg_dezessete_alc = null;
		$this->pmvg_dezessetemeio = null;
		$this->pmvg_dezessetemeio_alc = null;
		$this->pmvg_dezoito = null;
		$this->pmvg_dezoito_alc = null;
		$this->pmvg_vinte = null;
		$this->restricao_hospitalar = null;
		$this->cap = null;
		$this->confaz_oitosete = null;
		$this->icms_zero = null;
		$this->analise_recursal = null;
		$this->lista_ctributario = null;
		$this->comercializacao = null;
	}

	private function is_true($val, $return_null=false){
		$boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
		return intval ($boolval===null && !$return_null ? false : $boolval);
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_MEDICAMENTO (){ return $this->MEDICAMENTO; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_ean_um (){ return $this->ean_um; }
	public function get_ean_dois (){ return $this->ean_dois; }
	public function get_ean_tres (){ return $this->ean_tres; }
	public function get_regime_preco (){ return $this->regime_preco; }
	public function get_pf_semimpostos (){ return $this->pf_semimpostos; }
	public function get_pf_zero (){ return $this->pf_zero; }
	public function get_pf_doze (){ return $this->pf_doze; }
	public function get_pf_dezessete (){ return $this->pf_dezessete; }
	public function get_pf_dezessete_alc (){ return $this->pf_dezessete_alc; }
	public function get_pf_dezessetemeio (){ return $this->pf_dezessetemeio; }
	public function get_pf_dezessetemeio_alc (){ return $this->pf_dezessetemeio_alc; }
	public function get_pf_dezoito (){ return $this->pf_dezoito; }
	public function get_pf_dezoito_alc (){ return $this->pf_dezoito_alc; }
	public function get_pf_vinte (){ return $this->pf_vinte; }
	public function get_pmc_zero (){ return $this->pmc_zero; }
	public function get_pmc_doze (){ return $this->pmc_doze; }
	public function get_pmc_dezessete (){ return $this->pmc_dezessete; }
	public function get_pmc_dezessete_alc (){ return $this->pmc_dezessete_alc; }
	public function get_pmc_dezessetemeio (){ return $this->pmc_dezessetemeio; }
	public function get_pmc_dezessetemeio_alc (){ return $this->pmc_dezessetemeio_alc; }
	public function get_pmc_dezoito (){ return $this->pmc_dezoito; }
	public function get_pmc_dezoito_alc (){ return $this->pmc_dezoito_alc; }
	public function get_pmc_vinte (){ return $this->pmc_vinte; }
	public function get_pmvg_semimpostos (){ return $this->pmvg_semimpostos; }
	public function get_pmvg_zero (){ return $this->pmvg_zero; }
	public function get_pmvg_doze (){ return $this->pmvg_doze; }
	public function get_pmvg_dezessete (){ return $this->pmvg_dezessete; }
	public function get_pmvg_dezessete_alc (){ return $this->pmvg_dezessete_alc; }
	public function get_pmvg_dezessetemeio (){ return $this->pmvg_dezessetemeio; }
	public function get_pmvg_dezessetemeio_alc (){ return $this->pmvg_dezessetemeio_alc; }
	public function get_pmvg_dezoito (){ return $this->pmvg_dezoito; }
	public function get_pmvg_dezoito_alc (){ return $this->pmvg_dezoito_alc; }
	public function get_pmvg_vinte (){ return $this->pmvg_vinte; }
	public function get_restricao_hospitalar (){ return $this->restricao_hospitalar; }
	public function get_cap (){ return $this->cap; }
	public function get_confaz_oitosete (){ return $this->confaz_oitosete; }
	public function get_icms_zero (){ return $this->icms_zero; }
	public function get_analise_recursal (){ return $this->analise_recursal; }
	public function get_lista_ctributario (){ return $this->lista_ctributario; }
	public function get_comercializacao (){ return $this->comercializacao; }

	// Métodos Set
	public function set_id ($id){ $this->id = intval($id); }
	public function set_MEDICAMENTO ($MEDICAMENTO){ $this->MEDICAMENTO = $MEDICAMENTO; }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_ean_um ($ean_um){ $this->ean_um = str_replace("'", "", "".$ean_um); }
	public function set_ean_dois ($ean_dois){ $this->ean_dois = str_replace("'", "", "".$ean_dois); }
	public function set_ean_tres ($ean_tres){ $this->ean_tres = str_replace("'", "", "".$ean_tres); }
	public function set_regime_preco ($regime_preco){ $this->regime_preco = str_replace("'", "", "".$regime_preco); }
	public function set_pf_semimpostos ($pf_semimpostos){ $this->pf_semimpostos = floatval(str_replace(",", ".", $pf_semimpostos)); }
	public function set_pf_zero ($pf_zero){ $this->pf_zero = floatval(str_replace(",", ".", $pf_zero)); }
	public function set_pf_doze ($pf_doze){ $this->pf_doze = floatval(str_replace(",", ".", $pf_doze)); }
	public function set_pf_dezessete ($pf_dezessete){ $this->pf_dezessete = floatval(str_replace(",", ".", $pf_dezessete)); }
	public function set_pf_dezessete_alc ($pf_dezessete_alc){ $this->pf_dezessete_alc = floatval(str_replace(",", ".", $pf_dezessete_alc)); }
	public function set_pf_dezessetemeio ($pf_dezessetemeio){ $this->pf_dezessetemeio = floatval(str_replace(",", ".", $pf_dezessetemeio)); }
	public function set_pf_dezessetemeio_alc ($pf_dezessetemeio_alc){ $this->pf_dezessetemeio_alc = floatval(str_replace(",", ".", $pf_dezessetemeio_alc)); }
	public function set_pf_dezoito ($pf_dezoito){ $this->pf_dezoito = floatval(str_replace(",", ".", $pf_dezoito)); }
	public function set_pf_dezoito_alc ($pf_dezoito_alc){ $this->pf_dezoito_alc = floatval(str_replace(",", ".", $pf_dezoito_alc)); }
	public function set_pf_vinte ($pf_vinte){ $this->pf_vinte = floatval(str_replace(",", ".", $pf_vinte)); }
	public function set_pmc_zero ($pmc_zero){ $this->pmc_zero = floatval(str_replace(",", ".", $pmc_zero)); }
	public function set_pmc_doze ($pmc_doze){ $this->pmc_doze = floatval(str_replace(",", ".", $pmc_doze)); }
	public function set_pmc_dezessete ($pmc_dezessete){ $this->pmc_dezessete = floatval(str_replace(",", ".", $pmc_dezessete)); }
	public function set_pmc_dezessete_alc ($pmc_dezessete_alc){ $this->pmc_dezessete_alc = floatval(str_replace(",", ".", $pmc_dezessete_alc)); }
	public function set_pmc_dezessetemeio ($pmc_dezessetemeio){ $this->pmc_dezessetemeio = floatval(str_replace(",", ".", $pmc_dezessetemeio)); }
	public function set_pmc_dezessetemeio_alc ($pmc_dezessetemeio_alc){ $this->pmc_dezessetemeio_alc = floatval(str_replace(",", ".", $pmc_dezessetemeio_alc)); }
	public function set_pmc_dezoito ($pmc_dezoito){ $this->pmc_dezoito = floatval(str_replace(",", ".", $pmc_dezoito)); }
	public function set_pmc_dezoito_alc ($pmc_dezoito_alc){ $this->pmc_dezoito_alc = floatval(str_replace(",", ".", $pmc_dezoito_alc)); }
	public function set_pmc_vinte ($pmc_vinte){ $this->pmc_vinte = floatval(str_replace(",", ".", $pmc_vinte)); }
	public function set_pmvg_semimpostos ($pmvg_semimpostos){ $this->pmvg_semimpostos = floatval(str_replace(",", ".", $pmvg_semimpostos)); }
	public function set_pmvg_zero ($pmvg_zero){ $this->pmvg_zero = floatval(str_replace(",", ".", $pmvg_zero)); }
	public function set_pmvg_doze ($pmvg_doze){ $this->pmvg_doze = floatval(str_replace(",", ".", $pmvg_doze)); }
	public function set_pmvg_dezessete ($pmvg_dezessete){ $this->pmvg_dezessete = floatval(str_replace(",", ".", $pmvg_dezessete)); }
	public function set_pmvg_dezessete_alc ($pmvg_dezessete_alc){ $this->pmvg_dezessete_alc = floatval(str_replace(",", ".", $pmvg_dezessete_alc)); }
	public function set_pmvg_dezessetemeio ($pmvg_dezessetemeio){ $this->pmvg_dezessetemeio = floatval(str_replace(",", ".", $pmvg_dezessetemeio)); }
	public function set_pmvg_dezessetemeio_alc ($pmvg_dezessetemeio_alc){ $this->pmvg_dezessetemeio_alc = floatval(str_replace(",", ".", $pmvg_dezessetemeio_alc)); }
	public function set_pmvg_dezoito ($pmvg_dezoito){ $this->pmvg_dezoito = floatval(str_replace(",", ".", $pmvg_dezoito)); }
	public function set_pmvg_dezoito_alc ($pmvg_dezoito_alc){ $this->pmvg_dezoito_alc = floatval(str_replace(",", ".", $pmvg_dezoito_alc)); }
	public function set_pmvg_vinte ($pmvg_vinte){ $this->pmvg_vinte = floatval(str_replace(",", ".", $pmvg_vinte)); }
	public function set_restricao_hospitalar ($restricao_hospitalar){ $this->restricao_hospitalar = $this->is_true($restricao_hospitalar); }
	public function set_cap ($cap){ $this->cap = $this->is_true($cap); }
	public function set_confaz_oitosete ($confaz_oitosete){ $this->confaz_oitosete = $this->is_true($confaz_oitosete); }
	public function set_icms_zero ($icms_zero){ $this->icms_zero = $this->is_true($icms_zero); }
	public function set_analise_recursal ($analise_recursal){ $this->analise_recursal = $this->is_true($analise_recursal); }
	public function set_lista_ctributario ($lista_ctributario){ $this->lista_ctributario = str_replace("'", "", "".$lista_ctributario); }
	public function set_comercializacao ($comercializacao){ $this->comercializacao = $this->is_true($comercializacao); }
}
?>