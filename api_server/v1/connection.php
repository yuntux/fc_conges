<?php
include('db_parameters_prod.php');
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
		$con =$DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME;
		$bdd = new PDO($con, $DB_USER, $DB_PASSWORD, $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
?>
