<?php
include_once('rest_server_api.php');
class Consultant extends server_api_authentificated{
	public $DEMANDE;

	public function __construct($bdd) {
		parent::__construct($bdd);
                //$this->DEMANDE = new Demande($bdd);
	}
	public function add_demande($demande){
                $this->DEMANDE = $demande;
	}

	public function get(){
	}

	public function remove(){
	}

	public function add(){
	}

	public function update(){
	}

	public function get_list($fields ='*', $filter=False, $order_by="NOM_CONSULTANT", $inactifs=False){
		$q = 'SELECT '.$fields.' FROM consultant';
		if ($filter){
			$q.= ' WHERE '.$filter;
			if ($inactifs == False){
				$q.= ' AND `STATUT_CONSULTANT` = 1';
			}
		} else {
			if ($inactifs == False){
				$q.= ' WHERE `STATUT_CONSULTANT` = 1';
			}
		}
		if ($order_by)
			$q.= ' ORDER BY '.$order_by;
//echo $q;
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

	public function get_manager_list(){
		return $this->get_list('*', '`PROFIL_CONSULTANT` = "DM" or `PROFIL_CONSULTANT` = "DIRECTEUR"');
	}

	public function get_historique($id_consultant){
		//TODO : passer par la methode get_historique de la classe Demande
/*		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` < CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
*/
		return $this->DEMANDE->get_historique($id_consultant);
	}

	public function get_demandes_en_cours($id_consultant){
		//TODO : passer par la methode get_demandes en cours de la classe Demande
/*
		$q = 'SELECT * FROM conges WHERE CONSULTANT_CONGES = '.$id_consultant.' AND ((`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction") OR (`STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE))';
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
*/
		return $this->DEMANDE->get_demandes_en_cours($id_consultant);
	}

	public function get_acquis($id_consultant){
		$reponse = $this->bdd->query('SELECT * FROM acquis where CONSULTANT_ACQUIS =\''.$id_consultant.'\'');
		return $reponse->fetch();
	}

	public function set_acquis($id_consultant,$AcquisCPn,$AcquisCPn1,$AcquisRTTn,$AcquisRTTn1)
	{
		// TODO check rights
		try
                {
                	$record_maj = $this->bdd->exec('UPDATE `acquis` SET `CPn_ACQUIS`="'.$AcquisCPn.'",`CPn1_ACQUIS`="'.$AcquisCPn1.'",`RTTn_ACQUIS`="'.$AcquisRTTn.'",`RTTn1_ACQUIS`="'.$AcquisRTTn1.'",`DATE_ACQUIS`=CURRENT_DATE WHERE `CONSULTANT_ACQUIS`="'.$id_consultant.'"');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
	}

	public function get_solde($id_consultant){
		// TODO check rights
		if ($_SESSION['role'] == "CONSULTANT" && $id_consultant != $_SESSION['id'])
		{
			throw new Exception('Droits insuffisants');
			return False;
		}
		$reponse = $this->bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_SOLDE) from solde where CONSULTANT_SOLDE = \''.$id_consultant.'\')');
		//TODO : check la robustesse si on annuler une demande à différents niveaux => ça supprimer la ligne de solde mais ça ne recalcule pas toutes les suivantes...
		return $reponse->fetch();
	}


