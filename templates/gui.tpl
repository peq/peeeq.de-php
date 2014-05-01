{if $html_code}
	{$html_code}
	<br /><br />
	{if $smarty.post.trigger}
		<b>Link zu diesem Trigger : </b>
		<br /><a href="gui.php?id={$id}">http://peq.pe.ohost.de/gui.php?id={$id}</a>
		<br /><br /><b>Link zu diesem Trigger als BB-Code: </b>
		<br /><a href="gui.php?id={$id}&amp;bb">http://peq.pe.ohost.de/gui.php?id={$id}&amp;bb=1</a>
	{else}
		{if $smarty.get.bb}
			<br /><a href="gui.php?id={$id}">Orignial anzeigen</a>
		{else}
			<br /><a href="gui.php?id={$id}&amp;bb=1"><img src="bbcode.png" alt="BB-Code posten"/></a>
		{/if}			
		<br /><br /><a href="gui.php?game={$game}">Neuen Trigger Posten</a>
	{/if}
{else}
	<form action="gui.php" method="post">
	<p align="center">
	<textarea name="trigger" rows="20" cols="80"></textarea>
	<input type="hidden" name="game" value="{$game}" />
	<br /><input type="submit" value="speichern" /> ({$game})
	</p>
	</form>
{/if}
