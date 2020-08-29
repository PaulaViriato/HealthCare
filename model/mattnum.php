<?php
require_once('material.php');
require_once('mattab.php');

class MatTnum {
	// Propriedades
	private $id;
	private $MATERIAL;
	private $MATTAB;
	private $nome;
	private $cod_tiss;
	private $nome_comercial;
	private $observaces;
	private $cod_anterior;
	private $ref_tamanhomodelo;
	private $tipo_codificacao;
	private $inicio_vigencia;
	private $fim_vigencia;
	private $motivo_insercao;
	private $fim_implantacao;
	private $cod_simpro;
	private $descricaoproduto_simpro;
	private $equivalencia_tecnica;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->MATERIAL = null;
		$this->MATTAB = null;
		$this->nome = null;
		$this->cod_tiss = null;
		$this->nome_comercial = null;
		$this->observaces = null;
		$this->cod_anterior = null;
		$this->ref_tamanhomodelo = null;
		$this->tipo_codificacao = null;
		$this->inicio_vigencia = null;
		$this->fim_vigencia = null;
		$this->motivo_insercao = null;
		$this->fim_implantacao = null;
		$this->cod_simpro = null;
		$this->descricaoproduto_simpro = null;
		$this->equivalencia_tecnica = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_MATERIAL (){ return $this->MATERIAL; }
	public function get_MATTAB (){ return $this->MATTAB; }
	public function get_nome (){ return $this->nome; }
	public function get_cod_tiss (){ return $this->cod_tiss; }
	public function get_nome_comercial (){ return $this->nome_comercial; }
	public function get_observaces (){ return $this->observaces; }
	public function get_cod_anterior (){ return $this->cod_anterior; }
	public function get_ref_tamanhomodelo (){ return $this->ref_tamanhomodelo; }
	public function get_tipo_codificacao (){ return $this->tipo_codificacao; }
	public function get_inicio_vigencia (){ return $this->inicio_vigencia; }
	public function get_fim_vigencia (){ return $this->fim_vigencia; }
	public function get_motivo_insercao (){ return $this->motivo_insercao; }
	public function get_fim_implantacao (){ return $this->fim_implantacao; }
	public function get_cod_simpro (){ return $this->cod_simpro; }
	public function get_descricaoproduto_simpro (){ return $this->descricaoproduto_simpro; }
	public function get_equivalencia_tecnica (){ return $this->equivalencia_tecnica; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_MATERIAL ($MATERIAL){ $this->MATERIAL = $MATERIAL; }
	public function set_MATTAB ($MATTAB){ $this->MATTAB = $MATTAB; }
	public function set_nome ($nome){ $this->nome = str_replace("'", "", "".$nome); }
	public function set_cod_tiss ($cod_tiss){ $this->cod_tiss = str_replace("'", "", "".$cod_tiss); }
	public function set_nome_comercial ($nome_comercial){ $this->nome_comercial = str_replace("'", "", "".$nome_comercial); }
	public function set_observaces ($observaces){ $this->observaces = str_replace("'", "", "".$observaces); }
	public function set_cod_anterior ($cod_anterior){ $this->cod_anterior = str_replace("'", "", "".$cod_anterior); }
	public function set_ref_tamanhomodelo ($ref_tamanhomodelo){ $this->ref_tamanhomodelo = str_replace("'", "", "".$ref_tamanhomodelo); }
	public function set_tipo_codificacao ($tipo_codificacao){ $this->tipo_codificacao = str_replace("'", "", "".$tipo_codificacao); }
	public function set_inicio_vigencia ($inicio_vigencia){ $this->inicio_vigencia = str_replace("'", "", "".$inicio_vigencia); }
	public function set_fim_vigencia ($fim_vigencia){ $this->fim_vigencia = str_replace("'", "", "".$fim_vigencia); }
	public function set_motivo_insercao ($motivo_insercao){ $this->motivo_insercao = str_replace("'", "", "".$motivo_insercao); }
	public function set_fim_implantacao ($fim_implantacao){ $this->fim_implantacao = str_replace("'", "", "".$fim_implantacao); }
	public function set_cod_simpro ($cod_simpro){ $this->cod_simpro = str_replace("'", "", "".$cod_simpro); }
	public function set_descricaoproduto_simpro ($descricaoproduto_simpro){ $this->descricaoproduto_simpro = str_replace("'", "", "".$descricaoproduto_simpro); }
	public function set_equivalencia_tecnica ($equivalencia_tecnica){ $this->equivalencia_tecnica = str_replace("'", "", "".$equivalencia_tecnica); }
}
?>
