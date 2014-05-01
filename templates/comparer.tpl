{if $output_lines1 && $output_lines2}
<table width='100%' style='width:100%'>
	<tr>
		<td width='50%' style='width:50%'>
			{if $smarty.get.id1}<a href="code.php?id={$smarty.get.id1}">Code #{$smarty.get.id1}</a> {/if}
			{$output_lines1}
		</td>
		<td width='50%' style='width:50%'>
			{if $smarty.get.id1}<a href="code.php?id={$smarty.get.id2}">Code #{$smarty.get.id2}</a>{/if}
			{$output_lines2}
		</td>
	</tr>
</table>
<div style="margin-top:550px;margin-left:35px;">
<a href="comparer.php">Neuer Code-Vergleich</a>
</div>
{elseif $smarty.post.save}
	<div class="notice" style="margin-top:300px;">
	Dein Vergleich wurde gespeichert, wenn du nicht automatisch weitergeleitet wirst benutze folgenden Link:<br />
	<a href="comparer.php?id1={$id1}&id2={$id2}">http://peq.pe.ohost.de/comparer.php?id1={$id1}&id2={$id2}</a>
	</div>
{else}
<form method="post" action="comparer.php">
	<table width='100%' style='width:100%;margin-top:20px;' cellpadding="0" cellspacing="0">
		<tr>
			<td width='50%' style='width:50%'>
				Code 1:
				<textarea name="code1" cols="100" rows="25"></textarea>
			</td>
			<td width='50%' style='width:50%'>
				Code 2:
				<textarea name="code2" cols="100" rows="25"></textarea>
			</td>
		</tr>
	</table>
	<div style="margin-left:30px;">
		<input type="checkbox" name="save" value="1"> Codes speichern<br />
		Sprache: <select name="lang" onchange="onSyntaxChange(this);">
		{foreach from=$languages item=language}
			<option>{$language}</option>
		{/foreach}
		</select><br />
		<input type="submit" value="Codes vergleichen">
	</div>
</form>
{/if}