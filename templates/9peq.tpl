<style type="text/css">
{literal}
h2 {
	float:left; 
	width:300px; 
}
h2 a {
	text-decoration:none;
}

img.lazy {
	box-shadow: 3px 3px 20px #030; width:800px; height:600px; margin: 30px; 
}
{/literal}
</style>

{foreach from=$pictureIds item=picId}
	<h2><a href="draw.php?id={$picId}">Zeichnung #{$picId}</a></h2>
	<img src="zeichnung{$picId}.jpg" 
		class="lazy" width="800" height="600" 
		
		alt="Loading #{$picId}..." />
	<br style="clear:both;" />
{/foreach}
<p style="text-align:center; max-width:800px;">
<a href="/9peq.php?p={$page+1}" style="font-size:20px;">Can I haz more pictures?</a>
</p>


<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/jquery.lazyload.js" type="text/javascript"></script>
<script src="js/9peq.js" type="text/javascript"></script>

