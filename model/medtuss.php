<?php
require_once('medicamento.php');
require_once('medtab.php');

class MedTuss {
	// Propriedades
	private $id;
	private $MEDICAMENTO;
	private $MEDTAB;
	private $inicio_vigencia;
	private $fim_vigencia;
	private $fim_implantacao;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->MEDICAMENTO = null;
		$this->MEDTAB = null;
		$this->inicio_vigencia = null;
		$this->fim_vigencia = null;
		$this->fim_implantacao = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_MEDICAMENTO (){ return $this->MEDICAMENTO; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_inicio_vigencia (){ return $this->inicio_vigencia; }
	public function get_fim_vigencia (){ return $this->fim_vigencia; }
	public function get_fim_implantacao (){ return $this->fim_implantacao; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_MEDICAMENTO ($MEDICAMENTO){ $this->MEDICAMENTO = $MEDICAMENTO; }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_inicio_vigencia ($inicio_vigencia){ $this->inicio_vigencia = str_replace("'", "", "".$inicio_vigencia); }
	public function set_fim_vigencia ($fim_vigencia){ $this->fim_vigencia = str_replace("'", "", "".$fim_vigencia); }
	public function set_fim_implantacao ($fim_implantacao){ $this->fim_implantacao = str_replace("'", "", "".$fim_implantacao); }
}
?>