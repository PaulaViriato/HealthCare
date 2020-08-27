<?php
require_once('operadora.php');

class Rotina {
	// Propriedades
	private $id;
	private $type;
	private $url;
	private $periodo;
	private $OPERADORA;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->type = null;
		$this->url = null;
		$this->periodo = null;
		$this->OPERADORA = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_type (){ return $this->type; }
	public function get_url (){ return $this->url; }
	public function get_periodo (){ return $this->periodo; }
	public function get_OPERADORA (){ return $this->OPERADORA; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_type ($type){ $this->type = intval($type); }
	public function set_url ($url){ $this->url = "".$url; }
	public function set_periodo ($periodo){ $this->periodo = intval($periodo); }
	public function set_OPERADORA ($OPERADORA){ $this->OPERADORA = $OPERADORA; }
}
?>