<?

function getCodeTitle ($_text)
{
	$text = $_text;

	
	$regexps = array(
		"library" => '/library\s+(\w*)/',
		"package" => '/package\s+(\w*)/',
		"scope" => '/scope\s+(\w*)/',
		"class" => '/class\s+(\w*)/',
		"struct" => '/struct\s+(\w*)/',		
		"function" => '/function\s+(\w*)/',
		"method" => '/method\s+(\w*)/'
		);
	foreach ($regexps as $key => $regexp) {
		preg_match($regexp, $text, $treffer);
		if ($treffer != null) {
			return "$key ".$treffer[1];
		}
	}

	

	
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

?>
