<?
function code_css($cssdata = null)
{
$result='';

if ($cssdata == null)
{
	//load cssdata from database
	$query = 'SELECT cssdata FROM styles WHERE `id` = 1;';
	$style = mysql_fetch_array(mysql_query($query));
	$cssdata = $style['cssdata'];
}


//if (preg_match("/MSIE/i",$_SERVER['HTTP_USER_AGENT']))
//	return '';

//if (preg_match("/MSIE/i",$_SERVER['HTTP_USER_AGENT']))
//	$result.= '<script type="text/css">'; //fuck MS
//else
	$result.= '<style type="text/css">';

eval ('$classes = array('.$cssdata.');');


foreach ($classes as $class)
{
	$result.="".$class['name']."\n{";
	unset ($class['name']);
	foreach ($class as $key => $val)
	{
		$result.="$key:$val;\n";
	}
	$result.="}\n";
}


//if (preg_match("/MSIE/i",$_SERVER['HTTP_USER_AGENT']))
//	$result.= '</script>'; //fuck MS
//else
	$result.= '</style>';
	
	//echo "<pre>$result</pre>";
	return $result;
}

?>