<?php include("Functions/sessioncheck.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head style ="display: none;">
		<title>Fontaine Consultants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style.css?v=4" />
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
						<li class="menu-1-3" style="background-color:#FFF;"><a href="Historiques.php" class="menu-1-3">Historiques</a></li>
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
					<h2>Historique des demandes</h2>
					<p>Bievenue sur votre espace, <?php echo $PRENOM_CONSULTANT ;?> !</p>
				</div>
				<div id="entete_bloc_donnees">
					<h2>Demandes en cours</h2>
					<table id="background-image" class="styletab">
						<thead>
							<tr>
								<th>Date de la demande</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Nombre de jour</th>
								<th>Jours posés</th>
								<th>Statut</th>
								<th>Valideur</th>
								<th>Envoyer</th>
								<th>Annuler</th>
							</tr>
						</thead>
						<form action="Historiques_post.php" method="post">
						<tbody>
			<?php 
				try
				{  
					$reponse1 = $bdd->query('SELECT * FROM conges WHERE (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Attente envoie" OR `STATUT_CONGES` = "En cours de validation DM" OR `STATUT_CONGES` = "En cours de validation Direction" OR (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` >= CURRENT_DATE'); 
					while ($donnees1 = $reponse1->fetch())
					{
					?>
						<tr>
							<td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
							<td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
							<td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
							<td><?php echo $donnees1['NBJRS_CONGES']." jour(s)"; ?></td>
							<?php
								$cp = $donnees1['CP_CONGES'];
								$rtt = $donnees1['RTT_CONGES'];
								$ss = $donnees1['SS_CONGES'];
								$conv = $donnees1['CONV_CONGES'];
								$autres = $donnees1['AUTRE_CONGES'];
								$type  = "";
								if($cp != 0){
									$type = $type. $cp. " CP ";
								}
								if($rtt != 0){
									$type = $type. $rtt. " RTT ";
								}
								if($ss != 0){
									$type = $type. $ss. " Sans Solde ";
								}
								if($conv != 0){
									$type = $type. $conv. " Conventionnels ";
								}
								if($autres != 0){
									$type = $type. $autres. " Autres";
								}
							?>
							<td><?php echo $type; ?></td>
							<td><?php echo $donnees1['STATUT_CONGES']; ?></td>
							<td><?php echo $donnees1['VALIDEUR_CONGES']; ?></td>
							<td>
								<?php if($donnees1['STATUT_CONGES'] == "Attente envoie"){
										echo '<input type="submit" value="Envoyer" name="E'.$donnees1['ID_CONGES'].'" />' ;}
									else {
										echo "" ;}	
								 ?></td>
							<td>
								<?php if($donnees1['STATUT_CONGES'] == "En cours de validation DM" || $donnees1['STATUT_CONGES'] == "Attente envoie"){
										echo '<input type="submit" value="Annuler" name="A'.$donnees1['ID_CONGES'].'" />' ;}
									else {
										echo "" ;}	
								 ?></td>
						</tr>
					<?php
					}
					$reponse1->closeCursor();
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage());
				}
				?>
						</tbody>
					</table>
					</form>
					<h2>Historique</h2>
					<table id="background-image" class="styletab">
						<thead>
							<tr>
								<th>Date de la demande</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Nombre de jour</th>
								<th>Jours posés</th>
								<th>Statut</th>
								<th>Valideur</th>
							</tr>
						</thead>
						<tbody>
										<?php 
				try
				{  
					$reponse1 = $bdd->query('SELECT * FROM conges WHERE (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Annulée" OR `STATUT_CONGES` = "Annulée Direction" OR `STATUT_CONGES` = "Annulée DM" OR (CONSULTANT_CONGES = '.$_SESSION['id'].') AND `STATUT_CONGES` = "Validée" AND `DEBUT_CONGES` < CURRENT_DATE'); 
					while ($donnees1 = $reponse1->fetch())
					{
					?>
						<tr>
							<td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
							<td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
							<td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
							<td><?php echo $donnees1['NBJRS_CONGES']." jour(s)"; ?></td>
							<?php
								$cp = $donnees1['CP_CONGES'];
								$rtt = $donnees1['RTT_CONGES'];
								$ss = $donnees1['SS_CONGES'];
								$conv = $donnees1['CONV_CONGES'];
								$autres = $donnees1['AUTRE_CONGES'];
								$type  = "";
								if($cp != 0){
									$type = $type. $cp. " CP ";
								}
								if($rtt != 0){
									$type = $type. $rtt. " RTT ";
								}
								if($ss != 0){
									$type = $type. $ss. " Sans Solde ";
								}
								if($conv != 0){
									$type = $type. $conv. " Conventionnels ";
								}
								if($autres != 0){
									$type = $type. $autres. " Autres";
								}
							?>
							<td><?php echo $type; ?></td>
							<td><?php echo $donnees1['STATUT_CONGES']; ?></td>
							<td><?php echo $donnees1['VALIDEUR_CONGES']; ?></td>
						</tr>
					<?php
					}
					$reponse1->closeCursor();
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage());
				}
				?>
						</tbody>
					</table>				
				</div>
			</div>
			<div id="pied_page">
			</div>
		</div>
	</body>
</html>
