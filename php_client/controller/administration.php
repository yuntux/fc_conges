<?php


if(isset($_POST['select_consultant']) && $_POST['select_consultant']!="-1")
{
	$donnee = $CONSULTANT->get_by_id($_POST['select_consultant']);

	$CONom=$donnee['NOM_CONSULTANT'];
	$COprenom= $donnee['PRENOM_CONSULTANT'];
	$COmail= $donnee['EMAIL_CONSULTANT'];
	$COTri= $donnee['TRIGRAMME_CONSULTANT'];
	$COprofil=$donnee['PROFIL_CONSULTANT'];

	$acquis = $CONSULTANT->get_acquis($_POST['select_consultant']);
	$ACQUIS_RTTn1 = $acquis['RTTn1_ACQUIS'];
	$ACQUIS_RTTn = $acquis['RTTn_ACQUIS'];
	$ACQUIS_CPn1 = $acquis['CPn1_ACQUIS'];
	$ACQUIS_CPn = $acquis['CPn_ACQUIS'];

	$solde = $CONSULTANT->get_solde($_POST['select_consultant']);
	$NBJRS_RTTn1 = $solde['RTTn1_SOLDE'];
	$NBJRS_RTTn = $solde['RTTn_SOLDE'];
	$NBJRS_CPn1 = $solde['CPn1_SOLDE'];
	$NBJRS_CPn = $solde['CPn_SOLDE'];

}


if(isset($_POST['delete_consultant']))
{
	$CONSULTANT->delete_consultant($_POST['COid']);
	$message_succes = "Supression réalisée.";
}


if(isset($_POST['update_consultant']))
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
	$COid=$_POST['COid'];

	$AcquisCPn1=$_POST['AcquisCPn1'];
        $AcquisCPn=$_POST['AcquisCPn'];
        $AcquisRTTn=$_POST['AcquisRTTn'];
        $AcquisRTTn1=$_POST['AcquisRTTn1'];
        $SoldeCPn1=$_POST['SoldeCPn1'];
        $SoldeCPn=$_POST['SoldeCPn'];
        $SoldeRTTn=$_POST['SoldeRTTn'];
        $SoldeRTTn1=$_POST['SoldeRTTn1'];

	$res = $CONSULTANT->update_consultant($COid, $CONom,$COprenom,$COmail,$COprofil,$COTri);
	if ($res==True){
		$message_succes = "Mise à jour réalisée.";
		$CONom="";
		$COprenom="";
		$COmail="";
		$COTri="";
		$COprofil="";
		$AcquisCPn1="";
		$AcquisCPn="";
		$AcquisRTTn="";
		$AcquisRTTn1="";
		$SoldeCPn1="";
		$SoldeCPn="";
		$SoldeRTTn="";
		$SoldeRTTn1="";
	} else {
		$message_erreur = $res;
	}

        $CONSULTANT->set_solde($COid,$SoldeCPn,$SoldeCPn1,$SoldeRTTn,$SoldeRTTn1);
        $CONSULTANT->set_acquis($COid,$AcquisCPn,$AcquisCPn1,$AcquisRTTn,$AcquisRTTn1);

}


if(isset($_POST['add_consultant'])) 
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];

	/*
	$AcquisCPn1=$_POST['AcquisCPn1'];
        $AcquisCPn=$_POST['AcquisCPn'];
        $AcquisRTTn=$_POST['AcquisRTTn'];
        $AcquisRTTn1=$_POST['AcquisRTTn1'];
        $SoldeCPn1=$_POST['SoldeCPn1'];
        $SoldeCPn=$_POST['SoldeCPn'];
        $SoldeRTTn=$_POST['SoldeRTTn'];
        $SoldeRTTn1=$_POST['SoldeRTTn1'];
	*/

	$res = $CONSULTANT->add_consultant($CONom,$COprenom,$COmail,$COprofil,$COTri);
	if ($res==True){
		$message_succes = "Ajout réalisé.";
		$CONom="";
		$COprenom="";
		$COmail="";
		$COTri="";
		$COprofil="";

	} else {
		$message_erreur = $res;
	}


        //$CONSULTANT->set_solde(,$SoldeCPn,$SoldeCPn1,$SoldeRTTn,$SoldeRTTn1);
        //$CONSULTANT->set_acquis($id_consultant,$AcquisCPn,$AcquisCPn1,$AcquisRTTn,$AcquisRTTn1);
}



if(isset($_POST['reinitialiser']))
{
	$CONSULTANT->init_password($_POST['COid']);
}

$liste_consultants = $CONSULTANT->get_list();
$view_to_display="administration.php";

?>
