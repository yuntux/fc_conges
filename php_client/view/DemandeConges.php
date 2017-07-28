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
					<p style="width:90%;margin-bottom:20px;"><label for="du">Du : </label><input type="text" class="widget_calendar" name="dateFromDu" id ="dateFromDu" onchange="ok()" value="<?php return_isset('dateFromDu') ?>" />
					<select name="thelistMM" id ="thelistMM" onchange="ok()">
						<option<?php if (return_isset('thelistMM')=='Matin') echo 'selected';?>>Matin</option>
						<option<?php if (return_isset('thelistMM')=='Midi') echo 'selected';?>>Midi</option>
					</select></p>
					<p style="margin-bottom:20px;"><label for="du">Au :  </label><input type="text" class="widget_calendar" name="dateFromAu" id ="dateFromAu" onchange="ok()" value="<?php return_isset('dateFromAu') ?>" />
					<select name="thelistMS" id ="thelistMS" onchange="ok()">
						<option<?php if (return_isset('thelistMS')=='Soir') echo 'selected';?>>Soir</option>						  
						<option<?php if (return_isset('thelistMS')=='Midi') echo 'selected';?>>Midi</option>						  
					</select></p>
					<b>Attention : contrairement à  l'ancien système, indiquer ici le dernier jour de congès et non pas le jour de la reprise.</b>
					<p id="nbJrs"></p><input type="hidden" name="nbJrs_hidden" id="nbJrs_hidden" value="<?php return_isset('nbJrs_hidden');?>"/>
					<p style="width:90%;margin-bottom:20px;"><label for="au" style="margin-right:38px";>Directeur de mission : </label>
					<select name="thelistDM">
						<?php 
						try
						{  
							foreach ($reponse1 as $donnees1)
							{
								echo "<option";
								if ($thelistDM == $donnees1['TRIGRAMME_CONSULTANT'])
									echo " selected";
								echo">".$donnees1['PRENOM_CONSULTANT']." ".$donnees1['NOM_CONSULTANT']."</option>";
							}
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
						?>
					</select></p>
					<table class="reinitialise" style="text-align:center;width:80%;font-size: 10px;">
						<tr style="text-align:center;width:80%;">
							<td style="width:20%;">Jours de Congés Payés</td>
							<td style="width:20%;">Jours de Repos (RTT)</td>
							<td style="width:20%;">Jours conventionnels</td>
							<td style="width:20%;">Jours de Congés sans solde</td>
							<td style="width:20%;">Jours Autres</td>
						</tr>
						<tr>
							<td><input type="text" name="nbjrsCP" id="nbjrsCP" style="width:50%;" value="<?php return_isset('nbjrsCP');?>"/></td>
							<td><input type="text" name="nbjrsRTT" id="nbjrsRTT" style="width:50%;" value="<?php return_isset('nbjrsRTT');?>"/></td>
							<td><input type="text" name="nbjrsConv" id="nbjrsConv" style="width:50%;" value="<?php return_isset('nbjrsConv');?>"/></td>
							<td><input type="text" name="nbjrsSS" id="nbjrsSS" style="width:50%;" value="<?php return_isset('nbjrsSS');?>"/></td>
							<td><input type="text" name="nbjrsAutres"  id="nbjrsAutres" style="width:50%;" value="<?php return_isset('nbjrsAutres');?>"/></td>
						</tr>
					</table>
					<p style="margin-top: 50px;">Commentaire</p>
					<p><textarea name="commentaire" id="commentaire" style="width: 100%;height:50px;"><?php return_isset('commentaire');?></textarea>
					<p style="float:right">
						<input type="submit" value="Valider" name="Envoyer" style=""/>
					</p>	
				</div>
		</div>
	<script >
function ok(){
	var d1 = document.getElementById("dateFromDu").value;
	var d2 = document.getElementById("dateFromAu").value;
	var demidebut = document.getElementById("thelistMM").value;
	var demifin = document.getElementById("thelistMS").value;
	var demid = 0.5;
	var demif = 0.5;
	var cpt_j = 0;
	if(d1==""||d2==""){
		return false;}
	var date1 = new Date(parseInt(d1.substring(0,4),10),parseInt(d1.substring(5,7),10)-1,parseInt(d1.substring(8,10),10)),
	date2 = new Date(parseInt(d2.substring(0,4),10),parseInt(d2.substring(5,7),10)-1,parseInt(d2.substring(8,10),10)),
	diffj = 0;
	var tab_1=new Array;
	var tab_2=new Array;
	tab_1=JoursFeries(date1.getFullYear());
	tab_2=JoursFeries(date2.getFullYear()+1);
	if(date1>date2){	
			document.getElementById('nbJrs_hidden').value=0; 
	}
	if(date1.getDay()==0 || date1.getDay()==6){
		demid = 0;

	}
	if(date2.getDay()==0 || date2.getDay()==6){
		demif = 0;
	}
	for(cpt_i = 0; cpt_i <13; cpt_i++){
		if(date1.getMonth() == tab_1[cpt_i].getMonth() && date1.getFullYear() == tab_1[cpt_i].getFullYear() && date1.getDate() == tab_1[cpt_i].getDate()){
			cpt_j = 1;
			
		}
	}
	if(cpt_j == 1){	
		demid = 0; 
	}
	cpt_j = 0;
	for(cpt_i = 0; cpt_i <13; cpt_i++){
		if(date2.getMonth() == tab_1[cpt_i].getMonth() && date2.getFullYear() == tab_1[cpt_i].getFullYear() && date2.getDate() == tab_1[cpt_i].getDate()){
			cpt_j = 1;
		}
	}
	if(cpt_j == 1){	
		demif = 0; 
	}

	while(date1<=date2) {
		if(date1.getDay()!=0 && date1.getDay()!=6){
			for(cpt_i = 0; cpt_i <13; cpt_i++){
				if(date1.getMonth() == tab_1[cpt_i].getMonth() && date1.getFullYear() == tab_1[cpt_i].getFullYear() && date1.getDate() == tab_1[cpt_i].getDate()){
					cpt_j = 1
				}
			}
			if(cpt_j == 0){	
				diffj++; 
			}
		}
	    	date1.setTime(date1.getTime()+(24*3600*1000));
		cpt_j = 0 ;
	}
	if(demidebut == 'Midi'){	
		diffj = diffj - demid; 
	}
	if(demifin == 'Midi'){	
		diffj = diffj - demif; 
	}

	document.getElementById('nbJrs').innerHTML = 'Nombre de jours de repos à répartir : '+diffj+' jours.';
	document.getElementById('nbJrs_hidden').value = diffj;
}
function jrspose(){
	nbJrsDepose = 0 ;
	cp = document.getElementById("nbjrsCP").value;
	rtt = document.getElementById("nbjrsRTT").value;
	conv = document.getElementById("nbjrsConv").value;
	ss = document.getElementById("nbjrsSS").value;
	autres = document.getElementById("nbjrsAutres").value;
	nbJrs =document.getElementById("nbJrs_hidden").value;
	if(cp == ""){
		cp = 0 ;}
	if(rtt == ""){
		rtt = 0 ;}
	if(ss == ""){
		ss = 0 ;}
	if(conv == ""){
		conv = 0 ;}
	if(autres == ""){
		autres = 0 ;}
	nbJrsDepose = parseFloat(cp) + parseFloat(rtt) + parseFloat(conv) + parseFloat(ss) + parseFloat(autres) ;
	alert(nbJrsDepose);
}
function JoursFeries (an){
  var JourAn = new Date(an, "00", "01");
  var FeteTravail = new Date(an, "04", "01");
  var Victoire1945 = new Date(an, "04", "08");
  var FeteNationale = new Date(an,"06", "14");
  var Assomption = new Date(an, "07", "15");
  var Toussaint = new Date(an, "10", "01");
  var Armistice = new Date(an, "10", "11");
  var Noel = new Date(an, "11", "25");
  var G = an%19;
  var C = Math.floor(an/100);
  var H = (C - Math.floor(C/4) - Math.floor((8*C+13)/25) + 19*G + 15)%30;
  var I = H - Math.floor(H/28)*(1 - Math.floor(H/28)*Math.floor(29/(H + 1))*Math.floor((21 - G)/11));
  var J = (an*1 + Math.floor(an/4) + I + 2 - C + Math.floor(C/4))%7;
  var L = I - J;
  var MoisPaques = 3 + Math.floor((L + 40)/44);
  var JourPaques = L + 28 - 31*Math.floor(MoisPaques/4);
  var Paques = new Date(an, MoisPaques-1, JourPaques);
  var LundiPaques = new Date(an, MoisPaques-1, JourPaques+1);
  var Ascension = new Date(an, MoisPaques-1, JourPaques+39);
  var Pentecote = new Date(an, MoisPaques-1, JourPaques+49);
  var LundiPentecote = new Date(an, MoisPaques-1, JourPaques+50);

  return new Array(JourAn, Paques, LundiPaques, FeteTravail, Victoire1945, Ascension, Pentecote, LundiPentecote, FeteNationale, Assomption, Toussaint, Armistice, Noel);
}

	</script>
	</body>
</html>
