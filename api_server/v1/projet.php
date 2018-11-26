<?php
include_once('rest_server_api.php');
class Projet extends server_api_authentificated{
	public function __construct($bdd) {
		parent::__construct($bdd);
	}

	public function get(){
	}

	public function remove(){
	}


	public function get_prochain_numero($is_accord_cadre){
		// TODO : init le 1er projet de l'année après un numéro donné.
		if ($is_accord_cadre == 1)
			$type = "AC";
		else
			$type = "PR";
		$current_year = date('y');
		$projects = $this->get_list($fields ='*', $filter="NUM_PROJET LIKE '".$type.$current_year."%'", $order_by="NUM_PROJET");
		if (count($projects) == 0){
			$increment = 1;
		}else{
			$last_num_project = end($projects)['NUM_PROJET'];
			$increment = intval(substr($last_num_project,5)) + 1;
		}
		$num = $type.$current_year.'-'.str_pad($increment, 3, '0', STR_PAD_LEFT);
//error_log($num.'\n', 3,"/tmp/test.log");
		return $num;
	}

//	public function add($nom, $type, $statut, $id_dm, $id_client, $client_saisie_libre, $commanditaire, $ca, $proba, $commentaire, $nom_sous_traitant, $ca_sous_traitant)
	public function add($crud_dict)
        {
		$data = json_decode($crud_dict,true); 
		$champs_lecture_seule = array("ID_PROJET","NUM_PROJET");
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
			$prepa = array("`NUM_PROJET`");
			$prepa2 = array("?");
			if (isset($data['IS_ACCORD_CADRE_PROJET'])){
				$tab = array($this->get_prochain_numero($data['IS_ACCORD_CADRE_PROJET']));
			} else {
				$tab = array($this->get_prochain_numero(0));
			}
			foreach ($data as $key=>$val){
				if (in_array($key, $champs_lecture_seule) == False){
					array_push($prepa,"`".$key."`");
					array_push($prepa2, "?");
					array_push($tab,$val);
				}
			}
			
			$p= 'INSERT INTO `projet`('.implode(",",$prepa).') VALUES ('.implode(',',$prepa2).')';
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


	public function update ($id_projet, $crud_dict)
        {
                $data = json_decode($crud_dict,true);
                $champs_lecture_seule = array("ID_PROJET","NUM_PROJET","IS_ACCORD_CADRE_PROJET");

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
			
			$p= 'UPDATE `projet` SET '.implode(",",$prepa).' WHERE ID_PROJET = '.$id_projet;
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

	public function get_list($fields ='*', $filter=False, $order_by="NUM_PROJET")
	{
		$q = 'SELECT '.$fields.' FROM projet';
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
