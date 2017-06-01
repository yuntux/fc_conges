<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(empty($_SESSION['id'])) 
	{
	  header('Location: /index.php');
	  exit();
	}
?>
