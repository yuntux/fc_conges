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


	public function add($crud_dict)
        {
		$data = json_decode($crud_dict); 
		$champs_lecture_seule = array("ID_PARTENAIRE");
                try
                {
                        if ($_SESSION['role'] != "DIRECTEUR" && $_SESSION['role'] != "DM")
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
			$prepa = array();
			$prepa2 = array();
			foreach ($data as $key=>$val){
				if (in_array($key, $champs_lecture_seule) == False){
					array_push($prepa,"`".$key."`");
					array_push($prepa2, "?");
					array_push($tab,$val);
				}
			}
			
			$p= 'INSERT INTO `partenaire`('.implode(",",$prepa).') VALUES ('.implode(',',$prepa2).')';
                        $req = $this->bdd->prepare($p);
                        $req->execute($tab);
             //           $ID_projet = $this->bdd->lastInsertId();
                }
                catch(Exception $e)
                {
			echo $e;
                        die('Erreur : '.$e);
                }
                return True;
	}


	public function update ($id, $crud_dict)
        {
                $data = json_decode($crud_dict);
                $champs_lecture_seule = array("ID_PARTENAIRE");

                try
                {
                        if ($_SESSION['role'] != "DIRECTEUR" && $_SESSION['role'] != "DM")
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

			$prepa = array();
			$tab = array();
			foreach ($data as $key=>$val){
				if (in_array($key, $champs_lecture_seule) == False){
					array_push($prepa,"`".$key."` = ?");
					array_push($tab,$val);
				}
			}
			
			$p= 'UPDATE `partenaire` SET '.implode(",",$prepa).' WHERE ID_PARTENAIRE = '.$id;
error_log('\n'.$p, 3,"/tmp/test.log");
                        $req = $this->bdd->prepare($p);
                        $req->execute($tab);
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
//error_log('\n'.$q, 3,"/tmp/test.log");
//echo $q;
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

}
