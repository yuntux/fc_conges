<div id="nav" style="background-color: #E6B473;text-align:justify;">
	<ul class="links primary-links">
		<li class="menu-1-1"><a href="?action=home" class="menu-1-1"<?php if ($action=="home") echo ' style="background-color:#FFF;"';?>>Dashboard</a></li>
		<li class="menu-1-2"><a href="?action=DemandeConges" class="menu-1-2"<?php if ($action=="DemandeConges") echo ' style="background-color:#FFF;"';?>>Saisir une demande</a></li>
		<li class="menu-1-3"><a href="?action=Historiques" class="menu-1-3"<?php if ($action=="Historiques") echo ' style="background-color:#FFF;"';?>>Historiques</a></li>
		<?php 
			if($_SESSION['role'] == "DIRECTEUR"  || $_SESSION['role'] == "DM" ){
				echo '<li class="menu-1-4"><a href="?action=Validation" class="menu-1-4"';
					if ($action=="Validation") 
						echo ' style="background-color:#FFF;"';
					echo '>Validation</a></li>';
				echo '<li class="menu-1-5"><a href="?action=VisionGenerale" class="menu-1-5"';
					if ($action=="VisionGenerale")
						echo ' style="background-color:#FFF;"';
					echo '>Vision générale</a></li>';
				echo '<li class="menu-1-6"><a href="?action=editions" class="menu-1-6"';
					if ($action=="editions")
						echo ' style="background-color:#FFF;"';
					echo '>Editions</a></li>';
/*
				echo '<li class="menu-1-7"><a href="?action=liste_projets" class="menu-1-7"';
					if ($action=="liste_projets")
						echo ' style="background-color:#FFF;"';
					echo '>Liste projets</a></li>';
				echo '<li class="menu-1-8"><a href="?action=staffing" class="menu-1-8"';
					if ($action=="staffing")
						echo ' style="background-color:#FFF;"';
					echo '>Staffing</a></li>';
*/
			}
		?>
	</ul>
</div>
