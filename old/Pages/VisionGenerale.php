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
						<li class="menu-1-5" style="background-color:#FFF;"><a href="VisionGenerale.php" class="menu-1-5">Vision g&#233;n&#233;rale</a></li>
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
					<h2>Vision générale</h2>
					<p>Bievenue sur votre espace, <?php echo $PRENOM_CONSULTANT ;?> !</p>
				</div>
				<div id="entete_bloc_donnees">
					
				</div>
				<div id="entete_bloc_donnees">
					<table class="vg-table">
						<thead>
							<tr>
								<th style=" width: 140px;text-align:left;">Consultant</td>
								<th style=" width: 57px;text-align:left;">Janvier</td>
								<th style=" width: 57px;text-align:left;">Février</td>
								<th style=" width: 57px;text-align:left;">Mars</td>
								<th style=" width: 57px;text-align:left;">Avril</td>
								<th style=" width: 57px;text-align:left;">Mai</td>
								<th style=" width: 57px;text-align:left;">Juin</td>
								<th style=" width: 57px;text-align:left;">Juillet</td>
								<th style=" width: 57px;text-align:left;">Aout</td>
								<th style=" width: 57px;text-align:left;">Septembre</td>
								<th style=" width: 57px;text-align:left;">Octobre</td>
								<th style=" width: 57px;text-align:left;">Novembre</td>
								<th style=" width: 57px;text-align:left;">Décembre</td>
							</tr>
						</thead>
					</table>
					<div style="position:absolute;">
					<table class="vg-table">
						<tbody>
							<?php 
								try
								{  
									$reponse1 = $bdd->query('SELECT ID_CONSULTANT, PRENOM_CONSULTANT, NOM_CONSULTANT FROM consultant ORDER BY PRENOM_CONSULTANT');    
									while ($donnees1 = $reponse1->fetch())
									{
										$ID_CONSULTANT_Conges = $donnees1['ID_CONSULTANT'];
										echo '<tr><td style=" width: 200px;">'.$donnees1['PRENOM_CONSULTANT'].' '.$donnees1['NOM_CONSULTANT'].'</td>';
										$semaine_conges =array($ID_CONSULTANT_Conges);
										$semaine_conges_pasvalide =array($ID_CONSULTANT_Conges);								
										$reponse2 = $bdd->query('SELECT * FROM conges ORDER BY CONSULTANT_CONGES');  
										while ($donnees2 = $reponse2->fetch())
										{		
											//$nb_semaine = round($donnees2['NBJRS_CONGES']/5);
											//$nb_semaine = (strtotime($donnees2['DEBUT_CONGES'])->diff(strtotime($donnees2['FIN_CONGES'])))->days;
											$nb_semaine = Date('W',strtotime($donnees2['FIN_CONGES']).' + 1 DAY') - Date('W',strtotime($donnees2['DEBUT_CONGES']).' + 1 DAY') +1 ;
											$no_semaine = Date('W',strtotime($donnees2['DEBUT_CONGES']).' + 1 DAY');
											$consultant_conges = $donnees2['CONSULTANT_CONGES'];
											for ($i = 1;$i<= $nb_semaine; $i++){
												if($consultant_conges == $ID_CONSULTANT_Conges && $donnees2['STATUT_CONGES'] == "Validée"){	
													$semaine_conges[] = $no_semaine + $i -1;
												}	
											}
											for ($i = 1;$i<= $nb_semaine; $i++){
												if($consultant_conges == $ID_CONSULTANT_Conges && $donnees2['STATUT_CONGES'] != "Validée" && $donnees2['STATUT_CONGES'] != "Annulée" && $donnees2['STATUT_CONGES'] != "Annulée DM" && $donnees2['STATUT_CONGES'] != "Annulée Dir"){	
													$semaine_conges_pasvalide[] = $no_semaine + $i -1;
												}	
											}
										}
										for($j=1;$j<53;$j++){
											$champsPlein = "background: #FFF";
											$couleurtext = "color: #FFF";
											$no = "" ;
											for($k=1;$k<=max(count($semaine_conges),count($semaine_conges_pasvalide));$k++){
												if($j==$semaine_conges[$k]){
													$champsPlein = "background: #dd6";
													$couleurtext = "color: #4a5564";
													$no = $j ;
													break;	
												}
												elseif($j==$semaine_conges_pasvalide[$k]){
													$champsPlein = "background: #FFFACD";
													$couleurtext = "color:#4a5564";
													$no = $j ;
													break;	
												}
												else{
													$no = "00" ;
												}			
											}
										echo '<td style="border: 1px solid #000000;'.$champsPlein.';'.$couleurtext.';text-align:center;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px;border-radius:10px;">'.$no.'</td>';	
										}
										$reponse2->closeCursor();
									echo '<tr>';
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
			</div>
			<div id="pied_page">
				<p></p>
			</div>
		</div>
	</body>
</html>
