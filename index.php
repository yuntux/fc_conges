<?php include("Pages/Functions/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Fontaine Consultants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="styleSheet0.css" />
	</head>
	<body>
		<!--<a href="Pages/Home.php">test</a>-->
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<?php
				  if(!empty($errorMessage)) 
				  {
				    echo '<p> Erreur </p><p>', htmlspecialchars($errorMessage) ,'</p>';
				  }
				?>
			<table style="position:absolute;left:55%;top:30%;">
				<thead>
					<tr>
						<td colspan=2 style ="color : grey ;font-size : 18px;">Connexion</td>
					</tr>
				</thead>
				<tbody style="position: fixed;border-radius : 5px ;">
					<tr>
						<td>Login : </td>
						<td><input type="text" name="login" /></td>
					</tr>
					<tr>
						<td>Password : </td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td>Connexion automatique</td>
						<td><input type="checkbox" name="auto_connect" value="Y"/></td>
					</tr>
					<tr>
						<td><input type="submit" value="submit" /></td>
					</tr>
				</tbody>
			</table>
		</form>			
	</body>
</html>
