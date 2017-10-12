<?php

if (isset($_POST['bouton_recap_individuel'])){
	//$view_to_display = 'fiche_mensuelle_pdf.php';
	include_once('view/fiche_mensuelle_pdf.php');

	$res = "";
	$liste = $CONSULTANT->get_list();
	foreach ($liste as $consultant){
		$detail_consultant = $CONSULTANT->get_by_id($consultant['ID_CONSULTANT']);
		$res.= get_content($DEMANDE,$consultant['ID_CONSULTANT'],strtotime($_POST['debut_periode']), strtotime($_POST['fin_periode']), $detail_consultant['NOM_CONSULTANT'], $detail_consultant['PRENOM_CONSULTANT']);
	}

echo '<form action="controller/gen_pdf.php" method="post"> 
<input type="hidden" name="html_content" value="'.base64_encode($res).'"></input>
<input type="submit" value="ok">uuu</input>
</form>';

echo $res;

} else {
	//TODO : contrôle antériorité de la date de début
	$first_day_month = new DateTime('first day of this month');
	$first_day_month = $first_day_month->format('Y-m-d');
	$last_day_month = new DateTime('last day of this month');
	$last_day_month = $last_day_month->format('Y-m-d');
	$view_to_display = 'editions.php';
}
?>
