<?php

include("Functions/sessioncheck.php");
$AcquisCPn1=$_POST['AcquisCPn1'];
$AcquisCPn=$_POST['AcquisCPn'];
$AcquisRTTn=$_POST['AcquisRTTn'];
$AcquisRTTn1=$_POST['AcquisRTTn1'];
$SoldeCPn1=$_POST['SoldeCPn1'];
$SoldeCPn=$_POST['SoldeCPn'];
$SoldeRTTn=$_POST['SoldeRTTn'];
$SoldeRTTn1=$_POST['SoldeRTTn1'];
$consultant = $_SESSION['id'];
if(isset($_POST['Enregistrer']))
{
	include("Functions/connection.php");
	try
	{
 		$record_maj = $bdd->exec('UPDATE `acquis` SET `CPn_ACQUIS`="'.$AcquisCPn.'",`CPn1_ACQUIS`="'.$AcquisCPn1.'",`RTTn_ACQUIS`="'.$AcquisRTTn.'",`RTTn1_ACQUIS`="'.$AcquisRTTn1.'",`DATE_ACQUIS`=CURRENT_DATE WHERE `CONSULTANT_ACQUIS`="'.$consultant.'"');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->POSTMessage());
	}
	$max_ID = 0;
	try
	{  
		$reponse1 = $bdd->query('select max(ID_SOLDE) max_ID from solde where CONSULTANT_SOLDE = "'.$consultant.'" AND CONSULTANT_SOLDE ="'.$consultant.'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$max_ID = $donnees1['max_ID']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	//	header("Location: MonCompte.php?$max_ID");
	//	exit();
	try
	{
 		$record_maj1 = $bdd->exec('UPDATE `solde` SET `CPn_SOLDE`='.$SoldeCPn.',`CPn1_SOLDE`='.$SoldeCPn1.',`RTTn_SOLDE`='.$SoldeRTTn.',`RTTn1_SOLDE`='.$SoldeRTTn1.',`DATE_SOLDE`= CURRENT_DATE WHERE ID_SOLDE = '.$max_ID);
		header("Location: MonCompte.php");
		exit();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->POSTMessage());
	}
}		

if(isset($_POST['Annuler']))
{
	header("Location: MonCompte.php");
	exit();
}		
