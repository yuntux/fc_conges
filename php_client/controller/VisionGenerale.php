<?php 
	try
	{
		$reponse1 = $CONSULTANT->get_list('*', False, 'NOM_CONSULTANT');
		$reponse2 = $DEMANDE->get_list('*', False, 'CONSULTANT_CONGES');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	$view_to_display='VisionGenerale.php';
?>
