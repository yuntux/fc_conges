<?php
include_once('rest_server_api.php');
class LigneStaffing extends server_api_authentificated{
	public $nomTableSQL = 'ligne_staffing'; 

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
		$champs_lecture_seule = array("ID_".$this->nomTableSQL);
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
			
			$p= 'INSERT INTO `'.$this->nomTableSQL.'`('.implode(",",$prepa).') VALUES ('.implode(',',$prepa2).')';
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
			
			$p= 'UPDATE `'.$this->nomTableSQL.'` SET '.implode(",",$prepa).' WHERE ID_'.$this->nomTableSQL.' = '.$id;
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

	public function get_list($fields ='*', $filter=False, $order_by="ID_LIGNE_STAFFING")
	{
		$q = 'SELECT '.$fields.' FROM '.$this->nomTableSQL;
		if ($filter)
			$q.= ' WHERE '.$filter;
		if ($order_by)
			$q.= ' ORDER BY '.$order_by;
//error_log('\n'.$q, 3,"/tmp/test.log");
//echo $q;
		$reponse = $this->bdd->query($q);
		return $reponse->fetchAll();
	}

        public function get_forecast()
        {
                $q = 'SELECT * FROM ligne_staffing ORDER BY ID_CONSULTANT_LIGNE_STAFFING';
//error_log('\n'.$q, 3,"/tmp/test.log");
//echo $q;
                $reponse = $this->bdd->query($q);
                $l = $reponse->fetchAll();
		$res = Array();

		$precedente_ligne_staffing = null;
		foreach($l as $ligne_staffing){
			$key = $ligne_staffing['ID_CONSULTANT_LIGNE_STAFFING']."_".$ligne_staffing['ID_PROJET_LIGNE_STAFFING'];
			if (array_key_exists($key,$res) != True){
				$tmp = Array();
				$tmp['ID_LIGNE_STAFFING'] = $ligne_staffing['ID_LIGNE_STAFFING'];
				$tmp['ID_CONSULTANT_LIGNE_STAFFING'] = $ligne_staffing['ID_CONSULTANT_LIGNE_STAFFING'];
				$tmp['ID_PROJET_LIGNE_STAFFING'] = $ligne_staffing['ID_PROJET_LIGNE_STAFFING'];
				$res[$key] = $tmp;
			}
			$res[$key][$ligne_staffing['MOIS_LIGNE_STAFFING']] = $ligne_staffing['NB_JOURS_PREVISIONNEL_LIGNE_STAFFING'];
			/*
			if ($precedente_ligne_staffing != null){
				if $precedente_ligne_staffing['ID_CONSULTANT_LIGNE_STAFFING'] !=$precedente_ligne_staffing['ID_CONSULTANT_LIGNE_STAFFING']){
					// TODO : ajouter ligne formation
					// TODO : ajouter ligne congés
				}
			}
			$precedente_ligne_staffing = $ligne_staffing;
			*/
		}

		$res2 = Array();
		foreach ($res as $k=>$v)
			array_push($res2,$v);	
		return $res2;
        }
	
	public function change_staffing($key, $crud_dict)
	{
		$ligne_retournee = json_decode($crud_dict,true);
		//récupérer l'ID_CONSULTANT et l'ID_PROJET avant modification
                $q = 'SELECT * FROM ligne_staffing WHERE ID_LIGNE_STAFFING = '.$key;
                $reponse = $this->bdd->query($q);
                $ref = $reponse->fetchAll()[0];

		//Si le consultant change
		$consultant = $ref['ID_CONSULTANT_LIGNE_STAFFING'];
		if (isset($ligne_retournee['ID_CONSULTANT_LIGNE_STAFFING'])){
 			$p= 'UPDATE `'.$this->nomTableSQL.'` SET ID_CONSULTANT_LIGNE_STAFFING = '.$ligne_retournee['ID_CONSULTANT_LIGNE_STAFFING'].' WHERE ID_CONSULTANT_LIGNE_STAFFING = '.$ref['ID_CONSULTANT_LIGNE_STAFFING'].' and ID_PROJET_LIGNE_STAFFING = '.$ref['ID_PROJET_LIGNE_STAFFING'];
			$this->bdd->exec($p);
			$consultant = $ligne_retournee['ID_CONSULTANT_LIGNE_STAFFING'];
		}

		//Si le projet change
		$projet = $ref['ID_PROJET_LIGNE_STAFFING'];
		if (isset($ligne_retournee['ID_PROJET_LIGNE_STAFFING'])){
 			$p= 'UPDATE `'.$this->nomTableSQL.'` SET ID_PROJET_LIGNE_STAFFING = '.$ligne_retournee['ID_PROJET_LIGNE_STAFFING'].' WHERE ID_CONSULTANT_LIGNE_STAFFING = '.$ref['ID_CONSULTANT_LIGNE_STAFFING'].' and ID_PROJET_LIGNE_STAFFING = '.$ref['ID_PROJET_LIGNE_STAFFING'];
			$this->bdd->exec($p);
			$projet = $ligne_retournee['ID_PROJET_LIGNE_STAFFING'];
		}

		foreach($ligne_retournee as $k=>$v){
			if (strlen($k) == 7){ //TODO Remplacer le test sur la longueur du champ par une regexp 20\d\d-\d\d 
                		$q = 'SELECT * FROM ligne_staffing WHERE ID_CONSULTANT_LIGNE_STAFFING = '.$consultant.' and ID_PROJET_LIGNE_STAFFING = '.$projet.' and MOIS_LIGNE_STAFFING="'.$k.'"';
                		$reponse = $this->bdd->query($q);
				$r = $reponse->fetchAll()[0];
				// Si une imputation mensuelle change
				if (count($r) > 0) {
					$p= 'UPDATE `'.$this->nomTableSQL.'` SET NB_JOURS_PREVISIONNEL_LIGNE_STAFFING = '.$v.' WHERE ID_LIGNE_STAFFING = '.$r['ID_LIGNE_STAFFING'];
				// Si une imputation mensuelle est ajoutée
				} else {
					//TODO : contrôler que ID consultant et IS projet ne sont pas nuls
					$p= 'INSERT INTO `'.$this->nomTableSQL.'` (ID_CONSULTANT_LIGNE_STAFFING,ID_PROJET_LIGNE_STAFFING,MOIS_LIGNE_STAFFING,NB_JOURS_PREVISIONNEL_LIGNE_STAFFING) VALUE ("'.$consultant.'","'.$projet.'","'.$k.'","'.$v.'")';
				}
				//error_log('\n'.$p, 3,"/tmp/test.log");
				$this->bdd->exec($p);
			}
		}
	}

        public function add_staffing($crud_dict)
        {
		$data = json_decode($crud_dict,true);
		$consultant = $data['ID_CONSULTANT_LIGNE_STAFFING'];
              	$projet = $data['ID_PROJET_LIGNE_STAFFING'];
		foreach($data as $k=>$v){
			if (strlen($k) == 7){ //TODO Remplacer le test sur la longueur du champ par une regexp 20\d\d-\d\d
				$p= '	INSERT INTO `'.$this->nomTableSQL.'` (ID_CONSULTANT_LIGNE_STAFFING,ID_PROJET_LIGNE_STAFFING,MOIS_LIGNE_STAFFING,NB_JOURS_PREVISIONNEL_LIGNE_STAFFING) VALUE ("'.$consultant.'","'.$projet.'","'.$k.'","'.$v.'")';
				//error_log('\n PROJET '.$p, 3,"/tmp/test.log");
                		$this->bdd->exec($p);
			}
		}
	}
}
