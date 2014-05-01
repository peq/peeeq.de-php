<!--{if $InternetExplorer}
	<div id="logo"><embed width="800" height="600" src="svg.php?id={$id}" pluginspage="http://www.adobe.com/svg/viewer/install/" /></div>
	 
	<script language="JavaScript">
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
	 
	<script language="VBScript">
	' VB Script method to detect SVG viewer in IE
	' this will not be run by browsers with no support for VB Script
	On Error Resume Next
	If useVBMethod = true Then
	    hasSVGSupport = IsObject(CreateObject("Adobe.SVGCtl"))
	End If
	</script>
	 
	<script language="JavaScript">
	// tailored output for SVG and non-SVG users.
	if (hasSVGSupport == true) {
	// use the innerHTML method of the DOM to write in dynamic content to the logo layer
	  document.getElementById('logo').innerHTML = '<embed width="800" height="600"'+
	  'src="svg.php?id={/literal}{$id}{literal}" pluginspage="http://www.adobe.com/svg/viewer/install/" />';
	}else{
	// Alternative output for a user with no SVG support
	  document.getElementById('logo').innerHTML = '
		{if $id}
		<p>Sie brauchen das <a href="http://www.adobe.com/svg/viewer/install/">Adobe SVG-Plugin</a> um 
		diese Skizze im Originalformat anzeigen zu k&ouml;nnen.</p>
		<p><img src="zeichnung{$id}.jpg" /></p>
		{else}

		{/if}
		';
	
	}
	{/literal}
	</script>
	
	<br />
	Um Skizzen malen zu k&ouml;nnen ben&ouml;tigen Sie einen modernen Browser.
{else}-->
	<div style="height:700px;margin-top:30px;">
		<svg style="border-style:solid;border-width:1px; position:absolute;left:10px;top:40px;" 
				id="paint" 
				xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ev="http://www.w3.org/2001/xml-events" version="1.1" baseProfile="full" 
				width="800px" height="600px">
					
					<!--Inhalt der Datei -->
					{$svg}

		</svg>
		<div style="position:absolute;left:10px;top:660px;border-style:solid;border-width:1px;width:800px;height:50px;">
			<div id="bgcolor" style="background-color:#ffffff;position:absolute;left:20px;top:20px;width:25px;height:25px;border-style:solid;border-width:1px;"></div>
			<div id="fgcolor" style="background-color:#ff0000;position:absolute;left:4px;top:4px;width:25px;height:25px;border-style:solid;border-width:1px;"></div>
			<div style="position:absolute;left:50px;top:2px;">
				<div onclick="changecolor('#000000');" style="background-color:#000000;position:absolute;left:0px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ff0000');" style="background-color:#ff0000;position:absolute;left:25px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#00ff00');" style="background-color:#00ff00;position:absolute;left:50px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#0000ff');" style="background-color:#0000ff;position:absolute;left:75px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ffff00');" style="background-color:#ffff00;position:absolute;left:100px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ff00ff');" style="background-color:#ff00ff;position:absolute;left:125px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#00ffff');" style="background-color:#00ffff;position:absolute;left:150px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#003300');" style="background-color:#003300;position:absolute;left:175px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#993300');" style="background-color:#993300;position:absolute;left:200px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#3366cc');" style="background-color:#3366cc;position:absolute;left:225px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ff9900');" style="background-color:#ff9900;position:absolute;left:250px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#33cc00');" style="background-color:#33cc00;position:absolute;left:275px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ccff66');" style="background-color:#ccff66;position:absolute;left:300px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
			</div>
			<div style="position:absolute;left:50px;top:26px;">
				<div onclick="changecolor('#ffffff');" style="background-color:#ffffff;position:absolute;left:0px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#cccccc');" style="background-color:#cccccc;position:absolute;left:25px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#999999');" style="background-color:#999999;position:absolute;left:50px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#666666');" style="background-color:#666666;position:absolute;left:75px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#333333');" style="background-color:#333333;position:absolute;left:100px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#666633');" style="background-color:#666633;position:absolute;left:125px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#336600');" style="background-color:#336600;position:absolute;left:150px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#3366cc');" style="background-color:#3366cc;position:absolute;left:175px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ff6666');" style="background-color:#ff6666;position:absolute;left:200px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ff3300');" style="background-color:#ff3300;position:absolute;left:225px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#000033');" style="background-color:#000033;position:absolute;left:250px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#ffcc66');" style="background-color:#ffcc66;position:absolute;left:275px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				<div onclick="changecolor('#339966');" style="background-color:#339966;position:absolute;left:300px;width:20px;height:20px;border-style:solid;border-width:1px;"></div>
				
			</div>
			<div id="changesize1" onclick="changesize(1);" style="border-left:1px;border-color:red;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:400px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize2" onclick="changesize(2);" style="border-left:2px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:410px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize3" onclick="changesize(3);" style="border-left:3px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:420px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize4" onclick="changesize(4);" style="border-left:4px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:430px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize5" onclick="changesize(5);" style="border-left:5px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:440px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize6" onclick="changesize(6);" style="border-left:6px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:450px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize7" onclick="changesize(7);" style="border-left:7px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:460px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize8" onclick="changesize(8);" style="border-left:8px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:470px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize9" onclick="changesize(9);" style="border-left:9px;border-style:solid;boder-right:0px;border-bottom:0px;border-top:0px;width:10px;position:absolute;left:480px;top:2px;height:46px;background-color:white;"></div>
			<div id="changesize10" onclick="changesize(10);" style="border-left:10px;border-style:solid;boder-right:0;border-bottom:0;border-top:0;width:10px;position:absolute;left:490px;top:2px;height:46px;background-color:white;"></div>
			<div style="border-left:0px;border-style:solid;boder-right:0;border-bottom:0;border-top:0;width:10px;position:absolute;left:500px;top:2px;height:46px;background-color:white;"></div>
			<input style="position:absolute;left:550px;top:10px;" type="button" value="R&uuml;ckg&auml;ngig" onclick="draw_undo();"/>
		</div>

		
		<input style="position:absolute;left:30px;top:750px;" type="button" id="button_speichern" value="Bild speichern" onclick="draw_save({$smarty.get.id});"/>
		{if $admin}<input style="position:absolute;left:650px;top:750px;background-color:red;" type="button" id="button_ban" value="Admin: Bild l&ouml;schen" onclick="draw_ban({$smarty.get.id},2);"/>
		<input style="position:absolute;left:800px;top:750px;background-color:lime;" type="button" id="button_ok" value="Admin: Bild freigeben" onclick="draw_ban({$smarty.get.id},1);"/>
		{/if}
		<div style="position:absolute;left:150px;top:750px;" id="save_result"></div>
		
	</div>
	<script language="javascript">draw_init();</script>
{/if}
