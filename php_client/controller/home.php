<?php
try
{
	$ACQUIS = $CONSULTANT->get_acquis($_SESSION['id']);
	$SOLDE = $CONSULTANT->get_solde($_SESSION['id']);
}
catch(Exception $e)
{
	$message_erreur	= $e->POSTMessage();
}
	$view_to_display='home.php';
?>
