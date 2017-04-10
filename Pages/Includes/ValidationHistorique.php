<h2>Historiques des validations</h2>
<table id="background-image" class="styletab">
	<thead>
		<tr>
			<th>Date de la demande</th>
			<th>Consultants</th>
			<th>Début</th>
			<th>Fin</th>
			<th>Nombre de jour</th>
			<th>Commentaire</th>
			<th>Statut</th>
		</tr>
	</thead>
	<tbody>
		<form action="ValidationDir_post.php" method="post">
		<?php 
			try
			{
				$reponse1 = $bdd->query('SELECT * FROM conges a, consultant c WHERE c.ID_CONSULTANT = a.CONSULTANT_CONGES and (a.STATUT_CONGES = "Validée" or a.STATUT_CONGES = "Annulée Direction" or a.STATUT_CONGES = "Annulée DM")');  
				while ($donnees1 = $reponse1->fetch())
				{
				?>
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
					<tr>
						<td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
						<td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
						<td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
						<td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
						<td><?php echo $type; ?></td>
						<td><?php echo $donnees1['COMMENTAIRE']; ?></td>
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
		</form>
	</tbody>
	<tfoot>
	</tbody>
</table>
