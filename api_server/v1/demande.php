<?php
include_once("sendmail.php");

class Demande extends server_api_authentificated{
	public $CONSULTANT;

        public function __construct($bdd) {
		parent::__construct($bdd);
//                $this->CONSULTANT = new Consultant($bdd);
        }

        public function get_list($fields ='*', $filter=False, $order_by=False){
                $q = 'SELECT '.$fields.' FROM conges';
                if ($filter)
                        $q.= ' WHERE '.$filter;
                if ($order_by)
                        $q.= ' ORDER BY '.$order_by;
                $reponse = $this->bdd->query($q);
                return $reponse->fetchAll();
        }

        public function get_consultant($id_demande){
                $req = $this->bdd->prepare('SELECT * FROM conges a WHERE a.ID_CONGES=\''.$id_demande.'\'');
                $req->execute();
		return $req->fetch()['CONSULTANT_CONGES'];
	}

        public function get_dm($id_demande){
                $req = $this->bdd->prepare('SELECT * FROM conges a WHERE a.ID_CONGES=\''.$id_demande.'\'');
                $req->execute();
		return $req->fetch()['VALIDEUR_CONGES'];
	}

	public function mail_statut($id_demande, $mailtoDMfromCO=False, $mailtoCOfromDir_ok=False, $mailtoCOfromDM_ok=False, $mailtoDirfromDM=False, $mailtoCOfromDM_ko=False, $mailtoCOfromDir_ko=False)
	{
		global $EMAIL_CDC;
		$reponse1 = $this->bdd->query('SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.DEBUT_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_demande);
		$reponse1->fetch();
		{
			$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
			$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
			$EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
			$FIN_CONGES = $donnees1['FIN_CONGES'];
			$DEBUT_CONGES = $donnees1['DEBUT_CONGES'];
			$FINMS_CONGES = $donnees1['FINMS_CONGES'];
			$DEBUTMM_CONGES = $donnees1['DEBUTMM_CONGES'];
			$VALIDEUR_CONGES = $donnees1['VALIDEUR_CONGES'];
		}

		if ($mailtoCOfromDir_ok)
			mailtoCOfromDir_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
		if ($mailtoCOfromDM_ok)
                        mailtoCOfromDM_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
		if ($mailtoDirfromDM)
			mailtoDirfromDM($EMAIL_CDG, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $TRI_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
		if ($mailtoDMfromCO)
		{
			$EMAIL_DM = $this->bdd->query('SELECT * FROM consultant WHERE ID_CONSULTANT = '.$VALIDEUR_CONGES)->fetch()['EMAIL_CONSULTANT'];
			mailtoDMfromCO($EMAIL_DM, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
		}
		if ($mailtoCOfromDM_ko)
                        mailtoCOfromDM_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
		if ($$mailtoCOfromDir_ko)
                        mailtoCOfromDir_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);

	}

        public function valider($id_demande){
		$mailtoDMfromCO = False;
		$mailtoCOfromDir_ok = False;
		$mailtoGCOfromDM_ok = False;
		$mailtoDirfromDM = False;
		$mailtoCOfromDM_ko = False;
		$mailtoCOfromDir_ko = False;

		if($_SESSION['role'] == "DIRECTEUR")
		{
			$status = "'Validée'"; 
			$mailtoCOfromDir_ok = True;
		}
		elseif ($_SESSION['role'] == "DM")
		{
			if ($this->get_dm($id_demande) != $_SESSION['id'])
			{
				throw new Exception('Droits insuffisants');
				return False;
			}
			else
			{
				$status = "'En cours de validation Direction'"; 
				$mailtoCOfromDM_ok = True;
				$mailtoDirfromDM = True;
			}		
		}
		else
		{
			if ($this->get_consultant($id_demande) != $_SESSION['id'])
			{
				throw new Exception('Droits insuffisants');
				return False;
			}
			else
			{
				$status = "'En cours de validation DM'";
				$mailtoDMfromCO = True;
			}
		}
                try
                {
			$this->bdd->exec('UPDATE `conges` SET `STATUT_CONGES`='.$status.' WHERE `ID_CONGES`=\''.$id_demande.'\'');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
		$this->mail_statut($id_demande, $mailtoDMfromCO, $mailtoCOfromDir_ok, $mailtoCOfromDM_ok, $mailtoDirfromDM, $mailtoCOfromDM_ko, $mailtoCOfromDir_ko);
		return True;
        }
	
        public function cloturer($id_demande){
		$mailtoDMfromCO = False;
		$mailtoCOfromDir_ok = False;
		$mailtoCOfromDM_ok = False;
		$mailtoDirfromDM = False;
		$mailtoCOfromDM_ko = False;
		$mailtoCOfromDir_ko = False;

		if($_SESSION['role'] == "DIRECTEUR")
		{
			$status = "'Annulée Direction'"; 
			$mailtoCOfromDir_ko = True;
		}
		elseif ($_SESSION['role'] == "DM")
		{
			if ($this->get_dm($id_demande) != $_SESSION['id'])
			{
				throw new Exception('Droits insuffisants');
				return False;
			}
			else
			{
				$status = "'Annulée DM'"; 
				$mailtoCOfromDM_ko = True;
			}		
		}
		else
		{
			if ($this->get_consultant($id_demande) != $_SESSION['id'])
			{
				throw new Exception('Droits insuffisants');
				return False;
			}
			else
			{
				$status = "'Annulée'";
			}
		}
                try
                {
			$this->bdd->exec('UPDATE `conges` SET `STATUT_CONGES`='.$status.' WHERE `ID_CONGES`=\''.$id_demande.'\'');
			$this->bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$id_demande.')');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
		$this->mail_statut($id_demande, $mailtoDMfromCO, $mailtoCOfromDir_ok, $mailtoCOfromDM_ok, $mailtoDirfromDM, $mailtoCOfromDM_ko, $mailtoCOfromDir_ko);
		return True;
        }

        public function get_historique($id_consultant = False){
		// TODO : appeler get_list de cette classe ?
		$q = 'SELECT * FROM conges a, consultant c, consultant dm  WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and dm.ID_CONSULTANT = a.VALIDEUR_CONGES AND (`STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM" OR `STATUT_CONGES` = "Validée")';


		if ($id_consultant != False)
		{
			$q.= " AND a.CONSULTANT_CONGES = '".$id_consultant."'";
		} else {
			if($_SESSION['role'] == "DIRECTEUR")
			{
				//no restriction
			} 
			elseif ($_SESSION['role'] == "DM")
			{
				$q.= "AND dm.ID_CONSULTANT = '".$_SESSION['id']."'";
			}
			else
			{
				$q.= " AND a.CONSULTANT_CONGES = '".$_SESSION['id']."'";
			}
		}

                $reponse = $this->bdd->query($q);
                return $reponse->fetchAll();
        }

        public function get_demandes_en_cours($id_consultant = False){
		// TODO : appeler get_list de cette classe ?

		if ($id_consultant != False)
		{
			$restriction = " AND a.CONSULTANT_CONGES = '".$id_consultant."'";
			$status = 'AND (`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction")';
		} else {
			if($_SESSION['role'] == "DIRECTEUR")
			{
				$restriction = "";
				$status = 'AND (`STATUT_CONGES` = "En cours de validation Direction" OR (`STATUT_CONGES` = "En cours de validation DM" AND  dm.ID_CONSULTANT = \''.$_SESSION['id'].'\'))';
			} 
			elseif ($_SESSION['role'] == "DM")
			{
				$restriction = "AND dm.ID_CONSULTANT = '".$_SESSION['id']."'";
				$status = 'AND (`STATUT_CONGES` = "En cours de validation DM")';
			}
			else
			{
				$restriction = " AND a.CONSULTANT_CONGES = '".$_SESSION['id']."'";
				//seul le consultant peut voir les demande non encore envoyées au DM(status = "Attente envoie")
				$status = 'AND (`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction")';
			}
		}
		$q = 'SELECT * FROM conges a, consultant c, consultant dm  WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and dm.ID_CONSULTANT = a.VALIDEUR_CONGES '.$status.' '.$restriction;
                $reponse = $this->bdd->query($q);
                return $reponse->fetchAll();
        }

	private function get_nb_open_days($dateFromDu, $dateFromAu) {	
		$date_start = strtotime($dateFromDu);
		$date_stop = strtotime($dateFromAu);
		$nb_days_open = 0;
		while ($date_start <= $date_stop) {
			if ($this->jrTravaille($date_start)) {
				$nb_days_open++;		
			}
			$date_start = mktime(date('H', $date_start), date('i', $date_start), date('s', $date_start), date('m', $date_start), date('d', $date_start) + 1, date('Y', $date_start));			
		}		
		return $nb_days_open;
	}

	private function jrTravaille($date_saisie) {	
		if (!$this->jrSemaine($date_saisie) || $this->jrFerie($date_saisie)){
			return False;
		}
		return True;
	}
	private function jrSemaine($date_saisie) {	
		if (in_array(date('w', $date_start), array(0, 6))){
			return True;
		}
		return False;
	}

	private function jrWeekend($date_saisie) {
		return !$this->jrSemaine($date_saisie);
	}

	public function jrFerie($date_saisie) {	
	//	return True;
		$arr_bank_holidays = array(); // Tableau des jours feriés	
		$jrferie = 0 ;
		$year = (int)date('Y', $date_saisie) ;
			// Liste des jours feriés
		$arr_bank_holidays[] = '1_1_'.$year; // Jour de l'an
		$arr_bank_holidays[] = '1_5_'.$year; // Fete du travail
		$arr_bank_holidays[] = '8_5_'.$year; // Victoire 1945
		$arr_bank_holidays[] = '14_7_'.$year; // Fete nationale
		$arr_bank_holidays[] = '15_8_'.$year; // Assomption
		$arr_bank_holidays[] = '1_11_'.$year; // Toussaint
		$arr_bank_holidays[] = '11_11_'.$year; // Armistice 1918
		$arr_bank_holidays[] = '25_12_'.$year; // Noel
				
		// Récupération de paques. Permet ensuite d'obtenir le jour de l'ascension et celui de la pentecote	
		$easter = easter_date($year);
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + 86400); // Paques
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*39)); // Ascension
		$arr_bank_holidays[] = date('j_n_'.$year, $easter + (86400*50)); // Pentecote
		if (!in_array(date('j_n_Y', $date_saisie), $arr_bank_holidays)) {
			$jrferie = 1 ;	
		}					
		return $jrferie;
	}

