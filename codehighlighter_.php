<?

class languagedata
{
	var $case_sensitive = true;
	var $elements_in_array = array();
	var $elements_in_array_by_len = array();
	var $elements_until_end = array();
	var $elements_start_to_end = array();
	
	var $elements_until_end_first = array();
	var $elements_start_to_end_first = array();
	
	var $elements_regexp = array();
	
	var $shorts;
	
	
	var $delimiters = array();
	
	function cs($element)
	{
		if (!$this->case_sensitive)
		{
			return strtolower($element);
		}
		else
		{
			return $element;
		}
	}
	
	// +set
	function add_element_in_array($element, $tag)
	{
		$element = $this->cs($element);
		$this->elements_in_array[$element] = $tag;
		$this->elements_in_array_by_len[strlen($element)][$element] = $tag;
	}
	
	function add_element_until_end($element, $tag)
	{
		$element = $this->cs($element);
		$this->elements_until_end[$element] = $tag;
		$this->elements_until_end_first[$element[0]][$element] = $tag;
	}
	
	function add_element_start_to_end($element_start, $element_end, $tag)
	{
		$element_start = $this->cs($element_start);
		$element_end = $this->cs($element_end);
		$this->elements_start_to_end[$element_start] = array('TAG' => $tag,'START' => $element_start, 'END' => $element_end);
		$this->elements_start_to_end_first[$element_start[0]][$element_start] = array('TAG' => $tag,'START' => $element_start, 'END' => $element_end);
	}
	
	function add_element_regexp($element, $tag)
	{
		$this->elements_regexp[$element] = $tag;
	}
	// -set
	
	function get_element_in_array_tag($element)
	{
		$element = $this->cs($element);
		if (isset($this->elements_in_array[$element]))
		{
			return $this->elements_in_array[$element];
		}
		return false;
	}
	
	function get_element_in_array_tag_fast($element, $len)
	{
		$element = $this->cs($element);
		if (isset($this->elements_in_array_by_len[$len][$element]))
		{
			return $this->elements_in_array_by_len[$len][$element];
		}
		return false;
	}
	
	function get_element_until_end_tag($element)
	{
		$element = $this->cs($element);
		if (isset($this->elements_until_end[$element]))
		{
			return $this->elements_until_end[$element];
		}
		return false;
	}
	
	
	function get_element_start_to_end_tag($element)
	{
		$element = $this->cs($element);
		if (isset($this->elements_start_to_end[$element]))
		{
			return $this->elements_start_to_end[$element];
		}
		return false;
	}
	
	var $regexp_count = 0;
	function get_element_regexp_tag($element)
	{
		foreach ($this->elements_regexp as $regexp => $tag)
		{
			if (preg_match($regexp, $element))
			{
				return $tag;
			}
		}
		return false;
	}
	
	function is_delimiter($element)
	{
		if (isset($this->delimiters[$element]))
		{
			return true;
		}
		return false;
	}
	
	function debug_print()
	{
		echo "<pre>";
		echo "<h3>delimiters</h3>";
		print_r($this->delimiters);
		echo "<h3>elements_in_array</h3>";
		print_r($this->elements_in_array);
		echo "<h3>elements_in_array_by_len</h3>";
		print_r($this->elements_in_array_by_len);
		echo "<h3>elements_until_end</h3>";
		print_r($this->elements_until_end);
		echo "<h3>elements_start_to_end</h3>";
		print_r($this->elements_start_to_end);
		echo "<h3>elements_regexp</h3>";
		print_r($this->elements_regexp);
		echo "</pre><hr />";
	}
	
	
	function load_array($a)
	{
		//load delimiters
		$this->delimiters = array_flip($a['DELIMITERS']);
		unset($a['DELIMITERS']);
		
		if (isset($a['CASE_SENSITIVE']))
		{
			$this->case_sensitive = !(!$a['CASE_SENSITIVE']);
			unset($a['CASE_SENSITIVE']);
		}
		
		//loop through all tags...
		foreach ($a as $tag => $e0)
		{   	
			foreach ($e0 as $e)
			{
				if ($e['TYPE'] == 'IN_ARRAY')
				{
					//loop through all array elemnts...
					foreach ($e['ARRAY'] as $element)
					{
						$this->add_element_in_array($element, $tag);
					}
				}
				elseif ($e['TYPE'] == 'UNTIL_END')
				{
					$this->add_element_until_end($e['START'], $tag);
				}
				elseif ($e['TYPE'] == 'REGEXP')
				{
					$this->add_element_regexp($e['REGEXP'], $tag);
				}
				elseif ($e['TYPE'] == 'START_TO_END')
				{
					$this->add_element_start_to_end($e['START'], $e['END'], $tag);
				}
				else
				{
					echo "Corrupted Language-Data-Array. Error in line ". __LINE__;
				}
			}
		}		
	}
}

