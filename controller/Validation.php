<?php

if(isset($_POST["validation_DM"]) && $_SESSION['role'] == "DM")
        {
	$id_conges = $_POST['validation_DM'];
                try
                {
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'En cours de validation Direction\' WHERE `ID_CONGES`=\''.$id_conges.'\'');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $reponse1 = $bdd->query('SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.DEBUT_CONGES, a.VALIDEUR_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_conges);
                        while ($donnees1 = $reponse1->fetch())
                        {
                                $NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
                                $PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
                                $EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
                                $FIN_CONGES = $donnees1['FIN_CONGES'];
                                $DEBUT_CONGES = $donnees1['DEBUT_CONGES'];
                                $FINMS_CONGES = $donnees1['FINMS_CONGES'];
                                $DEBUTMM_CONGES = $donnees1['DEBUTMM_CONGES'];
                                $TRI_CONSULTANT = $donnees1['VALIDEUR_CONGES'];
                        }
                        $reponse1->closeCursor();
                        include("controller/sendmail.php");
                        mailtoCOfromDM_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
                        mailtoDirfromDM($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $TRI_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
                        header("Location: Validation.php?$TRI_CONSULTANT");
                        exit();
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
        }

if(isset($_POST["refus_DM"]) && $_SESSION['role'] == "DM")
        {
	$id_conges = $_POST['refus_DM'];
                try
                {
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`=\'Annulée DM\' WHERE `ID_CONGES`=\''.$id_conges.'\'');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $record_maj = $bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$id_conges.')');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $reponse1 = $bdd->query('SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.DEBUT_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_conges);
                        while ($donnees1 = $reponse1->fetch())
                        {
                                $NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
                                $PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
                                $EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
                                $FIN_CONGES = $donnees1['FIN_CONGES'];
                                $DEBUT_CONGES = $donnees1['DEBUT_CONGES'];
                                $FINMS_CONGES = $donnees1['FINMS_CONGES'];
                                $DEBUTMM_CONGES = $donnees1['DEBUTMM_CONGES'];
                        }
                        $reponse1->closeCursor();
                        include("controller/sendmail.php");
                        mailtoCOfromDM_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
                        header("Location: Validation.php");
                        exit();
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
        }

if(isset($_POST["validation_direction"]) && $_SESSION['role'] == "DIRECTEUR")
        {
	$id_conges = $_POST['validation_direction'];
                try
                {
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`= "Validée" WHERE `ID_CONGES`=\''.$id_conges.'\'');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $reponse1 = $bdd->query('SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.DEBUT_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_conges);
                        while ($donnees1 = $reponse1->fetch())
                        {
                                $NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
                                $PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
                                $EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
                                $FIN_CONGES = $donnees1['FIN_CONGES'];
                                $DEBUT_CONGES = $donnees1['DEBUT_CONGES'];
                                $FINMS_CONGES = $donnees1['FINMS_CONGES'];
                                $DEBUTMM_CONGES = $donnees1['DEBUTMM_CONGES'];
                        }
                        $reponse1->closeCursor();
                        include("controller/sendmail.php");
                        mailtoCOfromDir_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
                        header("Location: Validation.php?$id_conges");
                        exit();
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
        }

if(isset($_POST["refus_direction"]) && $_SESSION['role'] == "DIRECTEUR")
        {
	$id_conges = $_POST['refus_direction'];
                try
                {
                        $record_maj = $bdd->exec('UPDATE `conges` SET `STATUT_CONGES`= "Annulée Direction" WHERE `ID_CONGES`=\''.$id_conges.'\'');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $record_maj = $bdd->exec('DELETE FROM `solde` WHERE ID_Solde = (SELECT SOLDE_CONGES FROM conges WHERE `ID_CONGES` = '.$id_conges.')');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->POSTMessage());
                }
                try
                {
                        $reponse1 = $bdd->query('SELECT b.NOM_CONSULTANT, b.PRENOM_CONSULTANT, b.EMAIL_CONSULTANT, a.DEBUT_CONGES, a.FIN_CONGES, a.DEBUTMM_CONGES, a.FINMS_CONGES  FROM conges a, consultant b WHERE a.CONSULTANT_CONGES = b.ID_CONSULTANT and a.ID_CONGES = '.$id_conges);
                        while ($donnees1 = $reponse1->fetch())
                        {
                                $NOM_CONSULTANT = $donnees1['NOM_CONSULTANT'];
                                $PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
                                $EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT'];
                                $FIN_CONGES = $donnees1['FIN_CONGES'];
                                $DEBUT_CONGES = $donnees1['DEBUT_CONGES'];
                                $FINMS_CONGES = $donnees1['FINMS_CONGES'];
                                $DEBUTMM_CONGES = $donnees1['DEBUTMM_CONGES'];
                        }
                        $reponse1->closeCursor();
                        include("controller/sendmail.php");
                        mailtoCOfromDir_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES);
                        header("Location: Validation.php");
                        exit();
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
        }



try{
	$historique = $bdd->query('SELECT * FROM conges a, consultant c WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and (a.STATUT_CONGES = "Validée" or a.STATUT_CONGES = "Annulée DD
irection" or a.STATUT_CONGES = "Annulée DM")');
        $conges_validation_DM = $bdd->query('SELECT * FROM conges a, consultant b, consultant c WHERE a.VALIDEUR_CONGES = b.TRIGRAMME_CONSULTANT and b.ID_CONSULTANT = \''.$_SESSION['id'].'\' and c.ID_CONSULTANT = a.CONSULTANT_CONGES and a.STATUT_CONGES = "En cours de validation DM"');
	$conges_validation_direction = $bdd->query('SELECT * FROM conges a, consultant c WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and a.STATUT_CONGES = "En cours de validation Direction"');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

$view_to_display='Validation.php';

?>
