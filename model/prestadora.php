<?php
require_once('cnes.php');
require_once('operadora.php');

class Prestadora {
	// Propriedades
	private $id;
	private $CNES;
	private $OPERADORA;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->CNES = null;
		$this->OPERADORA = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_CNES (){ return $this->CNES; }
	public function get_OPERADORA (){ return $this->OPERADORA; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_CNES ($CNES){ $this->CNES = $CNES; }
	public function set_OPERADORA ($OPERADORA){ $this->OPERADORA = $OPERADORA; }
}
?>