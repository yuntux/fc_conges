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
								<th>Date de la demande</th>
								<th>Début</th>
								<th>Fin</th>
								<th>Nombre de jour</th>
								<th>Jours posés</th>
								<th>Statut</th>
								<th>Valideur</th>
								<th>Annuler</th>
							</tr>
						</thead>
						<tbody>
			<?php 
					foreach ($reponse1 as $donnees1)
					{
					?>
						<tr>
							<td><?php echo get_date_french_str($donnees1['DATEDEM_CONGES']); ?></td>
							<td><?php echo get_date_french_str($donnees1['DEBUT_CONGES']); ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['FIN_CONGES']); ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
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
							<td><?php echo $donnees1[27].' '.$donnees1[26]; ?></td>
							<td>
								<form action="?action=Historiques" method="post">
									<?php 
									if ($detail_consultant['ID_CONSULTANT'] == $_SESSION['id']) {
										if($donnees1['STATUT_CONGES'] == "En cours de validation DM" || $donnees1['STATUT_CONGES'] == "Attente envoie"){
											echo '<input type="submit" value="Annuler" name="cancel" />' ;
											echo '<input type="hidden" name="id_conges" value="'.$donnees1['ID_CONGES'].'" />' ;
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
					foreach ($reponse2 as $donnees1)
					{
					?>
						<tr>
							<td><?php echo get_date_french_str($donnees1['DATEDEM_CONGES']); ?></td>
							<td><?php echo get_date_french_str($donnees1['DEBUT_CONGES']); ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
							<td><?php echo get_date_french_str($donnees1['FIN_CONGES']); ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
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
							<td><?php echo $donnees1[27].' '.$donnees1[26]; ?></td>
						</tr>
					<?php
					}
				?>
						</tbody>
					</table>				
				</div>
