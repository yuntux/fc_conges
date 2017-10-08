<?php
session_start();
include("connection.php");
include("rest_server_api.php");
include("consultant.php");
include("demande.php");
$CONSULTANT = new Consultant($bdd);
$DEMANDE = new Demande($bdd);
include("auth.php");

//echo var_dump($_GET);
//echo var_dump($_POST);
$obj = new $_GET['object']($bdd);
//$entityBody = file_get_contents('php://input');
//echo $entityBody;
//$args = json_decode($entityBody);
if (isset($_GET['args_array'])) {
	$args = json_decode(base64_decode($_GET['args_array']));
}else{
	$args = array();
}
//echo var_dump($args);
$res = $obj->call_array_args($_GET['method'], $args);
echo json_encode($res);

?>
