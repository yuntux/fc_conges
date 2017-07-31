<?php

$liste_consultants = $CONSULTANT->get_list();

if(isset($_POST['search']))
{
	$donnee = $CONSULTANT->get_by_id($_POST['select_consultant']);

	$CONom=$donnee['NOM_CONSULTANT'];
	$COprenom= $donnee['PRENOM_CONSULTANT'];
	$COmail= $donnee['EMAIL_CONSULTANT'];
	$COTri= $donnee['TRIGRAMME_CONSULTANT'];
	$COprofil=$donnee['PROFIL_CONSULTANT'];
}


if(isset($_POST['delete_consultant']))
{
	$CONSULTANT->delete_consultant($_POST['COid']);
}


if(isset($_POST['update_consultant']))
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];
	$COid=$_POST['COid'];

	$res = $CONSULTANT->update_consultant($COid, $CONom,$COprenom,$COmail,$COprofil,$COTri);
	if ($res==True){
		$CONom = "";
		$COprenom = "";
		$COmail = "";
		$COTri = "";
		$COprofil = "";
	}
}


if(isset($_POST['add_consultant'])) 
{
	$CONom=$_POST['CONom'];
	$COprenom=$_POST['COprenom'];
	$COmail=$_POST['COmail'];
	$COTri=$_POST['COTri'];
	$COprofil=$_POST['COprofil'];

	$res = $CONSULTANT->add_consultant($CONom,$COprenom,$COmail,$COprofil,$COTri);
	if ($res==True){
		$CONom = "";
		$COprenom = "";
		$COmail = "";
		$COTri = "";
		$COprofil = "";
	}
}



if(isset($_POST['reinitialiser']))
{
	$CONSULTANT->init_password($_POST['COid']);
}

$view_to_display="administration.php";

?>
