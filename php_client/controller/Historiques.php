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

$id_consultant = $_SESSION['id'];

if($_SESSION['role'] == "DIRECTEUR"){
	$liste = $CONSULTANT->get_list();
	if (isset($_POST['id_consultant'])){
		$id_consultant = $_POST['id_consultant'];
	}
}

$reponse1 = $CONSULTANT->get_demandes_en_cours($id_consultant);
$reponse2 = $CONSULTANT->get_historique($id_consultant);
$detail_consultant = $CONSULTANT->get_by_id($id_consultant); 

//var_dump($reponse2);

$view_to_display='Historiques.php';
?>
