<?php
class server_api{
        public $bdd;
	public $CONSULTANT;
	public $DEMANDE;

        public function __construct($bdd) {
                $this->bdd = $bdd;
		$this->CONSULTANT = new Consultant($bdd);
		$this->DEMANDE = new Demande($bdd);
        }

	function hello($p)
	{
		return "hello ".$p;
	}
	function call_array_args($method,$args_array){
		return call_user_func_array(array($this, $method), $args_array); 
	}
 
}

class server_api_authentificated extends server_api{

        public function __construct($bdd) {
                parent::__construct($bdd);
        }

        public function call_array_args($method_name, $args_array) {
                //$auth_ok = $this->check_token_validity($_HEADER['Authorization']);
                $auth_ok = $this->check_token_validity();
		if ($auth_ok==False) {
			return "Error auth";
		}
		return call_user_func_array(array($this, $method_name), $args_array);
        }

	function check_token_validity($token){
		if (isset($_GET['auth_token']) == False){
			return False;
		} else {
			$token = $_GET['auth_token'];
		}
		session_id($token);
		session_start();
		if (count($_SESSION)>0)
			return True;
		else
			return False;
	}
}


?>
