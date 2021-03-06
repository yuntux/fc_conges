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
					<th>Consultant</th>
					<th>Début</th>
					<th>Fin</th>
					<th>Nombre de jours</th>
					<th>Commentaire</th>
					<th>Statut</th>
					<th>Directeur de mission (validation niveau 1)</th>
					<th>Valider</th>
					<th>Refuser</th>
				</tr>
			</thead>
			<tbody>
				<?php 
						foreach ($conges_validation as $donnees1)
						{
							$cp = $donnees1['demande.CP_CONGES'];
							$rtt = $donnees1['demande.RTT_CONGES'];
							$ss = $donnees1['demande.SS_CONGES'];
							$conv = $donnees1['demande.CONV_CONGES'];
							$autres = $donnees1['demande.AUTRE_CONGES'];
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
								<td><?php echo $donnees1['demande.ID_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.DATEDEM_CONGES']); ?></td>
								<td><?php echo $donnees1['consultant.PRENOM_CONSULTANT']." ".$donnees1['consultant.NOM_CONSULTANT']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.DEBUT_CONGES']); ?> <?php echo $donnees1['demande.DEBUTMM_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.FIN_CONGES']); ?> <?php echo $donnees1['demande.FINMS_CONGES']; ?></td>
								<td><?php echo $type; ?></td>
								<td><?php echo $donnees1['demande.COMMENTAIRE']; ?></td>
								<td><?php echo $donnees1['demande.STATUT_CONGES']; ?></td>
								<td><?php echo $donnees1['dm.PRENOM_CONSULTANT'].' '.$donnees1['dm.NOM_CONSULTANT']; ?></td>
								<td>
									<?php 
										if (($donnees1['demande.VALIDEUR_CONGES']==$_SESSION['id']) || ($donnees1['demande.STATUT_CONGES']=="En cours de validation Direction" && $_SESSION['role']=="DIRECTEUR")){
											echo '<form action="?action=Validation" method="post">';
											echo '<input type="submit" value="Valider"/>';
											echo '<input type="hidden" name="validation" value="'.$donnees1['demande.ID_CONGES'].'"/>';
											echo '</form>';
										}
									 ?>
								</td>

								<td>
									<?php
										if (($donnees1['demande.VALIDEUR_CONGES']==$_SESSION['id']) || ($_SESSION['role']=="DIRECTEUR" && ($donnees1['demande.STATUT_CONGES']=="En cours de validation Direction" || $donnees1['demande.STATUT_CONGES']=="Validée"))){
											echo '<form action="?action=Validation" method="post">';
											echo '<input type="submit" value="Refuser"/>';
											echo '<input type="hidden" name="refus" value="'.$donnees1['demande.ID_CONGES'].'"/>';
											echo '</form>';
										}
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
					<th>Consultant</th>
					<th>Début</th>
					<th>Fin</th>
					<th>Nombre de jours</th>
					<th>Commentaire</th>
					<th>Statut</th>
					<th>Directeur de mission (validation niveau 1)</th>
					<th>Annulation</th>
				</tr>
			</thead>
			<tbody>
				<form action="?action=Validation" method="post">
				<?php 
						foreach ($historique as $donnees1)
						{
							$cp = $donnees1['demande.CP_CONGES'];
							$rtt = $donnees1['demande.RTT_CONGES'];
							$ss = $donnees1['demande.SS_CONGES'];
							$conv = $donnees1['demande.CONV_CONGES'];
							$autres = $donnees1['demande.AUTRE_CONGES'];
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
								<td><?php echo $donnees1['demande.ID_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.DATEDEM_CONGES']); ?></td>
								<td><?php echo $donnees1['consultant.PRENOM_CONSULTANT']; ?> <?php echo $donnees1['consultant.NOM_CONSULTANT']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.DEBUT_CONGES']); ?> <?php echo $donnees1['demande.DEBUTMM_CONGES']; ?></td>
								<td><?php echo get_date_french_str($donnees1['demande.FIN_CONGES']); ?> <?php echo $donnees1['demande.FINMS_CONGES']; ?></td>
								<td><?php echo $type; ?></td>
								<td><?php echo $donnees1['demande.COMMENTAIRE']; ?></td>
								<td><?php echo $donnees1['demande.STATUT_CONGES']; ?></td>
								<td><?php echo $donnees1['dm.PRENOM_CONSULTANT'].' '.$donnees1['dm.NOM_CONSULTANT']; ?></td>

								<td>
									<?php
										if ($_SESSION['role']=="DIRECTEUR" && $donnees1['demande.STATUT_CONGES']=="Validée")
										{
											echo '<form action="?action=Validation" method="post">';
											echo '<input type="submit" value="Annuler a posteriori"/>';
											echo '<input type="hidden" name="refus" value="'.$donnees1['demande.ID_CONGES'].'"/>';
											echo '</form>';
										}
									 ?>
								</td>
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
