<?php include("controller/sessioncheck.php");
	$consultant = $bdd->query('SELECT * FROM consultant where ID_CONSULTANT =\''.$_SESSION['id'].'\'');  
	$acquis = $bdd->query('SELECT * FROM acquis where CONSULTANT_ACQUIS =\''.$_SESSION['id'].'\'');  
	$soldes = $bdd->query('SELECT * FROM solde where ID_SOLDE = (select max(ID_SOLDE) from solde where CONSULTANT_SOLDE = \''.$_SESSION['id'].'\') AND CONSULTANT_SOLDE =\''.$_SESSION['id'].'\'');  
	include("view/home.php");
?>
