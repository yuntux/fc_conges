<?php


function verif_propriete_conges($id_proprietaire, $id_conges){
        try
        {
                $req = $bdd->prepare('SELECT * FROM conges a WHERE a.CONSULTANT_CONGES = \''.$id_proprietaire.'\'  AND a.ID_CONGES=\''.$id_conges.'\'');
                $req->execute();
                $count = $req->rowCount();
echo $count;
                return $count;
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->POSTMessage());
        }
}

if(isset($_POST["send"])) 
        { 
		if (!verif_propriete_conges($_SESSION['id'], $_POST["id_conges"])
			return False;
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
		if (!verif_propriete_conges($_SESSION['id'], $_POST["id_conges"])
			return False;
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


function verif_valideur_conges($id_valideur, $id_conges){
        try
        {
                $req = $bdd->prepare('SELECT * FROM conges a, consultant c, consultant dm  WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and dm.TRIGRAMME_CONSULTANT = a.VALIDEUR_CONGES and a.ID_CONGES=\''.$id_conges.'\' and dm.ID_CONSULTANT = \''.$id_valideur.'\'');
                $req->execute();
                $count = $req->rowCount();
echo $count;
                return $count;
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->POSTMessage());
        }
}
$view_to_display='Historiques.php';
?>
