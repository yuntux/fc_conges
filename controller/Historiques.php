<?php
	try{
		$reponse1 = $bdd->query('SELECT * FROM conges WHERE (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction" OR (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE'); 

		$reponse2 = $bdd->query('SELECT * FROM conges WHERE (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM" OR (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` < CURRENT_DATE'); 
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}

if(isset($_POST["send"])) 
        { 
                try 
                { 
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'En cours de validation DM\' WHERE `ID_CONGES`=\''.$_POST["id_conges"].'\''); 
                        header("Location: ?action=Historiques"); 
                        exit(); 
                } 
                catch(Exception $e) 
                { 
                        die('Erreur : '.$e->POSTMessage()); 
                } 
        } 
if(isset($_POST["cancel"])) 
        { 
                try 
                { 
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'Annulée\' WHERE `ID_CONGES`=\''.$_POST["id_conges"].'\''); 
                } 
                catch(Exception $e) 
                { 
                        die('Erreur : '.$e->POSTMessage()); 
                } 
                try 
                { 
                        $record_maj = $bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$_POST["id_conges"].')'); 
                        header("Location: ?action=Historiques"); 
                        exit(); 
                } 
                catch(Exception $e) 
                { 
                        die('Erreur : '.$e->POSTMessage()); 
                } 
        }

include('view/Historiques.php');
?>
