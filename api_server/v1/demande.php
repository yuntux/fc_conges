<?php
include_once("sendmail.php");
include_once("lib_date.php");

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

	public function get_data_notification_mail($id_demande){
		$q ='SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.VALIDEUR_CONGES, a.DEBUT_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES,a.ID_CONGES,a.STATUT_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_demande.';';
//		error_log("TEST => ".$q, 3,"/tmp/test.log");
		$reponse1 = $this->bdd->query($q);
		$donnees1 = $reponse1->fetch();
		return $donnees1;
	}

	public function notification_mail_demande_a_valider($id_demande,$email){
		$demande = $this->get_data_notification_mail($id_demande);
		$message_html = '<html>
					<body>
						<p style="margin-bottom:10px;">Bonjour,</p>
						<p style="margin-bottom:10px;">Vous avez reçu une demande de congés à valider de la part de '.$demande['NOM_CONSULTANT']." ".$demande['PRENOM_CONSULTANT'].'. Cette demande de congés est du '.$demande['DEBUT_CONGES']." ".$demande['DEBUTMM_CONGES'].' au '.$demande['FIN_CONGES']." ".$demande['FINMS_CONGES'].'.</p>
						<p style="margin-bottom:20px;">Cordialement.</p>
					</body>
				</html>';

		mail_gateway($email,"Nouvelle demande de congés à valider",$message_html);
	}

	public function notification_mail_demande_change_status($id_demande){
		global $EMAIL_DIRECTION; 
		$demande = $this->get_data_notification_mail($id_demande);
//		error_log("TEST => ".$q, 3,"/tmp/test.log");

		$message_html = '<html>
					<body>
						<p style="margin-bottom:10px;">Bonjour '.$demande['PRENOM_CONSULTANT'].',</p>
						<p style="margin-bottom:10px;">Votre demande de congés numéro '.$demande['ID_CONGES'].' du '.$demande['DEBUT_CONGES']." ".$demande['DEBUTMM_CONGES'].' au '.$demande['FIN_CONGES']." ".$demande['FINMS_CONGES'].' est passée au statut '.$demande['STATUT_CONGES'].'.</p>
						<p style="margin-bottom:20px;">Cordialement.</p>
					</body>
				</html>';

		if ($demande['STATUT_CONGES']=='En cours de validation DM'){
			$DM = $this->bdd->query('SELECT * FROM consultant WHERE ID_CONSULTANT = '.$demande['VALIDEUR_CONGES'])->fetch();
                        $this->notification_mail_demande_a_valider($id_demande, $DM['EMAIL_CONSULTANT']);
		} elseif ($demande['STATUT_CONGES']=='En cours de validation Direction'){
			$this->notification_mail_demande_a_valider($id_demande, $EMAIL_DIRECTION);
		}

		mail_gateway($demande['EMAIL_CONSULTANT'],"Évolution de votre demande de congés",$message_html);
	}

        public function valider($id_demande){
		if($_SESSION['role'] == "DIRECTEUR")
		{
			$status = "'Validée'"; 
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
			}
		}
                try
                {
			$this->bdd->exec('UPDATE `conges` SET `STATUT_CONGES`='.$status.' WHERE `ID_CONGES`=\''.$id_demande.'\'');
			$this->notification_mail_demande_change_status($id_demande);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
			return False;
                }
		return True;
        }
	
        public function cloturer($id_demande){
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
				$status = "'AnnulÃ©e'";
			}
		}
                try
                {
			$this->bdd->exec('UPDATE `conges` SET `STATUT_CONGES`='.$status.' WHERE `ID_CONGES`=\''.$id_demande.'\'');
			$this->bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$id_demande.')');
			$this->notification_mail_demande_change_status($id_demande);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
			return False;
                }
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
				//seul le consultant peut voir les demande non encore envoyÃ©es au DM(status = "Attente envoie")
				$status = 'AND (`STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction")';
			}
		}
		$q = 'SELECT * FROM conges a, consultant c, consultant dm  WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and dm.ID_CONSULTANT = a.VALIDEUR_CONGES '.$status.' '.$restriction;
                $reponse = $this->bdd->query($q);
                return $reponse->fetchAll();
        }

	public function get_nb_open_days($dateFromDu, $dateFromAu) {	
		return get_nb_open_days($dateFromDu, $dateFromAu);
	}

	public function jrTravaille($date_saisie) {	
		return jrTravaille($date_saisie);
	}
	public function jrSemaine($date_saisie) {	
		return jrSemaine($date_saisie);
	}

	public function jrWeekend($date_saisie) {
		return jrWeekend($date_saisie);
	}

	public function jrFerie($date_saisie) {	
		return jrFerie($date_saisie);
	}

	public function nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS) {	
		if ($dateFromDu == "" || $dateFromAu == ""){
			return 0;
		}

		$nb_jours_a_poser = $this->get_nb_open_days($dateFromDu, $dateFromAu);

		$jour_debut_travaille = $this->jrTravaille($dateFromDu);
		if($jour_debut_travaille == True) {
			if ($thelistMM == 'Midi') {
				$nb_jours_a_poser = $nb_jours_a_poser - 0.5;
			}
		}

		$jour_fin_travaille = $this->jrTravaille($dateFromAu);
		if($jour_fin_travaille== True) {
			if ($thelistMS == 'Midi') {
				$nb_jours_a_poser = $nb_jours_a_poser - 0.5;
			}
		}
		return $nb_jours_a_poser;
	}

	public function enregistrer_demande($dateFromDu,$dateFromAu,$thelistMM,$thelistMS,$thelistDM,$commentaire,$nbjrsSS,$nbjrsAutres,$nbjrsConv,$nbjrsRTT,$nbjrsCP){
		$consultant = $_SESSION['id'];
		$message_erreur = True;
		$nbjrsTotal = $nbjrsCP + $nbjrsRTT + $nbjrsSS + $nbjrsConv + $nbjrsAutres;
		$nb_jours_a_poser = $this->nbJoursAPoser($dateFromDu,$dateFromAu,$thelistMM,$thelistMS);

		$filter = "CONSULTANT_CONGES = ".$consultant." AND (STATUT_CONGES NOT IN ('Annulée DM','Annulée Direction','Annulée')) AND (FIN_CONGES >= '".$dateFromDu."' AND DEBUT_CONGES <= '".$dateFromAu."')";

		$overlap_list = $this->get_list('*',$filter,False);
		if (count($overlap_list)>0){
			$message_erreur = "Il y a un chevauchement entre la demande à enregistrer et une autre demande non annulée.";
		}

		foreach (Array($nbjrsSS,$nbjrsAutres,$nbjrsConv,$nbjrsRTT,$nbjrsCP) as $nb_jour_cat){
			if ((10*$nb_jour_cat) % 5 != 0){
				$message_erreur = "La ventilation des congès doit se faire par demie journée. Vous avez saisi un nombre qui n'est pas un multiple de 0.5 pour l'une des catégories.";
			}
			if ($nb_jour_cat<0) {
				$message_erreur = "Le nombre de jours posés doit être positif (impossible de basculer des jours entre catégories).";
			}
		}
		if ($dateFromDu > $dateFromAu) {
			$message_erreur = "La date de fin ne doit pas etre anterieure à la date de début";
		}
		if ($nbjrsTotal != $nb_jours_a_poser) {
			$message_erreur = "Le nombre de jours ventilÃ© n'est pas Ã©gal au nombre de jours ouvrÃ©s.";
		}
		if ($multiple_05!=True) {
		}

		if ($message_erreur===True){ //ATTENTION : la triple egalite est indispensable
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
// TODO : dangereux, disque de concurrence, à encapsuler dans un transaction ACID
						//$this->bdd->beginTransaction(); 
						//TODO : ne plus stocker le nombre total de jours de congÃs NBJRS_CONGES
						$req = $this->bdd->prepare('INSERT INTO  conges (`ID_CONGES`, `DATEDEM_CONGES`, `DEBUT_CONGES`, `DEBUTMM_CONGES`, `FIN_CONGES`, `FINMS_CONGES`, `NBJRS_CONGES`, `CP_CONGES`, `RTT_CONGES`, `SS_CONGES`, `CONV_CONGES`, `AUTRE_CONGES`, `COMMENTAIRE`, `STATUT_CONGES`, `VALIDEUR_CONGES`, `CONSULTANT_CONGES`, `SOLDE_CONGES`) VALUES (DEFAULT,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
						$req->execute(array($dateFromDu,$thelistMM,$dateFromAu,$thelistMS,$nbjrsTotal,$nbjrsCP, $nbjrsRTT, $nbjrsSS, $nbjrsConv,$nbjrsAutres,$commentaire,'En cours de validation DM',$thelistDM,$consultant,$max_ID+1));
						//$this->bdd->commit(); 
						$id_demande = $this->bdd->lastInsertId();
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

					$this->notification_mail_demande_change_status($id_demande);
		}
		return $message_erreur;	
	}
}
