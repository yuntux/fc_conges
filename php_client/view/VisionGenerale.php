	<?php 
		$nb_mois_vision = 4;
		$debut_scope = date("Y-m-d");
		$fin_scope = date('Y-m-d',strtotime('+'.$nb_mois_vision.' month',strtotime($debut_scope)));

		$js_data = 'source: [';
		foreach ($reponse1 as $donnees1)
		{
			$values = '';

			$filter = "CONSULTANT_CONGES = ".$donnees1['ID_CONSULTANT']." AND (STATUT_CONGES NOT IN ('Annulée DM','Annulée Direction','Annulée')) AND (FIN_CONGES >= '".$debut_scope."' AND DEBUT_CONGES <= '".$fin_scope."')";
			$conges_consultants = $DEMANDE->get_list('*',$filter,False);

			foreach ($conges_consultants as $conges) {
				$debut = strtotime($conges['DEBUT_CONGES']);
				$debut_fr = get_date_french_str($conges['DEBUT_CONGES']);	
				$fin_fr = get_date_french_str($conges['FIN_CONGES']);	
				// TODO : ajouter l'heure au timestamp en cas de demie-journées
				$fin = strtotime($conges['FIN_CONGES']);
				$couleur = "ganttRed";
				if ($conges['STATUT_CONGES'] != "Validée"){
					$couleur = "ganttOrange";
				}
				$values.= '{
							from: "/Date('.$debut.'000)/",
							to: "/Date('.$fin.'000)/",
							label: "'.$donnees1["PRENOM_CONSULTANT"].' '.$donnees1["NOM_CONSULTANT"].'",
							customClass: "'.$couleur.'",
							dataObj: "Consultant : '.$donnees1["PRENOM_CONSULTANT"].' '.$donnees1["NOM_CONSULTANT"].'\nDébut : '.$debut_fr.' '.$conges['DEBUTMM_CONGES'].'\nFin : '.$fin_fr.' '.$conges['FINMS_CONGES'].'\nStatut : '.$conges["STATUT_CONGES"].'"
					   },';
				//TODO : ajouter le cahmp object pour pouvoir l'utiliser via la popup ou le hover pour afficher les détails
			}

			$js_data.= '
                                {
                                        name: "'.$donnees1["PRENOM_CONSULTANT"].'",
                                        desc: "'.$donnees1["NOM_CONSULTANT"].'",
                                        values: ['.$values.']
                                },';
		}
		$js_data .= ']';
	?>

                        <div id="bloc_donnees">
                                <div id="entete_bloc_donnees">
					<h2>Vision générale</h2>
                                </div>
                                <div id="bloc_donnees1" style="width: 100%">
                                        <h2>Calendrier des congés pour les <?php echo $nb_mois_vision; ?> prochains mois</h2>
En orange les demandes en attente / en rose les demandes validées par la direction.
<br>Cliquer sur le rectangle représentant la demande pour voir le détail de la demande.
<br>Cliquer sur les bouton "<" ou ">" pour passer d'une page à l'autre (25 consultants par page);
<br>Cliquer sur le bouton '-' pour visualiser à plsu grosse maille temporelle (semaine, mois) ou '+' pour visualiser à une maille plus fine (au mieux le jour).
						<div class="gantt"></div>
				</div>

				<!-- <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">-->
				<link href="view/jQuery_Gantt/style.css" type="text/css" rel="stylesheet">
				<!-- <link href="view/jQuery_Gantt/bootstrap.css" rel="stylesheet" type="text/css">-->
				<!-- <link href="view/jQuery_Gantt/prettify.css" rel="stylesheet" type="text/css">-->
				<style type="text/css">
					/* Bootstrap 3.x re-reset */
					.fn-gantt .nav-link {color:white;font-size:10px;width:30px;height:20px;}
					.fn-gantt *,
					.fn-gantt *:after,
					.fn-gantt *:before {
					    -webkit-box-sizing: content-box;
					       -moz-box-sizing: content-box;
						    box-sizing: content-box;
					  }
				</style>
				<script src="view/jQuery_Gantt/jquery.js"></script>
				<script src="view/jQuery_Gantt/jquery_002.js"></script>
				<!--<script src="view/jQuery_Gantt/bootstrap.js"></script>-->
				<!--<script src="view/jQuery_Gantt/prettify.js"></script>-->
				 <script>
						$(function() {

							"use strict";

							$(".gantt").gantt({
								<?php echo $js_data; ?>,
								scale: "days",
								navigate: "scroll",
								minScale: "days",
								maxScale: "months",
								waitText: "Chargement en cours...",
								dow: ["D", "L", "Ma", "Me", "J", "V", "S"],
								months : ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
								itemsPerPage: 25,
								onItemClick: function(data) {
									alert(data);
								},
								/*onAddClick: function(dt, rowId) {
									alert("Empty space clicked - add an item!");
								},
								onRender: function() {
									if (window.console && typeof console.log === "function") {
										console.log("chart rendered");
									}
								}*/
							});
				/*
							$(".gantt").popover({
								selector: ".bar",
								title: "I'm a popover",
								content: "And I'm the content of said popover.",
								trigger: "hover"
							});
				*/
							prettyPrint();

						});
				</script>


