<?php include("Functions/sessioncheck.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head style ="display: none;">
		<title>Fontaine Consultants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style.css?v=5" />
		<?php include("Functions/connection.php"); ?>
	</head>
	<body>
		<div id="main_wrapper">
			<div id="tete_page">
				<?php include("Includes/head.php"); ?>
				<div id="nav" style="background-color: #E6B473;text-align:justify;">
					<ul class="links primary-links">
						<li class="menu-1-1"><a href="Home.php" class="menu-1-1"">Dashboard</a></li>
						<li class="menu-1-2"><a href="DemandeConges.php" class="menu-1-2">Saisie</a></span></li>
						<li class="menu-1-3"><a href="Historiques.php" class="menu-1-3">Historiques</a></li>
						<li class="menu-1-4"><a href="Validation.php" class="menu-1-4">Validation</a></li>
						<li class="menu-1-5"><a href="VisionGenerale.php" class="menu-1-5">Vision g&#233;n&#233;rale</a></li>
					</ul>  
				</div>  
			</div>
				<?php 
				try
				{  
					$reponse1 = $bdd->query('SELECT * FROM consultant where ID_CONSULTANT =\''.$_SESSION['id'].'\'');  
					while ($donnees1 = $reponse1->fetch())
					{
						$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT']; 
						$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
						$TRIGRAMME_CONSULTANT = $donnees1['TRIGRAMME_CONSULTANT'];
					}
					$reponse1->closeCursor();
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage());
				}
				?>
			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Paramètres du compte <?php echo $_SESSION['role']?></h2>
					<p>Bievenue sur votre espace, <?php echo $PRENOM_CONSULTANT ;?> !</p>
				</div>
				<div id="bloc_donnees1">
					<h2>Paramètres du compte</h2>
					<div class="form-style-3" style="border-bottom:1px solid #000;">
						<h3>Changer le Mot de passe</h2>
						<?php if($_SESSION['erreur'] == 90){
							include("Includes/OK90.php");}?>
						<?php if($_SESSION['erreur'] == 92){
							include("Includes/Erreur92.php");}?>
						<?php if($_SESSION['erreur'] == 91){
							include("Includes/Erreur91.php");}?>
						<form action="MonCompteMdP_post.php" method="post">
							<label for="field1"><span>Nouveau <span class="required">*</span></span><input type="password" class="input-field" name="nouveauMdP" value="" /></label>
							<label for="field2"><span>Confirmer <span class="required">*</span></span><input type="password" class="input-field" name="confirmationMdP" value="" /></label>
							<label><input type="submit" value="Enregistrer" name="Enregistrer" style="float:right;"/></label>
						</form>
					</div>
					<?php if($_SESSION['role'] == "DIRECTEUR"){
							include("Includes/AddCO_UPCO.php");}?>
				</div>
				<div id="bloc_donnees1">
					<h2>Mise à jour du solde</h2>
					<?php 
						try
						{  
							$reponse1 = $bdd->query('SELECT * FROM acquis where CONSULTANT_ACQUIS =\''.$_SESSION['id'].'\'');  
							while ($donnees1 = $reponse1->fetch())
							{
								$ACQUIS_RTTn1 = $donnees1['RTTn1_ACQUIS']; 
								$ACQUIS_RTTn = $donnees1['RTTn_ACQUIS'];
								$ACQUIS_CPn1 = $donnees1['CPn1_ACQUIS'];
								$ACQUIS_CPn = $donnees1['CPn_ACQUIS'];
							}
							$reponse1->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
					?>
					<?php 
						try
						{  
							$reponse1 = $bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_SOLDE) from solde where CONSULTANT_SOLDE = \''.$_SESSION['id'].'\') AND CONSULTANT_SOLDE =\''.$_SESSION['id'].'\'');  
							while ($donnees1 = $reponse1->fetch())
							{
								$NBJRS_RTTn1 = $donnees1['RTTn1_SOLDE']; 
								$NBJRS_RTTn = $donnees1['RTTn_SOLDE'];
								$NBJRS_CPn1 = $donnees1['CPn1_SOLDE'];
								$NBJRS_CPn = $donnees1['CPn_SOLDE'];
							}
							$reponse1->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
					?>
					<form action="MonCompteSolde_post.php" method="post">
						<table id="background-image" class="styletab">
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
									<td><input type="text" value="<?php echo $ACQUIS_CPn1;?>" name="AcquisCPn1" id="AcquisCPn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_CPn;?>" name="AcquisCPn" id="AcquisCPn" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_RTTn1;?>" name="AcquisRTTn1" id="AcquisRTTn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_RTTn;?>" name="AcquisRTTn" id="AcquisRTTn" style="width:60px;"/></td>
								</tr>
								<tr style="text-align:center;">
									<td style="text-align:left;">Solde</td>
									<td><input type="text" value="<?php echo $NBJRS_CPn1;?>" name="SoldeCPn1" id="SoldeCPn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_CPn;?>" name="SoldeCPn" id="SoldeCPn" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_RTTn1;?>" name="SoldeRTTn1" id="SoldeRTTn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_RTTn;?>" name="SoldeRTTn" id="SoldeRTTn"style="width:60px;"/></td>
								</tr>
							</tbody>
						</table>
						<p style="float:right"><input type="submit" value="Enregistrer" name="Enregistrer"/><input type="submit" value="Annuler" name="Annuler"/></p>	
					</form>
				</div>
			</div>
			<div id="pied_page">
			</div>
		</div>
	</body>
<?php $_SESSION['erreur'] = 0;?>
<?php $indice = 0 ;?>
</html>
