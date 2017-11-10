<?php 
include_once("../api_server/v1/lib_date.php");
session_start();
//echo "Session id local auprès du client php : ".session_id();
$EMAIL_CDG = 'validation_conges_cdg@fontaine-consultants.fr';
include("model/rest_client.php");

$REST_CLIENT = new REST_client("helpers"); 
$auth = new REST_client("auth");
$CONSULTANT = new REST_client("Consultant"); 
$DEMANDE = new REST_client("Demande"); 

function get_action(){
	$action = null;
	if (isset($_GET["action"]))
		$action = $_GET["action"];
	return $action;
}

$action = get_action();
if(empty($_SESSION['id']) && $action!='mot_passe_oublie')
{
	$action="login";
}
else 
{
	if ($action==null)
        	$action="home";
}

include_once("controller/".$action.".php");


header('Content-Type: text/html; charset=utf-8');
include("view/head.php");
include("view/".$view_to_display);
include("view/foot.php");

/*TODO 

Besoins Denis
- envoyer les varibales de paye en fin de mois
- générer la fiche de fin de moins
- forecast
- avoir le nb de jour au 31/12
- Le profil directeur (et uniquement lui) doit pouvoir ajuster en masse les soldes
- Le profil directeur doit pouvoir voir les congés de tout le monde / lien avec la vision globale


Technique : 
- documenter l'API
- debug du module d'envoie de mail => fonction vers Gmail mais pas fontaine-consultants.fr => pb antispam ?
- revue des droits
- supprimer les trigrammes
- gestion des erreurs strictes : systématiser l'usage des exception. Remonter au client un status en erreur par le code de retour HTTP / 200 / 403(droits) /etc 
- encapsulation dans des transactions ACID
- vérifier les try/catch et les close cursor pour chaque requete dans les modeles

Fonctionnel :
- gestion en dur des 2 jours de repos imposés chez FC / y compris à l'arrivée de nouveaux consultants en cours d'année.
- bouton re RAZ des compteur au 31/12 et 31/05
- gestion des CP et RTT n-2
- visualisation des soldes projetés au mois le mois, ou au moins au 31/12 pour les CP et au 31/05 pour les RTT => revoir le MDD pour les soldes et acquis
- validation automatique des demandes des membres du CDG / masquer le champ "dm" pour eux dans le formulaire
- annulation automatique des demandes nont traitée le jour du démarrage du congés ?
- dissocier l'annulation par le consultant d'une demande envoyée au DM mais pas encore validée par le DM d'une demande supprimée par le consultant avant envoie au DM ?
	=> inutile s'il on supprimer l'étape d'envoie au DM (on ne laisse qu'un bouton Enregistrer et envoyer au DM" au bas du formulaire de saisie
*/	
?>
