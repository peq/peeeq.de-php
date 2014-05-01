<?php

function SaveHTML($str, $allow_font = false, $allow_img = false, $allow_lists = true)
{
	$approvedtags = array(
		'p' => 2,   		// 2 means accept all qualifiers: <foo bar>
		'b' => 1,   		// 1 means accept the tag only: <foo>
		'i' => 1,
		'u' => 1,
		's' => 1,
		'a' => 2,
		'em' => 1,
		'br' => 1,
		'strong' => 1,
		'strike' => 1,
		'blockquote' => 1,
		'tt' => 1,
		'hr' => 1,
		'div' => 2,
		'span' => 2,
		'table' => 2,
		'tr' => 2,
		'td' => 2,
		'th' => 2,
		'h1' => 1,
		'h2' => 1,
		'h3' => 1,
		'h4' => 1,
		'h5' => 1,
		'h6' => 1,
		'hr' => 1,
		'style' => 2
	);

	if ($allow_font == true)
	{
		$approvedtags['font'] = 2;
		$approvedtags['big'] = 1;
		$approvedtags['sup'] = 1;
		$approvedtags['sub'] = 1;
	}

	if ($allow_img == true)
		$approvedtags['img'] = 2;

	if ($allow_lists == true)
	{
		$approvedtags['li'] = 1;
		$approvedtags['ol'] = 1;
		$approvedtags['ul'] = 1;
	}

	$keys = array_keys($approvedtags);

	$str = stripslashes($str);
	$str = eregi_replace("<[[:space:]]*([^>]*)[[:space:]]*>","<\\1>",$str);
	$str = eregi_replace("<a([^>]*)href=\"?([^\"]*)\"?([^>]*)>","<a href=\"\\2\">", $str);

	$tmp = '';
	while (eregi("<([^> ]*)([^>]*)>",$str,$reg))
	{
		$i = strpos($str,$reg[0]);
		$l = strlen($reg[0]);
		if ($reg[1][0] == "/")
			$tag = strtolower(substr($reg[1],1));
		else
			$tag = strtolower($reg[1]);

		if ((in_array($tag, $keys))&&($a = $approvedtags[$tag]))
		{
			if ($reg[1][0] == "/")
				$tag = "</$tag>";
			elseif ($a == 1)
				$tag = "<$tag>";
			else
				$tag = "<$tag " . $reg[2] . ">";
		}
		else
			$tag = '';

		$tmp .= substr($str,0,$i) . $tag;
		$str = substr($str,$i+$l);
	}

	$str = $tmp . $str;

	// Squash PHP tags unconditionally
	$str = ereg_replace("<\?","",$str);

	// Squash comment tags unconditionally
	//$str = ereg_replace("<!--","",$str);

	return $str;
}


?>