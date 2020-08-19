<?php
require_once('mattab.php');
require_once('medtab.php');

class Arquivo {
	// Propriedades
	private $id;
	private $file_type;
	private $caminho;
	private $tab_type;
	private $MEDTAB;
	private $MATTAB;
	private $status;
	private $data;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->file_type = null;
		$this->caminho = null;
		$this->tab_type = null;
		$this->MEDTAB = null;
		$this->MATTAB = null;
		$this->status = null;
		$this->data = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_file_type (){ return $this->file_type; }
	public function get_caminho (){ return $this->caminho; }
	public function get_tab_type (){ return $this->tab_type; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_MATTAB (){ return $this->MATTAB; }
	public function get_status (){ return $this->status; }
	public function get_data (){ return $this->data; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_file_type ($file_type){ $this->file_type = intval($file_type); }
	public function set_caminho ($caminho){ $this->caminho = "".$caminho; }
	public function set_tab_type ($tab_type){ $this->tab_type = intval($tab_type); }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_MATTAB ($MATTAB){ $this->MATTAB = $MATTAB; }
	public function set_status ($status){ $this->status = intval($status); }
	public function set_data ($data){ $this->data = str_replace("'", "", "".$data); }
}
?>