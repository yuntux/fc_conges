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
						<li class="menu-1-1" style="background-color:#FFF;"><a href="Home.php" class="menu-1-1"">Dashboard</a></li>
						<li class="menu-1-2"><a href="DemandeConges.php" class="menu-1-2">Saisie</a></span></li>
						<li class="menu-1-3"><a href="Historiques.php" class="menu-1-3">Historiques</a></li>
						<li class="menu-1-4"><a href="Validation.php" class="menu-1-4">Validation</a></li>
						<li class="menu-1-5"><a href="VisionGenerale.php" class="menu-1-5">Vision g&#233;n&#233;rale</a></li>
					</ul>  
				</div>  
			</div>
			<div id="bloc_donnees">
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
				<div id="entete_bloc_donnees">
					<h2>Dashboard</h2>
				</div>
				<div id="bloc_donnees1">
					<h2>Informations G&#233;n&#233;rales</h2>
					<?php
					    echo 'Bienvenue '. $NOM_CONSULTANT." ".$PRENOM_CONSULTANT;
					?>
				</div>
				<div id="bloc_donnees2">
					<h2>Tableau des soldes</h2>
					<table id="background-image" class="styletab">
						<thead>
							<tr>
								<th></th>
								<th>CP n-1</th>
								<th>CP n</th>
								<th>RTT n-1</th>
								<th>RTT n</th>
							</tr>
						</thead>
						<tbody>
							<tr>
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
								<td>Acquis</td>
								<td><?php echo $ACQUIS_CPn1 ;?></td>
								<td><?php echo $ACQUIS_CPn ;?></td>
								<td><?php echo $ACQUIS_RTTn1 ;?></td>
								<td><?php echo $ACQUIS_RTTn ;?></td>
							</tr>
							<tr>
								<td>Pris</td>
								<td><?php echo $NBJRS_CPn1-$ACQUIS_CPn1 ;?></td>
								<td><?php echo $NBJRS_CPn-$ACQUIS_CPn ;?></td>
								<td><?php echo $NBJRS_RTTn1-$ACQUIS_RTTn1 ;?></td>
								<td><?php echo $NBJRS_RTTn-$ACQUIS_RTTn ;?></td>
							</tr>
							<tr>
							<?php 
							try
							{  
								$reponse1 = $bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_Solde) from solde where CONSULTANT_SOLDE = \''.$_SESSION['id'].'\') AND CONSULTANT_SOLDE =\''.$_SESSION['id'].'\'');  
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
								<td>Solde</td>
								<td><?php echo $NBJRS_CPn1 ;?></td>
								<td><?php echo $NBJRS_CPn ;?></td>
								<td><?php echo $NBJRS_RTTn1 ;?></td>
								<td><?php echo $NBJRS_RTTn ;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div id="pied_page">
			</div>
		</div>
	</body>
</html>
