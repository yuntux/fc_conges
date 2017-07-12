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

	public function get_historique($id_consultant){
		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` < CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

	public function get_demandes_en_cours($id_consultant){
		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}
}
?>
