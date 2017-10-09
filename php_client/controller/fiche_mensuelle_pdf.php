<?php
function get_content(){
	$res = "
FONTAINE CONSULTANTS - FICHE NOMINATIVE DE SUIVI MENSUEL
<br>Nom du salarié cadre relevant du forfait-jour :  ".$nom." ".$prenom."
<br>Période : ".$mois." ".$annee."

<br>
<br>Fiche de suivi :
<br>- Jours travaillé / non travaillés 
<br>- Temps de repos charge de travail, organisation du travail, amplitude de la journée de travail et équilibre entre vie privée et vie professionnelle.
<br>
<br>SUIVI DES JOURS TRAVAILLES ET DES JOURS NON TRAVAILLES :
<br>Rappel : RH = repos hebdomadaire (gris) / F = jours fériés (gris) / CP = congés payés (jaune) / JR = jours de repos (ex RTT) (vert) / JC = jours d’absences conventionnel (orange) / AA = autres absences (rose) / JT = jours travaillés (blanc)

<br>Détail de l’activité du mois de : ".$mois." ".$annee;

$cp = array();
$rtt = array();
$conventionnel = array();
$sans_solde = array();
$autre = array();
$jours_rh = array();
$jours_feries = array();
$travailles = array();

$tab_annuel = array();
$jour = "01/01/".$annee;
while ($jour <= "31/12/".$annee)
{
	$tab_j = array("matin"=>False, "apres-midi"=>False);
	$tab_annuel[$jour]=$tab_j;
	$jour = lendemain($jour);
}

//trouver les demande de congés dont la date de fin est dans l'annee ou la date de début est dans l'annee.
foreach ($conges => $liste_conges){
	$jour = $conges['jour_debut'];
	while ($jour <= $conges['jour_fin'])
	{	
		if (jour_ferie($jour)){
			//$jours_ferie.append($jour);
		}elseif (jour_semaine($jour) == "samedi" or jour_semaine($jour) == "dimanche"){
			//$jours_rh.append($jour);
		}elseif ($cp_restant>0){
			$cp.append($jour)
			$cp_restant--;
		}elseif ($rtt_restant>0){
			$rtt.append($jour)
			$rtt_restant--;
		}elseif ($conventionnel_restant>0){
			$conventionnel.append($jour)
			$conventionnel_restant--;
		}elseif ($sans_solde_restant>0){
			$sans_solde.append($jour)
			$sans_solde_restant--;
		}elseif ($autre_restant>0){
			$autre.append($jour)
			$autre_restant--;
		}
		$jour = lendemain($jour);
	} 
}

$temp_periode = array_merge($cp, $rtt, $conventionnel, $sans_solde, $autre, $jours_ferie, $jours_rh)

$jour = $debut_periode;
while ($jour <= $fin_periode)
{
	if jour not in $temp_periode {
                if (jour_ferie($jour)){
                        $jours_ferie.append($jour);
                }elseif (jour_semaine($jour) == "samedi" or jour_semaine($jour) == "dimanche"){
                        $jours_rh.append($jour);
		} else {
			$travailles.append($jour);
		}
	}
	$jour = lendemain($jour);
}

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
		$tab.='<td>AM</td>';
		$tab.='<td>PM</td>';
		$jour = lendemain($jour);
	}
$tab.=  '</tr>'
$tab.="</table>";


$res.=$tab;

$synthese = "<table><tr><td>";
$synthese.="<br><br>Synthèse de l’activité du mois :<br>";	
$s_mois = "<table>";
$s_mois.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
$s_mois.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
$s_mois.= "</table>";
$synthese.=$s_mois;
$synthese.="</td><td>";
$synthese.="<br><br>Synthèse de l’activité depuis le 1er janvier ".$annee." :<br>";	
$s_annee = "<table>";
$s_annee.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
$s_annee.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
$s_annee.= "</table>";
$synthese.=$s_annee;
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
