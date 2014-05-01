<form action="codesearch.php" method="get" class="search">
	<select name="l" class="searchlanguage">
	<option value="-1">alle Sprachen</option>
	{foreach from=$languages item=language}
		<option{if $smarty.get.l == $language.name} selected="true"{/if} value="{$language.id}">{$language.name}</option>
	{/foreach}
	</select>
	<input type="text" id="q" name="q" class="searchquery" value='{$q}' />
	<input type="submit" value="Suche starten!" class="seachgo" />
</form>

{if sizeof($searchresults) > 0} 
	<ul class="searchresult">
	{foreach from=$searchresults item=result}
		<li>
			<span style="margin-right:25px;font-size:8px;">{$result.score}</span> 
			<a href="code.php?id={$result.id}">
				{$result.lang}-Code#{$result.id}: {$result.title}
			</a>
			<pre style="white-space:pre-wrap;word-wrap:break-word;">{$result.text}</pre>
		</li>
	{/foreach}
	</ul>
{else}
{if $smarty.get.q}
<div class="notice">Leider wurden keine Ergebnisse gefunden. Bitte Beachte die folgenden Suchtipps:</div>
{/if}


<div class="notice" style="text-align:left;">
<h3>Such-Tipps:</h3>
Die Suche verwendet eine <a href="http://dev.mysql.com/doc/refman/5.1/de/fulltext-boolean.html">Boolsche Volltextsuche von Mysql</a>. Das bedeutet, das nur ganze Wörter gefunden werden, um Wörterteile zu finden muss der Platzhalter * benutzt werden.<br />
Alle eingegeben Wörter sind automatisch optional, das heißt es wird nach ihnen gesucht, aber sie müssen nicht umbedingt vorkommen und es werden alle Wörter gleich gewichtet.
Um die Suchabfrage zu verfeinern sind folgende Modifikatoren möglich:
<ul>
	<li style="list-style-type:none;"><strong>+</strong>
		Das nachfolgende Wort muss vorkommen
	</li>
	<li style="list-style-type:none;"><strong>-</strong>
		Das nachfolgende Wort darf nicht vorkommen
	</li>
	<li style="list-style-type:none;"><strong>&gt;</strong>
		Das nachfolgende Wort wird stärker bewertet
	</li>
	<li style="list-style-type:none;"><strong>&lt;</strong>
		Das nachfolgende Wort wird schwächer bewertet
	</li>
	<li style="list-style-type:none;"><strong>~</strong>
		Das nachfolgende Wort wird negativ gewertet
	</li>
	<li style="list-style-type:none;"><strong>*</strong>
		Platzhalter
	</li>
</ul>
Außerdem können Ausdrücke geklammert werden und mehrere Wörter lassen sich in Anführungszeichen schreiben, wenn sie wortwörtlich vorkommen sollen. 
</div>
{/if}