<?php

include("Functions/sessioncheck.php");
$CONom=$_POST['CONom'];
$COprenom=$_POST['COprenom'];
$COmail=$_POST['COmail'];
$COTri=$_POST['COTri'];
$consultant = $_SESSION['id'];
$mail_exist = 0;
$tri_exist = 0;
$test=0;
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
	if($tri_exist == 0 && $mail_exist == 0 && $CONom != "" && $COprenom !="" && $COmail !="" && $COTri !=""){
		try
		{  
			$reponse1 = $bdd->query('SELECT max(ID_AUTHEN) max_ID FROM authen');  
			while ($donnees1 = $reponse1->fetch())
			{
				$max_ID = $donnees1['max_ID']+1; 
			}
			$reponse1->closeCursor();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
/*
		try
		{
			$COid = $max_ID;
	 		$req = $bdd->prepare('INSERT INTO `authen`(`ID_AUTHEN`, `LOGIN_AUTHEN`, `ROLE_AUTHEN`) VALUES  (?,?,?,?)');
		   	$req->execute(array($COid,$COmail,"CONSULTANT"));
		}
		catch(Exception $e)
		{	
			die('Erreur : '.$e->POSTMessage());
		}
*/
			$COid = $max_ID;
	 		$req = $bdd->prepare('INSERT INTO `authen`(`ID_AUTHEN`, `LOGIN_AUTHEN`, `ROLE_AUTHEN`) VALUES  (?,?,?)');
		   	$req->execute(array($COid,$COmail,"CONSULTANT"));
        		include("password_generation.php");
        		generate_password($COid);
		try
		{
	 		$req = $bdd->prepare('INSERT INTO `consultant`(`ID_CONSULTANT`, `NOM_CONSULTANT`, `PRENOM_CONSULTANT`, `EMAIL_CONSULTANT`, `PROFIL_CONSULTANT`, `TRIGRAMME_CONSULTANT`, `STATUT_CONSULTANT`) VALUES (?,?,?,?,?,?,?)');
		   	$req->execute(array($max_ID,$CONom,$COprenom,$COmail,"CONSULTANT",$COTri,1));
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
		try
		{
	 		$req = $bdd->prepare('INSERT INTO `acquis`(`ID_ACQUIS`, `CPn_ACQUIS`, `CPn1_ACQUIS`, `RTTn_ACQUIS`, `RTTn1_ACQUIS`, `CONSULTANT_ACQUIS`, `INDICE_ACQUIS`, `DATE_ACQUIS`) VALUES (DEFAULT,?,?,?,?,?,?,CURRENT_DATE)');
		   	$req->execute(array(0,0,0,0,$max_ID,1));
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
		try
		{
	 		$req = $bdd->prepare('INSERT INTO `solde`(`ID_Solde`, `CPn_SOLDE`, `CPn1_SOLDE`, `RTTn_SOLDE`, `RTTn1_SOLDE`, `CONSULTANT_SOLDE`, `DATE_SOLDE`) VALUES (DEFAULT,?,?,?,?,?,CURRENT_DATE)');
		   	$req->execute(array(0,0,0,0,$max_ID));
			$_SESSION['erreur'] = 80;
			header("Location: MonCompte.php?$COTri");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}elseif($mail_exist > 0){
		$_SESSION['erreur'] = 81;
		header("Location: MonCompte.php?$test");
		exit();
	}elseif($CONom =="" || $COprenom =="" || $COmail =="" || $COTri ==""){
		$_SESSION['erreur'] = 82;
		header("Location: MonCompte.php?$test");
		exit();
	}else{
		$_SESSION['erreur'] = 83;
		header("Location: MonCompte.php?$test");
		exit();
	}
}			
