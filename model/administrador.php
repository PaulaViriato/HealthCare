<?php
class Administrador {
	// Propriedades
	private $id;
	private $nome;
	private $email;
	private $login;
	private $senha;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->nome = null;
		$this->email = null;
		$this->login = null;
		$this->senha = null;
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_nome (){ return $this->nome; }
	public function get_email (){ return $this->email; }
	public function get_login (){ return $this->login; }
	public function get_senha (){ return $this->senha; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_nome ($nome){ $this->nome = str_replace("'", "", "".$nome); }
	public function set_email ($email){ $this->email = str_replace("'", "", "".$email); }
	public function set_login ($login){ $this->login = str_replace("'", "", "".$login); }
	public function set_senha ($senha){ $this->senha = str_replace("'", "", "".$senha); }
}
?>