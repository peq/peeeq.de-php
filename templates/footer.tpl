<div id="footer" >
	<span style="position:absolute;left:15px;">
		Diese Seite wurde bis jetzt {$counter} mal aufgerufen.
	</span>
	<span style="position:absolute;text-align:center;width:100%;">
		Parsing done in {$compileTime} seconds 
	</span>
	<span style="position:absolute;right:25px;">
		<a href="{$backpath}impressum.php">Impressum</a><br />
		<a href="{$backpath}source.php?f={php}echo basename($_SERVER['SCRIPT_NAME']);{/php}">Quelltext</a>
	</span>
</div>