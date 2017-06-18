<!doctype html>
<html lang="fr">
        <head style ="display: none;">
                <title>Fontaine Consultants</title>
		<meta charset="utf-8">
                <link rel="stylesheet" media="screen" type="text/css" href="view/Style.css?v=5" />
        </head>
        <body>
                <div id="main_wrapper">
                        <div id="tete_page">
				<div id="header-bar-wrapper">
					<div id="header-bar">

                                <?php
					if(!empty($_SESSION['id']))
					{
echo'						<div class="links secondary-links">
							<a href="?action=MonCompte">Mon compte</a> | <a href="?action=deconnexion">Se déconnecter</a>
						</div>
';

					if($_SESSION['role'] == "DIRECTEUR"){
echo'                                           <div class="links secondary-links">
							<a href="?action=administration">Administration |</a>
						</div>
';
						}
					}
?>
						<a class="logo" href="?action=home"><img src="view/Pictures/logo.png" class="logo" alt=""></a>
					</div>
				</div>
                                <?php
					if(!empty($_SESSION['id']))
						include('view/menu.php');

				?>
                        </div>
<?php
if (isset($message_erreur))
        echo '<p style="background-color: #F5A9A9;">'.$message_erreur.'</p>';
if (isset($message_succes))
        echo '<p style="background-color: #81F157;">'.$message_succes.'</p>';
?>
