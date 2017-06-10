<div id="bloc_donnees">
	<div id="entete_bloc_donnees">
		<h2>Validation des demandes</h2>
	</div>
	<div id="entete_bloc_donnees">
		<?php 
			if($_SESSION['role'] == "DIRECTEUR"){
				$ection_title = "Validation Directeur";
				$step = "En cours de validation DM";
				include("view/ValidationDir.php");
			}
			if($_SESSION['role'] == "DIRECTEUR"  || $_SESSION['role'] == "DM" ){
				$ection_title = "Validation DM";
				$step = "En cours de validation DM";
				include("view/ValidationDM.php");
				$ection_title = "Historique de validation";
				$step = "En cours de validation DM";
				include("view/ValidationHistorique.php");
			}
		?>	
	</div>
</div>
<div id="pied_page">
</div>
