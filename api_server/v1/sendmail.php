<?php
include_once("lib_date.php");

function mail_gateway($mail,$sujet,$message_html)
{

	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}

	$message_txt = $message_html; //TODO

	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Création du header de l'e-mail.
	$header = "From: \"FC Congès\"<FCConges@fontaine-consultants.fr>".$passage_ligne;
	$header.= "Reply-to: \"FC Congès\" <FCConges@fontaine-consultants.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	 
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

	//$mail="yuntux@gmail.com";//pour les tests uniquement
	mail("yuntux@gmail.com",$sujet,$message,$header);
	return mail($mail,$sujet,$message,$header);
}

function new_password($EMAIL_CONSULTANT, $PASSWORD){	
	$message_html = '<html>
				<body>
Bonjour, <br>votre nouveau mot de passe : '.$PASSWORD.'<br>Cordialement.<br>Destinataire:'.$mail.'
				</body>
			</html>';
	mail_gateway($EMAIL_CONSULTANT,"Réinitialisation password FC Congés",$message_html);
}
?>
