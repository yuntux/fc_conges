<h2>Validation Direction</h2>
<table id="background-image" class="styletab">
	<thead>
		<tr>
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
				while ($donnees1 = $conges_validation_direction->fetch())
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
                                                <td><?php echo $donnees1['DATEDEM_CONGES']; ?></td>
                                                <td><?php echo $donnees1['NOM_CONSULTANT']; ?> <?php echo $donnees1['PRENOM_CONSULTANT']; ?></td>
                                                <td><?php echo $donnees1['DEBUT_CONGES']; ?> <?php echo $donnees1['DEBUTMM_CONGES']; ?></td>
                                                <td><?php echo $donnees1['FIN_CONGES']; ?> <?php echo $donnees1['FINMS_CONGES']; ?></td>
                                                <td><?php echo $type; ?></td>
                                                <td><?php echo $donnees1['COMMENTAIRE']; ?></td>
                                                <td>
                                                        <?php if($donnees1['STATUT_CONGES'] == "En cours de validation Direction" && $_SESSION['role'] == "DIRECTEUR"){
                                                                        echo '<form action="?action=Validation" method="post">';
                                                                        echo '<input type="submit" value="Valider"/>';
                                                                        echo '<input type="hidden" name="validation_direction" value="'.$donnees1['ID_CONGES'].'"/>';
                                                                        echo '</form>';
                                                                } else {
                                                                        echo "" ;}
                                                         ?>
                                                </td>
                                                <td>
                                                        <?php if($donnees1['STATUT_CONGES'] == "En cours de validation Direction" && $_SESSION['role'] == "DIRECTEUR"){
                                                                        echo '<form action="?action=Validation" method="post">';
                                                                        echo '<input type="submit" value="Refuser"/>';
                                                                        echo '<input type="hidden" name="refus_direction" value="'.$donnees1['ID_CONGES'].'"/>';
                                                                        echo '</form>';
                                                                } else {
                                                                        echo "" ;}
                                                         ?>
                                                </td>
                                        </tr>
				<?php
				}
		?>
	</tbody>
</table>
