<?php
	$reponse1 = $bdd->query('SELECT * FROM consultant where PROFIL_CONSULTANT ="DM" or PROFIL_CONSULTANT ="DIRECTEUR" ORDER BY TRIGRAMME_CONSULTANT');  
	$reponse2 = $bdd->query('SELECT * FROM conges WHERE (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction" OR (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE'); 

	if(isset($_POST['Enregistrer']) || isset($_POST['Envoyer']))
		include('controller/DemandeConges_post.php');

	$view_to_display='DemandeConges.php';
?>
