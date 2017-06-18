			<div id="bloc_donnees">
				<?php 
				try
				{  
					while ($donnees1 = $consultant->fetch())
					{
						$NOM_CONSULTANT = $donnees1['NOM_CONSULTANT']; 
						$PRENOM_CONSULTANT = $donnees1['PRENOM_CONSULTANT'];
						$TRIGRAMME_CONSULTANT = $donnees1['TRIGRAMME_CONSULTANT'];
					}
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
								while ($donnees1 = $acquis->fetch())
								{
									$ACQUIS_RTTn1 = $donnees1['RTTn1_ACQUIS']; 
									$ACQUIS_RTTn = $donnees1['RTTn_ACQUIS'];
									$ACQUIS_CPn1 = $donnees1['CPn1_ACQUIS'];
									$ACQUIS_CPn = $donnees1['CPn_ACQUIS'];
								}
							}
							catch(Exception $e)
							{
								die('Erreur : '.$e->getMessage());
							}
							?>
							<?php 
							try
							{  
								while ($donnees1 = $soldes->fetch())
								{
									$NBJRS_RTTn1 = $donnees1['RTTn1_SOLDE']; 
									$NBJRS_RTTn = $donnees1['RTTn_SOLDE'];
									$NBJRS_CPn1 = $donnees1['CPn1_SOLDE'];
									$NBJRS_CPn = $donnees1['CPn_SOLDE'];
								}
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
								while ($donnees1 = $soldes->fetch())
								{
									$NBJRS_RTTn1 = $donnees1['RTTn1_SOLDE']; 
									$NBJRS_RTTn = $donnees1['RTTn_SOLDE'];
									$NBJRS_CPn1 = $donnees1['CPn1_SOLDE'];
									$NBJRS_CPn = $donnees1['CPn_SOLDE'];
								}
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
