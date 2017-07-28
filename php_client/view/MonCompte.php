			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Type de compte : <?php echo $_SESSION['role']?></h2>
				</div>
				<div id="bloc_donnees1">
					<h2>Paramètres du compte</h2>
					<div class="form-style-3" style="border-bottom:1px solid #000;">
						<h3>Changer le Mot de passe</h2>
						<form action="?action=MonCompte" method="post">
							<label for="field0"><span>Ancien mot de passe <span class="required">*</span></span><input type="password" class="input-field" name="ancienMdP" value="" /></label>
							<label for="field1"><span>Nouveau <span class="required">*</span></span><input type="password" class="input-field" name="nouveauMdP" value="" /></label>
							<label for="field2"><span>Confirmer <span class="required">*</span></span><input type="password" class="input-field" name="confirmationMdP" value="" /></label>
							<label><input type="submit" value="Enregistrer" name="bouton_nouveauMdP" style="float:right;"/></label>
						</form>
					</div>
				</div>
				<div id="bloc_donnees1">
					<h2>Mise à jour du solde</h2>
					<form action="MonCompteSolde_post.php" method="post">
						<table id="background-image" class="styletab">
							<thead>
								<tr>
									<th></th>
									<th style="text-align:center;">CP n-1</th>
									<th style="text-align:center;">CP n</th>
									<th style="text-align:center;">RTT n-1</th>
									<th style="text-align:center;">RTT n</th>
								</tr>
							</thead>
							<tbody>
								<tr style="text-align:center;">
									<td style="text-align:left;">Acquis</td>
									<td><input type="text" value="<?php echo $ACQUIS_CPn1;?>" name="AcquisCPn1" id="AcquisCPn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_CPn;?>" name="AcquisCPn" id="AcquisCPn" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_RTTn1;?>" name="AcquisRTTn1" id="AcquisRTTn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $ACQUIS_RTTn;?>" name="AcquisRTTn" id="AcquisRTTn" style="width:60px;"/></td>
								</tr>
								<tr style="text-align:center;">
									<td style="text-align:left;">Solde</td>
									<td><input type="text" value="<?php echo $NBJRS_CPn1;?>" name="SoldeCPn1" id="SoldeCPn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_CPn;?>" name="SoldeCPn" id="SoldeCPn" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_RTTn1;?>" name="SoldeRTTn1" id="SoldeRTTn1" style="width:60px;"/></td>
									<td><input type="text" value="<?php echo $NBJRS_RTTn;?>" name="SoldeRTTn" id="SoldeRTTn"style="width:60px;"/></td>
								</tr>
							</tbody>
						</table>
						<p style="float:right"><input type="submit" value="Enregistrer" name="bouton_soldes"/></p>	
					</form>
				</div>
			</div>
