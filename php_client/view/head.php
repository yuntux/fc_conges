<!doctype html>
<html lang="fr">
        <head>
		<meta charset="utf-8">
                <title>FC congès</title>
		<link rel="icon" type="image/ico" href="view/favicon.ico"/>
                <link rel="stylesheet" media="screen" type="text/css" href="view/Style.css?v=5" />
		<link href="view/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
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
