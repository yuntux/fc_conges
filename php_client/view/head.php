<!doctype html>
<html lang="fr">
        <head>
		<meta charset="utf-8">
                <title>FC congés</title>
		<link rel="icon" type="image/ico" href="view/favicon.ico"/>
		<!--<link href="view/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/18.2.3/css/dx.common.css" />
    <link rel="dx-theme" data-theme="generic.light" href="https://cdn3.devexpress.com/jslib/18.2.3/css/dx.light.css" />
    <script src="https://cdn3.devexpress.com/jslib/18.2.3/js/dx.all.js"></script>
    <link rel="stylesheet" type ="text/css" href ="view/datagrid.css" />

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