class highlightstyle
{
	var $styles = array();
	
	function get_style($tag)
	{
		if (isset($this->styles[$tag]))
		{
			return $this->styles[$tag];
		}
		return '%%';
	}
	
	function create_styled_text ($text, $tag)
	{
		$style = $this->get_style($tag);
		$text2=$text;
		$text2 = str_replace("<","&lt;",$text2);
		$text2 = str_replace(">","&gt;",$text2);
		//$text2 = str_replace(" ","&nbsp;",$text2);
		return str_replace('%%', $text2, $style);
	}
	
	function create_styled_text_raw ($text, $tag)
	{
		$style = $this->get_style($tag);
		$text2=$text;
		//$text2 = str_replace("<","&lt;",$text2);
		//$text2 = str_replace(">","&gt;",$text2);
		//$text2 = str_replace(" ","&nbsp;",$text2);
		return str_replace('%%', $text2, $style);
	}
	
	function load_array($a)
	{
		$this->styles = $a;
	}
}


class codehighlighter
{
	var $lines;
	function codehighlighter($lines)
	{
		$this->lines = $lines;
	}
	
	function insert_highlight($line, $from, $to, $hl_start = '<span class="highlight">', $hl_end = '</span>')
	{
		//echo "<br /><br />$from - $to ".htmlspecialchars($line)."  <br />\n";
		//return $line;
		$result = '';
		
		
		$intag = false;
		$hl = false;
		$ignore_next = false;
		$add_start = false;
		
		$pos = 0;
		$real_pos = 0;
		$len = strlen($line);
		$c = "";
		
		while ($pos < $len)
		{
			$c = $line[$pos];
			if ($intag)
			{
				if ($c == ">")
				{
					$intag = false;
					if ($hl)
					{
						$add_start = true;
						//$result.= $hl_start;
					}
				}
			}
			else
			{
				if ($c == "<")
				{
					$intag = true;
					if (($real_pos == $to))
					{
						$result.=$hl_end;
						$hl=false;
					}
					else if ($hl)
					{
						if (!$ignore_next)
						{						
							$result.= $hl_end;
						}
						$ignore_next = false;
					}
				}
				else
				{
					if (($real_pos == $from))
					{
						//echo "real_pos == from<br />";
						$hl = true;
						if ($line[$pos] == "<")
						{
							//echo "line[pos]+1 == &lt;";
							$ignore_next = true;
							//$result.="<";
							//$pos++;
							//$intag=true;
						}
						else
						{
							//echo "adding hl_start<br />";
							$result.=$hl_start;
						}
					}
					if (($real_pos == $to))
					{
						$result.=$hl_end;
						$hl=false;
					}
					if (!$intag)
					{
						$real_pos++;
					}
				}
			}
			$result.=$line[$pos];
			if ($add_start)
			{
				$result.= $hl_start;
				$add_start = false;
			}
			
			//echo "($pos, $real_pos, ". (($intag) ? "true" : "false") .") ".htmlspecialchars($result)." <br />\n";
			
			$pos++;
		}
		
		return $result;
		
	}
	
