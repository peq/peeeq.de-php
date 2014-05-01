<?
class jass_formater
{

	function fill_line_array($_text, &$text_line_array)
	{
		//$time = microtime(1);
		$line_start = array();
		$line_end = array();
		
		$line = 0;
		$pos = 0;
		$line_start[$line] = 0;
		while ($pos = (strpos($_text,"<br />",$pos)))	
		{
			$line_end[$line] = $pos;
			$line++;
			$pos+=strlen("<br />");
			$line_start[$line] = $pos+2;	
		}
		for ($i=0;$i<=$line+1;$i++)
		{
			if ($line > $i)
			{
				if ($i > 0)
					$text_line_array[$i] = rtrim(substr($_text, $line_start[$i], $line_end[$i] - $line_start[$i]));
				else
					$text_line_array[$i] = rtrim(substr($_text, $line_start[$i], $line_end[$i] - $line_start[$i]));
			}
			elseif ($line == $i)
			{
				$text_line_array[$i] = rtrim(substr($_text, $line_start[$i]));			
			}
			else
			{
				//$text_line_array[$i] = 0;	
			}
		}
		//echo "parsing done in ".(microtime(1)-$time)." secs<br />" ;
		
	}
	
	function fill_line_array2($s)
	{
		return explode("\n",$s);
	}


	function begins_with_keyword($line,$keywords,$ignore)
	{
		$line2 = $line;
		foreach ($ignore as $i)
		{
			$line2 = str_replace($i,"",$line2);
		}
		foreach ($keywords as $k)
		{
			if (substr($line2,0,strlen($k)) == $k)
			{
				return true;
			}
		}
		return false;
	}

	function get_first_word($line)
	{
		return substr(ltrim($line),0,strpos($line," "));
	}

	function strpos2($string,$suchwort,$index=0)
	{
		$i=$index;
		$pos=0;
		while (($i-->=0) && ($pos < strlen($string)))
		{
			
			$pos=strpos($string,$suchwort,$pos+1);
			if ($pos == false)
			{
				$pos=strlen($string);
			}
		}
		return $pos;
	}

	function fill_string ($string, $len)
	{
		$r = $string;
		$l = strlen($string);
		while ($l++<$len)
		{
			$r.=" ";
		}
		return $r;
	}

	function set_same_height($text,$suchwort,$index)
	{
		$lines = array();
		$part1 = array();
		$part2 = array();
		
		$linebreak="\n";
		
		$ausgabe="";
		
		//fill_line_array(nl2br(trim($text)),	&$lines);
		$lines = $this->fill_line_array2(trim($text));
		
		
		$maxpos = 0;	
		$n=0;
		foreach ($lines as $line)
		{
			$p = $this->strpos2($line,$suchwort,$index);
			$part1[$n] = substr($line,0,$p);
			$part2[$n] = substr($line,$p,strlen($line)-$p);
			if (($p > $maxpos) && ($p!=strlen($line)) && (($p < strpos($line,"//") || strpos($line,"//") == false)))
			{
				$maxpos = $p;
			}
			$n++;
		}
		
		for($i=0;$i<count($part1);$i++)
		{
			
			$ausgabe.=$this->fill_string($part1[$i], $maxpos);
			$ausgabe.=$part2[$i].$linebreak;
		}
		//echo "<hr>maxpos = $maxpos<br><pre>$ausgabe</pre><hr>";
		return $ausgabe;
	}

	function format_block($block,$type)
	{
		
		$ausgabe=$block;
		if ($type=="local")
		{
			//$ausgabe=set_same_height($ausgabe," array",0);
			$ausgabe=$this->set_same_height($ausgabe," ",1);
			$ausgabe=$this->set_same_height($ausgabe,"=",0);
		}
		elseif ($type=="set")
		{
			$ausgabe=$this->set_same_height($ausgabe,"=",0);
		}
		elseif ($type=="call")
		{
			$ausgabe=$this->set_same_height($ausgabe,"(",0);
		}
		
		return $ausgabe;
	}

