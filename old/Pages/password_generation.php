<?php
include("Functions/sessioncheck.php");
$id_cons=$_POST['COid'];

function get_random_string_alpha($size)
{
   $password="";
    // Initialisation des caractères utilisables
    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

    for($i=0;$i<$size;$i++)
    {
        $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
    }

    return $password;
}

function generate_password($COid)
{
echo eval(eval($COid));
        include("Functions/connection.php");
        include("Functions/sendmail.php");

	$reponse = $bdd->query('SELECT * FROM consultant where ID_CONSULTANT = \''.$COid.'\'');
	while ($donnees = $reponse->fetch())
	{
		$COmail = $donnees['EMAIL_CONSULTANT'];
	}
	$reponse->closeCursor();

        try
        {
                $password = get_random_string_alpha(10);
                $record_maj = $bdd->exec('UPDATE `authen` SET `PASSWORD_AUTHEN` = "'.hash('sha512', $GUERANDE.$password).'" WHERE `ID_AUTHEN` = "'.$COid.'"');
                new_password($COmail, $password);
                new_password("aurelien.dumaine@fontaine-consultants.fr", $password);
		echo "Mote de passe réinitialisé etmail envé";
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->POSTMessage());
        }
}
if(isset($_POST['reinitialiser']))
{
        generate_password($id_cons);
}
?>
