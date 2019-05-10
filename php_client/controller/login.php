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
  $token_client_php = $res['token'];
  /*unset($_SESSION);
  session_destroy();
  session_id($token_client_php);
  session_start();
*/
			$_SESSION['id'] = $res['id'];
			$_SESSION['role'] = $res['role'];
			$_SESSION['nom'] = $res['nom'];
			$_SESSION['prenom'] = $res['prenom'];
			$_SESSION['trigramme'] = $res['trigramme'];
			$_SESSION['login'] = $res['login'];

			$_SESSION['mon_token'] = $token_client_php;
				// TODO : Dans tout php_client remplacer $_SESSION['mon_token'] par session_id();

			$CONSULTANT->trigger_login_solde_conges($res['id']);
			header("Location: index.php?action=home");
		}
	}
}else{
	$view_to_display='login.php'; 
}
?>
