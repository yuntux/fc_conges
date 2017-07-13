<?php
class Consultant{
/*
	private $ID_CONSULTANT;
	private $NOM_CONSULTANT;
	private $PRENOM_CONSULTANT;
	private $EMAIL_CONSULTANT;
	private $PROFIL_CONSULTANT;
	private $TRIGRAMME_CONSULTANT;
	private $STATUS_CONSULTANT;
	private $PASSWORD_AUTHEN;
*/
	private $bdd;

	public function __construct($bdd) {
		$this->bdd = $bdd;
	}

	public function get(){
	}

	public function remove(){
	}

	public function add(){
	}

	public function update(){
	}

	public function get_list($fields ='*', $filter=False, $order_by=False){
		$q = 'SELECT '.$fields.' FROM consultant';
		if ($filter)
			$q.= ' WHERE '.$filter;
		if ($order_by)
			$q.= ' ORDER BY '.$order_by;
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

	public function get_historique($id_consultant){
		//TODO : passer par la methode get_historique de la classe Demande
		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` < CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

	public function get_demandes_en_cours($id_consultant){
		//TODO : passer par la methode get_demandes en cours de la classe Demande
		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

	public function get_acquis($id_consultant){
		$reponse = $this->bdd->query('SELECT * FROM acquis where CONSULTANT_ACQUIS =\''.$id_consultant.'\'');
		return $reponse->fetch();
	}

	public function get_solde($id_consultant){
		if ($_SESSION['role'] == "CONSULTANT" && $id_consulant != $_SESSION['id'])
		{
			throw new Exception('Droits insuffisants');
			return False;
		}
		$reponse = $this->bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_SOLDE) from solde where CONSULTANT_SOLDE = \''.$id_consultant.'\')');
		//TODO : check la robustesse si on annuler une demande à différents niveaux => ça supprimer la ligne de solde mais ça ne recalcule pas toutes les suivantes...
		return $reponse->fetch();
	}
}
?>
