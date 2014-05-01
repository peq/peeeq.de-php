{if true}
<div id="pbar">
	<div id="login">
		<ul>
			{if $session_is_logged_in == true }
				<li>angemeldet als {$session_username}</li>
				<li><a href="{$backpath}change_profile.php">Profil</a> </li>
				<li><a href="{$backpath}login.php?a=logout">Abmelden</a> </li>
			{else}
				{if preg_match( '/^.*login.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}login.php">Anmelden</a></li>
				{else}
					<li>Anmelden</li>
				{/if}
			{/if}		
		</ul>
	</div>
	<div id="menu">
	<ul>
			
				{if preg_match( '/^.*index.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}index.php">Home</a></li>
				{else}
					<li>Home</li>
				{/if}
				{if preg_match( '/^.*gui.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}gui.php">GUI</a></li>
				{else}
					<li>GUI</li>
				{/if}
				{if (preg_match( '/^.*code.*/' , $smarty.server.PHP_SELF ) == true) && ($smarty.get.l == "jass")}
					<li>Jass</li>
				{else}
					<li><a href="{$backpath}code.php?l=jass">Jass</a></li>
				{/if}
				{if (preg_match( '/^.*code.*/' , $smarty.server.PHP_SELF ) == true) && ($smarty.get.l == "C++")}
					<li>C++</li>
				{else}
					<li><a href="{$backpath}code.php?l=C%2B%2B">C++</a></li>
				{/if}
				{if (preg_match( '/^.*code.*/' , $smarty.server.PHP_SELF ) == true) && ($smarty.get.l == "java")}
					<li>Java</li>
				{else}
					<li><a href="{$backpath}code.php?l=java">Java</a></li>
				{/if}
				{if (preg_match( '/^.*code.*/' , $smarty.server.PHP_SELF ) == true) && ($smarty.get.l == "delphi")}
					<li>Delphi</li>
				{else}
					<li><a href="{$backpath}code.php?l=delphi">Delphi</a></li>
				{/if}
				{if preg_match( '/^.*uploads.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}uploads/">Upload</a></li>
				{else}
					<li>Upload</li>
				{/if}
				{if preg_match( '/^.*text.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}text.php">Text</a></li>
				{else}
					<li>Text</li>
				{/if}
				{if preg_match( '/^.*html.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}html.php">Html</a></li>
				{else}
					<li>Html</li>
				{/if}
				{if preg_match( '/^.*comparer.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}comparer.php">Code-Vergleich</a></li>
				{else}
					<li>Code-Vergleich</li>
				{/if}
				{if preg_match( '/^.*draw\.php.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}draw.php">Skizze (alpha)</a></li>
				{else}
					<li>Skizze (alpha)</li>
				{/if}
				{if preg_match( '/^.*drawgraph\.php.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}drawgraph.php">Graph (alpha)</a></li>
				{else}
					<li>Graph (alpha)</li>
				{/if}
				{if preg_match( '/^.*codesearch.*/' , $smarty.server.PHP_SELF ) == false }
					<li><a href="{$backpath}codesearch.php">Code-Suche (alpha)</a></li>
				{else}
					<li>Code-Suche (alpha)</li>
				{/if}
				
		</ul>	
		</div>
		
	
		
</div>
{else}
<div id="pbar">
	<div id="menu">
	Lorem ipsum Lorem ipsum Lorem ipsum<br /> Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum<br />Lorem ipsum Lorem ipsum Lorem ipsum<br />Lorem ipsum Lorem ipsum Lorem ipsum<br />Lorem ipsum Lorem ipsum Lorem ipsum<br />Lorem ipsum Lorem ipsum Lorem ipsum<br />Lorem ipsum Lorem ipsum Lorem ipsum<br />
	</div>
	<div id="login">
	Lorem ipsum Lorem ipsum Lorem ipsum Lore
	</div>
</div>
{/if}
