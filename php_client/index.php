<?php 
session_start();
include("controller/connection.php");
include("model/consultant.php");
include("model/demande.php");

$CONSULTANT = new Consultant($bdd); 
$DEMANDE = new Demande($bdd); 

function get_action(){
	$action = null;
	if (isset($_GET["action"]))
		$action = $_GET["action"];
	return $action;
}

if(empty($_SESSION['id']))
{
	$action="login";
}
else 
{
	$action = get_action();
	if ($action==null)
        	$action="home";
}

include_once("controller/".$action.".php");


header('Content-Type: text/html; charset=utf-8');
include("view/head.php");
include("view/".$view_to_display);
include("view/foot.php");

/*TODO 
- annulation automatique des demandes nont traitée le jour du démarrage du congés ?
*/	
?>
