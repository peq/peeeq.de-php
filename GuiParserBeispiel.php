<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<!-- Das folgende Stylesheet muss irgendwie in die Seite eingebunden werden-->
	<style type="text/css">
		/*<![CDATA[*/
		.guipic
		{
			/*Hintergrundgrafik, Pfad anpassen:*/
			background: url('http://peeeq.de/GuiParserPics/symbols.png') no-repeat top left;
			width:16px;
			height:16px;
			margin:0px;
			padding:0px;
			display:block;
			float:left;
			position:relative;
		}

		.guitext
		{
			float:left;
			clear:both;
		}
		/*]]>*/
	</style>

	<?

		//GuiParser-Datei einbinden 
		require_once("GuiParser3.php");

		//Diese Funktion entfernt die Schrägstriche vor den Anführungszeichen, die durch 
		function unescape_string($s)
		{
			return str_replace('\"', '"', $s);
		}

		if (isset($_POST['GuiCode'])) {
			$gui_code = unescape_string($_POST['GuiCode']);
			
			//Gui-Parser Objekt erstellen
			$gui_parser = new GuiParser;
			
			//Gui parsen
			//der erste Parameter ist der Gui-Code, die nächsten beiden sind eigentlich nur zur Kompatibilität mit älteren Versionen da, 
			//der letzte Parameter ist entweder "html" für die normale Ausgabe oder "bb" um BB-Code zu erzeugen.
			$html_code = $gui_parser->ParseGui($gui_code, array(), false, "html");
			
			//Das Ergebnis ausgeben:
			echo $html_code;
		}

	?>


	<title></title>
	</head>
	<body>

		<form action="" method="post">
			<textarea name="GuiCode" cols="100" rows="20">
			</textarea>
			<br />
			<input type="submit" />
		</form>
	</body>
</html>
