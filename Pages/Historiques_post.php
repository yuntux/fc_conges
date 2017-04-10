<?php
include("includes/sessioncheck.php");
$bouton="";
$id_conges ="";
foreach($_POST as $index=>$valeur){
	$bouton =$valeur ;
	$id_conges = $index ."";
	$id_conges = substr($id_conges,1);
} 
if($bouton=="Envoyer")
	{
		try
 		{
			include("Functions/connection.php");
	 		$record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'En cours de validation DM\' WHERE `ID_CONGES`=\''.$id_conges.'\'');
			header("Location: Historiques.php?");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}
if($bouton=="Annuler")
	{
		try
 		{
			include("Functions/connection.php");
	 		$record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'Annulée\' WHERE `ID_CONGES`=\''.$id_conges.'\'');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
				try
 		{
	 		$record_maj = $bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$id_conges.')');
			header("Location: Historiques.php");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}
?>	

