<?php

$dateFromDu=$_POST['dateFromDu'];
$dateFromAu=$_POST['dateFromAu'];
$thelistMM=$_POST['thelistMM'];
$thelistMS=$_POST['thelistMS'];
$thelistDM=$_POST['thelistDM'];
$commentaire=$_POST['commentaire'];
$nbjrs=$_POST['nbJrs_hidden'];
$nbjrsSS=$_POST['nbjrsSS'];
$nbjrsAutres=$_POST['nbjrsAutres'];
$nbjrsConv=$_POST['nbjrsConv'];
$nbjrsRTT=$_POST['nbjrsRTT'];
$nbjrsCP=$_POST['nbjrsCP'];
$nbjrsSaisi = $_POST['nbjrsCP'] + $_POST['nbjrsRTT'] + $_POST['nbjrsSS'] + $_POST['nbjrsConv'] + $_POST['nbjrsAutres'];
$date_depart = strtotime($dateFromDu);
$date_fin = strtotime($dateFromAu);
$demid =0.5 ;
$demif =0.5 ;
function get_nb_open_days($date_start, $date_stop) {	
	$arr_bank_holidays = array(); // Tableau des jours feriés	
	
	$diff_year = date('Y', $date_stop) - date('Y', $date_start);
	for ($i = 0; $i <= $diff_year; $i++) {			
		$year = (int)date('Y', $date_start) + $i;
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
	}
	$nb_days_open = 0;

	while ($date_start <= $date_stop) {
		if (!in_array(date('w', $date_start), array(0, 6)) 
		&& !in_array(date('j_n_'.date('Y', $date_start), $date_start), $arr_bank_holidays)) {
			$nb_days_open++;		
		}
		$date_start = mktime(date('H', $date_start), date('i', $date_start), date('s', $date_start), date('m', $date_start), date('d', $date_start) + 1, date('Y', $date_start));			
	}		
	return $nb_days_open;
}

function jrFerie($date_saisie) {	
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
	if (!in_array(date('w', $date_saisie), array(0, 6)) && !in_array(date('j_n_'.date('Y', $date_saisie), $date_saisie), $arr_bank_holidays)) {
		$jrferie = 1 ;	
	}					
	return $jrferie;
}


$nb_jours_ouvres = get_nb_open_days($date_depart, $date_fin);
$test = jrFerie(strtotime($dateFromDu));
if($test == 0) {
	$demid = 0;
		}
if ($thelistMM == 'Midi') {
	$nb_jours_ouvres = $nb_jours_ouvres - $demid;
		}
$test = jrFerie(strtotime($dateFromAu));
if($test == 0) {
	$demif = 0;
	}
if ($thelistMS == 'Midi') {
	$nb_jours_ouvres = $nb_jours_ouvres - $demif;
		}

if ($dateFromDu > $dateFromAu) {
	$message_erreur = "La date de fin ne doit pas etre anterieure à la date de débt";
		}
else if ($nbjrsSaisi != $nb_jours_ouvres) {
	$message_erreur = "Le nombre de jours ventil� n'est pas �gal au nombre de jours ouvr�s.";
		}
