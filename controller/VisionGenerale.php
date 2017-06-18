<?php 
	try
	{
		$reponse1 = $bdd->query('SELECT ID_CONSULTANT, PRENOM_CONSULTANT, NOM_CONSULTANT FROM consultant ORDER BY PRENOM_CONSULTANT');    
		$reponse2 = $bdd->query('SELECT * FROM conges ORDER BY CONSULTANT_CONGES');  
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	$view_to_display='VisionGenerale.php';
?>
