<?php

$first_day_month = new DateTime('first day of last month');
$first_day_month = $first_day_month->format('Y-m-d');
$last_day_month = new DateTime('last day of last month');
$last_day_month = $last_day_month->format('Y-m-d');

if (isset($_POST['bouton_recap_individuel'])){
	if (strtotime($_POST['debut_periode']) > strtotime($_POST['fin_periode'])) {
		$message_erreur = "La date de fin ne peut être antérieure à la date de début.";
		$view_to_display = 'editions.php';
	} else {
		$liste = $CONSULTANT->get_list();
		$view_to_display = 'fiche_mensuelle_pdf.php';
	}
} else {
		$view_to_display = 'editions.php';
}
?>
