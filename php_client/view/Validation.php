<div id="bloc_donnees">
		<div id="entete_bloc_donnees">
			<h2>Validation des demandes</h2>
		</div>

		<h2>Demandes en cours</h2>
		<table id="background-image" class="styletab">
			<thead>
				<tr>
					<th>Numéro</th>
					<th>Date de la demande</th>
					<th>Consultants</th>
					<th>Début</th>
					<th>Fin</th>
					<th>Nombre de jour</th>
					<th>Commentaire</th>
					<th>Valider</th>
					<th>Refuser</th>
				</tr>
			</thead>
			<tbody>
				<?php 
						foreach ($conges_validation as $donnees1)
						{
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
								<td><?php echo $donnees1['ID_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['DATEDEM_CONGES']); ?></td>
								<td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
								<td><?php echo get_date_french_str($donnees1['DEBUT_CONGES']); ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['FIN_CONGES']); ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
								<td><?php echo $type; ?></td>
								<td><?php echo $donnees1['COMMENTAIRE']; ?></td>
								<td>
									<?php 
											echo '<form action="?action=Validation" method="post">';
											echo '<input type="submit" value="Valider"/>';
											echo '<input type="hidden" name="validation" value="'.$donnees1['ID_CONGES'].'"/>';
											echo '</form>';
									 ?>
								</td>
								<td>
									<?php
											echo '<form action="?action=Validation" method="post">';
											echo '<input type="submit" value="Refuser"/>';
											echo '<input type="hidden" name="refus" value="'.$donnees1['ID_CONGES'].'"/>';
											echo '</form>';
									 ?>
								</td>
							</tr>
						<?php
						}
				?>
			</tbody>
		</table>


		<h2>Historiques des validations</h2>
		<table id="background-image" class="styletab">
			<thead>
				<tr>
					<th>Numéro</th>
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
				<form action="?action=Validation" method="post">
				<?php 
						foreach ($historique as $donnees1)
						{
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
								<td><?php echo $donnees1['ID_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['DATEDEM_CONGES']); ?></td>
								<td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
								<td><?php echo get_date_french_str($donnees1['DEBUT_CONGES']); ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['FIN_CONGES']); ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
								<td><?php echo $type; ?></td>
								<td><?php echo $donnees1['COMMENTAIRE']; ?></td>
								<td><?php echo $donnees1['STATUT_CONGES']; ?></td>
							</tr>
						<?php
						}
				?>
				</form>
			</tbody>
			<tfoot>
			</tbody>
		</table>

</div>
