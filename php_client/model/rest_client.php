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

	public function post($method,$parameter_array){
		$object = $this->object;
		$url = $this->host."/".$this->api_version."/dispatcher.php?object=".$object."&method=".$method."&args_array=".base64_encode(json_encode($parameter_array));
		
		$header = "Content-type: application/x-www-form-urlencoded\r\n";
		if (isset($_SESSION['mon_token'])){
			//$header.= "Authorization: ".$this->auth_token;
			$url.="&auth_token=".$_SESSION['mon_token'];
		}
		$options = array(
		    'http' => array(
			'header'  => $header,
			'method'  => 'GET',
			//'content' => json_encode($parameter_array)
		    )
		);
		$context  = stream_context_create($options);
echo $url.'<br>';
//echo json_encode($parameter_array);
		$result = file_get_contents($url, false, $context);
//echo $result;
		if ($result === FALSE) { /* Handle error */ }

		$result = json_decode($result,True);
//echo $result;
//echo var_dump($result);
		return $result;
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