	function insert_highlight_old($line, $from, $to)
	{
		$soll = substr(strip_tags($line), $from, $to-$from);
		
		
		
		$result = '';
		
		$hl = false;
		$intag = false;
		
		$open = false;
		$start_after_endtag = false;
		

		
		
		
		//loop through chars
		$pos = 0;
		$real_pos = 0;
		$len = strlen($line);
		while ($pos < $len)
		{
			//echo "$pos || $real_pos || ". $line[$pos] . "<br />";
			
			if ((!$hl) && (!$intag) && ($real_pos == $from))
			{
				$result.= '<span class="highlight">';
				$hl = true;
			}			
			
			
			
			if ($intag)
			{
				$result.=$line[$pos];
				if ($line[$pos] == '>')
				{
					$intag = false;
					if ($start_after_endtag)
					{
						$start_after_endtag = false;
						$result.='<span class="highlight">';
					}
				}
				
			}
			else //not intag
			{
				
				if ($line[$pos] == '<')
				{
					$intag = true;
										
					if ($line[$pos+1] == '/')
					{
						$open = false;
						if (($hl) && ($real_pos >= $from) && ($real_pos < $to))
						{
							$result.='</span>';
							$start_after_endtag = true;
							
						}
					}
					else
					{
						$open = true;
					}
					
					$result.=$line[$pos];
				}
				else
				{
					$result.=$line[$pos];
					++$real_pos;
				}
				
				if (($hl) && ($real_pos == $to))
				{
					$result.= '</span>';
					$hl = false;
				}	
			}
			
			
			
			++$pos;
		}
		
		if ($hl)
		{
			$result.= '</span>';
		}
		$result = str_replace('<span class="highlight"></span>', '', $result);
		echo "<pre>\n\n".htmlspecialchars($line). "\n". htmlspecialchars($result) ."\n</pre>";
		
		return $result;
	}
	
	function fill_line_array($s)
	{
		return explode("\n",trim($s));
	}
	
