<?php
require_once('operadora.php');

class MatTab {
	// Propriedades
	private $id;
	private $nome;
	private $deflator;
	private $OPERADORA;
	private $MATTAB;
	private $data;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->nome = null;
		$this->deflator = null;
		$this->OPERADORA = null;
		$this->MATTAB = null;
		$this->data = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_nome (){ return $this->nome; }
	public function get_deflator (){ return $this->deflator; }
	public function get_OPERADORA (){ return $this->OPERADORA; }
	public function get_MATTAB (){ return $this->MATTAB; }
	public function get_data (){ return $this->data; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_nome ($nome){ $this->nome = str_replace("'", "", "".$nome); }
	public function set_deflator ($deflator){ $this->deflator = floatval(str_replace(",", ".", $deflator)); }
	public function set_OPERADORA ($OPERADORA){ $this->OPERADORA = $OPERADORA; }
	public function set_MATTAB ($MATTAB){ $this->MATTAB = $MATTAB; }
	public function set_data ($data){ $this->data = str_replace("'", "", "".$data); }
}
?>