	function format_line($line)
	{
		$ausgabe="";
		$has_space=false;
		$must_space=false;
		
		$lasttype="";
		$c_nr = 0;
		while ($c_nr < strlen($line) )
		{ //jedes Zeichen durchgehen
			$c = substr($line, $c_nr, 1);
			$cc = substr($line, $c_nr, 2);
			$ccc = substr($line, $c_nr, 3);
			$cccc = substr($line, $c_nr, 4);
			$ccccc = substr($line, $c_nr, 5);
			if ($c==",")
			{
				//$ausgabe.=$space ? '' : ' ';
				$ausgabe.=", ";
				$has_space=true;
				$must_space=false;
				$lasttype=",";
			}
			elseif(in_array($ccccc,array(" and "," and(",")and ",")and(")))
			{
				//$ausgabe.=$space ? '' : ' ';
				$ausgabe.="$cccc ";
				$has_space=true;
				$must_space=false;
				$c_nr+=3;
				$lasttype="operator";
			}
			elseif(in_array($cccc,array(" or ",")or "," or(",")or(")))
			{
				//$ausgabe.=$space ? '' : ' ';
				$ausgabe.="$ccc ";
				$has_space=true;
				$must_space=false;
				$c_nr+=2;
				$lasttype="operator";
			}
			elseif(in_array($cc,array("==","<=",">=","!=")))
			{
				//$ausgabe.=$space ? '' : ' ';
				$ausgabe.=" $cc ";
				$has_space=true;
				$must_space=false;
				$c_nr++;
				$lasttype="operator";
			}
			elseif(in_array($cc,array("//")))
			{
				//$ausgabe.=$space ? '' : ' ';

				if ($c_nr > 2) {
					$ausgabe.= '  //  ';
				}
				else
				{
					$ausgabe.= '//';
				}
				$ausgabe.=substr($line,$c_nr+2,strlen($line)-$c_nr-2);
				$c_nr = strlen($line) +1;
				$has_space=false;
				$must_space=false;
				$c_nr++;
				$lasttype="comment";
			}
			elseif(in_array($c, array("+","*","/","-","=","<",">")))
			{
				
				//$ausgabe.=$space ? '' : ' ';
				$ausgabe.=" $c ";
				$has_space=true;
				$must_space=false;
				$lasttype="operator";
			}
			elseif(in_array($c, array("(",")","[","]")))
			{
				
				//$ausgabe.=$space ? '' : ' ';
				if (in_array($c, array("(","[")))
				{
					if (in_array($lasttype,array("breaket","comment","char","space")))
					{
						$ausgabe.="$c";
					}
					else
					{
						$ausgabe.=" $c";
					}
				}
				else
				{
					//$ausgabe.='||'.$lasttype.'||';
					//if (in_array($lasttype,array("breaket","comment")))
					$oldc = substr($line, $c_nr-1, 1);
					if ((in_array($c,  array("(",")"))) && (in_array($oldc,  array("(",")"))))
					{
						$ausgabe.="$c";
					}
					else if ((in_array($c,  array("[","]"))) && (in_array($oldc,  array("[","]")))) 
					{
						$ausgabe.="$c";
					}
					else
					{
						$ausgabe.=" $c";
					}
				}
				$has_space=true;
				$must_space=true;
				$lasttype="breaket";
			}
			elseif(($c==" ") || ($c=="	"))
			{
				//$ausgabe.=$space ? '' : ' ';
				
				if (!$has_space)
				{
					$must_space=true;
				}
				$has_space=true;
				$lasttype="space";
			}
			else
			{
				$ausgabe.= $must_space ? ' ' : '';
				$ausgabe.= $c;
				$has_space=false;
				$must_space=false;
				$lasttype="char";
			}
		
			$c_nr++;
		}
		return $ausgabe;
	}




