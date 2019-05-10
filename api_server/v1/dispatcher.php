<?php
//session_start();
include("connection.php");
include("rest_server_api.php");
include("consultant.php");
include("demande.php");
include("auth.php");
include("helpers.php");
include("projet.php");
include("partenaire.php");
include("ligne_staffing.php");
include("type_projet.php");
include("statut_projet.php");

include_once('model_singleton.php');

//echo var_dump($_GET);
//echo var_dump($_POST);
//$obj = new $_GET['object']($bdd);

if ($_GET['object']=='Demande'){
	$obj = get_demande_singleton($bdd);
}elseif ($_GET['object']=='Consultant'){
	$obj = get_consultant_singleton($bdd);
}else{
	$obj = new $_GET['object']($bdd);
}


error_log("\nAAAA=>".$_GET['object'], 3,"/tmp/test.log");
if (isset($_GET['args_array'])) {
	$args = json_decode(base64_decode($_GET['args_array']));
}else{
	$args = array();
}
//echo var_dump($args);
$res = $obj->call_array_args($_GET['method'], $args);
echo json_encode($res);

?>
