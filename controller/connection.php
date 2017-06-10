<?php
$GUERANDE="n2sGZ93z";
header('Content-Type: text/html; charset=utf-8');
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=fc_conges', 'root', 'tb3cLe584eSRL3P9', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
?>