else{
	if(isset($_POST['Enregistrer']))
		{
			$dateFromDu=$_POST['dateFromDu'];
			$dateFromAu=$_POST['dateFromAu'];
			$thelistMM=$_POST['thelistMM'];
			$thelistMS=$_POST['thelistMS'];
			$thelistDM=$_POST['thelistDM'];
			$commentaire=$_POST['commentaire'];
			$nbjrs=$_POST['nbJrs_hidden'];
			$nbjrsSS=$_POST['nbjrsSS'];
			$nbjrsAutres=$_POST['nbjrsAutres'];
			$nbjrsConv=$_POST['nbjrsConv'];
			$nbjrsRTT=$_POST['nbjrsRTT'];
			$nbjrsCP=$_POST['nbjrsCP'];
			$consultant=$_SESSION['id'];
			try
			{  
				$reponse1 = $bdd->query('SELECT * FROM solde WHERE ID_Solde = (SELECT MAX(ID_Solde) id FROM solde WHERE CONSULTANT_SOLDE ='.$consultant.') AND CONSULTANT_SOLDE ='.$consultant);  
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
			if ($nbjrsCP>$soldeCPn1) {
				$newSoldeCPn = $SoldeCPn -$nbjrsCP + $SoldeCPn1;
				$newSoldeCPn1 = 0;
			}
			else{
				$newSoldeCPn1 = $SoldeCPn1 - $nbjrsCP ;
				$newSoldeCPn = $SoldeCPn;
			}
			if ($nbjrsRTT>$soldeRTTn1) {
				$newSoldeRTTn = $SoldeRTTn -$nbjrsRTT + $SoldeRTTn1;
				$newSoldeRTTn1 = 0;
			}
			else{
				$newSoldeRTTn1 = $SoldeRTTn1 - $nbjrsRTT ;
				$newSoldeRTTn = $SoldeRTTn ;
			}
			try
			{  
				$reponse1 = $bdd->query('SELECT MAX(ID_SOLDE) id FROM solde');  
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
		 		$req = $bdd->prepare('INSERT INTO  conges (`ID_CONGES`, `DATEDEM_CONGES`, `DEBUT_CONGES`, `DEBUTMM_CONGES`, `FIN_CONGES`, `FINMS_CONGES`, `NBJRS_CONGES`, `CP_CONGES`, `RTT_CONGES`, `SS_CONGES`, `CONV_CONGES`, `AUTRE_CONGES`, `COMMENTAIRE`, `STATUT_CONGES`, `VALIDEUR_CONGES`, `CONSULTANT_CONGES`, `SOLDE_CONGES`) VALUES (DEFAULT,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
		   		$req->execute(array($_POST['dateFromDu'],$_POST['thelistMM'],$_POST['dateFromAu'],$_POST['thelistMS'],$_POST['nbJrs_hidden'],$nbjrsCP, $nbjrsRTT, $nbjrsSS, $nbjrsConv,$nbjrsAutres,$commentaire,'Attente envoie',$thelistDM,$consultant,$max_ID+1));
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			try
	 		{
				$req = $bdd->prepare('INSERT INTO solde (`ID_Solde`, `CPn_SOLDE`, `CPn1_SOLDE`, `RTTn_SOLDE`, `RTTn1_SOLDE`, `CONSULTANT_SOLDE`, `DATE_SOLDE`) VALUES (?,?,?,?,?,?,CURRENT_DATE)');
		   		$req->execute(array($max_ID+1,$newSoldeCPn,$newSoldeCPn1,$newSoldeRTTn,$newSoldeRTTn1,$consultant));
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			$test = $_POST['thelistDM'];
			header("Location: ?action=home");
			exit();
	
		}		

	if(isset($_POST['Envoyer']))
		{
			$dateFromDu=$_POST['dateFromDu'];
			$dateFromAu=$_POST['dateFromAu'];
			$thelistMM=$_POST['thelistMM'];
			$thelistMS=$_POST['thelistMS'];
			$thelistDM=$_POST['thelistDM'];
			$commentaire=$_POST['commentaire'];
			$nbjrs=$_POST['nbJrs_hidden'];
			$nbjrsSS=$_POST['nbjrsSS'];
			$nbjrsAutres=$_POST['nbjrsAutres'];
			$nbjrsConv=$_POST['nbjrsConv'];
			$nbjrsRTT=$_POST['nbjrsRTT'];
			$nbjrsCP=$_POST['nbjrsCP'];
			$consultant=$_SESSION['id'];
			try
			{  
				$reponse1 = $bdd->query('SELECT * FROM solde WHERE ID_Solde = (SELECT MAX(ID_Solde) id FROM solde WHERE CONSULTANT_SOLDE ='.$consultant.') AND CONSULTANT_SOLDE ='.$consultant);  
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
			if ($nbjrsCP>$soldeCPn1) {
				$newSoldeCPn = $SoldeCPn -$nbjrsCP + $SoldeCPn1;
				$newSoldeCPn1 = 0;
			}
			else{
				$newSoldeCPn1 = $SoldeCPn1 - $nbjrsCP ;
				$newSoldeCPn = $SoldeCPn;
			}
			if ($nbjrsRTT>$soldeRTTn1) {
				$newSoldeRTTn = $SoldeRTTn -$nbjrsRTT + $SoldeRTTn1;
				$newSoldeRTTn1 = 0;
			}
			else{
				$newSoldeRTTn1 = $SoldeRTTn1 - $nbjrsRTT ;
				$newSoldeRTTn = $SoldeRTTn ;
			}
			try
			{  
				$reponse1 = $bdd->query('SELECT MAX(ID_SOLDE) id FROM solde');  
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
		 		$req = $bdd->prepare('INSERT INTO  conges (`ID_CONGES`, `DATEDEM_CONGES`, `DEBUT_CONGES`, `DEBUTMM_CONGES`, `FIN_CONGES`, `FINMS_CONGES`, `NBJRS_CONGES`, `CP_CONGES`, `RTT_CONGES`, `SS_CONGES`, `CONV_CONGES`, `AUTRE_CONGES`, `COMMENTAIRE`, `STATUT_CONGES`, `VALIDEUR_CONGES`, `CONSULTANT_CONGES`, `SOLDE_CONGES`) VALUES (DEFAULT,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
		   		$req->execute(array($_POST['dateFromDu'],$_POST['thelistMM'],$_POST['dateFromAu'],$_POST['thelistMS'],$_POST['nbJrs_hidden'],$nbjrsCP, $nbjrsRTT, $nbjrsSS, $nbjrsConv,$nbjrsAutres,$commentaire,'En cours de validation DM',$_POST['thelistDM'],$consultant,$max_ID+1));
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			try
	 		{
				$req = $bdd->prepare('INSERT INTO solde (`ID_Solde`, `CPn_SOLDE`, `CPn1_SOLDE`, `RTTn_SOLDE`, `RTTn1_SOLDE`, `CONSULTANT_SOLDE`, `DATE_SOLDE`) VALUES (?,?,?,?,?,?,CURRENT_DATE)');
		   		$req->execute(array($max_ID+1,$newSoldeCPn,$newSoldeCPn1,$newSoldeRTTn,$newSoldeRTTn1,$consultant));
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			try
			{  
				$reponse1 = $bdd->query('SELECT * from consultant where TRIGRAMME_CONSULTANT = "'.$_POST['thelistDM'].'"');  
				while ($donnees1 = $reponse1->fetch())
				{
					$mail_valideur = $donnees1['EMAIL_CONSULTANT']; 
				}
				$reponse1->closeCursor();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			try
			{  
				$reponse1 = $bdd->query('SELECT * from consultant where ID_CONSULTANT = "'.$consultant.'"');  
				while ($donnees1 = $reponse1->fetch())
				{
					$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT']; 
					$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT']; 
				}
				$reponse1->closeCursor();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
			include("controller/sendmail.php");
			mailtoDMfromCO($mail_valideur, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $_POST['dateFromDu'], $_POST['thelistMM'], $_POST['dateFromAu'], $_POST['thelistMS']);
			header("Location: ?action=home");
			exit();
	
		}		
}
