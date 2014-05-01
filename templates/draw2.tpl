<!--{if $InternetExplorer}
	<div id="logo"><embed width="800" height="600" src="svg.php?id={$id}" pluginspage="http://www.adobe.com/svg/viewer/install/" /></div>
	 
	<script type="text/javascript">
	var id = {$id};
	{literal}
	// Boolean variable to keep track of user's SVG support
	var hasSVGSupport = false;
	 
	// Boolean to determine if we need to use VB Script method or not to find SVG support
	var useVBMethod = false;
	 
	/* Internet Explorer returns 0 as the number of MIME types,
	   so this code will not be executed by it. This is our indication
	  to use VBScript to detect SVG support.  */ 
	if (navigator.mimeTypes != null && navigator.mimeTypes.length > 0) {
	    if (navigator.mimeTypes["image/svg-xml"] != null)
	        hasSVGSupport = true;
	}else{
	    useVBMethod = true;
	}
	</script>
	 
	<script type="text/VBScript">
	' VB Script method to detect SVG viewer in IE
	' this will not be run by browsers with no support for VB Script
	On Error Resume Next
	If useVBMethod = true Then
	    hasSVGSupport = IsObject(CreateObject("Adobe.SVGCtl"))
	End If
	</script>
	 
	<script type="text/javascript">
	// tailored output for SVG and non-SVG users.
	if (hasSVGSupport == true) {
	// use the innerHTML method of the DOM to write in dynamic content to the logo layer
	  document.getElementById('logo').innerHTML = '<embed width="800" height="600"'+
	  'src="svg.php?id={/literal}{$id}{literal}" pluginspage="http://www.adobe.com/svg/viewer/install/" />';
	}else{
	// Alternative output for a user with no SVG support
		if (id > 0) {
	  document.getElementById('logo').innerHTML = 
		'<p>Sie brauchen das <a href="http://www.adobe.com/svg/viewer/install/">Adobe SVG-Plugin</a>' +
		' oder einen modernen Browser um diese Skizze vollständig (als SVG-Datei) anzeigen zu k&ouml;nnen.</p>' +
		'<p><img src="zeichnung'+id+'.jpg" /></p>';
		}
	}
	{/literal}
	</script>
	
	<br />
	Um Skizzen malen zu k&ouml;nnen ben&ouml;tigen Sie einen modernen Browser.
{else}-->
<div id="paintcontainer">
	
	<div id="Tools">
		<ul id="Tools_tabbar" style="height: 30px;"> 
			<li><a href="#Tools_Paint"><span>Paint</span></a></li> 
			<li><a href="#Tools_Datei"><span>Datei</span></a></li> 
			<li><a href="#Tools_Einstellungen"><span>Einstellungen</span></a></li> 
			<li><a href="#Tools_Hilfe"><span>Hilfe</span></a></li> 
		</ul> 
		<div id="Tools_Paint"> 
			<ul class="Tools_Paint">
				<li class="Tools_Paint" id="Tools_Paint_Pen" title="Freihand-Zeichnung">Stift</li>
				<li class="Tools_Paint" id="Tools_Paint_Line" title="Linie zeichnen">Linie</li>
				<li class="Tools_Paint" id="Tools_Paint_Curve" title="Kurve aus kubischen Bezierkurven durch Angabe von Stützpunkten zeichnen">Kurve</li>
				<li class="Tools_Paint" id="Tools_Paint_CurvePen" title="kubische Bezierkurve mit dem Stift zeichnen">Kurve2</li>
				<li class="Tools_Paint" id="Tools_Paint_SplinePen" title="Kurve aus kubischen Bezierkurven mit dem Stift zeichnen">Kurve3</li>
				
				<li class="Tools_Paint" id="Tools_Paint_Ellipse" title="Ellipse zeichnen">Ellipse</li>
				<li class="Tools_Paint" id="Tools_Paint_Rect" title="Rechteck zeichnen">Rechteck</li>
				<li class="Tools_Paint" id="Tools_Paint_Polygon" title="gefüllte Form zeichnen">Polygon</li>
				<li class="Tools_Paint" id="Tools_Paint_Text" title="Text einfügen">Text</li>
				<li class="Tools_Paint" id="Tools_Paint_Image" title="Bild einfügen">Bild</li>
			</ul>
			<br style="clear:both;"/><br /><input type="button" value="Oberstes Element löschen" id="undo" />
			<br /><br /><input type="button" value="Start-Ansicht wiederherstellen" id="reset_view" />
		<div style="clear:both;"></div>
		</div> 
		<div id="Tools_Datei"> 
				<input id="save" type="button" value="Bild speichern" />
				<input id="parent" type="hidden" value="{$smarty.get.id}"/>
				<input disabled="disabled" type="button" value="Bild speichern unter ..." />
				<div id="save_feedback"></div>
		</div> 
		<div id="Tools_Einstellungen"> 
			<fieldset>
				<legend>Einstellungen</legend>
				<table>
					<tr>
						<td><label for="Tools_Settings_Smoothing">Smoothing:</label></td>
					<td><input type="text" id="Tools_Settings_Smoothing" name="Tools_Settings_Smoothing" value="2" style="width:100px;" /></td>
					</tr>
				</table>

			</fieldset>
		</div> 
		<div id="Tools_Hilfe">
		Nicht-Offensichtliche Dinge:
		<br />- Durch drehen des Mausrades kann man rein- und rauszoomen
		<br />- Bei gedrückter mittlerer Maustaste lässt sich der Ausschnitt hin und her bewegen
		<br />- Durch Doppelklick auf eine Farbe in der Farbpalette öffnet sich ein Farbauswahldialog.
		<br />- Durch drehen des Mausrades über der Anzeige für die aktuell gewählte Farbe lässt sich die Transparenz regulieren.
		</div>
	</div>
	<div id="paint">
		
	</div>
	<div id="pensettings" style="margin-left:10px;">
	
	</div>
<div style="clear:both;"></div>
</div>


<script type="text/javascript">
{if $viewbox}
{$viewbox}
{/if}
</script>
{/if}
