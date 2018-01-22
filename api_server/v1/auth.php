<?php

include_once('model_singleton.php');

class auth extends server_api {

        public $CONSULTANT;
        public $DEMANDE;
	public $bdd;

        public function __construct($bdd) {
                parent::__construct($bdd);
		$this->CONSULTANT =  get_consultant_singleton($bdd);
		$this->DEMANDE =  get_demande_singleton($bdd);
		$this->bdd = $bdd;
        }

	public function init_consultant_pass_from_login($login){
		$id=$this->CONSULTANT->get_id_from_login($login);	
		return $this->CONSULTANT->init_password($id);
	} 

	public function deconnect(){
		$protected_object = new server_api_authentificated($this->bdd);
	        $auth_ok = $protected_object->check_token_validity();
                if ($auth_ok==False) {
                        return "Error auth";
                } else {
			unset($_SESSION);
			session_destroy();	
			return True;
		}
	}

	public function login_password($login,$password_given){

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
//echo "Mauvais mot de passe";
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
                		$_SESSION['id'] = $id;
                		$_SESSION['role'] = $role;
			}
			return $res;
		}
	}
}

?>
