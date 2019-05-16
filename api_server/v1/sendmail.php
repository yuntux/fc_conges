<?php
include_once("lib_date.php");
require_once("PHPMailer/PHPMailerAutoload.php");

function mail_gateway($mail,$sujet,$message_html)
{
	//$mail="yuntux@gmail.com";//pour les tests uniquement
	send_mail("aurelien.dumaine@tasmane.com",$sujet,$message_html);
	return send_mail($mail,$sujet,$message_html);
}

function send_mail($to,$subject,$message){
	global $_SMTP_HOST;
	global $_SMTP_PORT;

        $mail = new PHPMailer;
        //$mail->SMTPDebug = 34;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $_SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->Port = $_SMTP_PORT;                                    // TCP port to connect to
        $mail->SMTPAuth = false;                               // Enable SMTP authentication
	$mail->CharSet = 'UTF-8';
        $mail->setFrom('no-reply@tasmane.com', 'TAZ Congés');
        $mail->addAddress($to);     // Add a recipient
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

/*
	if(!$mail->send()) {
		echo '<br>Message could not be sent.';
		echo '<br>Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo '<br>Message has been sent to '.$to;
		echo $message;
		echo "==============================";
	}
*/
	return $mail->send();

}

function email_new_password($EMAIL_CONSULTANT, $PASSWORD){	
	$message_html = '<html>
				<body>
Bonjour, <br>votre nouveau mot de passe : '.$PASSWORD.'<br>Cordialement.<br>Destinataire:'.$EMAIL_CONSULTANT.'
				</body>
			</html>';
error_log("=========>".$EMAIL_CONSULTANT."<", 3, "/tmp/er.log");
	mail_gateway($EMAIL_CONSULTANT,"Réinitialisation password TAZ Congés",$message_html);
}
?>
