{if $action == 'register_formular'}
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
					<form action="login.php" method="post">
						<font size=2><b>Bitte f&uuml;lle die folgenden Felder aus um dich zu registrieren:</b></font>
						<font size=2><nobr>(Felder, die mit einem * gekennzeichnet sind optional.)</nobr></font>
						<br />
						<br />
						<table>
							<tr>
								<td align="left"><b>Accountname:</b><br /><font style='font-size:10px;' color="red">{$error.name}</font></td>
								<td><input type="text" name="name" value="{$name}"></td>
							</tr>
							<tr>
								<td align="left"><b>Passwort:</b><br /><font style='font-size:10px;' color="red">{$error.password1}</font></td>
								<td><input type="password" name="password1" value="{$password}"></td>
							</tr>
							<tr>
								<td align="left"><b>Passwort wiederholen:</b><br /><font style='font-size:10px;' color="red">{$error.password2}</font></td>
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
								<input type="hidden" name="a" value="register">
								<input type="submit" value="Registrieren">
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
{elseif $action == 'login_screen' || $action == 'login_failed'}
	<table width="100%" cellpadding="50px" style="margin-top:30px;">
		<tr>
			<td>
			<div style="
				margin-left:80px;
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
				<b>Melde dich jetzt an, um alle Features von peq.de.vu zu nutzen!</b>
				<br />
				<br />
				<br />
				Die Anmeldung ist kostenlos - es entstehen keinerlei Verpflichtungen. Die Anmeldung wird nur ben&ouml;tigt, damit du die Seite an deine W&uuml;nsche anpassen kannst und du als Eigent&uuml;mer deiner hier hochgeladenen Dateien und Scripte in die Datenbank eingetragen werden kannst.
				<br />
				<br />
				Nach der Anmeldung kannst du den Style der Syntax-hervorhebung an deine W&uuml;nsche anpassen und es ist dir erlaubt Dateien hoch zu laden und Kommentare zu verfassen (alles noch in Entwicklung). 
				<br />
				<br />
				Weitere neue Funktionen werden auch verst&auml;rkt von der Anmeldung Gebrauch machen. Die gewohnten Funktionen der Seite stehen aber weiterhin auch ohne Anmeldung zur Verf&uuml;gungng.
			</div>
			</div>
			</td>
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
				<form action="login.php" method="post">
					<input type="hidden" name="backto" value="{$referer}" />
					<font size=2>Melde dich hier an:</font>
					{if $action == 'login_failed'}
					<font color="red" style="font-size:10px;"><br />Anmeldung fehlgeschlagen.</font>
					{/if}
					<br />
					<br />
					<table>
						<tr>
							<td>Accountname:</td>
							<td><input type="text" name="name" value="{$name}"></td>
						</tr>
						<tr>
							<td>Passwort:</td>
							<td><input type="password" name="password"></td>
						</tr>
						<tr>
							<th colspan="2">
								<input type="hidden" name="a" value="login">
								<input type="submit" value="Anmelden">
							</td>
						</tr>
					</table>
				
				</form>
				</div>
				</div>
				<br />
				<br />
				<br />
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
				<font size="2"><b>Du hast noch keinen Account?</b></font>
				<br /><a href="login.php?a=register">=&gt; Jetzt registrieren! &lt;=</a>
			</div>
			</div>
			</td>
		</tr>
	</table>
{elseif $action == 'register_complete'}
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
					Registrierung abgeschlossen.
					</div>
					</div>
		</td>
		<td width="50%"></td>
		</tr>
		<tr height="100px">
		<th colspan=3></th>
		</tr>
	</table>
{elseif $action == 'login_complete'}
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
					Anmeldung erfolgreich.
					<br />Wilkommen.
					</div>
					</div>
		</td>
		<td width="50%"></td>
		</tr>
		<tr height="100px">
		<th colspan=3></th>
		</tr>
	</table>
{/if}
