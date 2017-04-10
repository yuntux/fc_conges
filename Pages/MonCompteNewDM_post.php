<?php

include("Functions/sessioncheck.php");
$CONom=$_POST['CONom'];
$COprenom=$_POST['COprenom'];
$COmail=$_POST['COmail'];
$COTri=$_POST['COTri'];
$COprofil=$_POST['COprofil'];
$thelistDM=$_POST['thelistDM'];
$COid=$_POST['COid'];

$consultant = $_SESSION['id'];
$mail_exist = 0;
$tri_exist = 0;
$indice=0;
if(isset($_POST['Chercher']))
{
	include("Functions/connection.php");
	try
	{  
		$reponse1 = $bdd->query('SELECT * FROM consultant WHERE CONCAT(NOM_CONSULTANT, " ", PRENOM_CONSULTANT) = "'.$thelistDM.'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$id = $donnees1['ID_CONSULTANT']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	header("Location: MonCompte.php?search=$id");
	exit();
}	
		
if(isset($_POST['Enregistrer']))
{
	include("Functions/connection.php");
	try
	{  
		$reponse1 = $bdd->query('SELECT COUNT(*) mail_exist from consultant where `EMAIL_CONSULTANT` = "'.$COmail.'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$mail_exist = $donnees1['mail_exist']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	try
	{  
		$reponse1 = $bdd->query('SELECT COUNT(*) tri_exist from consultant where `TRIGRAMME_CONSULTANT` = "'.$COTri.'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$tri_exist = $donnees1['tri_exist']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	try
	{  
		$reponse1 = $bdd->query('SELECT * from consultant where `ID_CONSULTANT` = "'.$COid.'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$TRIGRAMME_CONSULTANT = $donnees1['TRIGRAMME_CONSULTANT']; 
			$EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}	
	if($EMAIL_CONSULTANT == $COmail){
		$mail_exist = 0;
	}
	if($TRIGRAMME_CONSULTANT == $COTri){
		$tri_exist = 0;
	}				
	if($tri_exist == 0 && $mail_exist == 0 && $CONom != "" && $COprenom !="" && $COmail !="" && $COTri !=""){
		try
		{
	 		$record_maj = $bdd->exec('UPDATE `consultant` SET `NOM_CONSULTANT`= "'.$CONom.'", `PRENOM_CONSULTANT`= "'.$COprenom.'", `EMAIL_CONSULTANT`= "'.$COmail.'", `TRIGRAMME_CONSULTANT`= "'.$COTri.'", `PROFIL_CONSULTANT`= "'.$COprofil.'" WHERE `ID_CONSULTANT` = "'.$COid.'"');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
		try
		{
	 		$record_maj = $bdd->exec('UPDATE `authen` SET `ROLE_AUTHEN`= "'.$COprofil.'" WHERE `ID_AUTHEN` = "'.$COid.'"');
			$_SESSION['erreur'] = 80;
			header("Location: MonCompte.php?search=$COid");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}elseif($mail_exist > 0){
		$_SESSION['erreur'] = 81;
		header("Location: MonCompte.php?search=$COid");
		exit();
	}elseif($CONom =="" || $COprenom =="" || $COmail =="" || $COTri ==""){
		$_SESSION['erreur'] = 82;
		header("Location: MonCompte.php?search=$COid");
		exit();
	}else{
		$_SESSION['erreur'] = 83;
		header("Location: MonCompte.php?search=$COid");
		exit();
	}
}
if(isset($_POST['reinitialiser']))
{
	include("Functions/connection.php");
	try
	{
 		$record_maj = $bdd->exec('UPDATE `authen` SET `PASSWORD_AUTHEN` = "Fontaine123" WHERE `ID_AUTHEN` = "'.$COid.'"');
		$_SESSION['erreur'] = 80;
		header("Location: MonCompte.php?search=$COid");
		exit();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->POSTMessage());
	}

}			
