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
			<h2>Demande en cours</h2>
			
			<table class="rwd-table">
				<thead>
					<tr>
						<th style=" width: 16%;">Consultant</td>
						<th colspan="9" style=" width: 7%;">Janvier</td>
						<th colspan="8" style=" width: 7%;">Février</td>
						<th colspan="8" style=" width: 7%;">Mars</td>
						<th colspan="9" style=" width: 7%;">Avril</td>
						<th colspan="9" style=" width: 7%;">Mai</td>
						<th colspan="8" style=" width: 7%;">Juin</td>
						<th colspan="10" style=" width: 7%;">Juillet</td>
						<th colspan="8" style=" width: 7%;">Aout</td>
						<th colspan="9" style=" width: 7%;">Septembre</td>
						<th colspan="10" style=" width: 7%;">Octobre</td>
						<th colspan="8" style=" width: 7%;">Novembre</td>
						<th colspan="10" style=" width: 7%;">Décembre</td>
					</tr>
					<tr>
						<td style=" width: 16%;"></td>
						<?php for($i=1;$i<54;$i++){
							echo '<td colspan="2" style="border: 1px solid #000000;background: #646f7f;color:#fff;text-align:center; ">'.$i.'</td>';
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
						try
						{  
							$reponse1 = $bdd->query('SELECT ID_CONSULTANT, PRENOM_CONSULTANT, NOM_CONSULTANT FROM consultant ORDER BY PRENOM_CONSULTANT');    
							//$reponse2 = $bdd->query('SELECT * FROM conges WHERE STATUT_CONGES = "Validée" ORDER BY CONSULTANT_CONGES');  
							while ($donnees1 = $reponse1->fetch())
							{
								$ID_CONSULTANT_Conges = $donnees1['ID_CONSULTANT'];
								echo '<tr><td style=" width: 16%;">'.$donnees1['PRENOM_CONSULTANT'].' '.$donnees1['NOM_CONSULTANT'].'</td>';
								$semaine_conges =array($ID_CONSULTANT_Conges);
								$reponse2 = $bdd->query('SELECT * FROM conges WHERE STATUT_CONGES = "Validée" ORDER BY CONSULTANT_CONGES');  
								while ($donnees2 = $reponse2->fetch())
								{		
									$nb_semaine = round($donnees2['NBJRS_CONGES']/5);
									$no_semaine = Date('W',strtotime($donnees2['DEBUT_CONGES']));
									$consultant_conges = $donnees2['CONSULTANT_CONGES'];
									for ($i = 1;$i<= $nb_semaine; $i++){
										if($consultant_conges == $ID_CONSULTANT_Conges){	
											$semaine_conges[] = $no_semaine + $i -1;
										}	
									}
								}
								for($j=1;$j<54;$j++){
									$champsPlein = "background: #FFF";
									$no = "" ;
									for($k=1;$k<10;$k++){
										if($j==$semaine_conges[$k]){
											$champsPlein = "background: #dd5";
											$no = $j ;
											break;	
										}	
									}
								echo '<td colspan="2" style="border: 1px solid #000000;'.$champsPlein.';color:#fff;text-align:center; ">'.$no.'</td>';	
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
				<tfoot>
				</tfoot>
			</table>
		</div>
	</body>
</html>
