<?php 

function my_obstart() 
{ 
	$encode = getenv("HTTP_ACCEPT_ENCODING");
	if(ereg("gzip",$encode)) { 
		ob_start("ob_gzhandler"); 
	} 
	else 
	{ 
		ob_start(); 
	} 
} 
if (!isset($_GET['no_cache']))
{
	my_obstart(); // Führt die Funktion nun aus
}

?>