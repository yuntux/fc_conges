<?php 
session_start();
$EMAIL_CDG = 'validation_conges_cdg@fontaine-consultants.fr';
include("model/rest_client.php");

$CONSULTANT = new Consultant(); 
$DEMANDE = new Demande(); 

//echo var_dump($CONSULTANT->get_list());

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
- dissocier l'annulation par le consultant d'une demande envoyée au DM mais pas encore validée par le DM d'une demande supprimée par le consultant avant envoie au DM ?
	=> inutile s'il on supprimer l'étape d'envoie au DM (on ne laisse qu'un bouton Enregistrer et envoyer au DM" au bas du formulaire de saisie
- vérifier les try/catch et les close cursor pour chaque requete dans les modeles
- supprimer les trigrammes
- verifier la robustesse des calcul
- ajouter les rapports pour Denis
- bouton d'ecretage/remis eà 0 des soldes RTT et CP
- gestion en dur des jours chomés chez FC
- vérifier le non chevauchement de deux zones de congès 
- vérification de l'ancien mot de passe avant d'accepeter le changement
- email "mot de passe oublié"
*/	
?>
