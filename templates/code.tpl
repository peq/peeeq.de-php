{if $output}
	{if ($smarty.get.showpic) && ($id == 1000)}
		<img src="peq1000.jpg" />
	{/if}
	{$ausgabe}
	{$output}
	<br />
	<div style="float:right;margin-right:150px;clear:both;">
		{if $format_script == 1}
			<a href="code.php?id={$id}&amp;f=1&amp;language={$language_id}&amp;style={$style_id}">Diesen Code in Standard-Formatierung anzeigen</a>
		{elseif $format_script == 2}
			<a href="code.php?id={$id}&amp;language={$language_id}&amp;style={$style_id}">Diesen Code in Original-Formatierung anzeigen</a>
		{/if}
	</div>
	<div style="float:right;margin-right:150px;clear:both;">
		<ul id="cssdropdown">

		<li class="mainitems">
		select language
		<ul class="subuls">
		{foreach from=$languages item=language}
			{if ($language_id == $language.id)}
				<li><a href="code.php?id={$id}&amp;language={$language.id}&amp;style={$style_id}{if $format_script == 2}&amp;f=1{/if}"> &gt; {$language.name}</a></li>
			{else}
				<li><a href="code.php?id={$id}&amp;language={$language.id}&amp;style={$style_id}{if $format_script == 2}&amp;f=1{/if}">{$language.name}</a></li>
			{/if}	
		{/foreach}
		</ul>
		</li>

		<li class="mainitems">
		select style
		<ul class="subuls">
		{foreach from=$styles item=style}
			{if ($style_id == $style.id)}
				<li><a href="code.php?id={$id}&amp;style={$style.id}&amp;language={$language_id}{if $format_script == 2}&amp;f=1{/if}"> &gt; {$style.name}</a></li>
			{else}
				<li><a href="code.php?id={$id}&amp;style={$style.id}&amp;language={$language_id}{if $format_script == 2}&amp;f=1{/if}">{$style.name}</a></li>
			{/if}
		{/foreach}
		</ul>
		</li>

		</ul>
	</div>
	<div style="margin-left:20px;">
		goto line: <input name="linenr" id="linenr"  style="width:50px;" onkeydown="wait_jumpto();" onchange="jumpto2();" />
		<form style="margin-left:35px;display:inline;" method="get" action="comparer.php">Compare with: 
			<input style="width:50px;" type="text" name="id2" value="{$id-1}" />
			<input type="hidden" name="id1" value="{$id}" />
			<input type="submit" value="go" />
		</form>
	</div>
	
	<div style="margin:20px;">
		
		<a href="javascript:onoff()">text copy window</a>
		<a style="margin-left:100px;" href="code.php?l={$language_name}&copy={$id}{$keyString}">edit this code</a> 
		<a style="margin-left:100px;" href="code.php?l={$language_name}">post new code</a>
	</div>
	<textarea rows="35" cols="80" id="copyarea" style="visibility:hidden;font-family:monospace;Corier New,Verdana,Tahoma,Arial;font-size:13px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999; overflow:auto; height:0px;">{$jass_code}</textarea>
{elseif $smarty.post.code}
	<div class="notice" style="margin-top:300px;">
	Dein Code wurde gespeichert, wenn du nicht automatisch zu deinem code weitergeleitet wirst benutze folgenden Link:<br />
	<a href="code.php?id={$id}">http://peeeq.de/code.php?id={$id}</a>
	</div>
{else}
	<br />
	<form action="code.php" method="post">
	<p align="center">
	<textarea name="code" id="code" rows="35" cols="80">{$code}</textarea>
	<br />
	<select name="lang" onchange="onSyntaxChange(this);">
	{foreach from=$languages item=language}
		<option{if $smarty.get.l == $language} selected="true"{/if}>{$language}</option>
	{/foreach}
	</select>
	<input type="checkbox" name="hidden" />hidden 
	<input type="submit" value="save" /> 

	</p></form>
{/if}