	public function enregistrer_demande($dateFromDu,$dateFromAu,$thelistMM,$thelistMS,$thelistDM,$commentaire,$nbjrsSS,$nbjrsAutres,$nbjrsConv,$nbjrsRTT,$nbjrsCP){
		$consultant = $_SESSION['id'];
		//TODO : vérifier qu'il n'y a pas de recouvrement avec d'autres périodes de congés
		$nbjrsTotal = $nbjrsCP + $nbjrsRTT + $nbjrsSS + $nbjrsConv + $nbjrsAutres;
		$demid =0.5 ;
		$demif =0.5 ;

		$nb_jours_ouvres = $this->get_nb_open_days($dateFromDu, $dateFromAu);
		$test = $this->jrTravaille(strtotime($dateFromDu));
		if($test == 0) {
			$demid = 0;
				}
		if ($thelistMM == 'Midi') {
			$nb_jours_ouvres = $nb_jours_ouvres - $demid;
				}
		$test = $this->jrTravailee(strtotime($dateFromAu));
		if($test == 0) {
			$demif = 0;
			}
		if ($thelistMS == 'Midi') {
			$nb_jours_ouvres = $nb_jours_ouvres - $demif;
				}

		if ($dateFromDu > $dateFromAu) {
			$message_erreur = "La date de fin ne doit pas etre anterieure à la date de débt";
				}
		else if ($nbjrsTotal != $nb_jours_ouvres) {
			$message_erreur = "Le nombre de jours ventilé n'est pas égal au nombre de jours ouvrés.";
				}
		else{
					try
					{  
						$reponse1 = $this->bdd->query('SELECT * FROM solde WHERE ID_Solde = (SELECT MAX(ID_Solde) id FROM solde WHERE CONSULTANT_SOLDE ='.$consultant.') AND CONSULTANT_SOLDE ='.$consultant);  
						while ($donnees1 = $reponse1->fetch())
						{
							$SoldeCPn = $donnees1['CPn_SOLDE']; 
							$SoldeRTTn = $donnees1['RTTn_SOLDE']; 
							$SoldeCPn1 = $donnees1['CPn1_SOLDE']; 
							$SoldeRTTn1 = $donnees1['RTTn1_SOLDE']; 
						}
						$reponse1->closeCursor();
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->POSTMessage());
					}
					$newSoldeCPn = 0;
					$newSoldeRTTn = 0;
					$newSoldeCPn1 = 0;
					$newSoldeRTTn1 = 0;
					if ($nbjrsCP>$SoldeCPn1) {
						$newSoldeCPn = $SoldeCPn -$nbjrsCP + $SoldeCPn1;
						$newSoldeCPn1 = 0;
					}
					else{
						$newSoldeCPn1 = $SoldeCPn1 - $nbjrsCP ;
						$newSoldeCPn = $SoldeCPn;
					}
					if ($nbjrsRTT>$SoldeRTTn1) {
						$newSoldeRTTn = $SoldeRTTn -$nbjrsRTT + $SoldeRTTn1;
						$newSoldeRTTn1 = 0;
					}
					else{
						$newSoldeRTTn1 = $SoldeRTTn1 - $nbjrsRTT ;
						$newSoldeRTTn = $SoldeRTTn ;
					}
					try
					{  
						$reponse1 = $this->bdd->query('SELECT MAX(ID_SOLDE) id FROM solde');  
						while ($donnees1 = $reponse1->fetch())
						{
							$max_ID = $donnees1['id']; 
						}
						$reponse1->closeCursor();
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->POSTMessage());
					}
					try
					{
						//TODO : ne plus stocker le nombre total de jours de cong�s NBJRS_CONGES
						$req = $this->bdd->prepare('INSERT INTO  conges (`ID_CONGES`, `DATEDEM_CONGES`, `DEBUT_CONGES`, `DEBUTMM_CONGES`, `FIN_CONGES`, `FINMS_CONGES`, `NBJRS_CONGES`, `CP_CONGES`, `RTT_CONGES`, `SS_CONGES`, `CONV_CONGES`, `AUTRE_CONGES`, `COMMENTAIRE`, `STATUT_CONGES`, `VALIDEUR_CONGES`, `CONSULTANT_CONGES`, `SOLDE_CONGES`) VALUES (DEFAULT,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
						$req->execute(array($dateFromDu,$thelistMM,$dateFromAu,$thelistMS,$nbjrsTotal,$nbjrsCP, $nbjrsRTT, $nbjrsSS, $nbjrsConv,$nbjrsAutres,$commentaire,'En cours de validation DM',$thelistDM,$consultant,$max_ID+1));
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->POSTMessage());
					}
					try
					{
						$req = $this->bdd->prepare('INSERT INTO solde (`ID_Solde`, `CPn_SOLDE`, `CPn1_SOLDE`, `RTTn_SOLDE`, `RTTn1_SOLDE`, `CONSULTANT_SOLDE`, `DATE_SOLDE`) VALUES (?,?,?,?,?,?,CURRENT_DATE)');
						$req->execute(array($max_ID+1,$newSoldeCPn,$newSoldeCPn1,$newSoldeRTTn,$newSoldeRTTn1,$consultant));
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->POSTMessage());
					}

					$mailtoDMfromCO = True;
					$mailtoCOfromDir_ok = False;
					$mailtoCOfromDM_ok = False;
					$mailtoDirfromDM = False;
					$mailtoCOfromDM_ko = False;
					$mailtoCOfromDir_ko = False;
					$this->mail_statut($id_demande, $mailtoDMfromCO, $mailtoCOfromDir_ok, $mailtoCOfromDM_ok, $mailtoDirfromDM, $mailtoCOfromDM_ko, $mailtoCOfromDir_ko);
					return True;
		}
	}
}
