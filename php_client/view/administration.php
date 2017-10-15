<div id="bloc_donnees">

	<div id="bloc_donnees1">
	<h2>Consultants</h2>
	<form action="?action=administration" method="post">
		<select name="select_consultant">
			<option>Sélectionner consultant</option>
		<?php 
			try
			{  
				foreach($liste_consultants as $donnees)
				{
					echo "<option value='".$donnees['ID_CONSULTANT']."'>".$donnees['NOM_CONSULTANT']." ".$donnees['PRENOM_CONSULTANT']."</option>";
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		?>
		</select>
		
		<input type="submit" value="Chercher" name="search" style="margin-left:50px;"/>
	</form>

	<?php 
	$option ='<option selected="selected">CONSULTANT</option><option >DM</option><option>DIRECTEUR</option>';

	if(isset($_POST['search'])){
		if($COprofil == "DM"){
			$option ='<option>CONSULTANT</option><option selected="selected">DM</option><option>DIRECTEUR</option>';
		}
		elseif($COprofil == "DIRECTEUR"){
			$option ='<option>CONSULTANT</option><option >DM</option><option selected="selected">DIRECTEUR</option>';
		}
	}
	?>
	<form action="?action=administration" method="post">
		<table>
		<tr><td>Nom *</td><td> <input type="text" name="CONom" value="<?php if(isset($CONom)) echo $CONom;?>"  required/></td></tr>
		<tr><td>Prenom *</td><td> <input type="text" name="COprenom" value="<?php if(isset($COprenom)) echo $COprenom;?>"  required/></td></tr>
		<tr><td>Email * </td><td><input type="text" name="COmail" value="<?php if(isset($COmail)) echo $COmail;?>"  required/></td></tr>
		<tr><td>Trigramme * </td><td><input type="text" name="COTri" value="<?php if(isset($COTri)) echo $COTri;?>"  required/></td></tr>
		<tr><td>Profil * </td><td><select name="COprofil"><?php echo $option;?></select></td></tr>
		</table>

		<?php 
		if(isset($_POST['search'])) {
			echo '<input type="hidden" name="COid" value="'.$_POST['select_consultant'].'" />';
			echo '<input type="submit" value="Enregistrer" name="update_consultant" style="float:right;" />';
			echo '<input type="submit" value="Réintialiser Mot de passe" name="reinitialiser" style="floatleftt;" />';
			if ($_SESSION['id'] != $_POST['select_consultant']){
				echo '<input type="submit" value="Supprimer" name="delete_consultant" />';
			}
		} else {
			echo '<input type="submit" value="Ajouter" name="add_consultant" style="float:right;" />';
		}
		?>
	</form>
	</div>
</div>
