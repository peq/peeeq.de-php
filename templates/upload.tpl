{foreach from=$errors item=error}
	<div class="error">
	{$error}
	</div>
{/foreach}
{foreach from=$notices item=notice}
	<div class="notice">
	{$notice}
	</div>
{/foreach}
<a href="{$backpath}uploads/">uploads</a>
{foreach from=$nav_ordner item=unterordner}
	{if $unterordner.id}
	-&gt; <a href="{$unterordner.path}">{$unterordner.name}</a>
	{/if}
{/foreach}


{if $folderexists}
	<table width="100%" style="align-left:5px;align-right:5px;">
	<thead> 
	<tr>
		<th class="header">
			{if ! "name"|in_array:$sort_parameters}
				<a href="&amp;sortby=name">Name</a>
			{else}
				<a href="&amp;sortby=name%20DESC">Name</a>
			{/if}
		</th>
		<th class="header">
					{if ! "filetype"|in_array:$sort_parameters}
				<a href="&amp;sortby=filetype">Typ</a>
			{else}
				<a href="&amp;sortby=filetype%20DESC">Typ</a>
			{/if}
		</th>
		<th class="header">
				{if ! "filesize"|in_array:$sort_parameters}
				<a href="&amp;sortby=filesize">Größe</a>
			{else}
				<a href="&amp;sortby=filesize%20DESC">Größe</a>
			{/if}
		</th>
		<th class="header">
				{if ! "datum"|in_array:$sort_parameters}
				<a href="&amp;sortby=datum">Datum</a>
			{else}
				<a href="&amp;sortby=datum%20DESC">Datum</a>
			{/if}
		</th>
		<th class="header">
				{if ! "downloads"|in_array:$sort_parameters}
				<a href="&amp;sortby=downloads">Downloads</a>
			{else}
				<a href="&amp;sortby=downloads%20DESC">Downloads</a>
			{/if}
		</th>
		<th class="header">
				{if ! "owner"|in_array:$sort_parameters}
				<a href="&amp;sortby=owner">Owner</a>
			{else}
				<a href="&amp;sortby=owner%20DESC">Owner</a>
			{/if}
		</th>
		<th class="header">Aktionen</th>
		
	</tr>
	</thead> 
	<tbody> 
	{foreach from=$ordnerinhalt item=row}
	{cycle values="odd,even" assign=tempclass}
		<tr class="{$tempclass}">
			
			{if $row.istordner}
				<td class="row"><img src="{$backpath}ordner.gif" alt="Ordner" /><a href="{$row.name|escape:"url"}/">{$row.name}</a></td>
				<td class="row">Ordner</td>
				<td class="row">{math equation="x" x=$row.filesize format="%.0f"} Kb</td>
				<td class="row">{$row.datum|date_format:"%d.%m.%Y %H:%I:%S"}</td>
				<td class="row"></td>
				<td class="row">{$row.avatar}{$row.ownername}</td>:
				<td class="row">
					{if $row.ownerid==$session_userid ||$row.ownerid== 0 || $session_admin}
						<a title="löschen" href="?{$sortby}&amp;c=delete&amp;id={$row.id}&amp;savekey={$row.savekey}"><img src="{$backpath}delete.png" alt="löschen" /></a>
					{/if}</td>
			{else}
				<td class="row">
				{if $row.thumb != ''}
				<img src="{$backpath}{$row.thumb}" alt="Bild"/>
				{/if}
				<a rel="nofollow" href="{$row.name|escape:"url"}">{$row.name}</a>
				</td>
				<td class="row">{$row.filetype}</td>
				<td class="row">{math equation="x" x=$row.filesize format="%.0f"} Kb</td>
				<td class="row">{$row.datum|date_format:"%d.%m.%Y %H:%I:%S"}</td>
				<td class="row">{$row.downloads}</td>
				<td class="row">{$row.ownername}</td>
				<td class="row">
					{if (($row.ownerid == $session_userid ||$row.ownerid== 0) && $session_userid ) || $session_admin}
						<a title="löschen" href="?{$sortby}&amp;c=delete&amp;id={$row.id}&amp;savekey={$row.savekey}"><img src="{$backpath}delete.png" alt="löschen" /></a>
					{/if}</td>
			{/if}
		</tr>
	{/foreach}
	</tbody> 
	</table>

	{if $session_is_logged_in == true }
		<br /><br />
		<div id="jcupload_messages">
		</div>
		<div id="jcupload_content">
                        <!-- jcUpload dialog output -->
                </div>
				
		
		<br /><br />
		<div id="olduploadform">
		<form action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>Datei hochladen</legend>
		<input type="hidden" name="c" value="upload" />
		<input type="hidden" name="o" value="{$ordner}" />
		<input type="file" size="100" maxlength="100000" name="userfile" />
		<input type="submit" value="upload" />
		</fieldset>
		</form>
		</div>
		<form action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>Ordner erstellen</legend>
		<input type="hidden" name="c" value="newfolder" />
		<input type="hidden" name="o" value="{$ordner}" />
		<input type="text" name="folder" />
		<input type="submit" value="Ordner erstellen" />
		</fieldset>
		</form>
	{else}
		<p style="margin:20px;padding:10px;background-color:#fea;"><a href="{$backpath}login.php">Anmelden</a> um Dateien hochzuladen.</p>
	{/if}
{/if}
