<?php

include("Functions/sessioncheck.php");
$nouveauMdP=$_POST['nouveauMdP'];
$confirmationMdP=$_POST['confirmationMdP'];
$consultant = $_SESSION['id'];
$long = strlen($nouveauMdP);
if(isset($_POST['Enregistrer']))
{
	include("Functions/connection.php");
	if($nouveauMdP==$confirmationMdP && $long >7){
		try
		{
	 		$record_maj = $bdd->exec('UPDATE `authen` SET `PASSWORD_AUTHEN`= "'.hash('sha512', $GUERANDE.$nouveauMdP).'" WHERE `ID_AUTHEN` = "'.$consultant.'"');
			$_SESSION['erreur'] = 90;
			header("Location: MonCompte.php");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}elseif($long <8){
		$_SESSION['erreur'] = 92;
		header("Location: MonCompte.php?$long");
		exit();
	}
	else{
		$_SESSION['erreur'] = 91;
		header("Location: MonCompte.php?$long");
		exit();
	}
}			
