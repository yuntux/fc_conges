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
						<li class="menu-1-3"><a href="Historiques.php" class="menu-1-3">Historiques</a></li>
						<li class="menu-1-4" style="background-color:#FFF;"><a href="Validation.php" class="menu-1-4">Validation</a></li>
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
						$PROFIL_CONSULTANT = $donnees1['PROFIL_CONSULTANT'];
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
					<h2>Validation des demandes</h2>
					<p>Bievenue sur votre espace, <?php echo $PRENOM_CONSULTANT ;?> !</p>
				</div>
				<div id="entete_bloc_donnees">
					<?php 
						if($PROFIL_CONSULTANT == "DIRECTEUR"){
							include("Includes/ValidationDir.php");
						}
						if($PROFIL_CONSULTANT == "DIRECTEUR"  || $PROFIL_CONSULTANT == "DM" ){
							include("Includes/ValidationDM.php");
							include("Includes/ValidationHistorique.php");
						}
						if($PROFIL_CONSULTANT == "CONSULTANT"){
							echo "<p>Rien à valider</p>";
						}
					?>	
				</div>
			</div>
			<div id="pied_page">
			</div>
		</div>
	</body>
</html>
