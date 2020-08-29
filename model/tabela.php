<?php
require_once('prestadora.php');
require_once('medtab.php');
require_once('mattab.php');

class Tabela {
	// Propriedades
	private $id;
	private $type;
	private $PRESTADORA;
	private $MEDTAB;
	private $MATTAB;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->type = null;
		$this->PRESTADORA = null;
		$this->MEDTAB = null;
		$this->MATTAB = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_type (){ return $this->type; }
	public function get_PRESTADORA (){ return $this->PRESTADORA; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_MATTAB (){ return $this->MATTAB; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_type ($type){ $this->type = intval($type); }
	public function set_PRESTADORA ($PRESTADORA){ $this->PRESTADORA = $PRESTADORA; }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_MATTAB ($MATTAB){ $this->MATTAB = $MATTAB; }
}
?>