	function parse_code($language_data, $highlight_style)
	{
		$output_lines = array();
		

		
	
		//go through all lines
		
		//temp 
		$cur_tag = '';
		$cur_end = '';
		
		$line_nr = 0;
		foreach($this->lines as $line)
		{
			$line_nr++;
			$add_lines = substr_count($line, "\n");
			//cut off right whitespace
			$line = rtrim($line);
			//replace tabs by 4 spaces
			$line = str_replace("\t","    ",$line);
			
			
			
			//manage highlights with @@ or ##
			$highlight_line = false;
			if (substr($line, 0, 2) == '##')
			{
				$highlight_line = true;
				$line = substr($line, 2);
			}
			$highlight_part_a = array();
			$highlight_part = false;
			$highlight_count = 0;
			$pos = 0;
			while (1)
			{
				$pos = strpos($line, "@@", $pos);
				if ($pos === false)
				{
					if ((isset($highlight_part_a[$highlight_count-1]['START'])) && (!isset($highlight_part_a[$highlight_count-1]['END'])))
					{
						$highlight_part_a[$highlight_count-1]['END'] = strlen($line);
					}					
					break;
				}
				else
				{
					if ($highlight_part)
					{
						//end
						$highlight_part_a[$highlight_count-1]['END'] = $pos - 4 * $highlight_count + 2;
						
					}
					else
					{
						//start
						$highlight_part_a[$highlight_count]['START'] = $pos - 4 * $highlight_count;
						++$highlight_count;						
					}
					$highlight_part = !$highlight_part;
					++$pos;
				}
				++$pos;
			}
			
			if ($highlight_count)
			{
				$line = str_replace("@@","",$line);

			}
			
			
			$pos = 0;
			$output_line = '';
			if (!$cur_tag)
			{
				//find the first no whitespace character
				$pos = strlen($line) - strlen(ltrim($line));
				$output_line.= substr($line,0,$pos);
			}
			else
			{
				
                $end_pos = strpos($line, $cur_end);
				if ($end_pos === false)
				{
					$output_line.= $highlight_style->create_styled_text($line , $cur_tag);
					$pos = strlen($line);
					//continue;
				}
				else
				{
					$pos = $end_pos+strlen($cur_end);
					$output_line.= $highlight_style->create_styled_text(substr($line, 0, $pos) , $cur_tag);
					$cur_tag = '';
					$cur_end = '';
					
				}				
			}
			
			//temp strings
			$word = '';
			$endword = false;
			$add = '';
			
			//loop through remaining chars
			$len = strlen($line);
			while ($pos < $len)
			{
				
				
				$c = array();
				
				$c[0] = $line[$pos];
				for ($o = 1; ($o + $pos < $len) && ($o < 3); $o++ )
				{
					$c[$o] = $c[$o-1] . $line[$pos + $o];
				}
				
				/*if ((isset($c[1])) && ($c[1] == '@@'))
				{
					if ($highlight_part)
					{
						$highlight_part = false;
						//$word.= '</span>';
					}
					else
					{
						$highlight_part = true;
						//$word.= '<span class="highlight">';
					}
					$pos+=2;
					continue;
				}
				*/
				
				
				
				$found = false;
				/* old way
				for ($c_pos = sizeof($c)-1; $c_pos >= 0; $c_pos--)
				{
					$cc = $c[$c_pos];
					
					if ($tag = $language_data->get_element_until_end_tag($cc))
					{
						$endword = true;
						$add = $highlight_style->create_styled_text(substr($line, $pos) , $tag);
						$pos = strlen($line);
						$found = true;
						break;
					}
					elseif ($data = $language_data->get_element_start_to_end_tag($cc))
					{
						
						$tag = $data['TAG'];
						$end = $data['END'];
						$end_pos = strpos($line, $end, $pos + $c_pos + 1);
						if ($end_pos === false)
						{
							$endword = true;
							$add = $highlight_style->create_styled_text(substr($line, $pos) , $tag);
							$pos = strlen($line);
							//save tag and end for next line
							$cur_tag = $tag;
							$cur_end = $end;
						}
						else
						{
							$endword = true;
							$add = $highlight_style->create_styled_text(substr($line, $pos, $end_pos - $pos + strlen($end)) , $tag);
							$pos = $end_pos + $c_pos;
						}
						$found = true;
						break;
					}				
				}
				*/
				//Altrenative : andersrum...
				if (isset($language_data->elements_until_end_first[$c[0]]))
				{
					$found_tag = '';
					$found_tag_len = 0;
					foreach ($language_data->elements_until_end_first[$c[0]] as $element => $tag)
					{
						$element_len = strlen($element)-1;
						if (isset($c[$element_len]) &&($element == $c[$element_len]))
						{
							if ($element_len >= $found_tag_len)
							{
								$found_tag = $tag;
								$found_tag_len = $element_len;
							}
						}
						
							
					}
					if ($found_tag != '')
					{
						
						$tag = $found_tag;
						$endword = true;
						$add = $highlight_style->create_styled_text(substr($line, $pos) , $tag);
						$pos = strlen($line);
						$found = true;
						//break;
					}
				}
				
				
				if (!$found)
				{
					if (isset($language_data->elements_start_to_end_first[$c[0]]))
					{
						$found_tag = '';
						$found_data;
						$found_tag_len = 0;
						foreach ($language_data->elements_start_to_end_first[$c[0]] as $element => $data)
						{
							
							$element_len = strlen($element)-1;
							if (isset($c[$element_len]) &&($element == $c[$element_len]))
							{
								if ($element_len >= $found_tag_len)
								{	
									$found_tag = $data['TAG']; //undefined variable tag?
									$found_data = $data;
									$found_tag_len = $element_len;
								}
							}
						}
						if ($found_tag != '')
						{
							$data = $found_data;
							$tag = $data['TAG'];
							$end = $data['END'];
							$end_pos = strpos($line, $end, $pos + $element_len + 1);
							if ($end_pos === false)
							{
								$endword = true;
								$add = $highlight_style->create_styled_text(substr($line, $pos) , $tag);
								$pos = strlen($line);
								//save tag and end for next line
								$cur_tag = $tag;
								$cur_end = $end;
							}
							else
							{
								$endword = true;
								$add = $highlight_style->create_styled_text(substr($line, $pos, $end_pos - $pos + strlen($end)) , $tag);
								$pos = $end_pos + $element_len;
							}
							$found = true;
							//break;
						}
					}
				}
				
				
				
				if (!$found)
				{
					if ($tag = $language_data->get_element_in_array_tag($c[0]))
					{
						$add = $highlight_style->create_styled_text($c[0], $tag);
						$endword = true;
					}					
					elseif ($language_data->is_delimiter($c[0]))
					{
						$add = $c[0];
						$endword = true;
					}				
				}
				
				
				
				if (!$endword)
				{
					$word.= $c[0];
				}
				else
				{	//endword
					if ($word != '')
					{
						if ($tag = $language_data->get_element_in_array_tag($word))
						{
							$output_line.= $highlight_style->create_styled_text($word, $tag);
						}
						elseif ($tag = $language_data->get_element_regexp_tag($word))
						{
							$output_line.= $highlight_style->create_styled_text($word, $tag);
						}
						else
						{
							$output_line.= $word;
						}
					}
					$endword = false;
					$word = '';
				}
				
				if ($add != '')
				{
					$output_line.= $add;
					$add = '';
				}
				
				
				//----
				++$pos;
			}
			if ($word != '') //REST
			{
				if ($tag = $language_data->get_element_in_array_tag($word))
				{
					$output_line.= $highlight_style->create_styled_text($word, $tag);
				}
				elseif ($tag = $language_data->get_element_regexp_tag($word))
				{
					$output_line.= $highlight_style->create_styled_text($word, $tag);
				}
				else
				{
					$output_line.= $word;
				}
				$word = '';
			}
			
			if ($output_line == "")
			{
				$output_line = " ";
			}
			
			
			if ($highlight_line)
			{
				$output_line = $highlight_style->create_styled_text_raw($output_line,"HIGHLIGHT_LINE");//"<li class='highlight_line'>$output_line</li>";
			}
			else
			{
				$output_line = $highlight_style->create_styled_text_raw($output_line,"NORMAL_LINE");//"<li class='normal_line' style=''>$output_line</li>";
			}
			
			
			
			foreach ($highlight_part_a as $x)
			{
				$output_line = $this->insert_highlight($output_line, $x['START'], $x['END']);
			}
			
			for ($i=0; $i < $add_lines; $i++)
			{
				$output_line.=$highlight_style->create_styled_text_raw($line_nr,"NULL_LINE");//"\n<li value='$line_nr' class='nullline'></li>";
			}
			

			
			
			$output_lines[] = $output_line;
			
		}
		

		$output = '';
		foreach ($output_lines as $output_line)
		{
			$output.="$output_line\n";
		}
		$output=$highlight_style->create_styled_text_raw($output,"BLOCK");
		return $output;
		//return $output_lines;
	}
	
}
/*
//test

$test = 
'
123@@4@@5@@6789abcdefghijklm@@n
//! library CSSafety
//******************************************************************************************
//*
//* CSSafety 14.5
//* ��������
//*
//*  Utilities to@@ make things safer. Currently this simpl@@y includes @@a @@timer recycling
//* Stack. Once you replace CreateTimer with NewTimer and DestroyTimer with ReleaseTimer
//* you no longer have to @@c@@are about se@@t@@t@@i@@ng timers to null nor about timer related issues
//* with the handle index stack.
//*
//******************************************************************************************

//==========================================================================================
##globals
    pri@@vat@@e timer array T
    private@@ integer@@ N = 0
endglobals

//==========================================================================================
function NewTimer takes nothing returns timer
    if (N==0) then
        return CreateTimer()
    endif
 set N=N-1
 return T[N]
endfunction

//==========================================================================================
function ReleaseTimer takes timer t returns nothing
    call PauseTimer(t)
    if (N==8191) then
        debug call BJDebugMsg("Warning: Timer stack is full, destroying timer!!")

        //stack is full, the map already has much more troubles than the chance of bug
        call DestroyTimer(t)
    else
        set T[N]=t
        set N=N+1
    endif    
endfunction
//! endlibrary


';

$time = microtime(1);
$ld = new languagedata();
$ld->load_array($language_data);
//$ld->debug_print();
echo "languagedata init in ".(microtime(1)-$time)." secs<br />" ;

$time = microtime(1);
$hs = new highlightstyle();
$hs->load_array($style_data);
echo "highlightstyle init in ".(microtime(1)-$time)." secs<br />" ;

$lines  = array(
'function f$oo$ takes nothing returns string ',
'	local integer i = 0.8 //comment
	
	
',
'   return "Hallo, das 
',
'	ist ein String',
'	der �ber mehrere ',
'	Zeilen geht." ',
'endfunction //comment'

);

//$ch = new codehighlighter(fill_line_array($test));
$ch = new codehighlighter($lines);

$time = microtime(1);
$ch->parse_code($ld, $hs);
echo "parsing done in ".(microtime(1)-$time)." secs<br />" ;
*/
class easycodehighlighter
{
	var $language_id;
	var $style_id;
	