	public function set_solde($id_consultant,$SoldeCPn,$SoldeCPn1,$SoldeRTTn,$SoldeRTTn1)
	{

		$max_ID = 0;
		try
		{
			$reponse1 = $this->bdd->query('select max(ID_SOLDE) max_ID from solde where CONSULTANT_SOLDE = "'.$id_consultant.'" AND CONSULTANT_SOLDE ="'.$id_consultant.'"');
			while ($donnees1 = $reponse1->fetch())
			{
				$max_ID = $donnees1['max_ID'];
			}
			$reponse1->closeCursor();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		try
                {
                	$record_maj1 = $this->bdd->exec('UPDATE `solde` SET `CPn_SOLDE`='.$SoldeCPn.',`CPn1_SOLDE`='.$SoldeCPn1.',`RTTn_SOLDE`='.$SoldeRTTn.',`RTTn1_SOLDE`='.$SoldeRTTn1.',`DATE_SOLDE`= CURRENT_DATE WHERE ID_SOLDE = '.$max_ID);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
	}

	public function change_password($id_consultant,$old_password,$new_password){
		if ($_SESSION['id'] != $id_consultant)
		{
                        //throw new Exception('Seul le consultant peut changer son propre mot de passe. Néanmoins, les directeurs peuvent déclencher l\'envoi d\'un nouveau mot de passe.');
                        return "Seul le consultant peut changer son propre mot de passe. Néanmoins, les directeurs peuvent déclencher l\'envoi d\'un nouveau mot de passe.";
		}
		if (strlen($new_password) <7){
			//throw new Exception('Le mot de passe est trop court.');
			return "Le mot de passe est trop court.";
		}
		if ($this->check_password($this->get_login_from_id($id_consultant),$old_password) == True)
		{
			try
			{
				$this->bdd->exec('UPDATE `consultant` SET `PASSWORD_AUTHEN`= "'.$this->hash_password($new_password).'" WHERE `ID_CONSULTANT` = "'.$id_consultant.'"');
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
			return True;
		} else {
			return "L'ancien mot de passe n'est pas corret.";
		}
	}
	public function check_password($login,$password){
		try
		{
			$reponse = $this->bdd->query('SELECT * FROM consultant where EMAIL_CONSULTANT = \''.$login.'\' AND `STATUT_CONSULTANT` = 1')->fetch();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}

//echo "<br>passed : ".$password;
//echo "<br>passed : ".$this->hash_password($password);
//echo "<br>attendu : ".$reponse['PASSWORD_AUTHEN'];
		if($this->hash_password($password)==$reponse['PASSWORD_AUTHEN'])
			return True;
		else
			return False;

	}
	private function hash_password($password)
	{
		$GUERANDE ="n2sGZ93z";
		return hash('sha512', $GUERANDE.$password);
	}

	public function get_login_from_id($id_consultant)
	{
		try
                {
                        $reponse = $this->get_by_id($id_consultant);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
		return $reponse['EMAIL_CONSULTANT'];
	}

	public function get_id_from_login($login_consultant)
	{
		try
                {
                        $reponse = $this->get_by_login($login_consultant);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
		return $reponse['ID_CONSULTANT'];
	}
	public function get_by_login($login_consultant, $inactifs=False)
	{
		return $this->get_list('*', '`EMAIL_CONSULTANT` = \''.$login_consultant.'\'', "NOM_CONSULTANT", $inactifs)[0];
	}
	public function get_by_id($id_consultant, $inactifs=False)
	{
		return $this->get_list('*', '`ID_CONSULTANT` = \''.$id_consultant.'\'', "NOM_CONSULTANT", $inactifs)[0];
	}

	public function delete_consultant($id_consultant)
        {
                try 
                {
			if ($_SESSION['role'] != "DIRECTEUR")
			{
                       		throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                        	return False;
			}
			if ($_SESSION['id'] == $id_consultant)
			{
                       		//throw new Exception('Impossible de supprimer son propre compte.');
                       		return 'Impossible de supprimer son propre compte.';
                        	//return False;
			}
                }
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		try
		{
			$reponse1 = $this->bdd->query('DELETE * from consultant where `ID_CONSULTANT` = "'.$id_consultant.'"');;
			$reponse1 = $this->bdd->query('DELETE * from acquis where `CONSULTANT_ACQUIS` = "'.$id_consultant.'"');;
			$reponse1 = $this->bdd->query('DELETE * from conges where `CONSULTANT_CONGES` = "'.$id_consultant.'"');;
			$reponse1 = $this->bdd->query('DELETE * from solde where `CONSULTANT_SOLDE` = "'.$id_consultant.'"');;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}

	public function add_consultant($CONom,$COprenom,$COmail,$COprofil,$COTri)
	{
                try 
                {
                        if ($_SESSION['role'] != "DIRECTEUR")
                        {
                                throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                                return False;
                        }
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
		#trigramme and email unicity are verified at DB level. Prenom, nom, profil not null too
		try
		{
			$req = $this->bdd->prepare('INSERT INTO `consultant`(`NOM_CONSULTANT`, `PRENOM_CONSULTANT`, `EMAIL_CONSULTANT`, `PROFIL_CONSULTANT`, `TRIGRAMME_CONSULTANT`, `STATUT_CONSULTANT`) VALUES (?,?,?,?,?,?)');
			$req->execute(array($CONom,$COprenom,$COmail,$COprofil,$COTri,1));
			$max_ID = $this->bdd->lastInsertId();
			$req = $this->bdd->prepare('INSERT INTO `acquis`(`ID_ACQUIS`, `CPn_ACQUIS`, `CPn1_ACQUIS`, `RTTn_ACQUIS`, `RTTn1_ACQUIS`, `CONSULTANT_ACQUIS`, `INDICE_ACQUIS`, `DATE_ACQUIS`) VALUES (DEFAULT,?,?,?,?,?,?,CURRENT_DATE)');
			$req->execute(array(0,0,0,0,$max_ID,1));
			$req = $this->bdd->prepare('INSERT INTO `solde`(`ID_Solde`, `CPn_SOLDE`, `CPn1_SOLDE`, `RTTn_SOLDE`, `RTTn1_SOLDE`, `CONSULTANT_SOLDE`, `DATE_SOLDE`) VALUES (DEFAULT,?,?,?,?,?,CURRENT_DATE)');
			$req->execute(array(0,0,0,0,$max_ID));
			$this->init_password($max_ID);
		}
		catch(Exception $e)
		{
echo $e;
			die('Erreur : '.$e);
		}
		return True;
/*		TODO : catch SLQ error
		}elseif($mail_exist > 0){
			$message_erreur = "L'adresse mail saisie existe d<c3>ja" ;
		}elseif($CONom =="" || $COprenom =="" || $COmail =="" || $COTri ==""){
			$message_erreur = "Veuillez remplir tous les champs";
		}else{
			$message_erreur = "Le trigramme saisi existe déa";
		}
*/
	}


	public function update_consultant($id_consultant, $CONom,$COprenom,$COmail,$COprofil,$COTri,$COstatut)
	{
                try 
                {
                        if ($_SESSION['role'] != "DIRECTEUR")
                        {
                                throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                                return False;
                        }
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }

		try
		{
			$record_maj = $this->bdd->exec('UPDATE `consultant` SET `NOM_CONSULTANT`= "'.$CONom.'", `PRENOM_CONSULTANT`= "'.$COprenom.'", `EMAIL_CONSULTANT`= "'.$COmail.'", `TRIGRAMME_CONSULTANT`= "'.$COTri.'", `PROFIL_CONSULTANT`= "'.$COprofil.'", `STATUT_CONSULTANT`= "'.$COstatut.'"  WHERE `ID_CONSULTANT` = "'.$id_consultant.'"');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		return True;
	}


	public function init_password($id_consultant)
	{
		include_once("sendmail.php");

/*
                try
                {
                        if ($_SESSION['role'] != "DIRECTEUR")
                        {
                                throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                                return False;
                        }
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
*/
		$password = $this->get_random_string_alpha(10);
		$q = 'UPDATE `consultant` SET `PASSWORD_AUTHEN` = "'.$this->hash_password($password).'" WHERE `ID_CONSULTANT` = "'.$id_consultant.'"';
		//echo $q;
		$record_maj = $this->bdd->exec($q);
		$res = email_new_password($this->get_login_from_id($id_consultant), $password);
		return $res;
	}

	private function get_random_string_alpha($size)
	{
	    $password="";
	    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

	    for($i=0;$i<$size;$i++)
	    {
		$password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
	    }

	    return $password;
	}

	public function trigger_login_solde_conges($id_consultant)
	{
                try
                {
                        $reponse = $this->bdd->query('SELECT DATE_ACQUIS FROM acquis where CONSULTANT_ACQUIS = '.$id_consultant);
                        while ($donnees = $reponse->fetch())
                        {
                                $datemaj = $donnees['DATE_ACQUIS'];
                        }
                        $reponse->closeCursor();
                }
                catch (Exception $e)
                {
                                die('Erreur : ' . $e->getMessage());
                }
                $datecurrent =date("Y-m-d");
		$datemaj = null;
                sscanf($datemaj, "%4s-%2s-%2s", $annee, $mois, $jour);
                $a1 = $annee;
                $m1 = $mois;
                sscanf($datecurrent, "%4s-%2s-%2s", $annee, $mois, $jour);
                $a2 = $annee;
                $m2 = $mois;
                $dif_en_mois = ($m2-$m1)+12*($a2-$a1);
                $majCP = 2.08* $dif_en_mois;
                $indice=0;
                try
                {
                        $record_maj = $this->bdd->exec('UPDATE `acquis` SET `CPn_ACQUIS`= CPn_ACQUIS+'.$majCP.', `DATE_ACQUIS`=CURRENT_DATE WHERE `CONSULTANT_ACQUIS`= '.$id_consultant);
                        $indice=1;
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                if($indice=1){
                        try
                        {
                                $record_maj = $this->bdd->exec('UPDATE `solde` SET `CPn_SOLDE`= CPn_SOLDE+'.$majCP.' WHERE `CONSULTANT_SOLDE`= '.$id_consultant);
                                $indice=1;
                        }
                        catch(Exception $e)
                        {
                                die('Erreur : '.$e->getMessage());
                        }
                }

	}
}
