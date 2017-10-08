<?php
class auth extends server_api {
        public function __construct($bdd) {
                parent::__construct($bdd);
echo 'ppppppppppppppppppp';
        }

	function login_password($login,$password_given){

		$res = False;
		if(!empty($login) && !empty($password_given))
		    {
			try
			{

				$reponse = $this->bdd->query('SELECT * FROM consultant where EMAIL_CONSULTANT = \''.$login.'\'');
				while ($donnees = $reponse->fetch())
				{
					$id = $donnees['ID_CONSULTANT'];
					$nom = $donnees['NOM_CONSULTANT'];
					$prenom = $donnees['PRENOM_CONSULTANT'];
					$trigramme = $donnees['TRIGRAMME_CONSULTANT'];
					$login = $donnees['EMAIL_CONSULTANT'];
					//$password = $donnees['PASSWORD_AUTHEN'];
					$role = $donnees['PROFIL_CONSULTANT'];
				}
				$reponse->closeCursor();
			}
			catch (Exception $e)
			{
					die('Erreur : ' . $e->getMessage());
			}

			if($this->CONSULTANT->check_password($login,$password_given)!=True)
			{
				$message_erreur = 'Mauvais mot de passe !';
echo "Mauvais mot de passe";
				$view_to_display='login.php';
			}
			else
			{
				$res = array();
				$res['id'] = $id;
				$res['role'] = $role;
				$res['nom'] = $nom;
				$res['prenom'] = $prenom;
				$res['trigramme'] = $trigramme;
				$res['login'] = $login;
				session_start();
				$res['token'] = session_id();
				$_SESSION['login']=$login;
echo "mmmmmmmmmmmmmm";
			}
			return $res;
		}
	}
}

?>
