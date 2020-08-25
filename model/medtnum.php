<?php
require_once('medicamento.php');
require_once('medtab.php');

class MedTnum {
	// Propriedades
	private $id;
	private $MEDICAMENTO;
	private $MEDTAB;
	private $cod_tiss;
	private $observacoes;
	private $cod_anterior;
	private $tipo_produto;
	private $tipo_codificacao;
	private $inicio_vigencia;
	private $fim_vigencia;
	private $motivo_insercao;
	private $fim_implantacao;
	private $cod_tissbrasindice;
	private $descricao_brasindice;
	private $apresentacao_brasindice;
	private $pertence_confaz;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->MEDICAMENTO = null;
		$this->MEDTAB = null;
		$this->cod_tiss = null;
		$this->observacoes = null;
		$this->cod_anterior = null;
		$this->tipo_produto = null;
		$this->tipo_codificacao = null;
		$this->inicio_vigencia = null;
		$this->fim_vigencia = null;
		$this->motivo_insercao = null;
		$this->fim_implantacao = null;
		$this->cod_tissbrasindice = null;
		$this->descricao_brasindice = null;
		$this->apresentacao_brasindice = null;
		$this->pertence_confaz = null;
	}

	private function is_true($val, $return_null=false){
		$boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
		return intval ($boolval===null && !$return_null ? false : $boolval);
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_MEDICAMENTO (){ return $this->MEDICAMENTO; }
	public function get_MEDTAB (){ return $this->MEDTAB; }
	public function get_cod_tiss (){ return $this->cod_tiss; }
	public function get_observacoes (){ return $this->observacoes; }
	public function get_cod_anterior (){ return $this->cod_anterior; }
	public function get_tipo_produto (){ return $this->tipo_produto; }
	public function get_tipo_codificacao (){ return $this->tipo_codificacao; }
	public function get_inicio_vigencia (){ return $this->inicio_vigencia; }
	public function get_fim_vigencia (){ return $this->fim_vigencia; }
	public function get_motivo_insercao (){ return $this->motivo_insercao; }
	public function get_fim_implantacao (){ return $this->fim_implantacao; }
	public function get_cod_tissbrasindice (){ return $this->cod_tissbrasindice; }
	public function get_descricao_brasindice (){ return $this->descricao_brasindice; }
	public function get_apresentacao_brasindice (){ return $this->apresentacao_brasindice; }
	public function get_pertence_confaz (){ return $this->pertence_confaz; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_MEDICAMENTO ($MEDICAMENTO){ $this->MEDICAMENTO = $MEDICAMENTO; }
	public function set_MEDTAB ($MEDTAB){ $this->MEDTAB = $MEDTAB; }
	public function set_cod_tiss ($cod_tiss){ $this->cod_tiss = str_replace("'", "", "".$cod_tiss); }
	public function set_observacoes ($observacoes){ $this->observacoes = str_replace("'", "", "".$observacoes); }
	public function set_cod_anterior ($cod_anterior){ $this->cod_anterior = str_replace("'", "", "".$cod_anterior); }
	public function set_tipo_produto ($tipo_produto){ $this->tipo_produto = str_replace("'", "", "".$tipo_produto); }
	public function set_tipo_codificacao ($tipo_codificacao){ $this->tipo_codificacao = str_replace("'", "", "".$tipo_codificacao); }
	public function set_inicio_vigencia ($inicio_vigencia){ $this->inicio_vigencia = str_replace("'", "", "".$inicio_vigencia); }
	public function set_fim_vigencia ($fim_vigencia){ $this->fim_vigencia = str_replace("'", "", "".$fim_vigencia); }
	public function set_motivo_insercao ($motivo_insercao){ $this->motivo_insercao = str_replace("'", "", "".$motivo_insercao); }
	public function set_fim_implantacao ($fim_implantacao){ $this->fim_implantacao = str_replace("'", "", "".$fim_implantacao); }
	public function set_cod_tissbrasindice ($cod_tissbrasindice){ $this->cod_tissbrasindice = str_replace("'", "", "".$cod_tissbrasindice); }
	public function set_descricao_brasindice ($descricao_brasindice){ $this->descricao_brasindice = str_replace("'", "", "".$descricao_brasindice); }
	public function set_apresentacao_brasindice ($apresentacao_brasindice){ $this->apresentacao_brasindice = str_replace("'", "", "".$apresentacao_brasindice); }
	public function set_pertence_confaz ($pertence_confaz){ $this->pertence_confaz = $this->is_true($pertence_confaz); }
}
?>