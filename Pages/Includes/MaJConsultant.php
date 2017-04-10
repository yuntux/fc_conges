<?php 
	include("Functions/connection.php");
	try
	{  
		$reponse1 = $bdd->query('SELECT * FROM consultant WHERE ID_CONSULTANT = "'.$_GET['search'].'"');  
		while ($donnees1 = $reponse1->fetch())
		{
			$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT']; 
			$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT']; 
			$EMAIL_CONSULTANT = $donnees1['EMAIL_CONSULTANT']; 
			$TRIGRAMME_CONSULTANT = $donnees1['TRIGRAMME_CONSULTANT']; 
			$PROFIL_CONSULTANT = $donnees1['PROFIL_CONSULTANT']; 
		}
		$reponse1->closeCursor();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}

	if($PROFIL_CONSULTANT == "DM"){
		$option ='<option>CONSULTANT</option><option selected="selected">DM</option><option>DIRECTEUR</option>';
	}
	elseif($PROFIL_CONSULTANT == "DIRECTEUR"){
		$option ='<option>CONSULTANT</option><option >DM</option><option selected="selected">DIRECTEUR</option>';
	}
	else{
		$option ='<option selected="selected">CONSULTANT</option><option >DM</option><option>DIRECTEUR</option>';
	}
?>
<input type="hidden" class="input-field" name="COid" value="<?php echo $_GET['search'];?>" />
<label for="field1"><span>Nom <span class="required">*</span></span><input type="text" class="input-field" name="CONom" value="<?php echo $NOM_CONSULTANT;?>" /></label>
<label for="field2"><span>Prénom <span class="required">*</span></span><input type="text" class="input-field" name="COprenom" value="<?php echo $PRENOM_CONSULTANT;?>" /></label>
<label for="field1"><span>Email <span class="required">*</span></span><input type="Email" class="input-field" name="COmail" value="<?php echo $EMAIL_CONSULTANT;?>" /></label>
<label for="field1"><span>Trigramme <span class="required">*</span></span><input type="text" class="input-field" name="COTri" value="<?php echo $TRIGRAMME_CONSULTANT;?>" /></label>
<label for="field1"><span>Profil <span class="required">*</span></span><select name="COprofil"><?php echo $option;?></select></label>
<input type="submit" value="Réintialiser Mot de passe" name="reinitialiser" style="float:right;"/>
