<?php
class Medicamento {
	// Propriedades
	private $id;
	private $substancia;
	private $cnpj;
	private $laboratorio;
	private $codggrem;
	private $produto;
	private $apresentacao;
	private $classe_terapeutica;
	private $tipo_produto;
	private $tarja;
	private $cod_termo;
	private $generico;
	private $grupo_farmacologico;
	private $classe_farmacologica;
	private $forma_farmaceutica;
	private $unidmin_fracao;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->substancia = null;
		$this->cnpj = null;
		$this->laboratorio = null;
		$this->codggrem = null;
		$this->produto = null;
		$this->apresentacao = null;
		$this->classe_terapeutica = null;
		$this->tipo_produto = null;
		$this->tarja = null;
		$this->cod_termo = null;
		$this->generico = null;
		$this->grupo_farmacologico = null;
		$this->classe_farmacologica = null;
		$this->forma_farmaceutica = null;
		$this->unidmin_fracao = null;
	}

	private function is_true($val, $return_null=false){
		$boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
		return intval ($boolval===null && !$return_null ? false : $boolval);
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_substancia (){ return $this->substancia; }
	public function get_cnpj (){ return $this->cnpj; }
	public function get_laboratorio (){ return $this->laboratorio; }
	public function get_codggrem (){ return $this->codggrem; }
	public function get_produto (){ return $this->produto; }
	public function get_apresentacao (){ return $this->apresentacao; }
	public function get_classe_terapeutica (){ return $this->classe_terapeutica; }
	public function get_tipo_produto (){ return $this->tipo_produto; }
	public function get_tarja (){ return $this->tarja; }
	public function get_cod_termo (){ return $this->cod_termo; }
	public function get_generico (){ return $this->generico; }
	public function get_grupo_farmacologico (){ return $this->grupo_farmacologico; }
	public function get_classe_farmacologica (){ return $this->classe_farmacologica; }
	public function get_forma_farmaceutica (){ return $this->forma_farmaceutica; }
	public function get_unidmin_fracao (){ return $this->unidmin_fracao; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_substancia ($substancia){ $this->substancia = str_replace("'", "", "".$substancia); }
	public function set_cnpj ($cnpj){ $this->cnpj = str_replace("'", "", "".$cnpj); }
	public function set_laboratorio ($laboratorio){ $this->laboratorio = str_replace("'", "", "".$laboratorio); }
	public function set_codggrem ($codggrem){ $this->codggrem = str_replace("'", "", "".$codggrem); }
	public function set_produto ($produto){ $this->produto = str_replace("'", "", "".$produto); }
	public function set_apresentacao ($apresentacao){ $this->apresentacao = str_replace("'", "", "".$apresentacao); }
	public function set_classe_terapeutica ($classe_terapeutica){ $this->classe_terapeutica = str_replace("'", "", "".$classe_terapeutica); }
	public function set_tipo_produto ($tipo_produto){ $this->tipo_produto = str_replace("'", "", "".$tipo_produto); }

	public function set_tarja ($tarja){
		if (is_null($tarja)){ $this->tarja = null; }
		else{ $this->tarja = str_replace("'", "", "".$tarja); }
	}

	public function set_cod_termo ($cod_termo){ $this->cod_termo = str_replace("'", "", "".$cod_termo); }
	public function set_generico ($generico){ $this->generico = $this->is_true($generico); }
	public function set_grupo_farmacologico ($grupo_farmacologico){ $this->grupo_farmacologico = str_replace("'", "", "".$grupo_farmacologico); }
	public function set_classe_farmacologica ($classe_farmacologica){ $this->classe_farmacologica = str_replace("'", "", "".$classe_farmacologica); }
	public function set_forma_farmaceutica ($forma_farmaceutica){ $this->forma_farmaceutica = str_replace("'", "", "".$forma_farmaceutica); }
	public function set_unidmin_fracao ($unidmin_fracao){ $this->unidmin_fracao = str_replace("'", "", "".$unidmin_fracao); }
}
?>