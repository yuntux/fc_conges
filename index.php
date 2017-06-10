<?php 

session_start();
include("controller/connection.php");

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

include("view/head.php");
include_once("controller/".$action.".php");
include("view/foot.php");

?>
