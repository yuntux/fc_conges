<?php

function middle_between_date($date_debut, $date_fin){
    $nbjours = round((($date_fin - $date_debut)/(60*60*24)-1)/2,0); //nb jours entres les deux dates
    return date('Y-m-d', strtotime('+'.$nbjours.' day', $date_debut));
}
function lendemain($date){
        //return date('Y-m-d', strtotime('+1 day', strtotime($date)));
        return date('Y-m-d', strtotime('+1 day', strtotime($date)));
}


	function get_nb_open_days($dateFromDu, $dateFromAu) {	
		$date_start = strtotime($dateFromDu);
		$date_stop = strtotime($dateFromAu);
		$nb_days_open = 0;
		while ($date_start <= $date_stop) {
			if (jrTravaille($date_start)) {
				$nb_days_open++;		
			}
			$date_start = mktime(date('H', $date_start), date('i', $date_start), date('s', $date_start), date('m', $date_start), date('d', $date_start) + 1, date('Y', $date_start));			
		}		
		return $nb_days_open;
	}

	function jrTravaille($date_saisie) {	
		if (!jrSemaine($date_saisie) || jrFerie($date_saisie)){
			return False;
		}
		return True;
	}
	function jrSemaine($date_saisie) {	
		if (in_array(date('w', strtotime($date_saisie)), array(1, 2, 3, 4, 5))){
			return True;
		}
		return False;
	}

	function jrWeekend($date_saisie) {
		return !jrSemaine($date_saisie);
	}


	function jrFerie($date_saisie) {	
		$date_saisie = strtotime($date_saisie);
		$arr_bank_holidays = array(); // Tableau des jours feriés	
		$jrferie = False ;
//echo date('Y', strtotime($date_saisie));
		$year = (int)date('Y', $date_saisie);
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
		if (in_array(date('j_n_Y', $date_saisie), $arr_bank_holidays)) {
			$jrferie = True ;
		}					
		return $jrferie;
	}
?>
