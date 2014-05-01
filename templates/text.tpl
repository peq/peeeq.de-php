
{if $html_code}
	<div style="margin:20px;border-style:solid;border-width:1px;padding:5px;line-height:20px;">
	{$html_code}
	</div>
	{if $smarty.post.text}
		<br /><b>Link zu diesem Text : </b><br /><a href="text.php?id={$id}">http://peq.pe.ohost.de/text.php?id={$id}</a>
	{else}
		<br /><a href="text.php">Neuen Text Posten</a>
	{/if}
{else}
	<form action="text.php" method="post" enctype="multipart/form-data"><p align="center">
	<textarea name="text" rows="20" cols="80">

	</textarea>
	<br /><input type="submit" value="speichern" />
	</p></form>
{/if}