<?php
function get_random_string_alpha($size)
{
   $password="";
    // Initialisation des caractères utilisables
    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

    for($i=0;$i<$size;$i++)
    {
        $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
    }

    return $password;
}

$liste_consultants = $bdd->query('SELECT * FROM consultant order by NOM_CONSULTANT');  

if($_POST['search'] != "")
{
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
	try
	{
		$target = $bdd->query('SELECT * FROM consultant WHERE ID_CONSULTANT = "'.$_GET['search'].'"');
		while ($donnees1 = $target->fetch())
		{
			$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
			$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
			$EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
			$TRIGRAMME_CONSULTANT = $donnees1['TRIGRAMME_CONSULTANT'];
			$PROFIL_CONSULTANT = $donnees1['PROFIL_CONSULTANT'];
		}
		$target->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}


if(isset($_POST['delete_consultant']))
{
	$COid=$_POST['COid'];
	$COmail=$_POST['COmail'];
        try
        {
                $reponse1 = $bdd->query('DELETE * from consultant where `ID_CONSULTANT` = "'.$COid.'"');;
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
                $reponse1 = $bdd->query('DELETE * from acquis where `CONSULTANT_ACQUIS` = "'.$COid.'"');;
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
                $reponse1 = $bdd->query('DELETE * from authen where `LOGIN_AUTHEN` = "'.$COmail.'"');;
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
                $reponse1 = $bdd->query('DELETE * from conges where `CONSULTANT_CONGES` = "'.$COid.'"');;
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
                $reponse1 = $bdd->query('DELETE * from solde where `CONSULTANT_SOLDE` = "'.$COid.'"');;
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
}



if(isset($_POST['update_consultant']))
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
	$thelistDM=$_POST['thelistDM'];
	$COid=$_POST['COid'];
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


if($_POST['add_consultant'] != "") 
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
	$consultant = $_SESSION['id'];
	$mail_exist = 0;
	$tri_exist = 0;
	$test=0;
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
			$COid = $max_ID;
			$req = $bdd->prepare('INSERT INTO `authen`(`ID_AUTHEN`, `LOGIN_AUTHEN`, `ROLE_AUTHEN`) VALUES  (?,?,?)');
			$req->execute(array($COid,$COmail,"CONSULTANT"));
			include("password_generation.php");
			generate_password($COid);
		try
		{
			$req = $bdd->prepare('INSERT INTO `consultant`(`ID_CONSULTANT`, `NOM_CONSULTANT`, `PRENOM_CONSULTANT`, `EMAIL_CONSULTANT`, `PROFIL_CONSULTANT`, `TRIGRAMME_CONSULTANT`, `STATUT_CONSULTANT`) VALUES (?,?,?,?,?,?,?)');
			$req->execute(array($max_ID,$CONom,$COprenom,$COmail,$COprofil,$COTri,1));
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



if(isset($_POST['reinitialiser']))
{
        include("Functions/connection.php");
        include("Functions/sendmail.php");
	$id_cons=$_POST['COid'];

        $reponse = $bdd->query('SELECT * FROM consultant where ID_CONSULTANT = \''.$COid.'\'');
        while ($donnees = $reponse->fetch())
        {
                $COmail = $donnees['EMAIL_CONSULTANT'];
        }
        $reponse->closeCursor();

        try
        {
                $password = get_random_string_alpha(10);
                $record_maj = $bdd->exec('UPDATE `authen` SET `PASSWORD_AUTHEN` = "'.hash('sha512', $GUERANDE.$password).'" WHERE `ID_AUTHEN` = "'.$COid.'"');
                new_password($COmail, $password);
                new_password("aurelien.dumaine@fontaine-consultants.fr", $password);
                echo "Mote de passe réinitialisé etmail envé";
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->POSTMessage());
        }
}
?>
