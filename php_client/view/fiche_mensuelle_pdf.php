<?php
$color = array();
$color['RH']="#c0c0c0";
$color['F']="grey";
$color['CP']="yellow";
$color['RTT']="green";
$color['CONV']="orange";
$color['SS']="brown";
$color['AA']="pink";
$color['TRA']="white";

$synthese_entreprise_periode = array();
$synthese_entreprise_annuelle = array();
$synthese_conges_consultant = array();

function tab_synthese($compteur_periode){
	global $color;
	$s = '<div class="solid_table"><table style="width:10cm; height:3cm;font-size:26px; text-align:center; ">';
	$s.= "<tr><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td></tr>";
	$s.= "<tr><td style='background-color : ".$color['RH']."'>".$compteur_periode['RH']."</td><td style='background-color : ".$color['F']."'>".$compteur_periode['F']."</td><td style='background-color : ".$color['CP']."'>".$compteur_periode['CP']."</td><td style='background-color : ".$color['RTT']."'>".$compteur_periode['RTT']."</td><td style='background-color : ".$color['CONV']."'>".$compteur_periode['CONV']."</td><td style='background-color : ".$color['SS']."'>".$compteur_periode['SS']."</td><td style='background-color : ".$color['AA']."'>".$compteur_periode['AUTRE']."</td></tr>";
	$s.= "</table></div>";
	return $s;
}

function count_cat($date_debut,$date_fin,$tab_source){
	$count = array("CP"=>0.0,"RTT"=>0.0,"CONV"=>0.0,"SS"=>0.0,"AUTRE"=>0.0,"F"=>0.0,"RH"=>0.0,"TRA"=>0.0);
	$jour = $date_debut;
while ($jour <= $date_fin){
		$count[$tab_source[$jour]['Matin']]+=0.5;
		$count[$tab_source[$jour]['Soir']]+=0.5;
	 	$jour = lendemain($jour);
	}

	return $count;
}

