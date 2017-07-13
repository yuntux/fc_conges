<?php

if(isset($_POST["validation"]))
        {
		$id_conges = $_POST['validation'];
                try
                {
                        $DEMANDE->valider($id_conges);
                }
                catch(Exception $e)
                {
                        $message_erreur = $e->POSTMessage();
                }
        }




if(isset($_POST["refus"]))
        {
		$id_conges = $_POST['refus'];

                try
                {
                        $DEMANDE->cloturer($id_conges);
                }
                catch(Exception $e)
                {
                        $message_erreur = $e->POSTMessage();
                }
        }

try
{
	$historique = $DEMANDE->get_historique();
	$conges_validation = $DEMANDE->get_demandes_en_cours();
}
catch(Exception $e)
{
	$message_erreur	= $e->POSTMessage();
}

$view_to_display='Validation.php';

?>
