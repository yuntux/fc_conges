			<div id="bloc_donnees">
				<div id="entete_bloc_donnees">
					<h2>Demande de congés</h2>
				</div>
				<form action="?action=DemandeConges" id="DemandeConges_post" method="post">
				<div id="bloc_donnees1" style="padding-right:50px;">
					<h2>Nouvelle demande</h2>
<?php
function return_isset($post_name){
	if (isset($_POST[$post_name]))
		return $_POST[$post_name];
	else 
		return "";
}
?>
					<p style="width:90%;margin-bottom:20px;"><label for="du">Du : </label><input type="date" name="dateFromDu" id ="dateFromDu" onchange="nombre_jours_a_poser()" value="<?php echo return_isset('dateFromDu'); ?>" />
					<select name="thelistMM" id ="thelistMM" onchange="nombre_jours_a_poser()">
						<option<?php if (return_isset('thelistMM')=='Matin') echo ' selected';?>>Matin</option>
						<option<?php if (return_isset('thelistMM')=='Midi') echo ' selected';?>>Midi</option>
					</select></p>
					<p style="margin-bottom:20px;"><label for="du">Au :  </label><input type="date" name="dateFromAu" id ="dateFromAu" onchange="nombre_jours_a_poser()" value="<?php echo return_isset('dateFromAu'); ?>" />
					<select name="thelistMS" id ="thelistMS" onchange="nombre_jours_a_poser()">
						<option<?php if (return_isset('thelistMS')=='Soir') echo ' selected';?>>Soir</option>						  
						<option<?php if (return_isset('thelistMS')=='Midi') echo ' selected';?>>Midi</option>						  
					</select></p>
					<b>Attention : contrairement à  l'ancien système, indiquer ici le dernier jour de congès et non pas le jour de la reprise.</b>
					<br>Nombre de jours de repos à répartir (par multiple de 0.5 jours) : <div style="display: inline-block;" id="nbJrs"><?php if (return_isset('nbJrs_hidden') != "") echo return_isset('nbJrs_hidden'); else echo "0";?></div><br>
					<input type="hidden" name="nbJrs_hidden" id="nbJrs_hidden" value="<?php if (return_isset('nbJrs_hidden') != "") echo return_isset('nbJrs_hidden'); else echo "0";?>"/>
<br>

					<table class="reinitialise" style="text-align:center;width:80%;font-size: 10px;">
						<tr style="text-align:center;width:80%;">
							<td style="width:20%;">Jours de Congés Payés</td>
							<td style="width:20%;">Jours de Repos (RTT)</td>
							<td style="width:20%;">Jours conventionnels</td>
							<td style="width:20%;">Jours de Congés sans solde</td>
							<td style="width:20%;">Jours Autres</td>
						</tr>
						<tr>
							<td><input type="text" name="nbjrsCP" id="nbjrsCP" onkeyup="this.value=this.value.replace(',','\.');" style="width:50%;" value="<?php echo return_isset('nbjrsCP');?>"/></td>
							<td><input type="text" name="nbjrsRTT" id="nbjrsRTT" onkeyup="this.value=this.value.replace(',','\.');" style="width:50%;" value="<?php echo return_isset('nbjrsRTT');?>"/></td>
							<td><input type="text" name="nbjrsConv" id="nbjrsConv" onkeyup="this.value=this.value.replace(',','\.');" style="width:50%;" value="<?php echo return_isset('nbjrsConv');?>"/></td>
							<td><input type="text" name="nbjrsSS" id="nbjrsSS" onkeyup="this.value=this.value.replace(',','\.');" style="width:50%;" value="<?php echo return_isset('nbjrsSS');?>"/></td>
							<td><input type="text" name="nbjrsAutres"  id="nbjrsAutres" onkeyup="this.value=this.value.replace(',','\.');" style="width:50%;" value="<?php echo return_isset('nbjrsAutres');?>"/></td>
						</tr>
					</table>

<br>
<br>
<br>
					<p style="width:90%;margin-bottom:20px;"><label for="au" style="margin-right:38px";>Directeur de mission : </label>
					<select name="thelistDM">
						<?php 
						try
						{  
							foreach ($reponse1 as $donnees1)
							{
								//TODO : cacher ce IF que je ne saurais voir
							//	if ($donnees1['NOM_CONSULTANT'] != "ADMIN"){
									echo "<option value=\"".$donnees1['ID_CONSULTANT']."\" ";
									if (return_isset('thelistDM') == $donnees1['ID_CONSULTANT'])
										echo " selected";
									echo">".$donnees1['PRENOM_CONSULTANT']." ".$donnees1['NOM_CONSULTANT']."</option>";
							//	}
							}
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
						?>
					</select></p>

					<p style="margin-top: 50px;">Commentaire</p>
					<p><textarea name="commentaire" id="commentaire" style="width: 100%;height:50px;"><?php echo return_isset('commentaire');?></textarea>
					<p style="float:right">
						<input type="submit" value="Valider" name="Envoyer" style=""/>
					</p>	
				</div>
		</div>
	<script >



function nombre_jours_a_poser(){
	var d1 = document.getElementById("dateFromDu").value;
	var d2 = document.getElementById("dateFromAu").value;
	var demidebut = document.getElementById("thelistMM").value;
	var demifin = document.getElementById("thelistMS").value;

	var date1 = new Date(parseInt(d1.substring(0,4),10),parseInt(d1.substring(5,7),10)-1,parseInt(d1.substring(8,10),10));
	var date2 = new Date(parseInt(d2.substring(0,4),10),parseInt(d2.substring(5,7),10)-1,parseInt(d2.substring(8,10),10));

	if(date1>date2){	
		document.getElementById('nbJrs_hidden').value=0; 
		alert("La date de fin ne peut être antérieure à la date de début.");
		document.getElementById("dateFromAu").value = document.getElementById("dateFromDu").value;
		date2 = date1;
		d2 = d1;
	}
	
	if (d1!="" && d2==""){
		document.getElementById("dateFromAu").value = document.getElementById("dateFromDu").value;
		date2 = date1;
		d2 = d1;
	}

	var req = new XMLHttpRequest();
	var url =  "<?php echo $REST_CLIENT->get_url_auth("nbJoursAPoser","helpers");?>";
	var args = Array(d1,d2,demidebut,demifin);
	url=url+"&args_array="+encodeURI(btoa(JSON.stringify(args)));
	//alert(url);
	req.open("GET",url,true);
	req.onreadystatechange = function () {
		if (req.status==200){
			var diffj = req.responseText;
			//diffj = JSON.parse(diffj);
			//alert(diffj);
			document.getElementById('nbJrs').innerHTML = diffj;
			document.getElementById('nbJrs_hidden').value = diffj;
		}
	}
	req.send(null);
}

	</script>
	</body>
</html>
