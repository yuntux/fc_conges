<div id="bloc_donnees">

	<div id="bloc_donnees1">
	<h2>Consultants</h2>
	<form action="?action=administration" method="post">
		<select name="select_consultant" onchange="this.form.submit()">
		<option value="-1">Sélectionner un consultant</option>
		<?php 
			try
			{  
				foreach($liste_consultants as $donnees)
				{
					echo "<option value='".$donnees['ID_CONSULTANT']."'>".$donnees['NOM_CONSULTANT']." ".$donnees['PRENOM_CONSULTANT'];
					if ($donnees['STATUT_CONSULTANT']=="0") {
						echo " (INACTIF)";
					}
					echo "</option>";
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		?>
		</select>
		
	</form>

	<?php 
	$option ='<option selected="selected">CONSULTANT</option><option >DM</option><option>DIRECTEUR</option>';

	if(isset($_POST['select_consultant'])){
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
		<!--<tr><td>Trigramme * </td><td><input type="text" name="COTri" value="<?php if(isset($COTri)) echo $COTri;?>"  required/></td></tr>-->
		<input type="hidden" name="COTri" value=""/>
		<tr><td>Profil * </td><td><select name="COprofil"><?php echo $option;?></select></td></tr>
		<?php if(isset($_POST['select_consultant'])){
			echo '<tr><td>Statut * </td><td><select name="COstatut">';
			if($COstatut == "0"){
				echo '<option value="1">ACTIF</option><option selected="selected" value="0">INACTIF</option>'; 
			}
			else {
				echo '<option selected="selected" value="1">ACTIF</option><option value="0">INACTIF</option>';
			}
			echo '</select></td></tr>';
		}
		?>
		</table>



		<?php 
		if(isset($_POST['select_consultant'])) {
			echo '<table id="background-image" class="styletab">
				<thead>
					<tr>
						<th></th>
						<th style="text-align:center;">CP n-1</th>
						<th style="text-align:center;">CP n</th>
						<th style="text-align:center;">RTT n-1</th>
						<th style="text-align:center;">RTT n</th>
					</tr>
				</thead>
				<tbody>
					<tr style="text-align:center;">
						<td style="text-align:left;">Acquis</td>
						<td><input type="text" value="'.$ACQUIS_CPn1.'" name="AcquisCPn1" id="AcquisCPn1" style="width:60px;"/></td>
						<td><input type="text" value="'.$ACQUIS_CPn.'" name="AcquisCPn" id="AcquisCPn" style="width:60px;"/></td>
						<td><input type="text" value="'.$ACQUIS_RTTn1.'" name="AcquisRTTn1" id="AcquisRTTn1" style="width:60px;"/></td>
						<td><input type="text" value="'.$ACQUIS_RTTn.'" name="AcquisRTTn" id="AcquisRTTn" style="width:60px;"/></td>
					</tr>
					<tr style="text-align:center;">
						<td style="text-align:left;">Solde</td>
						<td><input type="text" value="'.$NBJRS_CPn1.'" name="SoldeCPn1" id="SoldeCPn1" style="width:60px;"/></td>
						<td><input type="text" value="'.$NBJRS_CPn.'" name="SoldeCPn" id="SoldeCPn" style="width:60px;"/></td>
						<td><input type="text" value="'.$NBJRS_RTTn1.'" name="SoldeRTTn1" id="SoldeRTTn1" style="width:60px;"/></td>
						<td><input type="text" value="'.$NBJRS_RTTn.'" name="SoldeRTTn" id="SoldeRTTn"style="width:60px;"/></td>
					</tr>
				</tbody>
			</table>';
			echo '<input type="hidden" name="COid" value="'.$_POST['select_consultant'].'" />';
			echo '<input type="submit" value="Enregistrer" name="update_consultant" style="float:right;" />';
			echo '<input type="submit" value="Réintialiser Mot de passe" name="reinitialiser" style="floatleftt;" />';
/*
			if ($_SESSION['id'] != $_POST['select_consultant']){
				echo '<input type="submit" value="Supprimer" name="delete_consultant" />';

			}
*/
		} else {
			echo '<input type="submit" value="Ajouter" name="add_consultant" style="float:right;" />';
		}

		?>


	</form>
	</div>
</div>