	function format_jass_same_height($input)
	{
		
		
		
		$tab="     ";
		$linebreak="\n";
		$signs = array("+","-","*",",","<",">","=");
		
		$jass_line = array();
		//unnötige leerzeichen entfernen
		$_input = $input;
		//$_input = preg_replace('/\s\s+/', ' ', $_input);
		$_input = str_replace("	","    ",$_input);
		$_input = trim($_input);
		$jass_line = $this->fill_line_array2($_input);
		//fill_line_array(nl2br(trim(str_replace("	","    ",$input2))),	&$jass_line);
		//$ausgabe = "";
		
		
		$ausgabe = '';
		
		$block="";
		$current_type = "";
		
		$line_types = array("local","set","call");
		
		$line_nr=0;
		while ($line_nr < count($jass_line))
		{
			$line = trim($jass_line[$line_nr]);
			
			$line = $this->format_line($line);
			
			//unnötige leerzeichen entfernen
			//$line = preg_replace('/\s\s+/', ' ', $line);
			
			if (($line_nr < count($jass_line) - 1) || ($line!="0"))
			{
				$b = true;
				foreach ($line_types as $line_type)
				{
					if ($this->get_first_word($line) == $line_type)
					{
					
						if ($current_type == $line_type)
						{
							$block.=$line.$linebreak;
						}
						else
						{
							$ausgabe.=$this->format_block($block,$current_type);
							$current_type = $line_type;
							$block = $line.$linebreak;
						}
						$b=false;
					}
				}
				if ($b)
				{	
					if ($current_type != "")
					{
						$ausgabe.=$this->format_block($block,$current_type);
						$block = "";
						$current_type = "";
						
						$ausgabe.=$line.$linebreak;
					}
					else
					{
						
						$ausgabe.=$line.$linebreak;
					}
				}
			}		
			$line_nr++;
		}
		
		return $ausgabe;
	}

	function format_jass_indent($input)
	{
		$indent_keywords = array("function","if","else","elseif","loop","struct","scope","library","globals","method");
		$indent_end_keywords = array("endfunction","endif","else","elseif","endloop","endstruct","endscope","endlibrary","endglobals","endmethod");
		$indent_ignores = array("static","constant","private","public","	"," ");
		
		$same_height_keywords = array("(",")","=",",",);
		
		$tab="     ";
		$linebreak="\n";
		
		$jass_line = array();
		//fill_line_array(nl2br(trim(str_replace("	","    ",$input))),	&$jass_line);
		$_input = $input;
		$_input = str_replace("	","    ",$_input);
		$_input = trim($_input);
		$jass_line = $this->fill_line_array2($_input);
		
		
		
		$ausgabe = "";
		
		$block="";
		
		$tabs = 0;
		$line_nr= 0;
		while ($line_nr < count($jass_line))
		{
			
			$line = trim($jass_line[$line_nr]);
			
			if (($line_nr < count($jass_line) - 1) || ($line!="0"))
			{
				if ($this->begins_with_keyword($line,$indent_end_keywords,$indent_ignores))
				{
					$tabs--;
					
					
				}		
				for ($i=0;$i<$tabs;$i++)
				{
					$ausgabe.=$tab;
				}
				$ausgabe.=$line.$linebreak;
				if ($this->begins_with_keyword($line,$indent_keywords,$indent_ignores))
				{
					$tabs++;
					//function interface ausnahme
					if ($this->begins_with_keyword($line,array("functioninterface"),$indent_ignores))
					{
						$tabs--;
					}
				}
			}	
			$line_nr++;
		}
		$ausgabe.=$block;
		
		//echo "<pre>$ausgabe</pre>";
		return $ausgabe;
	}

	function format($input, $indent = true, $same_height = true)
	{
		$ausgabe = $input;
		if ($same_height)
		{
			$ausgabe=$this->format_jass_same_height($ausgabe);
		}
		if ($indent)
		{
			$ausgabe=$this->format_jass_indent($ausgabe);
		}
		return $ausgabe;
	}
}
?>