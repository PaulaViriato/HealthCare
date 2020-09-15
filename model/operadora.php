<?php
class Operadora {
	// Propriedades
	private $id;
	private $nome;
	private $codans;
	private $cnpj;
	private $email;
	private $contato;
	private $login;
	private $senha;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->nome = null;
		$this->codans = null;
		$this->cnpj = null;
		$this->email = null;
		$this->contato = null;
		$this->login = null;
		$this->senha = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_nome (){ return $this->nome; }
	public function get_codans (){ return $this->codans; }
	public function get_cnpj (){ return $this->cnpj; }
	public function get_email (){ return $this->email; }
	public function get_contato (){ return $this->contato; }
	public function get_login (){ return $this->login; }
	public function get_senha (){ return $this->senha; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_nome ($nome){ $this->nome = str_replace("'", "", "".$nome); }
	public function set_codans ($codans){ $this->codans = str_replace("'", "", "".$codans); }
	public function set_cnpj ($cnpj){ $this->cnpj = str_replace("'", "", "".$cnpj); }
	public function set_email ($email){ $this->email = str_replace("'", "", "".$email); }
	public function set_contato ($contato){ $this->contato = str_replace("'", "", "".$contato); }
	public function set_login ($login){ $this->login = str_replace("'", "", "".$login); }
	public function set_senha ($senha){ $this->senha = str_replace("'", "", "".$senha); }
}
?>
