<h2>Vision générale</h2>
	<table style="font-size:10px;">
		<tr  style=" width: 620px;">
			<td style=" width: 100px;text-align:left;">Consultant</td>
			<td>
				<table style="margin-top: 2px;margin-bottom:2px;font-size:10px;table-layout: fixed;"><tr>
					<td style="text-align:center;">Janvier</td>
					<td style="text-align:center;">Février</td>
					<td style="text-align:center;">Mars</td>
					<td style="text-align:center;">Avril</td>
					<td style="text-align:center;">Mai</td>
					<td style="text-align:center;">Juin</td>
					<td style="text-align:center;">Juillet</td>
					<td style="text-align:center;">Aout</td>
					<td style="text-align:center;">Septembre</td>
					<td style="text-align:center;">Octobre</td>
					<td style="text-align:center;">Novembre</td>
					<td style="text-align:center;">Décembre</td>
				</tr></table>
			</td>
		</tr>

		<?php 
		foreach ($reponse1 as $donnees1)
		{
			$ID_CONSULTANT_Conges = $donnees1['ID_CONSULTANT'];
			echo '<tr style=" width: 620px;"><td style=" width: 100px;">'.$donnees1['PRENOM_CONSULTANT'].' '.$donnees1['NOM_CONSULTANT'].'</td>';
			$semaine_conges =array($ID_CONSULTANT_Conges);
			$semaine_conges_pasvalide =array($ID_CONSULTANT_Conges);								
				echo '<td colspan=12>';
					echo '<table style="margin-top: 2px;margin-bottom:2px;font-size:10px;table-layout: fixed;"><tr>';


			foreach ($reponse2 as $donnees2)
			{		
				$nb_semaine = Date('W',strtotime($donnees2['FIN_CONGES']).' + 1 DAY') - Date('W',strtotime($donnees2['DEBUT_CONGES']).' + 1 DAY') +1 ;
				$no_semaine = Date('W',strtotime($donnees2['DEBUT_CONGES']).' + 1 DAY');
				$consultant_conges = $donnees2['CONSULTANT_CONGES'];
				for ($i = 1;$i<= $nb_semaine; $i++){
					if($consultant_conges == $ID_CONSULTANT_Conges && $donnees2['STATUT_CONGES'] == "Validée"){	
						$semaine_conges[] = $no_semaine + $i -1;
					}	
				}
				for ($i = 1;$i<= $nb_semaine; $i++){
					if($consultant_conges == $ID_CONSULTANT_Conges && $donnees2['STATUT_CONGES'] != "Validée" && $donnees2['STATUT_CONGES'] != "Annulée" && $donnees2['STATUT_CONGES'] != "Annulée DM" && $donnees2['STATUT_CONGES'] != "Annulée Dir" && $donnees2['STATUT_CONGES'] != "Annulée DM"){	
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
						$no = "0" ;
					}			
				}
			echo '<td  style="width:10px;height=10px;border: 1px solid #000000;'.$champsPlein.';'.$couleurtext.';text-align:center;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px;border-radius:10px;">'.$no.'</td>';	
			}

					echo '</tr></table>';
				echo '</td>';
			echo '</tr>';
		}
			?>
	</table>
