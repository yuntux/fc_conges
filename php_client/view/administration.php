<div id="bloc_donnees">

	<div id="bloc_donnees1">
	<h2>Consultants</h2>
	<?php if($_SESSION['erreur'] == 80 && isset($_GET['search'])){
		include("Includes/OK80.php");}?>
	<?php if($_SESSION['erreur'] == 81 && isset($_GET['search'])){
		include("Includes/Erreur81.php");}?>
	<?php if($_SESSION['erreur'] == 82 && isset($_GET['search'])){
		include("Includes/Erreur82.php");}?>
	<?php if($_SESSION['erreur'] == 83 && isset($_GET['search'])){
		include("Includes/Erreur83.php");}?>
	<form action="?action=administration" method="post">
		<select name="select_consultant">
			<option>Sélectionner consultant</option>
		<?php 
			try
			{  
				while ($donnees1 = $liste_consultants->fetch())
				{
					echo "<option value='".$donnees1['ID_CONSULTANT']."'>".$donnees1['NOM_CONSULTANT']." ".$donnees1['PRENOM_CONSULTANT']."</option>";
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
			echo '<input type="submit" value="Supprimer" name="delete_consultant" />';
		} else {
			echo '<input type="submit" value="Ajouter" name="add_consultant" style="float:right;" />';
		}
		?>
	</form>
	</div>
</div>