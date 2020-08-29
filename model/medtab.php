<?php
require_once('operadora.php');

class MedTab {
	// Propriedades
	private $id;
	private $nome;
	private $deflator;
	private $pf_alicota;
	private $pmc_alicota;
	private $pmvg_alicota;
	private $OPERADORA;
	private $MEDTAB;
	private $data;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->nome = null;
		$this->deflator = null;
		$this->pf_alicota = null;
		$this->pmc_alicota = null;
		$this->pmvg_alicota = null;
		$this->OPERADORA = null;
		$this->MEDTAB = null;
		$this->data = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_nome (){ return $this->nome; }
	public function get_deflator (){ return $this->deflator; }
	public function get_pf_alicota (){ return $this->pf_alicota; }
	public function get_pmc_alicota (){ return $this->pmc_alicota; }
	public function get_pmvg_alicota (){ return $this->pmvg_alicota; }
	public function get_OPERADORA (){ return $this->OPERADORA; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_data (){ return $this->data; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_nome ($nome){ $this->nome = str_replace("'", "", "".$nome); }
	public function set_deflator ($deflator){ $this->deflator = floatval(str_replace(",", ".", $deflator)); }
	public function set_pf_alicota ($pf_alicota){ $this->pf_alicota = intval($pf_alicota); }
	public function set_pmc_alicota ($pmc_alicota){ $this->pmc_alicota = intval($pmc_alicota); }
	public function set_pmvg_alicota ($pmvg_alicota){ $this->pmvg_alicota = intval($pmvg_alicota); }
	public function set_OPERADORA ($OPERADORA){ $this->OPERADORA = $OPERADORA; }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_data ($data){ $this->data = str_replace("'", "", "".$data); }
}
?>
