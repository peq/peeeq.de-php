{if $html_code}
	<pre>{$html_code}</pre>
	<br />zu Zeile springen: <input name="linenr" id="linenr"  onkeydown="wait_jumpto();" onchange="jumpto2();">
	<br /><br />
	{if $smarty.post.java}
		<b>Link zu diesem Code : </b>
		<br /><a href="java.php?id={$id}">http://peq.pe.ohost.de/java.php?id={$id}</a>
	{else}
		<br /><a href="java.php">Neuen Java-Code Posten</a>
	{/if}
	
	<br />
	<br />
	<br />
	<a href="javascript:onoff()">Text-Kopier-Fenster</a>
	<textarea id="copyarea" style="visibility:hidden;font-family:monospace;Corier New,Verdana,Tahoma,Arial;font-size:13px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999;white-space: nowrap; width: 97%;overflow:auto; height:500px;">{$java_code}</textarea>
{else}
	<form action="java.php" method="post"><p align="center">
	<textarea name="java" rows="20" cols="80">

	</textarea>
	<br /> <input type="submit" value="speichern" /> 

	</p></form>
{/if}
