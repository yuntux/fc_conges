			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Vision générale</h2>
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
									foreach ($reponse1 as $donnees1)
									{
										$ID_CONSULTANT_Conges = $donnees1['ID_CONSULTANT'];
										echo '<tr><td style=" width: 200px;">'.$donnees1['PRENOM_CONSULTANT'].' '.$donnees1['NOM_CONSULTANT'].'</td>';
										$semaine_conges =array($ID_CONSULTANT_Conges);
										$semaine_conges_pasvalide =array($ID_CONSULTANT_Conges);								
										foreach ($reponse2 as $donnees2)
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
										for($j=1;$j<53;$j++)
										{
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
									echo '<tr>';
									}
							?>
						</tbody>
					</table>
					</div>
				</div>
