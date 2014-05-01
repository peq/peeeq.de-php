
{if $html_code}
	{if $smarty.post.html}
		<br />
		<br /><b>Link zu dieser Html-site : </b><br /><a href="html.php?id={$id}">http://peq.pe.ohost.de/html.php?id={$id}</a>
		<br /><b>Link zu dieser Html-site (mit peq.de.vu-interface) : </b><br /><a href="html.php?id={$id}&interface=1">http://peq.pe.ohost.de/html.php?id={$id}&interface=1</a>
		<hr />
	{/if}
	{$html_code}
	<br /><br /><hr>
	<a href="html.php">Neue Html-Seite posten</a>
	
{else}
	{if $smarty.post.html}
		<br />
		<br /><b>Link zu dieser Html-site : </b><br /><a href="html.php?id={$id}">http://peq.pe.ohost.de/html.php?id={$id}</a>
		<br /><b>Link zu dieser Html-site (mit peq.de.vu-interface) : </b><br /><a href="html.php?id={$id}&interface=1">http://peq.pe.ohost.de/html.php?id={$id}&interface=1</a>
	{else}
	
	
		<form action="html.php" method="post" enctype="multipart/form-data"><p align="center">
		<textarea name="html" rows="20" cols="80">

		</textarea>
		<br /><input type="submit" value="speichern" />
		</p></form>
	{/if}
{/if}