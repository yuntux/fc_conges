<?php include("includes/sessioncheck.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head style ="display: none;">
		<title>Fontaine Consultants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style.css" />
		<?php include("includes/connection.php"); ?>
	</head>
	<body>
		<?php include("Includes/head.php"); ?>
		<?php if($_SESSION['role'] == "Consultant"){
				include("Includes/nav.php");}
			else{
				include("Includes/navadmin.php");} ?>
		<div id="wrapper">
			<?php if($_SESSION['role'] == "Directeur"){
				include("Functions/ValidationDir.php");} ?>
			<h2>Demande à valider</h2>
			<table id="background-image">
				<thead>
					<tr>
						<td>Date de la demande</td>
						<td>Consultants</td>
						<td>Début</td>
						<td>Fin</td>
						<td>Nombre de jour</td>
						<td>Valider</td>
						<td>Annuler</td>
					</tr>
				</thead>
				<tbody>
					<form action="Validation_post.php" method="post">
					<?php 
						try
						{
							$reponse1 = $bdd->query('SELECT a.ID_CONGES, a.DATEDEM_CONGES, a.DEBUT_CONGES, a.DEBUTMM_CONGES, a.FIN_CONGES, a.FINMS_CONGES, a.STATUT_CONGES, a.NBJRS_CONGES, c.NOM_CONSULTANT, c.PRENOM_CONSULTANT FROM conges a, consultant b, consultant c WHERE a.VALIDEUR_CONGES = b.TRIGRAMME_CONSULTANT and b.ID_CONSULTANT = \''.$_SESSION['id'].'\' and c.ID_CONSULTANT = a.CONSULTANT_CONGES and a.STATUT_CONGES = "En attente Validation DM"');  
							while ($donnees1 = $reponse1->fetch())
							{
							?>
								<tr>
									<td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
									<td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
									<td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
									<td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
									<td><?php echo $donnees1['NBJRS_CONGES']; ?></td>
									<td>
										<?php if($donnees1['STATUT_CONGES'] == "En attente validation DM"){
												echo '<input type="submit" value="Envoyer" name="E'.$donnees1['ID_CONGES'].'" />' ;}
											else {
												echo "" ;}	
										 ?></td>
									<td>
										<?php if($donnees1['STATUT_CONGES'] == "En attente validation DM" || $donnees1['STATUT_CONGES'] == "En cours de validation Direction"){
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
					</form>
				</tbody>
				<tfoot>
				</tbody>
			</table>
			<h2>Historique des demandes</h2>
			<table id="background-image">
				<thead>
					<tr>
						<td>Date de la demande</td>
						<td>Consultants</td>
						<td>Début</td>
						<td>Fin</td>
						<td>Nombre de jour</td>
						<td>Statut</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						try
						{
$req = 'SELECT a.ID_CONGES,a.DATEDEM_CONGES, a.DEBUT_CONGES, a.DEBUTMM_CONGES, a.FIN_CONGES, a.FINMS_CONGES, a.STATUT_CONGES, a.NBJRS_CONGES, c.NOM_CONSULTANT, c.PRENOM_CONSULTANT 
FROM conges a, consultant b, consultant c
WHERE (a.VALIDEUR_CONGES = b.TRIGRAMME_CONSULTANT 
       and b.ID_CONSULTANT = \''.$_SESSION['id'].'\' 
       and c.ID_CONSULTANT = a.CONSULTANT_CONGES  
       and a.STATUT_CONGES <> "Annulée" 
       and a.STATUT_CONGES <> "En attente Validation DM" 
       and a.STATUT_CONGES <> "Attente envoie")
       OR (a.VALIDEUR_CONGES = b.TRIGRAMME_CONSULTANT 
       and b.ID_CONSULTANT <> \''.$_SESSION['id'].'\' 
       and c.ID_CONSULTANT = a.CONSULTANT_CONGES  
       and a.STATUT_CONGES = "Validée") 
       OR (a.VALIDEUR_CONGES = b.TRIGRAMME_CONSULTANT 
       and b.ID_CONSULTANT <> \''.$_SESSION['id'].'\' 
       and c.ID_CONSULTANT = a.CONSULTANT_CONGES  
       and a.STATUT_CONGES = "Annulée Dir") ';
							$reponse1 = $bdd->query($req);  
							while ($donnees1 = $reponse1->fetch())
							{
							?>
								<tr>
									<td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
									<td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
									<td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
									<td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
									<td><?php echo $donnees1['NBJRS_CONGES']; ?></td>
									<td><?php echo $donnees1['STATUT_CONGES']; ?></td>
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
				<tfoot>
				</tbody>
			</table>
		</div>
	</body>
</html>
