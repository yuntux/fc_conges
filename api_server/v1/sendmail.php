<?php
include_once("lib_date.php");
require_once 'PHPMailer/PHPMailerAutoload.php';

function mail_gateway($mail,$sujet,$message_html)
{

/*
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
*/

	//$mail="yuntux@gmail.com";//pour les tests uniquement
	send_mail("yuntux@gmail.com",$sujet,$message_html,$header);
	return send_mail($mail,$sujet,$message_html);
}

function send_mail($mail,$subject,$message){
	//return mail($to,$sujet,$message,$header);
	global $_SMTP_HOST;
	global $_SMTP_PORT;
	global $_SMTP_USERNAME;
	global $_SMTP_PASSWORD;

	//$mail="yuntux@gmail.com";//pour les tests uniquement
	$mail = new PHPMailer;
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $_SMTP_HOST;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $_SMTP_USERNAME;                 // SMTP username
	$mail->Password = $_SMTP_PASSWORD;                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $_SMTP_PORT;                                    // TCP port to connect to
	$mail->setFrom('no-reply@fontaine-consultants.fr', 'FC Congés');
	$mail->addAddress($mail, $mail);     // Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	return $mail->send();

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
