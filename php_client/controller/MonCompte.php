<?php

if (isset($_POST['bouton_nouveauMdP']))
{
	$ancienMdP=$_POST['ancienMdP'];
	$nouveauMdP=$_POST['nouveauMdP'];
	$confirmationMdP=$_POST['confirmationMdP'];
	$consultant = $_SESSION['id'];

        if($nouveauMdP==$confirmationMdP){
		$res = $CONSULTANT->change_password($consultant,$ancienMdP,$nouveauMdP);
        }else{
                $message_erreur = "Les deux mots de passe saisis ne sont pas identiques.";
        }
	if ($res !== True){ //ATTENTION à l'opérateur !==
                $message_erreur = $res;
	}
}


/*
Demande de Denis du 27 octobre 2017 : les consultants ne doivent pas pouvoir ajuster eux-même leur solde.
if(isset($_POST['bouton_soldes']))
{
	$AcquisCPn1=$_POST['AcquisCPn1'];
	$AcquisCPn=$_POST['AcquisCPn'];
	$AcquisRTTn=$_POST['AcquisRTTn'];
	$AcquisRTTn1=$_POST['AcquisRTTn1'];
	$SoldeCPn1=$_POST['SoldeCPn1'];
	$SoldeCPn=$_POST['SoldeCPn'];
	$SoldeRTTn=$_POST['SoldeRTTn'];
	$SoldeRTTn1=$_POST['SoldeRTTn1'];
	$id_consultant = $_SESSION['id'];

	$CONSULTANT->set_solde($id_consultant,$SoldeCPn,$SoldeCPn1,$SoldeRTTn,$SoldeRTTn1);
	$CONSULTANT->set_acquis($id_consultant,$AcquisCPn,$AcquisCPn1,$AcquisRTTn,$AcquisRTTn1);
}
*/

$acquis = $CONSULTANT->get_acquis($_SESSION['id']);
$ACQUIS_RTTn1 = $acquis['RTTn1_ACQUIS']; 
$ACQUIS_RTTn = $acquis['RTTn_ACQUIS'];
$ACQUIS_CPn1 = $acquis['CPn1_ACQUIS'];
$ACQUIS_CPn = $acquis['CPn_ACQUIS'];

$solde = $CONSULTANT->get_solde($_SESSION['id']);
$NBJRS_RTTn1 = $solde['RTTn1_SOLDE']; 
$NBJRS_RTTn = $solde['RTTn_SOLDE'];
$NBJRS_CPn1 = $solde['CPn1_SOLDE'];
$NBJRS_CPn = $solde['CPn_SOLDE'];

$view_to_display='MonCompte.php';

?>
