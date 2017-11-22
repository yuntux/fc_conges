		<form action="?action=login" method="post">
			<table style="position:absolute;left:55%;top:30%;">
				<thead>
					<tr>
						<td colspan=2 style ="color : grey ;font-size : 18px;">Connexion</td>
					</tr>
				</thead>
				<tbody style="position: fixed;border-radius : 5px ;">
					<tr>
						<td>E-mail : </td>
						<td><input type="text" name="login" /></td>
					</tr>
					<tr>
						<td>Password : </td>
						<td><input type="password" name="password" /></td>
					</tr>
<!--
					<tr>
						<td>Connexion automatique</td>
						<td><input type="checkbox" name="auto_connect" value="Y"/></td>
					</tr>
-->
					<tr>
						<td></td>
						<td><input type="submit" name="bouton_login" value="Connexion" style="margin-left: 0em;"/></td>
					</tr>
					<tr>
						<td><br><br><br><td><a href="?action=mot_passe_oublie">Mot de passe oublié</a></td>
					</tr>
				</tbody>
			</table>
		</form>			

