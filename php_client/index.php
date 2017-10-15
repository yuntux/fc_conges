<?php 
session_start();
$EMAIL_CDG = 'validation_conges_cdg@fontaine-consultants.fr';
include("model/rest_client.php");

$REST_CLIENT = new REST_client(); 
$CONSULTANT = new Consultant(); 
$DEMANDE = new Demande(); 

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
Technique : 
- gestion des erreurs stricte : systématiser l'usage des exception. Remonter au client un status en erreur par le code de retour HTTP / 200 / 403(droits) /etc 
- encapsulation dans des transactions ACID
- revue des droits
- contrôler qu'on a bien des multiples de 0.5 jour par catégorie lors de la saisie des demandes

Fonctionnel :
- gestion des CP et RTT n-2
- bouton re RAZ des compteur au 31/12 et 31/05
- visualisation des soldes projetés au mois le mois, ou au moins au 31/12 pour les CP et au 31/05 pour les RTT => revoir le MDD pour les soldes et acquis
- validation automatique des demandes des membres du CDG / masquer le champ "dm" pour eux dans le formulaire
- annulation automatique des demandes nont traitée le jour du démarrage du congés ?
- dissocier l'annulation par le consultant d'une demande envoyée au DM mais pas encore validée par le DM d'une demande supprimée par le consultant avant envoie au DM ?
	=> inutile s'il on supprimer l'étape d'envoie au DM (on ne laisse qu'un bouton Enregistrer et envoyer au DM" au bas du formulaire de saisie
- vérifier les try/catch et les close cursor pour chaque requete dans les modeles
- supprimer les trigrammes
- gestion en dur des 2 jours de repos imposés chez FC / y compris à l'arrivée de nouveaux consultants en cours d'année.
- vérifier le non chevauchement de deux zones de congès 
*/	
?>
