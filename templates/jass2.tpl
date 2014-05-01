{if $html_code}
	<pre>{$html_code}</pre>
	<br />zu Zeile springen: <input name="linenr" id="linenr"  onkeydown="wait_jumpto();" onchange="jumpto2();">
	<br /><br />
	{if $smarty.post.jass}
		<b>Link zu diesem Code : </b>
		<br /><a href="jass.php?id={$id}">http://peq.pe.ohost.de/jass.php?id={$id}</a>
		<br /><b>Link zu diesem Code mit Standard-Formatierung : </b>
		<br /><a href="jass.php?id={$id}&f=1">http://peq.pe.ohost.de/jass.php?id={$id}&f=1</a>
	{else}
		{if $smarty.get.f}
			<br /><a href="jass.php?id={$id}">Diesen Code in Original-Formatierung anzeigen</a>
		{else}
			<br /><a href="jass.php?id={$id}&f=1">Diesen Code in Standard-Formatierung anzeigen</a>
		{/if}
		<br /><a href="jass.php">Neuen Jass-Code Posten</a>
	{/if}
	
	<br />
	<br />
	<br />
	<a href="javascript:onoff()">Text-Kopier-Fenster</a>
	<textarea id="copyarea" style="visibility:hidden;font-family:monospace;Corier New,Verdana,Tahoma,Arial;font-size:13px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999;white-space: nowrap; width: 97%;overflow:auto; height:500px;">{$jass_code}</textarea>
{else}
	<form action="jass.php" method="post">
	<p align="center">
	<textarea name="jass" id="jass" rows="35" cols="80"></textarea>
	<br /><input type="submit" value="speichern" /> 

	</p></form>
{/if}
