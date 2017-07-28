<?php

if (isset($_POST['bouton_nouveauMdP']))
{
	$ancienMdP=$_POST['ancienMdP'];
	$nouveauMdP=$_POST['nouveauMdP'];
	$confirmationMdP=$_POST['confirmationMdP'];
	$consultant = $_SESSION['id'];

        if($nouveauMdP==$confirmationMdP){
		$CONSULTANT->change_password($consultant,$ancienMdP,$nouveauMdP);
        }else{
                $message_erreur = "Les deux mots de passe saisis ne sont pas identiques.";
        }
}


if(isset($_POST['bouton_soldes']))
{
	$AcquisCPn1=$_POST['AcquisCPn1'];
	$AcquisCPn=$_POST['AcquisCPn'];
	$AcquisRTTn=$_POST['AcquisRTTn'];
	$AcquisRTTn1=$_POST['AcquisRTTn1'];
	$SoldeCPn1=$_POST['SoldeCPn1'];
	$SoldeCPn=$_POST['SoldeCPn'];
	$SoldeRTTn=$_POST['SoldeRTTn'];
	$SoldeRTTn1=$_POST['SoldeRTTn1'];
	$consultant = $_SESSION['id'];
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
	try
	{
		$record_maj1 = $bdd->exec('UPDATE `solde` SET `CPn_SOLDE`='.$SoldeCPn.',`CPn1_SOLDE`='.$SoldeCPn1.',`RTTn_SOLDE`='.$SoldeRTTn.',`RTTn1_SOLDE`='.$SoldeRTTn1.',`DATE_SOLDE`= CURRENT_DATE WHERE ID_SOLDE = '.$max_ID);
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->POSTMessage());
	}
}


try
{  
	$acquis = $bdd->query('SELECT * FROM acquis where CONSULTANT_ACQUIS =\''.$_SESSION['id'].'\'');  
	while ($donnees1 = $acquis->fetch())
	{
		$ACQUIS_RTTn1 = $donnees1['RTTn1_ACQUIS']; 
		$ACQUIS_RTTn = $donnees1['RTTn_ACQUIS'];
		$ACQUIS_CPn1 = $donnees1['CPn1_ACQUIS'];
		$ACQUIS_CPn = $donnees1['CPn_ACQUIS'];
	}
	$acquis->closeCursor();
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

try
{  
	$soldes = $bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_SOLDE) from solde where CONSULTANT_SOLDE = \''.$_SESSION['id'].'\') AND CONSULTANT_SOLDE =\''.$_SESSION['id'].'\'');  
	while ($donnees1 = $soldes->fetch())
	{
		$NBJRS_RTTn1 = $donnees1['RTTn1_SOLDE']; 
		$NBJRS_RTTn = $donnees1['RTTn_SOLDE'];
		$NBJRS_CPn1 = $donnees1['CPn1_SOLDE'];
		$NBJRS_CPn = $donnees1['CPn_SOLDE'];
	}
	$soldes->closeCursor();
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

$view_to_display='MonCompte.php';

?>

