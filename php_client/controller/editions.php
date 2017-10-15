<?php

if (isset($_POST['bouton_recap_individuel'])){
	//$view_to_display = 'fiche_mensuelle_pdf.php';
	//include_once('view/fiche_mensuelle_pdf.php');

	$liste = $CONSULTANT->get_list();
	$view_to_display = 'fiche_mensuelle_pdf.php';
} else {
	//TODO : contrôle antériorité de la date de début
	$first_day_month = new DateTime('first day of this month');
	$first_day_month = $first_day_month->format('Y-m-d');
	$last_day_month = new DateTime('last day of this month');
	$last_day_month = $last_day_month->format('Y-m-d');
	$view_to_display = 'editions.php';
}
?>
