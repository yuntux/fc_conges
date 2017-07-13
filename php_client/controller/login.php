<?php 

if(!empty($_SESSION['id']))
	header("Location: ?action=home");

if(!empty($_POST['login']) && !empty($_POST['password']))
    {
        try
        {

                $reponse = $bdd->query('SELECT * FROM consultant where EMAIL_CONSULTANT = \''.$_POST['login'].'\'');
                while ($donnees = $reponse->fetch())
                {
                        $id = $donnees['ID_CONSULTANT'];
			$nom = $donnees['NOM_CONSULTANT'];
			$prenom = $donnees['PRENOM_CONSULTANT'];
			$trigramme = $donnees['TRIGRAMME_CONSULTANT'];
                        $login = $donnees['EMAIL_CONSULTANT'];
                        $password = $donnees['PASSWORD_AUTHEN'];
                        $role = $donnees['PROFIL_CONSULTANT'];
                }
                $reponse->closeCursor();
        }
        catch (Exception $e)
        {
                        die('Erreur : ' . $e->getMessage());
        }

        if(hash('sha512', $GUERANDE.$_POST['password']) != $password)
        {
	        $message_erreur = 'Mauvais mot de passe !';
		$view_to_display='login.php';
        }
        else
        {
		$_SESSION['id'] = $id;
		$_SESSION['role'] = $role;
		$_SESSION['nom'] = $nom;
		$_SESSION['prenom'] = $prenom;
		$_SESSION['trigramme'] = $trigramme;
		$_SESSION['login'] = $login;
		try
		{
			$reponse = $bdd->query('SELECT DATE_ACQUIS FROM acquis where CONSULTANT_ACQUIS = '.$id);
			while ($donnees = $reponse->fetch())
			{
				$datemaj = $donnees['DATE_ACQUIS'];
			}
			$reponse->closeCursor();
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
		$datecurrent =date("Y-m-d");
		sscanf($datemaj, "%4s-%2s-%2s", $annee, $mois, $jour);
		$a1 = $annee;
		$m1 = $mois;
		sscanf($datecurrent, "%4s-%2s-%2s", $annee, $mois, $jour);
		$a2 = $annee;
		$m2 = $mois;
		$dif_en_mois = ($m2-$m1)+12*($a2-$a1);
		$majCP = 2.08* $dif_en_mois;
		$indice=0;
		try
		{
			$record_maj = $bdd->exec('UPDATE `acquis` SET `CPn_ACQUIS`= CPn_ACQUIS+'.$majCP.', `DATE_ACQUIS`=CURRENT_DATE WHERE `CONSULTANT_ACQUIS`= '.$id);
			$indice=1;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->POSTMessage());
		}
		if($indice=1){
			try
			{
				$record_maj = $bdd->exec('UPDATE `solde` SET `CPn_SOLDE`= CPn_SOLDE+'.$majCP.' WHERE `CONSULTANT_SOLDE`= '.$id);
				$indice=1;
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->POSTMessage());
			}
		}
	$message_succes = "Réussi";
        header("Location: index.php?action=home");
      }
}
else
{
	$view_to_display='login.php';
}

?>
