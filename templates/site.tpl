<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN" "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="{$backpath}{$peqdevu_css}" />
	<link rel="shortcut icon" type="image/x-icon" href="{$backpath}peqsmalllogo.ico" />
	<!-- Step 1: Add a Photos RSS feed to this webpage. //-->
	<link rel="alternate" href="{$backpath}photos.rss" type="application/rss+xml" title="" id="gallery" />


	
	<title>peq - {$title}</title>

	{foreach from=$additional_headers item=additional_header}
		{$additional_header}
	{/foreach}
</head>

<body onload="
{foreach from=$addtional_onloads item=addtional_onload}
{$addtional_onload};
{/foreach}
">
{include file='pbar.tpl'}
<div id="maindiv">
{include file=$main_template}
</div>
{include file='footer.tpl'}

{foreach from=$footer_scripts item=footer_script}
	{$footer_script}
{/foreach}
</body>

</html>
