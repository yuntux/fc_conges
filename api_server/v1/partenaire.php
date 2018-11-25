<?php
include_once('rest_server_api.php');
class Partenaire extends server_api_authentificated{
	public function __construct($bdd) {
		parent::__construct($bdd);
	}

	public function get(){
	}

	public function remove(){
	}

	public function add($nom_partenaire,$secteur_partenaire)
        {
                try
                {
                        if ($_SESSION['role'] != "DIRECTEUR")
                        {
                                throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                                return False;
                        }
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                try
                {
                        $req = $this->bdd->prepare('INSERT INTO `partenaire`(`NOM_PARTENAIRE`, `ID_SECTEUR_PARTENAIRE`) VALUES (?,?)');
                        $req->execute(array($nom_partenaire,$secteur_partenaire));
                        $max_ID = $this->bdd->lastInsertId();
                }
                catch(Exception $e)
                {
			echo $e;
                        die('Erreur : '.$e);
                }
                return True;
	}


	public function update($nom_partenaire,$secteur_partenaire)
	{
                try
                {
                        if ($_SESSION['role'] != "DIRECTEUR")
                        {
                                throw new Exception('Droits insuffisants, seul un directeur peut effectuer cette action.');
                                return False;
                        }
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }

                try
                {
                        $record_maj = $this->bdd->exec('UPDATE `partenaire` SET `NOM_PARTENAIRE`= "'.$nom_partenaire.'", `SECTEUR_PARTENAIRE`= "'.$secteur_partenaire.'"');
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                return True;
	}

	public function get_list($fields ='*', $filter=False, $order_by="NOM_PARTENAIRE")
	{
		$q = 'SELECT '.$fields.' FROM partenaire';
		if ($filter)
			$q.= ' WHERE '.$filter;
		if ($order_by)
			$q.= ' ORDER BY '.$order_by;
//echo $q;
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

}
