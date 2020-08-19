<?php
require_once('cnes.php');

class Login {
	// Propriedades
	private $id;
	private $first_login;
	private $senha;
	private $CNES;

	// Construtor
	function __construct(){
		$this->id = null;
		$this->first_login = null;
		$this->senha = null;
		$this->CNES = null;
	}

	private function is_true($val, $return_null=false){
		$boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
		return intval ($boolval===null && !$return_null ? false : $boolval);
	}

	public function geraSenha (){
		$this->senha = "";
		for ($i = 0; $i < 10; $i++){
			$choice = intval(rand(0, 2));
			if ($choice == 0){ $this->senha .= chr(rand(65, 90)); }
			if ($choice == 1){ $this->senha .= chr(rand(97, 122)); }
			if ($choice == 2){ $this->senha .= "".rand(0, 9); }
		}
	}

	// Métodos Get
	public function get_id (){ return $this->id; }
	public function get_first_login (){ return $this->first_login; }
	public function get_senha (){ return $this->senha; }
	public function get_CNES (){ return $this->CNES; }

	// Métodos Set
	public function set_id ($id){ $this->id = str_replace("'", "", "".$id); }
	public function set_first_login ($first_login){ $this->first_login = $this->is_true($first_login); }
	public function set_senha ($senha){ $this->senha = str_replace("'", "", "".$senha); }
	public function set_CNES ($CNES){ $this->CNES = $CNES; }
}
?>