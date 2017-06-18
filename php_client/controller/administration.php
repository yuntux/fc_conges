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


if(isset($_POST['search']) && $_SESSION['role'] == "DIRECTEUR")
{
	$COid = $_POST['select_consultant'];
	try
	{
		$target = $bdd->query('SELECT * FROM consultant WHERE ID_CONSULTANT = "'.$COid.'"');
		while ($donnees1 = $target->fetch())
		{
			$CONom=$donnees1['NOM_CONSULTANT'];
			$COprenom= $donnees1['PRENOM_CONSULTANT'];
			$COmail= $donnees1['EMAIL_CONSULTANT'];
			$COTri= $donnees1['TRIGRAMME_CONSULTANT'];
			$COprofil=$donnees1['PROFIL_CONSULTANT'];
		}
		$target->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}


if(isset($_POST['delete_consultant']) && $_SESSION['role'] == "DIRECTEUR")
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



if(isset($_POST['update_consultant']) && $_SESSION['role'] == "DIRECTEUR")
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
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
                $message_erreur = "L'adresse mail saisie existe d�ja" ;
        }elseif($CONom =="" || $COprenom =="" || $COmail =="" || $COTri ==""){
                $message_erreur = "Veuillez remplir tous les champs";
        }else{
		$message_erreur = "Le trigramme saisi existe déa";
        }
}


if(isset($_POST['add_consultant']) && $_SESSION['role'] == "DIRECTEUR") 
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
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
			$reponse1 = $bdd->query('SELECT max(CONSULTANT_ID) max_ID FROM consultant');
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
			$message_succes = 80;
			header("Location: ?action=home");
			exit();
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
	}elseif($mail_exist > 0){
                $message_erreur = "L'adresse mail saisie existe d�ja" ;
	}elseif($CONom =="" || $COprenom =="" || $COmail =="" || $COTri ==""){
                $message_erreur = "Veuillez remplir tous les champs";
	}else{
		$message_erreur = "Le trigramme saisi existe déa";
	}
}



if(isset($_POST['reinitialiser']) && $_SESSION['role'] == "DIRECTEUR")
{
        include("controller/sendmail.php");
	$COid=$_POST['COid'];

        $reponse = $bdd->query('SELECT * FROM consultant where ID_CONSULTANT = \''.$COid.'\'');
        while ($donnees = $reponse->fetch())
        {
                $COmail = $donnees['EMAIL_CONSULTANT'];
        }
        $reponse->closeCursor();

        try
        {
                $password = get_random_string_alpha(10);
                $record_maj = $bdd->exec('UPDATE `consultant` SET `PASSWORD_AUTHEN` = "'.hash('sha512', $GUERANDE.$password).'" WHERE `CONSULTANT_ID` = "'.$COid.'"');
                new_password($COmail, $password);
                new_password("aurelien.dumaine@fontaine-consultants.fr", $password);
                echo "Mote de passe réinitialis Vous allez le recevoir par email.";
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->POSTMessage());
        }
}

$view_to_display="administration.php";
?>
