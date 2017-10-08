<?php 

if(!empty($_SESSION['id']))
	header("Location: ?action=home");

if(!empty($_POST['login']) && !empty($_POST['password']))
{
	$auth = new Auth();
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

		//$CONSULTANT->trigger_login_solde_conges($id);
		$message_succes = "Réussi";
		header("Location: index.php?action=home");
	}
}else{
	$view_to_display='login.php'; 
}
?>
