<?php

if(isset($_POST["send"])) 
        { 
                try 
                { 
			$DEMANDE->valider($_POST["id_conges"]);
                } 
                catch(Exception $e) 
                { 
			$message_erreur	= $e->POSTMessage();
                } 
        } 

if(isset($_POST["cancel"])) 
        { 
                try 
                { 
			$DEMANDE->cloturer($_POST["id_conges"]);
                } 
                catch(Exception $e) 
                { 
			$message_erreur	= $e->POSTMessage();
                } 
        }

$reponse1 = $CONSULTANT->get_demandes_en_cours($_SESSION['id']);
$reponse2 = $CONSULTANT->get_historique($_SESSION['id']);

$view_to_display='Historiques.php';
?>
