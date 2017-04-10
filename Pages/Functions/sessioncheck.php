<?php
	session_start();
	if(empty($_SESSION['id'])) 
	{
	  header('Location: /00.FCC/index.php');
	  exit();
	}
?>
