<?php 
include_once("../api_server/v1/lib_date.php");
session_start();
//echo "Session id local auprès du client php : ".session_id();
include("model/rest_client.php");

$REST_CLIENT = new REST_client("helpers"); 
$auth = new REST_client("auth");
$CONSULTANT = new REST_client("Consultant"); 
$DEMANDE = new REST_client("Demande"); 
$PROJET = new REST_client("Projet"); 

function get_action(){
	$action = "home";
	if (isset($_GET["action"]))
		$action = $_GET["action"];
	return $action;
}

$action = get_action();
if(empty($_SESSION['id']) && $action!='mot_passe_oublie')
{
	$action="login";
}

include_once("controller/".$action.".php");


header('Content-Type: text/html; charset=utf-8');
include("view/head.php");
include("view/".$view_to_display);
include("view/foot.php");

/*TODO 

Fonctionnel :
- ANNULATION A POSTERIORI DE CONGES : Dans l'idéal il faudrait créer un nouveau status (différent de "Annulé direction" a priori) et logger précisément les passages de status (utilisateur / date), voire même avoir une double demande d'annulation par les salarié puis la direction... mais ça ne sera pas pour ce soir. Le mail de changement peut faire office de log pour le moment.
- DEMANDE DENIS : qu'il puisse modifier la ventilation des jours (sauf si on bloque la pose suivant le solde)
- DEMANDE DAVID : le DM doit pouvoir saisir un commentaire notamment pour indiquer la prise en compte de OK du DM "secondaire" (demande de David) => plutot un process de validation multi-DM ? À clarifier
- visualisation des soldes projetés au mois le mois, ou au moins au 31/12 pour les CP et au 31/05 pour les RTT => revoir le MDD pour les soldes et acquis
- OPPORTUNITE COMPTABLE : export CSV des congés
- mémoriser les dates de pose et dates de validation des demande ? + ajouter "validée le XXX" dans les IHM
- date limite de saisie dans le passé ? 1er du mois en cours ? du mois précédent
- ne pas compter les jours RH et F dans la synthèse annuelle avant l'arrivée du consultant (si le consultant est arrivé en cours d'année)
- forecast => avoir l'excel de Denis
- avoir le nb de jour au 31/12
- permettre de poser un reliquat de compteur même si ce n'est pas un multiple de 0,5.
- pouvoir modifier la ventilation des congés ? => en théorie Denis ne devrat pas pouvir le faire... en pratique ça nous fait gagner un temps précieux
- bloquer la pose de congés si induit des soldes négatifs => nécessite de gérer la projection
- gestion des temps partiel (Audrey)
- gestion des 2 jours de repos imposés chez FC / y compris à l'arrivée de nouveaux consultants en cours d'année.
- bouton re RAZ des compteur au 31/12 et 31/05
- gestion des CP n-2 et RTT n-2 avec leur date d'échéance
- masquer le champ "dm" pour eux dans le formulaire pour les directeurs et les DM
- annulation automatique des demandes nont traitée le jour du démarrage du congés ?
- dissocier l'annulation par le consultant d'une demande envoyée au DM mais pas encore validée par le DM d'une demande supprimée par le consultant avant envoie au DM ?
	=> inutile s'il on supprimer l'étape d'envoie au DM (on ne laisse qu'un bouton Enregistrer et envoyer au DM" au bas du formulaire de saisie => Solution retenue
- permettre d'ajouter les soldes sur l'écran d'inscription d'un consultant
- booléen consultant actif / inactif


Technique : 
- supprimer le champ "NBJRS_CONGES" de la table congés => le calculer dans la méthode au pire
- généraliser le $this->bdd->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); lorsque l'on JOIN deux fois la mm table
=> SECU : vérifier coté serveur que le DM supposé d'une demande est bien DM
- sécurité API => filtre clause WHERE
- documenter l'API
- revue des droits
- supprimer les trigrammes
- gestion des erreurs strictes : systématiser l'usage des exception. Remonter au client un status en erreur par le code de retour HTTP / 200 / 403(droits) /etc 
- encapsulation dans des transactions ACID
- vérifier les try/catch et les close cursor pour chaque requete dans les modeles

*/	
?>
