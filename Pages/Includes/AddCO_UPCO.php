<div class="form-style-3" style="border-bottom:1px solid #000;">
	<h3>Nouveau Consultant</h2>
	<?php if($_SESSION['erreur'] == 80 && $_GET['search'] == ""){
		include("Includes/OK80.php");}?>
	<?php if($_SESSION['erreur'] == 81 && $_GET['search'] == ""){
		include("Includes/Erreur81.php");}?>
	<?php if($_SESSION['erreur'] == 82 && $_GET['search'] == ""){
		include("Includes/Erreur82.php");}?>
	<?php if($_SESSION['erreur'] == 83 && $_GET['search'] == ""){
		include("Includes/Erreur83.php");}?>
	<form action="MonCompteNewCons_post.php" method="post">
		<label for="field1"><span>Nom <span class="required">*</span></span><input type="text" class="input-field" name="CONom" value="" /></label>
		<label for="field2"><span>Prénom <span class="required">*</span></span><input type="text" class="input-field" name="COprenom" value="" /></label>
		<label for="field1"><span>Email <span class="required">*</span></span><input type="Email" class="input-field" name="COmail" value="" /></label>
		<label for="field1"><span>Trigramme <span class="required">*</span></span><input type="text" class="input-field" name="COTri" value="" /></label>
		<label><input type="submit" value="Enregistrer" name="Enregistrer" style="float:right;"/></label>
	</form>
</div>
<div class="form-style-3" style="border-bottom:1px solid #000;">
	<h3>Mise à jour Consultant</h2>
	<?php if($_SESSION['erreur'] == 80 && $_GET['search'] != ""){
		include("Includes/OK80.php");}?>
	<?php if($_SESSION['erreur'] == 81 && $_GET['search'] != ""){
		include("Includes/Erreur81.php");}?>
	<?php if($_SESSION['erreur'] == 82 && $_GET['search'] != ""){
		include("Includes/Erreur82.php");}?>
	<?php if($_SESSION['erreur'] == 83 && $_GET['search'] != ""){
		include("Includes/Erreur83.php");}?>
	<form action="MonCompteNewDM_post.php" method="post">
		<select name="thelistDM">
			<option>Sélectionner consultant</option>
		<?php 
			try
			{  
				$reponse1 = $bdd->query('SELECT * FROM consultant order by NOM_CONSULTANT');  
				while ($donnees1 = $reponse1->fetch())
				{
					echo "<option>".$donnees1['NOM_CONSULTANT']." ".$donnees1['PRENOM_CONSULTANT']."</option>";
				}
				$reponse1->closeCursor();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		?>
		</select><input type="submit" value="Chercher" name="Chercher" style="margin-left:50px;"/></p>
		<?php if($_GET['search'] != ""){
			include("Includes/MaJConsultant.php");}?>
		<label><input type="submit" value="Enregistrer" name="Enregistrer" style="float:right;"/></label>
	</form>
</div>