function header_tab_periode($debut_periode,$fin_periode_str,$tab_annuel,$colonne_nom_consultant=False){
	$tab=  '<tr>';
	if ($colonne_nom_consultant === True)
	{
		$tab.='<td>Consultant</td>';
	}	
		$jour = $debut_periode;
		while ($jour <= $fin_periode_str)
		{
			$jour_fr = date('d/m',strtotime($jour));
			$tab.='<td colspan=2>'.$jour_fr.'</td>';
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>';

	$tab.=  '<tr>';
	if ($colonne_nom_consultant === True)
	{
		$tab.='<td></td>';
	}	
		$jour = $debut_periode;
		while ($jour <= $fin_periode_str)
		{
			$tab.='<td>AM</td>';
			$tab.='<td>PM</td>';
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>';
	return $tab;
}

function row_tab_periode($debut_periode,$fin_periode_str,$tab_annuel,$colonne_nom_consultant=False){
	global $color;
	$tab=  '<tr style="height:100%;">';
        if ($colonne_nom_consultant != False)
        {
                $tab.='<td>'.$colonne_nom_consultant.'</td>';
        }
		$jour = $debut_periode;
		while ($jour <= $fin_periode_str)
		{
			//$tab.='<td bgcolor="'.$color[$tab_annuel[$jour]['Matin']].'" style="background-color : '.$color[$tab_annuel[$jour]['Matin']].';">'.$tab_annuel[$jour]['Matin'].'</td>';
			//$tab.='<td bgcolor="'.$color[$tab_annuel[$jour]['Matin']].'" style="background-color : '.$color[$tab_annuel[$jour]['Matin']].';">'.$tab_annuel[$jour]['Soir'].'</td>';
			$tab.='<td bgcolor="'.$color[$tab_annuel[$jour]['Matin']].'" style="background-color : '.$color[$tab_annuel[$jour]['Matin']].';"></td>';
			$tab.='<td bgcolor="'.$color[$tab_annuel[$jour]['Matin']].'" style="background-color : '.$color[$tab_annuel[$jour]['Matin']].';"></td>';
			$jour = lendemain($jour);
		}
	$tab.=  '</tr>';
	return $tab;
}

function tab_periode($debut_periode,$fin_periode_str,$tab_annuel){
	$tab = '<div class="solid_table"><table style="width:50cm; height:3cm;font-size:26px; text-align:center;">';
	$tab.= header_tab_periode($debut_periode,$fin_periode_str,$tab_annuel);
	$tab.= row_tab_periode($debut_periode,$fin_periode_str,$tab_annuel);
	$tab.="</table></div>";
	return $tab;
}



function get_content($DEMANDE,$id_consultant,$debut_periode, $fin_periode,$nom, $prenom){
global $synthese_entreprise_periode;
global $synthese_entreprise_annuelle;
global $synthese_conges_consultant;
 
$fin_periode_str = date('Y-m-d',$fin_periode);
$fin_periode_fr = date('d/m/Y',$fin_periode);
$debut_periode_str = date('Y-m-d',$debut_periode);
$debut_periode_fr = date('d/m/Y',$debut_periode);
$annee = date("Y", $debut_periode);
$debut_annee = date('Y-m-d',strtotime($annee."-01-01"));
$debut_annee_str = $debut_annee;
$mi_periode = middle_between_date($debut_periode, $fin_periode);
$tab_annuel = array();
	$res = "

<div style='font-size:26px;'>
<h1>FONTAINE CONSULTANTS - FICHE NOMINATIVE DE SUIVI MENSUEL</h1>
<br>Nom du salarié cadre relevant du forfait-jour :  ".$prenom." ".$nom."
<br>Période : du ".$debut_periode_fr." au ".$fin_periode_fr."

<br>
<br>Fiche de suivi :
<br>- Jours travaillé / non travaillés 
<br>- Temps de repos charge de travail, organisation du travail, amplitude de la journée de travail et équilibre entre vie privée et vie professionnelle.
<br>
<br><h3>SUIVI DES JOURS TRAVAILLES ET DES JOURS NON TRAVAILLES :</h3>
<br>Rappel : RH = repos hebdomadaire (gris) / F = jours fériés (gris) / CP = congés payés (jaune) / JR = jours de repos (ex RTT) (vert) / JC = jours d’absences conventionnel (orange) / AA = autres absences (rose) / JT = jours travaillés (blanc)

<br><br>Détail de l'activité sur la période :<br><br> ";



$jour = $debut_annee;
while ($jour <= $fin_periode_str){
	$tab_j = array("Matin"=>False, "Soir"=>False);
	$tab_annuel[$jour]=$tab_j;
	$jour = lendemain($jour);
}

$filter = "CONSULTANT_CONGES = ".$id_consultant." AND (STATUT_CONGES NOT IN ('Annulée DM','Annulée Direction','Annulée')) AND (FIN_CONGES >= '".$debut_annee."' AND DEBUT_CONGES <= '".$fin_periode_str."')";

$liste_conges = $DEMANDE->get_list('*',$filter,False);
foreach ($liste_conges as $conges){
	$jour = $conges['DEBUT_CONGES'];
	$am_pm = $conges['DEBUTMM_CONGES'];
	$cp_restant = $conges['CP_CONGES'];
	$rtt_restant = $conges['RTT_CONGES'];
	$conventionnel_restant = $conges['CONV_CONGES'];
	$sans_solde_restant = $conges['SS_CONGES'];
	$autre_restant = $conges['AUTRE_CONGES'];


	while ($jour <= $conges['FIN_CONGES'] && $jour<= $fin_periode_str)
	{	
		if (($jour >= $debut_annee) and !($jour == $conges['FIN_CONGES'] && $conges['FINMS_CONGES'] == "Matin")){

			if (jrFerie($jour)==True){
				//$jours_ferie.append($jour)
			}elseif (jrWeekend($jour)==True){
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
		}

		if ($am_pm == "Matin") {
			$am_pm = "Soir";
		} else {
			$am_pm = "Matin";
			$jour = lendemain($jour);
		}
	} 	
}
$jour = $debut_annee;
$am_pm = "Matin";
while ($jour <= $fin_periode_str){
	if (jrFerie($jour)==True){
		$tab_annuel[$jour][$am_pm]="F";
	}elseif (jrWeekend($jour)==True){
		$tab_annuel[$jour][$am_pm]="RH";
	} else {
		if ($tab_annuel[$jour][$am_pm]==""){
			$tab_annuel[$jour][$am_pm]="TRA";
		}
	}

	if ($am_pm == "Matin") {
		$am_pm = "Soir";
	} else {
		$am_pm = "Matin";
		$jour = lendemain($jour);
	}
}



$compteur_annuel = count_cat($debut_annee_str, $fin_periode_str,$tab_annuel);
$compteur_periode = count_cat($debut_periode_str,$fin_periode_str,$tab_annuel);

$synthese_entreprise_periode[$id_consultant] = $compteur_periode;
$synthese_entreprise_annuelle[$id_consultant] = $compteur_annuel;
$synthese_conges_consultant[$id_consultant] = $tab_annuel;

$res.=tab_periode($debut_periode_str,$mi_periode,$tab_annuel);
$res.="<br><br>";
$res.=tab_periode(lendemain($mi_periode),$fin_periode_str,$tab_annuel);



$synthese = '<table style="width:50cm;font-size:26px;"><tr><td>';
$synthese.="<br><br>Synthèse de l’activité de la période :<br><br>";	
$synthese.=tab_synthese($compteur_periode);
$synthese.="</td><td>";
$synthese.="<br><br>Synthèse de l’activité depuis le 1er janvier ".$annee." :<br><br>";	
$synthese.=tab_synthese($compteur_annuel);
$synthese.="</td></tr></table>";

$res.=$synthese;

$page_2 = "
<div style='page-break-before: always;'></div>
<br><h3>SUIVI DE LA CHARGE DE TRAVAIL, DE L’ORGANISATION DU TRAVAIL ET DE L’AMPLITUDE DES JOURNEES DE TRAVAIL :</h3>
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
<div class='solid_table'><table style='width:50cm;height:5cm; font-size:26px; text-align:center;'>
<tr><td>#</td><td>Date :</td><td>Description :</td><td>Motifs :</td></tr>
<tr><td>#1</td><td></td><td></td><td></td></tr>
<tr><td>#2</td><td></td><td></td><td></td></tr>
<tr><td>#3</td><td></td><td></td><td></td></tr>
</table></div>

<br>
<br>
<table style='width:50cm;font-size:26px; text-align:center;'>
<tr><td>À Paris, le</td><td>Signature du salarié</td></tr>
</table>
<div style='page-break-before: always;'></div>
</div>
";

	$res.=$page_2;

	return $res;
}

function page_cumuls($liste_consultants,$debut_periode,$fin_periode){
	global $synthese_entreprise_periode;
	global $synthese_entreprise_annuelle;

	$page_cumuls = "<h1>Consommé sur la période du ".$debut_periode." au ".$fin_periode."</h1>";
	$page_cumuls.= "<div class='solid_table'><table style='width:50cm; height:3cm;font-size:26px; text-align:center;'>";
	$page_cumuls.= "<tr><td rawspan='2'>Nom</td><td colspan='8'>Consommé sur la période</td><td colspan='8'>Consommé depuis le 1er janvier</td></tr>";
	$page_cumuls.= "<tr><td></td><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td><td>Total période</td><td>RH</td><td>F</td><td>CP</td><td>JR</td><td>JC</td><td>JSS</td><td>AA</td><td>Total 1er janvier</td></tr>";

	foreach ($liste_consultants as $consultant){
		$p = $synthese_entreprise_periode[$consultant['ID_CONSULTANT']];
		$cumul_periode = $p['RH']+$p['F']+$p['CP']+$p['RTT']+$p['CONV']+$p['SS']+$p['AUTRE'];
		$a = $synthese_entreprise_annuelle[$consultant['ID_CONSULTANT']];
                $cumul_annuel= $a['RH']+$a['F']+$a['CP']+$a['RTT']+$a['CONV']+$a['SS']+$a['AUTRE'];
		$page_cumuls.= "<tr>";
		$page_cumuls.= "<td>".$consultant['PRENOM_CONSULTANT']." ".$consultant['NOM_CONSULTANT']."</td>";
                $page_cumuls.= "<td>".$p['RH']."</td>";
                $page_cumuls.= "<td>".$p['F']."</td>";
                $page_cumuls.= "<td>".$p['CP']."</td>";
                $page_cumuls.= "<td>".$p['RTT']."</td>";
                $page_cumuls.= "<td>".$p['CONV']."</td>";
                $page_cumuls.= "<td>".$p['SS']."</td>";
                $page_cumuls.= "<td>".$p['AUTRE']."</td>";
                $page_cumuls.= "<td>".$cumul_periode."</td>";

                $page_cumuls.= "<td>".$a['RH']."</td>";
                $page_cumuls.= "<td>".$a['F']."</td>";
                $page_cumuls.= "<td>".$a['CP']."</td>";
                $page_cumuls.= "<td>".$a['RTT']."</td>";
                $page_cumuls.= "<td>".$a['CONV']."</td>";
                $page_cumuls.= "<td>".$a['SS']."</td>";
                $page_cumuls.= "<td>".$a['AUTRE']."</td>";
                $page_cumuls.= "<td>".$cumul_annuel."</td>";
		$page_cumuls.= "</tr>";	
	}

	$page_cumuls.= "</table></div>";
	return $page_cumuls;
}


function page_recap_demandes($liste_consultants,$debut_periode,$fin_periode){
	global $synthese_conges_consultant;
	$mi_periode = middle_between_date($debut_periode, $fin_periode);
	$debut_periode_str = date('Y-m-d',$debut_periode);
	$fin_periode_str = date('Y-m-d',$fin_periode);
	$tab_annuel = $synthese_conges_consultant[0];

	$page.= "<h1>Récapitulatif des demandes sur la période du ".$debut_periode_str." au ".$fin_periode_str."</h1>";
        $page.= '<div class="solid_table"><table style="width:50cm; height:3cm;font-size:26px; text-align:center;">';
        $page.= header_tab_periode($debut_periode_str,$mi_periode,$tab_annuel,True);
        foreach ($liste_consultants as $consultant){
		$tab_annuel = $synthese_conges_consultant[$consultant['ID_CONSULTANT']];
       		$page.= row_tab_periode($debut_periode_str,$mi_periode,$tab_annuel,$consultant['PRENOM_CONSULTANT']." ".$consultant['NOM_CONSULTANT']);
	}
        $page.= "</table></div>";
	$page.= "<div style='page-break-before: always;'></div>";


	$page.= "<h1>Récapitulatif des demandes sur la période du ".$debut_periode_str." au ".$fin_periode_str."(suite) </h1>";
        $page.= '<div class="solid_table"><table style="width:50cm; height:3cm;font-size:26px; text-align:center;">';
        $page.= header_tab_periode(lendemain($mi_periode),$fin_periode_str,$tab_annuel,True);
        foreach ($liste_consultants as $consultant){
		$tab_annuel = $synthese_conges_consultant[$consultant['ID_CONSULTANT']];
       		$page.= row_tab_periode(lendemain($mi_periode),$fin_periode_str,$tab_annuel,$consultant['PRENOM_CONSULTANT']." ".$consultant['NOM_CONSULTANT']);
	}
        $page.= "</table></div>";
	$page.= "<div style='page-break-before: always;'></div>";
        return $page;
}


$res = "";
foreach ($liste as $consultant){
//	if ($consultant['ID_CONSULTANT']==2){
		$res.= get_content($DEMANDE,$consultant['ID_CONSULTANT'],strtotime($_POST['debut_periode']), strtotime($_POST['fin_periode']), $consultant['NOM_CONSULTANT'], $consultant['PRENOM_CONSULTANT']);
//	}
}

$res.= page_recap_demandes($liste,strtotime($_POST['debut_periode']),strtotime($_POST['fin_periode']));
$res.= page_cumuls($liste,$_POST['debut_periode'],$_POST['fin_periode']);

echo '<form action="controller/gen_pdf.php" method="post"> 
<input type="hidden" name="html_content" value="'.base64_encode($res).'"></input>
<input type="submit" value="Récupérer PDF"></input>
</form>';

//echo $res;


?>

