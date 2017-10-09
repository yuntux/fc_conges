<?php
function get_content($nom, $prenom, $debut_periode, $fin_periode){
	$res = "
FONTAINE CONSULTANTS - FICHE NOMINATIVE DE SUIVI MENSUEL
<br>Nom du salarié cadre relevant du forfait-jour :  ".$nom." ".$prenom."
<br>Période : du ".$debut_periode." au ".$fin_periode."

<br>
<br>Fiche de suivi :
<br>- Jours travaillé / non travaillés 
<br>- Temps de repos charge de travail, organisation du travail, amplitude de la journée de travail et équilibre entre vie privée et vie professionnelle.
<br>
<br>SUIVI DES JOURS TRAVAILLES ET DES JOURS NON TRAVAILLES :
<br>Rappel : RH = repos hebdomadaire (gris) / F = jours fériés (gris) / CP = congés payés (jaune) / JR = jours de repos (ex RTT) (vert) / JC = jours d’absences conventionnel (orange) / AA = autres absences (rose) / JT = jours travaillés (blanc)

<br>Détail de l’activité sur la période : ";

$mois = ;
$annee = ;
$debut_annee = $annee."-01-01";
$mi_periode = $annee."-".$mois."-15";
$tab_annuel = array();
$jour = $debut_annee;
while ($jour <= $fin_periode)
{
	$tab_j = array("Matin"=>False, "Soir"=>False);
	$tab_annuel[$jour]=$tab_j;
	$jour = lendemain($jour);
}

function jour_weekend($jour){
	if (date("l",($jour)) == 6 or date("l",($jour)) == 0){
		return True;
	}
	return False;
}
function lendemain($jour){
	return date('Y-m-d', strtotime('+1 day', strtotime($date)))
}
function jour_ferie($jour)
	return $DEMANDE->jrFerie($jour);
}

//trouver les demande de congés dont la date de fin est dans l'annee ou la date de début est dans l'annee.
$DEMANDE->get_list('*', "(DEBUT_CONGES >= ".$debut_annee." AND DEBUT_CONGES <= "$fin_periode.") OR (FIN_CONGES>= ".$debut_annee." AND FIN_CONGES <= "$fin_periode.")",False);

foreach ($conges => $liste_conges){
	$jour = $conges['DEBUT_CONGE'];
	$am_pm = $conges['DEBUTMM_CONGES'];
	$cp_restant = $conges['CP_CONGES'];
	$rtt_restant = $conges['RTT_CONGES'];
	$conventionnel_restant = $conges['CONV_CONGES'];
	$sans_solde_restant = $conges['SS_CONGES'];
	$autre_restant = $conges['AUTRE_CONGES'];

//TODO : contrôler qu'on a bien des multiples de 0.5 lors de la saisie des demandes

	while ($jour <= $conges['FIN_CONGES'] && $jour<= $fin_periode)
	{	
		if ($jour == $conges['FIN_CONGES'] && $conges['FINMM_CONGES'] == "Matin"){
			continue;
		}

		if (jour_ferie($jour)){
			//$jours_ferie.append($jour);
		}elseif (jour_weekend($jour)){
			//$jours_rh.append($jour);
		}elseif ($cp_restant>0){
			$tab_annuel[$jour][$am_pm]="CP";
			$cp_restant = $cp_restant-0.5;
		}elseif ($rtt_restant>0){
			$tab_annuel[$jour][$am_pm]="RTT";
			$rtt_restant = $rtt_restant-0.5;
		}elseif ($conventionnel_restant>0){
			$tab_annuel[$jour][$am_pm]="CONV";
			$conventionnel_restant = $conventionnel_restant-0.5;
		}elseif ($sans_solde_restant>0){
			$tab_annuel[$jour][$am_pm]="SS";
			$sans_solde_restant = $sans_solde_restant-0.5;
		}elseif ($autre_restant>0){
			$tab_annuel[$jour][$am_pm]="AUTRE";
			$autre_restant = $autre_restant-0.5;
		} else {
			echo "erreur";
		}

		if $am_pm = "Matin" {
			$am_pm = "Soir";
		} else {
			$am_pm = "Matin";
			$jour = lendemain($jour);
		}
	} 	
}

$jour = $debut_annee;
while ($jour <= $fin_periode)
{
	if (jour_ferie($jour)){
		$tab_annuel[$jour][$am_pm]="F";
	}
	}elseif (jour_weekend($jour)){
		$tab_annuel[$jour][$am_pm]="RH";
	} else {
		$tab_annuel[$jour][$am_pm]="TRA";
	}

	if $am_pm = "Matin" {
		$am_pm = "Soir";
	} else {
		$am_pm = "Matin";
		$jour = lendemain($jour);
	}

}

function count_cat($date_debut,$date_fin,$tab_source){
	$count = array("CP"=>0.0,"RTT"=>0.0,"CONV"=>0.0,"SS"=>0.0,"AUTRE"=>0.0,"F"=>0.0,"RH"=>0.0,"TRA"=>0.0);
	for ($i=index($tab_source,$date_debut),$i++,$i<index($tab_source,$date_fin)){
		$coun[$tab_source[$i]['Matin']]+=0.5;
		$coun[$tab_source[$i]['Soir']]+=0.5;
	}
	return $count;
}

$compteur_annuel = count_cat($debut_annee, $fin_periode,$tab_annuel);
$compteur_periode = count_cat($debut_periode,$fin_periode,$tab_annuel);

