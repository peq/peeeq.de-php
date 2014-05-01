	<table width=100%>
		<tr height="100px">
		<th colspan=3></th>
		</tr>
		<tr>
		<td width="50%"></td>
		<td align="center">
				<div style="
					
					padding-left:2px;
					padding-right:2px;
					padding-bottom:2px;
					padding-top:2px;
					border-width:1px;
					border-color:#E0E0FF;
					border-style:solid;
					">
				<div style="
					padding-left:10px;
					padding-right:10px;
					padding-bottom:10px;
					padding-top:10px;
					background-color:#E0E0FF;
					">
					<form action="change_profile.php" method="post">
						<font size=2><b>Bitte trage die gewünschten Änderungen ein:</b></font>
						<font size=2><nobr>(Felder, die mit einem * gekennzeichnet sind optional.)</nobr></font>
						<br />
						<br />
						<table>
							<tr>
								<td align="left"><b>Accountname:</b><br /><font style='font-size:10px;' color="red">{$error.name}</font></td>
								<td><input type="text" name="name" value="{$name}"></td>
							</tr>
							<tr>
								<td align="left"><b>altes Passwort:</b><br /><font size=2>(nur bei Änderungen am Passwort benötigt)</font><br /><font style='font-size:10px;' color="red">{$error.password0}</font></td>
								<td><input type="password" name="password0" value="{$oldpassword}"></td>
							</tr>
							<tr>
								<td align="left"><b>neues Passwort:</b><br /><font size=2>(Feld frei lassen, um altes Passwort zu behalten)</font><br /><font style='font-size:10px;' color="red">{$error.password1}</font></td>
								<td><input type="password" name="password1" value="{$password}"></td>
							</tr>
							<tr>
								<td align="left"><b>neues Passwort wiederholen:</b><br /><font style='font-size:10px;' color="red">{$error.password2}</font></td>
								<td><input type="password" name="password2" value="{$password}"></td>
							</tr>
							<tr>
								<td align="left"><b>E-mail Adresse:</b><br /><font style='font-size:10px;' color="red">{$error.email}</font></td>
								<td><input type="text" name="email" value="{$email}"></td>
							</tr>
							<tr>
								<td align="left">Nachname*:<br /><font style='font-size:10px;' color="red">{$error.nachname}</font></td>
								<td><input type="text" name="nachname" value="{$nachname}"></td>
							</tr>
							<tr>
								<td align="left">Vorname*:<br /><font style='font-size:10px;' color="red">{$error.vorname}</font></td>
								<td><input type="text" name="vorname" value="{$vorname}"></td>
							</tr>
							<tr>
								<td align="left">ICQ-Nummer*:<br /><font style='font-size:10px;' color="red">{$error.icq}</font></td>
								<td><input type="text" name="icq" value="{$icq}"></td>
							</tr>
							<tr>
								<th colspan="2">
								<input type="hidden" name="a" value="update">
								<input type="submit" value="Änderungen übernehmen">
								</td>
							</tr>
						</table>
					
					</form>
					</div>
					</div>
		</td>
		<td width="50%"></td>
		</tr>
		<tr height="100px">
		<th colspan=3></th>
		</tr>
	</table>
