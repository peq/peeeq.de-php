{if false}<!--
<table border="0" width="100%" height="100%">
<tr>
<td width="70%" align="center">
<img src="peqdevu.png"></img>
</td><td align="left">
<br /><img src="arrow.png" alt="&gt;"><a href="gui.php">GUI-Trigger posten</a>
<br /><img src="arrow.png" alt="&gt;"><a href="code.php&l=jass">Jass-Code posten</a>
<br /><img src="arrow.png" alt="&gt;"><a href="code.php&l=C%2B%2B">C++-Code posten</a>
<br /><img src="arrow.png" alt="&gt;"><a href="code.php&l=java">Java-Code posten</a>
<br /><img src="arrow.png" alt="&gt;"><a href="code.php&l=delphi">Delphi-Code posten</a>
<br /><img src="arrow.png" alt="&gt;"><a href="upload/">Dateien hochladen</a>
<br /><img src="arrow.png" alt="&gt;"><a href="text.php">Text posten.</a>
<br /><img src="arrow.png" alt="&gt;"><a href="html.php">HTML posten.</a>
</td>
</tr>
<th colspan="2">

<img src="contaminated.jpg" alt="contamination"/><br /><i>(my new map, coming soon)</i>
</th>
</tr>
</table>

<table border="0" width="100%">
	<tr>
		<td width="70%" align="center">
			<img src="peqdevu.png" alt="peq.de.vu-logo"></img>
		</td>
		<td align="left">
			<ul class="styledlist">
			<li><a href="gui.php">GUI-Trigger posten</a></li>
			<li><a href="code.php&l=jass">Jass-Code posten</a></li>
			<li><a href="code.php&l=C%2B%2B">C++-Code posten</a></li>
			<li><a href="code.php&l=java">Java-Code posten</a></li>
			<li><a href="code.php&l=delphi">Delphi-Code posten</a></li>
			<li><a href="upload/">Dateien hochladen</a></li>
			<li><a href="text.php">Text posten.</a></li>
			<li><a href="html.php">HTML posten.</a></li>
	</ul>
		</td>
	</tr>
</table>	
-->{/if}

<div id="headerpic">
	<ul id="featuremenu" class="styledlist">
			<li><a href="gui.php">GUI-Trigger posten</a></li>
			<li><a href="code.php?l=jass">Jass-Code posten</a></li>
			<li><a href="code.php?l=C%2B%2B">C++-Code posten</a></li>
			<li><a href="code.php?l=java">Java-Code posten</a></li>
			<li><a href="code.php?l=delphi">Delphi-Code posten</a></li>
			<li><a href="uploads/">Dateien hochladen</a></li>
			<li><a href="text.php">Text posten.</a></li>
			<li><a href="html.php">HTML posten.</a></li>
			<li><a href="comparer.php">Codes vergleichen.</a></li>
			<li><a href="draw.php">Skizze malen.</a></li>
			<li><a href="codesearch.php">Codes durchsuchen.</a></li>
	</ul>
</div>

<div id="latest">
	<div id="latestcode" class="latest">
	<h1>Die letzten Code-Posts:</h1>
	<ul>
		{foreach from=$latest_code item=row}
		<li class="{$row.codetype}">
			<a href="code.php?id={$row.id}">{$row.short}</a><br />
			gepostet vor {$row.ago_time}			
		</li>
		{/foreach}
	</ul>
	</div>
	<div id="latestgui" class="latest">
	<h1>Die letzten Gui-Posts:</h1>
	<ul>
		{foreach from=$latest_gui item=row}
		<li class="gui">
			<a href="gui.php?id={$row.id}">{$row.short}</a><br />
			gepostet vor {$row.ago_time}			
		</li>
		{/foreach}
	</ul>
	</div>
</div>

<div id="comments">
{include file='comments.tpl'}
</div>