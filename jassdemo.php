<?

require_once('enable_gzip.php');
require_once('mysql_cfg.php');
require_once('code_css.php'); 



$lang = "jass";


 



function escape_string($s)
{
	return str_replace('"', '\"', $s);
}

function unescape_string($s)
{
	return str_replace('\"', '"', $s);
}

function fill_line_array($s)
{
	return explode("\n",$s);
}

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}

function get_firtst_line ($_text)
{
	$text = nl2br(trim($_text));
	$pos = strpos($text,"<br />");
	if ($pos)
	{
		return strip_markup(substr($text,0, $pos));
	}
	else
	{
		return strip_markup($text);
	}	
}
require_once("codehighlighter.php");




if (isset($_POST['code']))
{
	
	
	
	
	
	$code = stripslashes(unescape_string($_POST['code']));
	$code = str_replace("<", "&lt;", $code);
	$code = str_replace(">", "&gt;", $code);


	$ech = new easycodehighlighter($code, 'jass', 1, true, true);
	$hlcode = $ech->output;
	
	echo $ech->code_css;
	
	echo "<pre>$hlcode</pre>";
	
	
	
	
}



echo '

<form action="jassdemo.php" method="post">
<textarea name="code" cols="50" rows="30" style="width:95%">
';
if (isset($_POST['code']))
{
	echo strip_markup(($ech->code));
}

echo '
</textarea>
<br />
<input type="submit">
</form>';
?>