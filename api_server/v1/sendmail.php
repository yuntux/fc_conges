<?php

function mail_gateway($mail,$sujet,$message,$header)
{
	$mail="adumaine@fontaine-consultants.fr";//pour les tests uniquement
echo $sujet;
echo $message;
	mail($mail,$sujet,$message,$header);
}


function mailtoCOfromDM_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour'.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.','.$passage_ligne.'Votre directeur de mission a validé votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.'.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.',</p>
					<p style="margin-bottom:10px;">Votre directeur de mission a <B>validé</B> votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}	
function mailtoCOfromDir_ok($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour'.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.','.$passage_ligne.'La direction a validé votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.'.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.',</p>
					<p style="margin-bottom:10px;">La direction a <B>validé</B> votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}
function mailtoCOfromDM_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour'.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.','.$passage_ligne.'Votre directeur de mission n\'a pas validé votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.'.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.',</p>
					<p style="margin-bottom:10px;">Votre directeur de mission <B>n\'a pas validé</B> votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}
function mailtoCOfromDir_ko($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour'.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.','.$passage_ligne.'La direction n\'a pas validé votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.'.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.',</p>
					<p style="margin-bottom:10px;">La direction <B>n\'a pas validé</B> votre demande de congé du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}
function mailtoDMfromCO($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour,'.$passage_ligne.'Vous avez reçu une demande de congés à valider de la part de '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.'. Cette demande de congés est du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour,</p>
					<p style="margin-bottom:10px;">Vous avez reçu une demande de congés à valider de la part de '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.'. Cette demande de congés est du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}
function mailtoDirfromDM($EMAIL_CONSULTANT, $NOM_CONSULTANT, $PRENOM_CONSULTANT, $TRI_VALIDEUR, $DEBUT_CONGES, $DEBUTMM_CONGES, $FIN_CONGES, $FINMS_CONGES){	
	$mail = "zlarguet@fontaine-consultants.fr"; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour,'.$passage_ligne.'Vous avez reçu une demande de congés à valider de la part de '.$TRI_VALIDEUR.'. Cette demande de congés est du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.' et concerne : '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.$passage_ligne.'Cordialement.'.$passage_ligne.'FONTAINE CONSULTANS.'.$passage_ligne.'http://www.fontaine-consultants.fr'.$passage_ligne.'WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse';

	$message_html = '<html>
				<body>
					<p style="margin-bottom:10px;">Bonjour,</p>
					<p style="margin-bottom:10px;">Vous avez reçu une demande de congés à valider de la part de '.$TRI_VALIDEUR.'. Cette demande de congés est du '.$DEBUT_CONGES." ".$DEBUTMM_CONGES.' au '.$FIN_CONGES." ".$FINMS_CONGES.' et concerne : '.$NOM_CONSULTANT." ".$PRENOM_CONSULTANT.'.</p>
					<p style="margin-bottom:20px;">Cordialement</p>
					<p style="Font-Weight: Bold;color:grey;">FONTAINE CONSULTANTS</p>
					<p style="margin-bottom:100px;Font-Weight: Bold;">http://www.fontaine-consultants.fr</p>
					<p style="Font-Weight: Bold;">WORKFLOW PILOT : Ce mail est envoyé par un robot, veuillez ne pas répondre sur cette adresse</p>
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	mail_gateway($mail,$sujet,$message,$header);
	//==========
}

function new_password($EMAIL_CONSULTANT, $PASSWORD){	
	$mail = $EMAIL_CONSULTANT; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 'Bonjour, votre nouveau mot de passe : '.$PASSWORD.' Cordialement.';


	$message_html = '<html>
				<body>
Bonjour, <br>votre nouveau mot de passe : '.$PASSWORD.'<br>Cordialement.
				</body>
			</html>';
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet = "Demande de congés";
	//=========
	 
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
	//==========
	 
	//=====Envoi de l'e-mail.
	return mail_gateway($mail,$sujet,$message,$header);
	//==========
}
?>
