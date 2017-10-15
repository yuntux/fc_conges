<?php


class REST_client{
	public $host;
	public $api_version;
	public $object;

        public function __construct() {
		$API_HOST = "http://conges.fcnet/api_server";
		$API_VERSION = "v1";
		$this->api_version = $API_VERSION;
		$this->host = $API_HOST;
        }


	/*
	public function auth_sso($sso_token){
	}
	*/

	public function get_url($method,$object,$parameter_array=False){
		$url = $this->host."/".$this->api_version."/dispatcher.php?object=".urlencode($object)."&method=".urlencode($method);
		if ($parameter_array!=False){
			$url.="&args_array=".urlencode(base64_encode(json_encode($parameter_array)));
		}
		return $url;
	}

	public function get_url_auth($method,$object,$parameter_array){
		$url =  $this->get_url($method,$object,$parameter_array);
		if (isset($_SESSION['mon_token'])){
			$url.="&auth_token=".urlencode($_SESSION['mon_token']);
		}
		return $url;
	}

	public function post($method,$parameter_array){
		$object = $this->object;
		$url = $this->get_url_auth($method,$object,$parameter_array);
		$options = array(
		    'http' => array(
			'method'  => 'GET',
		    )
		);
		$context  = stream_context_create($options);
echo $url.'<br>';
		$result = file_get_contents($url, false, $context);
		$result = json_decode($result,True);
		if ($result === "Error auth"){ //ATTENTION : la tiple égalité est primmordiale !!
			$message_erreur = 'Session inactive.';
			include("controller/deconnexion.php"); 	
		} else {
			return $result;
		}
	}

	public function get(){
	}

	public function put(){
	}

	public function del(){
	}
}

class Auth extends REST_client
{
        public function __construct() {        
                $this->object = "auth";
		parent::__construct();
        }

/*
	public function auth_password($user, $password){
		$res = $this->post("auth","login_password");
		$_SESSION['auth_token'] = $res['token'];
		return res;
	}
*/
        public function __call($method_name, $args) {
                $res = $this->post($method_name,$args);
                return $res;
        }
}
class Consultant extends REST_client{
        public function __construct() {        
                $this->object = "Consultant";
		parent::__construct();
        }	

        public function __call($method_name, $args) {
		$res = $this->post($method_name,$args);
		return $res;
        }
}
class Demande extends REST_client{
        public function __construct() {
                $this->object = "Demande";
                parent::__construct();
        }

        public function __call($method_name, $args) {
                $res = $this->post($method_name,$args);
                return $res;
        }
}

//$test = new Auth();
//$test->hello("World");
?>
