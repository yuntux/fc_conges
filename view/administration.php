<div class="form-style-3" style="border-bottom:1px solid #000;">
	<h3>Consultant</h2>
	<?php if($_SESSION['erreur'] == 80 && $_GET['search'] != ""){
		include("Includes/OK80.php");}?>
	<?php if($_SESSION['erreur'] == 81 && $_GET['search'] != ""){
		include("Includes/Erreur81.php");}?>
	<?php if($_SESSION['erreur'] == 82 && $_GET['search'] != ""){
		include("Includes/Erreur82.php");}?>
	<?php if($_SESSION['erreur'] == 83 && $_GET['search'] != ""){
		include("Includes/Erreur83.php");}?>
	<form action="?action=administration" method="post">
		<select name="thelistDM">
			<option>Sélectionner consultant</option>
		<?php 
			try
			{  
				while ($liste_consultants = $reponse1->fetch())
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
		
		<input type="submit" value="Chercher" name="search" style="margin-left:50px;"/></p>
	</form>

	<?php 
	$option ='<option selected="selected">CONSULTANT</option><option >DM</option><option>DIRECTEUR</option>';

	if($_POST['search'] != ""){
		if($PROFIL_CONSULTANT == "DM"){
			$option ='<option>CONSULTANT</option><option selected="selected">DM</option><option>DIRECTEUR</option>';
		}
		elseif($PROFIL_CONSULTANT == "DIRECTEUR"){
			$option ='<option>CONSULTANT</option><option >DM</option><option selected="selected">DIRECTEUR</option>';
		}
	?>
	<form action="?action=administration" method="post">
		<?php 
		if(!isset($_POST['search']))
			echo '<input type="hidden" class="input-field" name="COid" value="'.$_POST['search'].'" />';
		?>
		<label for="field1"><span>Nom <span class="required">*</span></span><input type="text" class="input-field" name="CONom" value="<?php if($_POST['search'] != "") echo $NOM_CONSULTANT;?>" /></label>
		<label for="field2"><span>Prénom <span class="required">*</span></span><input type="text" class="input-field" name="COprenom" value="<?phpif($_POST['search'] != "") echo $PRENOM_CONSULTANT;?>" /></label>
		<label for="field1"><span>Email <span class="required">*</span></span><input type="Email" class="input-field" name="COmail" value="<?php if($_POST['search'] != "")echo $EMAIL_CONSULTANT;?>" /></label>
		<label for="field1"><span>Trigramme <span class="required">*</span></span><input type="text" class="input-field" name="COTri" value="<?php if($_POST['search'] != "")echo $TRIGRAMME_CONSULTANT;?>" /></label>
		<label for="field1"><span>Profil <span class="required">*</span></span><select name="COprofil"><?php echo $option;?></select></label>

		<?php 
		if(!isset($_POST['search']))
			echo '<label><input type="submit" value="Ajouter" name="add_consultant" style="float:right;"/></label>';

		if(isset($_POST['search']))
			echo '<label><input type="submit" value="Enregistrer" name="update_consultant" style="float:right;"/></label>';
			echo '<input type="submit" value="Réintialiser Mot de passe" name="reinitialiser" style="floatleftt;"';
			echo '<input type="submit" value="Supprimer" name="delete_consultant" style="floatleftt;"';
		?>
	</form>
</div>
