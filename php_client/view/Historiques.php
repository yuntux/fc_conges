			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Historique des demandes de <?php echo $detail_consultant['PRENOM_CONSULTANT']." ".$detail_consultant['NOM_CONSULTANT'];?></h2>
					<?php
					if($_SESSION['role'] == "DIRECTEUR"){
						echo "<form action='?action=Historiques' method='post'>";
						echo "<select name='id_consultant' onchange='this.form.submit()'>";
						echo "<option>Sélectionner un consultant</option>";
						foreach ($liste as $consultant)
						{
							echo "<option value=\"".$consultant['ID_CONSULTANT']."\" ";
                                                        if (isset($_POST['id_consultant']) && $_POST['id_consultant'] == $consultant['ID_CONSULTANT'])
                                                        	echo " selected";
                                                        echo ">".$consultant['PRENOM_CONSULTANT']." ".$consultant['NOM_CONSULTANT']."</option>";
						}
						echo "</select>";
					}
					?>
				</div>
				<div id="entete_bloc_donnees">
					<h2>Demandes en cours</h2>
					<table id="background-image" class="styletab">
						<thead>
							<tr>
								<th>N° demande</th>
								<th>Date de la demande</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Nombre de jour</th>
								<th>Jours posés</th>
								<th>Statut</th>
								<th>Directeur de mission (validation niveau 1)</th>
								<th>Annuler</th>
							</tr>
						</thead>
						<tbody>
			<?php 
					foreach ($reponse1 as $donnees1)
					{
					?>
						<tr>
							<td><?php echo $donnees1['demande.ID_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.DATEDEM_CONGES']); ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.DEBUT_CONGES']); ?> <?php echo $donnees1['demande.DEBUTMM_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.FIN_CONGES']); ?> <?php echo $donnees1['demande.FINMS_CONGES']; ?></td>
							<td><?php echo $donnees1['demande.NBJRS_CONGES']." jour(s)"; ?></td>
							<?php
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
							<td><?php echo $type; ?></td>
							<td><?php echo $donnees1['demande.STATUT_CONGES']; ?></td>
							<td><?php echo $donnees1['dm.PRENOM_CONSULTANT'].' '.$donnees1['dm.NOM_CONSULTANT']; ?></td>
							<td>
								<form action="?action=Historiques" method="post">
									<?php 
									if ($detail_consultant['ID_CONSULTANT'] == $_SESSION['id']) {
										if($donnees1['demande.STATUT_CONGES'] == "En cours de validation DM" || $donnees1['demande.STATUT_CONGES'] == "Attente envoie"){
											echo '<input type="submit" value="Annuler" name="cancel" />' ;
											echo '<input type="hidden" name="id_conges" value="'.$donnees1['demande.ID_CONGES'].'" />' ;
										}
									}
								 	?>
								</form>
							</td>
						</tr>
					<?php
					}
				?>
						</tbody>
					</table>
					<h2>Historique</h2>
					<table id="background-image" class="styletab">
						<thead>
							<tr>
								<th>N° demande</th>
								<th>Date de la demande</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Nombre de jour</th>
								<th>Jours posés</th>
								<th>Statut</th>
								<th>Directeur de mission (validation niveau 1)</th>
							</tr>
						</thead>
						<tbody>
										<?php 
					foreach ($reponse2 as $donnees1)
					{
					?>
						<tr>
							<td><?php echo $donnees1['demande.ID_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.DATEDEM_CONGES']); ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.DEBUT_CONGES']); ?> <?php echo $donnees1['demande.DEBUTMM_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['demande.FIN_CONGES']); ?> <?php echo $donnees1['demande.FINMS_CONGES']; ?></td>
							<td><?php echo $donnees1['demande.NBJRS_CONGES']." jour(s)"; ?></td>
							<?php
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
							<td><?php echo $type; ?></td>
							<td><?php echo $donnees1['demande.STATUT_CONGES']; ?></td>
							<td><?php echo $donnees1['dm.PRENOM_CONSULTANT'].' '.$donnees1['dm.NOM_CONSULTANT']; ?></td>
						</tr>
					<?php
					}
				?>
						</tbody>
					</table>				
				</div>
