                        <div id="bloc_donnees">
                                <div id="entete_bloc_donnees">
                                        <h2>Éditions</h2>
                                </div>
                                <div id="bloc_donnees1" style="width: 100%">
					<h2>Fiches récapitulatives individuelles</h2>
						<form action="?action=editions" method="post">
							Date de début : <input type="date" name="debut_periode" value="<?php echo $first_day_month ?>">
							<br>Date de fin : <input type="date" name="fin_periode" value="<?php echo $last_day_month ?>">
							<br><input type="submit" value="Générer PDF" name="bouton_recap_individuel"/>
						</form>
				</div>
			</div>
