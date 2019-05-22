<?php
class REST_client{
	public $host;
	public $api_version;
	public $object;

        public function __construct($object) {
		$API_HOST = "https://conges.tasmane.com/api_server";
		$API_VERSION = "v1";
		$this->api_version = $API_VERSION;
		$this->host = $API_HOST;
		$this->object = $object;
        }

	/*
	public function auth_sso($sso_token){
	}
	*/

	public function get_url_auth($method,$object,$parameter_array=False){
		$url = $this->host."/".$this->api_version."/dispatcher.php?object=".urlencode($object)."&method=".urlencode($method);
		if ($parameter_array!=False){
			$url.="&args_array=".urlencode(base64_encode(json_encode($parameter_array)));
		}

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
if (isset($_SESSION['login']) && $_SESSION['login']=='admin.conges@tasmane.com'){
	echo '<br>MODE DEBUG / URL appelée par le client PHP - endPoint de l\'API => '.$url;
}
		$result = file_get_contents($url, false, $context);
		$result = json_decode($result,True);
		if ($result === "Error auth"){ //ATTENTION : la tiple égalité est primmordiale !!
			$message_erreur = 'Session inactive.';
			include("controller/deconnexion.php"); 	
		} else {
			return $result;
		}
	}

        public function __call($method_name, $args) {
//echo $method_name;
		//TODO : voir si ce ne peut pas être fait plus simplement
		if (in_array($method_name, Array("get_url_auth","post"))){
			return call_user_func_array(array($this, $method_name), $args_array);	
		} else {
                	$res = $this->post($method_name,$args);
                	return $res;
		}
        }

/*
	public function get(){
	}

	public function put(){
	}

	public function del(){
	}
*/
}

?>