	var $language_name;
	
	var $code;
	var $output;
	var $code_css;
	
	var $language = false;
	var $format_script;
	
	function fill_line_array($s)
	{
		return explode("\n",$s);
	}
	function strip_markup($s)
	{
		return str_replace('##', '', str_replace('@@', '', $s));
	}

	
	function easycodehighlighter($input, $default_lang, $language_id = null, $style_id = null, $format_output = false)
	{
		$this->code = $input;
		$output_lines = '';
		
		$this->language = false;
		if ($language_id != null)
		{
			//try to load language
			$query = 'SELECT data, defaultstyle, `id`, `name` FROM languages WHERE `id` = "'.$language_id.'";';
			$this->language = mysql_fetch_array(mysql_query($query));
		}
		if (!$this->language)
		{
			//load default language
			$query = 'SELECT data, defaultstyle, `id`, `name` FROM languages WHERE `name` = "'.$default_lang.'";';
			$this->language = mysql_fetch_array(mysql_query($query));
			
		}	
		
			
		if ($this->language)
		{
			$this->language_id = $this->language['id'];
			$this->format_script = 'format_'.$this->language['name'].'.php';
			
			
			if (file_exists($this->format_script) != '')
			{
				if ($format_output)
				{
					require_once('format_'.$this->language['name'].'.php');
					//$my_jass_formater = new jass_formater();
					eval('$my_formater = new '.$this->language['name'].'_formater();');
					
					$this->code = $my_formater->format($this->strip_markup($this->code),true,true);
				}
			}
			else
			{
				$this->format_script = null;
			}
			
			$code_lines = null;
			if (is_array($this->code))
			{
				$code_lines = $this->code;
			}
			else
			{
				$code_lines = $this->fill_line_array($this->code);
			}
			
			
			
			eval('$language_data = array('.$this->language['data'].');');
			$ld = new languagedata();
			$ld->load_array($language_data);

			//$style_id = 0;
			$style = null;
			$cssdata = null;
			if ($style_id)
			{
				$query = 'SELECT data, cssdata FROM styles WHERE `id` = "'.$style_id.'";';
				$style = mysql_fetch_array(mysql_query($query));
				if (!$style)
				{
					$style_id = 0;
				}
				$cssdata = $style['cssdata'];
				$style = $style['data'];
			}
			
			if ($style_id == 0)			
			{
				//load default value of language
				$style_id = $this->language['defaultstyle'];
				$query = 'SELECT data, cssdata FROM styles WHERE `id` = "'.$style_id.'";';
				$style = mysql_fetch_array(mysql_query($query));
				$cssdata = $style['cssdata'];
				$style = $style['data'];
				
			}


			$this->code_css = code_css($cssdata);
			
			
			$this->style_id = $style_id;
			
			eval('$style_data = array('.$style.');');
			$hs = new highlightstyle();
			$hs->load_array($style_data);
			
			
			$ch = new codehighlighter($code_lines);
			
			$output = $ch->parse_code($ld, $hs);
		}
		else
		{  //no language definend
			$this->language_id = 0;
			$code_lines = fill_line_array($this->code);
			$output='<textarea>';
			for($i=0;$i<sizeof($code_lines);$i++)
			{
				$output_lines[$i] = "".$code_lines[$i]."\n";
			}
			$output='</textarea>';
		}
			
			
			$this->output = $output;	
	}
}


?>