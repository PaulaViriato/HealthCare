<?php
require_once('material.php');
require_once('mattab.php');

class MatTuss {
	// Propriedades
	private $id;
	private $MATERIAL;
	private $MATTAB;
	private $termo;
	private $modelo;
	private $inicio_vigencia;
	private $fim_vigencia;
	private $fim_implantacao;
	private $codigo_termo;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->MATERIAL = null;
		$this->MATTAB = null;
		$this->termo = null;
		$this->modelo = null;
		$this->inicio_vigencia = null;
		$this->fim_vigencia = null;
		$this->fim_implantacao = null;
		$this->codigo_termo = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_MATERIAL (){ return $this->MATERIAL; }
	public function get_MATTAB (){ return $this->MATTAB; }
	public function get_termo (){ return $this->termo; }
	public function get_modelo (){ return $this->modelo; }
	public function get_inicio_vigencia (){ return $this->inicio_vigencia; }
	public function get_fim_vigencia (){ return $this->fim_vigencia; }
	public function get_fim_implantacao (){ return $this->fim_implantacao; }
	public function get_codigo_termo (){ return $this->codigo_termo; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_MATERIAL ($MATERIAL){ $this->MATERIAL = $MATERIAL; }
	public function set_MATTAB ($MATTAB){ $this->MATTAB = $MATTAB; }
	public function set_termo ($termo){ $this->termo = str_replace("'", "", "".$termo); }
	public function set_modelo ($modelo){ $this->modelo = str_replace("'", "", "".$modelo); }
	public function set_inicio_vigencia ($inicio_vigencia){ $this->inicio_vigencia = str_replace("'", "", "".$inicio_vigencia); }
	public function set_fim_vigencia ($fim_vigencia){ $this->fim_vigencia = str_replace("'", "", "".$fim_vigencia); }
	public function set_fim_implantacao ($fim_implantacao){ $this->fim_implantacao = str_replace("'", "", "".$fim_implantacao); }
	public function set_codigo_termo ($codigo_termo){ $this->codigo_termo = str_replace("'", "", "".$codigo_termo); }
}
?>