<?php

if (isset($_POST['mdp_oublie'])){
	if (!isset($_POST['login']) || empty($_POST['login'])){
		$message_erreur = "Remplissez le login puis recliquez sur le bouton mot de passe oublié.";
	}
	else
	{
		$auth->init_consultant_pass_from_login($_POST['login']);
		$message_succes = "Vous allez recevoir un nouveau mot de passe par email.";
	}
	$view_to_display='login.php'; 

} else {
	$view_to_display = 'mot_passe_oublie.php';
}
?>
