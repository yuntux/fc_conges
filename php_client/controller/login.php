<?php 

if(!empty($_SESSION['id']))
	header("Location: ?action=home");


if (isset($_POST['bouton_login'])){
	if(!empty($_POST['login']) && !empty($_POST['password']))
	{
		$res = $auth->login_password($_POST['login'],$_POST['password']);
		if ($res == False){
			$message_erreur = 'Mauvais mot de passe !';
			$view_to_display='login.php'; 
		} else{
			$_SESSION['id'] = $res['id'];
			$_SESSION['role'] = $res['role'];
			$_SESSION['nom'] = $res['nom'];
			$_SESSION['prenom'] = $res['prenom'];
			$_SESSION['trigramme'] = $res['trigramme'];
			$_SESSION['login'] = $res['login'];

			$_SESSION['mon_token'] = $res['token'];

			$CONSULTANT->trigger_login_solde_conges($res['id']);
			$message_succes = "Bonjour ".$_SESSION['id'];
	//		header("Location: index.php?action=home");
		}
	}
}elseif (isset($_POST['mdp_oublie'])){
	if (!isset($_POST['login']) || empty($_POST['login'])){
		$message_erreur = "Remplissez le login puis recliquez sur le bouton mot de passe oublié.";
	}
	else
	{
		$auth->init_consultant_pass_from_login($_POST['login']);
		$message_succes = "Vous allez recevoir un nouveau mot de passe par email.";
	}
	$view_to_display='login.php'; 
}else{
	$view_to_display='login.php'; 
}
?>