function tab_periode($debut_periode,$fin_periode,$tab_annuel){
	$tab = "<table>";
	$tab.=  '<tr>'
		$jour = $debut_periode;
		while ($jour <= $fin_periode)
		{
			$tab.='<td>'.$jour.'</td>';
			$tab.='<td>'.$jour.'</td>'; //TODO : fusionner les deux
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>'

	$tab.=  '<tr>'
		$jour = $debut_periode;
		while ($jour <= $fin_periode)
		{
			$tab.='<td>AM</td>';
			$tab.='<td>PM</td>';
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>'

	$tab.=  '<tr>'
		$jour = $debut_periode;
		while ($jour <= $fin_periode)
		{
			$tab.='<td>'.$tab_annuel[$jour]['Matin'].'</td>';
			$tab.='<td>'.$tab_annuel[$jour]['Soir'].'</td>';
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>'
	$tab.="</table>";
	return $tab;
}

$res.=tab_periode($debut_periode,$mi_periode,$tab_annuel);
$res.=tab_periode(lendemain($mi_periode),$fin_periode,$tab_annuel);

function tab_synthese($compteur_periode){
	$s = "<table>";
	$s.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
	$s.= "<tr><td>RH</td><td>".$compteur_periode['F']."</td><td>".$compteur_periode['CP']."</td><td>".$compteur_periode['RTT']."</td><td>".$compteur_periode['CONV']."</td><td>".$compteur_periode['SS']."</td><td>".$compteur_periode['AUTRE']."</td></tr>";
	$s.= "</table>";
	return $s;
}

$synthese = "<table><tr><td>";
$synthese.="<br><br>Synthèse de l’activité de la période :<br>";	
$synthese.=tab_synthse($compteur_periode);
$synthese.="</td><td>";
$synthese.="<br><br>Synthèse de l’activité depuis le 1er janvier ".$annee." :<br>";	
$synthese.=tab_synthse($compteur_annuel);
$synthese.="</td></tr></table>";

$res.=$synthese;

$page_2 = "
<br>SUIVI DE LA CHARGE DE TRAVAIL, DE L’ORGANISATION DU TRAVAIL ET DE L’AMPLITUDE DES JOURNEES DE TRAVAIL:
<br>- RAPPEL CONCERNANT LES TEMPS DE REPOS QUOTIDIEN ET HEBDOMADAIRE : Les salariés relevant du forfait annuel en jours doivent bénéficier d’un repos quotidien minimum de 11 heures consécutives et d’un repos hebdomadaire de 35 heures minimum consécutives. Ces limites n’ont pas pour but de définir une journée habituelle de travail de 13 heures mais une amplitude exceptionnelle maximale de la journée de travail.
<br><br>Début et fin d’une période quotidienne et d’une période hebdomadaire au cours desquelles les durées minimales de repos quotidien et hebdomadaire doivent être respectées :
<br>- Durée journalière : 8H – 21H
<br>- Repos hebdomadaire: du samedi 21H au lundi 8H.
<br>Le travail entre le vendredi 21H et le samedi 21H doit rester exceptionnel et soumis à l’accord de la direction tout en respectant le repos quotidien minimum.
<br>L’effectivité du respect par le salarié de ces durées minimales de repos implique UNE OBLIGATION DE DECONNEXION DES OUTILS DE COMMUNICATION A DISTANCE
<br>
<br> Cochez cette case dans le cas de non respect éventuel des temps de repos quotidien et hebdomadaire. |__|
<br>
<br>- INFORMATIONS TRANSMISES A LA DIRECTION SUR LA CHARGE DE TRAVAIL, DE L’ORGANISATION DU TRAVAIL ET DE L’AMPLITUDE DES JOURNEES DE TRAVAIL :
<br>Souhaitez-vous alerter la direction sur  une situation anormale ou inhabituelle en matière de charge de travail, d’organisation du travail d’amplitude des journées de travail et d’équilibre vie privée/ vie professionnelle ? OUI/NON
<br>
<br>Si OUI, merci de compléter le tableau ci-dessous. Un point avec la direction suivra dans les 8 jours. 
<br>
<table>
<tr><td>Date :</td><td>Description :</td><td>Motifs :</td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
</table>

<br>
<br>
A Paris, le 												Signature du salarié
";

$res.=$page2;
	return $res;
}


function generate_pdf($html_input){
	/*
	Permet de générer un PDF avec TCPDF.
	Il ne faut avoir aucune autre entete d'envoyée.
	L'on crée un fichier placé dans ce repertoire contenant le contenu html à inclure dans le PDF.
	On execute ce fichier puis on le supprime.
	Ainsi les personnes non autorités ne peuvent pas générer de PDF (ou pendant moins d'une seconde !) et l'on est pas limité par la taille d'une quelconque variable GET ou POST.
	*/
	require_once('../../../libs/tcpdf/config/lang/fra.php');
	require_once('../../../libs/tcpdf/tcpdf.php');



	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	/*$pdf->SetCreator($_GET['creator']);
	$pdf->SetAuthor($_GET['autor']);
	$pdf->SetTitle($_GET['title']);
	$pdf->SetSubject($_GET['subject']);
	$pdf->SetKeywords($_GET['keywords']);

	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $_GET['entete1'], $_GET['entete2']);
	*/
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set some language-dependent strings
	$pdf->setLanguageArray($l);

	// ---------------------------------------------------------

	// add a page
	$pdf->AddPage();

	$pdf->SetFont('helvetica', '', 8);
	// -----------------------------------------------------------------------------

	// Set some content to print
	$html = fopen($_GET['id_pdf'], "a+");
	//$contenu_html="";
	//while ($ligne = fgets($html))
	//	$contenu_html.=$ligne;
	$contenu_html=$html_input;
	fclose($html);
	unlink($_GET['id_pdf']);

	// Print text using writeHTMLCell()
	$pdf->writeHTML($contenu_html, true, false, false, false, '');

	// This method has several options, check the source code documentation for more information.
	$pdf->Output($_GET['nom_fichier'].'.pdf', 'I');
}

?>
