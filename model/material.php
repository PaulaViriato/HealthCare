<?php
class Material {
	// Propriedades
	private $id;
	private $cnpj;
	private $fabricante;
	private $classe_risco;
	private $descricao_produto;
	private $especialidade_produto;
	private $classificacao_produto;
	private $nome_tecnico;
	private $unidmin_fracao;
	private $tipo_produto;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->cnpj = null;
		$this->fabricante = null;
		$this->classe_risco = null;
		$this->descricao_produto = null;
		$this->especialidade_produto = null;
		$this->classificacao_produto = null;
		$this->nome_tecnico = null;
		$this->unidmin_fracao = null;
		$this->tipo_produto = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_cnpj (){ return $this->cnpj; }
	public function get_fabricante (){ return $this->fabricante; }
	public function get_classe_risco (){ return $this->classe_risco; }
	public function get_descricao_produto (){ return $this->descricao_produto; }
	public function get_especialidade_produto (){ return $this->especialidade_produto; }
	public function get_classificacao_produto (){ return $this->classificacao_produto; }
	public function get_nome_tecnico (){ return $this->nome_tecnico; }
	public function get_unidmin_fracao (){ return $this->unidmin_fracao; }
	public function get_tipo_produto (){ return $this->tipo_produto; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_cnpj ($cnpj){ $this->cnpj = str_replace("'", "", "".$cnpj); }
	public function set_fabricante ($fabricante){ $this->fabricante = str_replace("'", "", "".$fabricante); }
	public function set_classe_risco ($classe_risco){ $this->classe_risco = str_replace("'", "", "".$classe_risco); }
	public function set_descricao_produto ($descricao_produto){ $this->descricao_produto = str_replace("'", "", "".$descricao_produto); }
	public function set_especialidade_produto ($especialidade_produto){ $this->especialidade_produto = str_replace("'", "", "".$especialidade_produto); }
	public function set_classificacao_produto ($classificacao_produto){ $this->classificacao_produto = str_replace("'", "", "".$classificacao_produto); }
	public function set_nome_tecnico ($nome_tecnico){ $this->nome_tecnico = str_replace("'", "", "".$nome_tecnico); }
	public function set_unidmin_fracao ($unidmin_fracao){ $this->unidmin_fracao = str_replace("'", "", "".$unidmin_fracao); }
	public function set_tipo_produto ($tipo_produto){ $this->tipo_produto = str_replace("'", "", "".$tipo_produto); }
}
?>
