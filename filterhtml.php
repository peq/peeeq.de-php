<?
function FilterTag($str)
{
	$allowed_attributes = array('style','href','align','width','height','color','size','d','stroke-width','fill','stroke','stroke-linejoin','stroke-linecap','stroke-opacity','fill-opacity','fill','cx','cy','x','y','rx','ry','x1','x2','y1','y2','font-size','points','xlink:href','a0:href','opacity','xmlns:a0','NS1:href','xmlns:NS1');
	
	for ($i=0;$i<50;$i++) {
		$allowed_attributes[]="a".$i.":href";
		$allowed_attributes[]="xmlns:a".$i;
	}

	$output = "";
	global $mysqlconnection;
	
/*
	if (isset($mysqlconnection)) {
		$query = 'INSERT INTO debug(`msg`) VALUES ("'.mysql_real_escape_string($str).'");';
		$data = mysql_query($query);
	}
*/
	
	$pos = 0;
	
	$pos_space = stripos($str," ",$pos);
	if ($pos_space === false)
	{
		$pos_space = strlen($str);
	}
	$tag = substr($str,0,$pos_space);
	
	$output.=$tag;

	
	while(1)
	{
		//Gleichheitszeichen finden
		$equals_pos = stripos($str,"=",$pos);
		if ($equals_pos === false)
		{
			break;
		}
		
		//nach Links gehen:
		$attribute = "";
		$pos2 = $equals_pos;
		while ($pos2 > 0)
		{
			$pos2--;
			if ($str[$pos2] == " ")
			{
				if ($attribute != "")
				{
					break;
				}
			}
			else
			{
				$attribute = $str[$pos2] .$attribute;
			}
		}
		
		//nach rechts gehen:
		$value = "";
		$pos3 = $equals_pos;
		$quoted = false;
		$not_quoted = false;
		while ($pos3 < strlen($str)-1)
		{
			$pos3++;
			if ($str[$pos3] == " ")
			{
				if ($attribute != "") 
				{
					if ($not_quoted)
					{
						break;
					}
					else
					{
						$value.=" ";
					}
				}
			}
			elseif ($str[$pos3] == '"')
			{
				if ($quoted)
				{
					break;
				}
				else
				{
					$quoted = true;
					$quoted_end_pos = $pos3;
					while (1)
					{
						$quoted_end_pos = stripos($str,'"',$quoted_end_pos+1);
						if ($str[$quoted_end_pos-1] == "\\")
						{
						
						
						}
						else
						{
							break;
						}
					}
					
					$value=substr($str,$pos3+1,$quoted_end_pos-1-$pos3);
					
					//echo "<br>$pos3 bis $quoted_end_pos ist $value<br>";
					$pos3 = $quoted_end_pos;
					break;
				}
			}
			elseif ($str[$pos3] == '\\')
			{
				$value.=$str[$pos3].$str[$pos3+1];
				$pos3++;
			}
			else
			{
				if (!$quoted)
				{
					if ($attribute != "")
					{
						$not_quoted = true;
					}
				}
				$value.=$str[$pos3];
			}
		}
		
		//echo "<br /> * $quoted,$not_quoted || $attribute = \"$value\"";

		if (in_array($attribute,$allowed_attributes))
		{
			$output.=" $attribute=\"$value\" ";
		}
		$pos = $pos3;
	}
	
	if ($str[strlen($str)-1] == "/")
	{	
		$output.=" /";
	}
	
	
	//Format
	//<tag attribute1="">
	return $output;
}

function FilterHTML($str)
{
	$allowed_tags = array('p','b','i','u','s','a','em','br','strong','strike','blockquote','tt','hr','div','span','table','tr','td','th','h1','h2','h3','h4','h5','h6','hr','style','font','big','sup','sub','path','text','ellipse','line','rect','polygon','image');
	
	
	
	

	
	//
	$pos = 0;
	$output = '';
	while (true)
	{
		$pos_old = $pos;
		$pos = stripos($str,"<",$pos);
		if ($pos === false)
		{
			$output .= substr($str,$pos_old,strlen($str)-$pos_old);
			break;
		}
		$output .= substr($str,$pos_old,$pos-$pos_old);
		
		$pos_space = stripos($str," ",$pos);
		$pos_endtag = stripos($str,">",$pos);
		if (($pos_space > $pos_endtag) || ($pos_space === false))
			$pos_space = $pos_endtag;
		
		$tag = substr($str,$pos+1,$pos_space-$pos-1);
		$code = substr($str,$pos+1,$pos_endtag-$pos-1);

		
		if ((in_array($tag,$allowed_tags)) || (($tag[0] == "/") && (in_array(substr($tag,1,strlen($tag)-1),$allowed_tags))))
		{
			$output .= "<".FilterTag($code).">";
			//$output .= "<".($code).">";
		}
		else
		{
			//forbidden
		}
		
		
		$pos = $pos_endtag+1;
	}
	
	$output = preg_replace('/href[[:space:]]*=[[:space:]]*["\']*javascript\:/Uis',"",$output);
	
	return $output;
}

/*
$html = '<path d="M32,47 L32,47.5 L31.5,48.5 L31,50 L30.5,53 L29.5,55.5 L28.5,56 L27.5,57 L27,59 L26.5,60.5 L26,62 L26,63.5 L26,65 L26,67 L26,68.5 L25.5,70 L25,72 L25,74 L24.5,75.5 L24,76.5 L24,77.5 L24,78.5 L24,80 L24,81.5 L24,82.5 L24,83.5 L24,84.5 L24,85.5 L24,88 L24.5,90.5 L25,91.5 L25,93 L25,94.5 L25,95.5 L25,96.5 L25,97.5 L25,99 L25,101 L25,102.5 L25,104 L25,105.5 L25,107 L25,109 L25,111 L25,113 L25,115 L25.5,117 L26.5,119 L27.5,120.5 L28,122 L28,124 L28,126 L28,127.5 L28,128.5 L28,130 L28,131.5 L28,133 L28,135.5 L28,137.5 L28,139 L28,141 L28,143 L28,144.5 L28.5,145.5 L29,146" stroke="#000000" stroke-width="9" fill="none" />';

$clean = FilterHTML($html);

echo "<pre>".htmlspecialchars($clean)."</pre><hr>";
echo $clean;
 */
?>
