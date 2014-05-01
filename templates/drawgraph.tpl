{if $id}
	<p>
		<img style="max-width:100%;" src="graph{$id}.png" alt="{$text}" />
	</p>
	<p>
		Direktlink zum Bild: <a href="graph{$id}.png">http://peeeq.de/graph{$id}.png</a> 
| <a href="graph{$id}.svg">http://peeeq.de/graph{$id}.svg</a> 
	</p>
	
{/if}
<form action="drawgraph.php" method="post" enctype="multipart/form-data">
	<p align="center">
		<textarea name="text" rows="20" cols="80">{$text}</textarea>
	</p>
	<p style="padding-left:100px;">
		<br />Richtung: <select name="rankdir">
			<option value="TB">von Oben nach Unten</option>
			<option value="LR">von Links nach Rechts</option>
			<option value="BT">von Unten nach Oben</option>
			<option value="RL">von Rechts nach Links</option>
		</select>
		<br />Layout-Engine: <select name="engine">
			<option value="dot">dot (gut für Bäume)</option>
			<option value="neato">neato (gut für Graphen)</option>
			<option value="fdp">fdp (gut für Graphen)</option>
			<option value="twopi">twopi (Kreis-Layout)</option>
			<option value="circo">circo (Kreis-Layout)</option>
		</select>
		<br /><input accesskey="s" type="submit" value="speichern" />
	</p>
</form>
<div id="Hilfe" style="padding-left:50px;padding-right:50px;">
<h2>Hilfe:</h2>
<p>
Dieses Tool zeichnet Graphen aus einem einger&uuml;cktem Text. Am besten sieht mand dies an einem einfachen Beispiel. Der folgende Text zeichnet einen Pfeil von Hallo nach Welt, da Welt unter Hallo steht und einger&uuml;ckt ist.</p>
<img src="graph46.png" alt="Hallo Welt Beispiel" style="float:right;"/>
<pre>
Hallo
	Welt
</pre>
<p>
Der selbe Knotenname bezeichnet auch immer den selben Knoten, also kann man mehr zeichnen als nur B&auml;ume. </p>
<p>Kanten kann man beschriften, indem man die Beschriftung 
gefolgt von einem Gr&ouml;&szlig;er-Zeichen vor den Knotennamen schreibt. 
Verschiedene Formen sind ebenfalls mÃglich, dazu schreibt man einfach hinter 
einen Knotennamen getrennt durch einen Doppelpunkt die gewünschte Form (erlaubt
sind: ellipse, box, circle, doublecircle, diamond,
plaintext). Ein Beispiel eines Automaten sollte dies klar machen:</p>
<img src="graph45.png" alt="Automat" style="float:right;" />
<pre>
Start:plaintext
	s0
		a > s1
			a|b > s1
			b > s2:doublecircle
				a > s0
				b > s1
</pre>
<p>
	Mehr Features und eine verbesserte Bedienung werden in Zukunft kommen.
</p></div><div style="clear:both;"></div>
