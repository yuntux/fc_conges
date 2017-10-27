			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Dashboard</h2>
				</div>
				<div id="bloc_donnees1">
					<?php
					    echo 'Bienvenue '. $_SESSION['prenom']." ".$_SESSION['nom'];
					?>	
					<br><br>
					<h2>Tableau des soldes</h2>
					Ces soldes sont le reflet d'une estimation limitée et donnés à titre indicatif. <b>Vos soldes réels ne sont disponibles que sur vos bulletins de paie, avec un mois de décalage.</b>
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
								<td>Acquis</td>
								<td><?php echo $ACQUIS['CPn1_ACQUIS'] ;?></td>
								<td><?php echo $ACQUIS['CPn_ACQUIS'] ;?></td>
								<td><?php echo $ACQUIS['RTTn1_ACQUIS'] ;?></td>
								<td><?php echo $ACQUIS['RTTn_ACQUIS'] ;?></td>
							</tr>
							<tr>
								<td>Pris</td>
								<td><?php echo $SOLDE['CPn1_SOLDE']-$ACQUIS['CPn1_ACQUIS'] ;?></td>
								<td><?php echo $SOLDE['CPn_SOLDE']-$ACQUIS['CPn_ACQUIS'] ;?></td>
								<td><?php echo $SOLDE['RTTn1_SOLDE']-$ACQUIS['RTTn1_ACQUIS'] ;?></td>
								<td><?php echo $SOLDE['RTTn_SOLDE']-$ACQUIS['RTTn_ACQUIS'] ;?></td>
							</tr>
							<tr>
								<td>Solde</td>
								<td><?php echo $SOLDE['CPn1_SOLDE'] ;?></td>
								<td><?php echo $SOLDE['CPn_SOLDE'] ;?></td>
								<td><?php echo $SOLDE['RTTn1_SOLDE'] ;?></td>
								<td><?php echo $SOLDE['RTTn_SOLDE'] ;?></td>
							</tr>
						</tbody>
					</table>
			</div>
