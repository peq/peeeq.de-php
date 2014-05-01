<?php


class GuiParser
{
	var $output_style = "html";
	var $symbols = array(	
		"Wait" => "wait",
		"Set" => "set",
		"KI" => "ki",
		"AI" => "ki",
		"--------" => "comment",
		"Animation" => "animation",
		"Kamera" => "cam",
		"Camera" => "cam",
		"Video" => "cam",
		"Cinematic" => "cam",
		"Countdown-Timer" => "timer",
		"CountdownTimer" => "timer",
		"Time" => "timer",
		"Zeit" => "timer",
		"Zerstörbar" => "destructable",
		"Destructible" => "destructable",
		"Zerst�rbar" => "destructable",
		"Dialog" => "dialog",
		"Umgebung" => "environment",
		"Spiel-Cache" => "set",
		"GameCache" => "set",
		"Held" => "hero",
		"Hero" => "hero",
		"Gegenstand" => "item",
		"Item" => "item",
		"Bestenliste" => "quest",
		"Leaderboard" => "quest",
		"Nahkampf" => "mellee",
		"Melee" => "mellee",
		"Multiboard" => "quest",
		"Neutral" => "neutral",
		"Spieler" => "player",
		"Player" => "player",
		"Spiel" => "game",
		"Game" => "game",
		"Quest" => "quest",
		"Gebiet" => "rect",
		"Rect" => "rect",
		"Auswahl" => "selection",
		"Selection" => "selection",
		"Sound" => "sound",
		"Spezialeffekt" => "animation",
		"SpecialEffect" => "animation",
		"Einheit" => "unit",
		"Unit" => "unit",
		"unit" => "unit",
		"Sichtbarkeit" => "visibility",
		"Visibility" => "visibility",
		
		
		
		"Ereignisse" => "events",
		"Events" => "events",
		"Bedingungen" => "cond",
		"Conditions" => "cond",
		"Aktionen" => "actions",
		"Actions" => "actions",
		"Foreach" => "struct",
		"Schleifen-Aktionen" => "actions",
		"Loop-Actions" => "actions",
		"'IF'" => "cond",
		"If-Conditions" => "cond",
		"'THEN'" => "actions",
		"Then-Actions" => "actions",
		"'ELSE'" => "actions",
		"Else-Actions" => "actions",
		"If" => "struct",
		"Spielergruppe" => "force",
		"PlayerGroup" => "force",
		"Einheitengruppe" => "group",
		"UnitGroup" => "group",
		);
	
	//Funktionen f�r die Ausgabe:
	function  make_picture($src)
	{
		if ($this->output_style == "html")
		{
			return '<img alt="X" style="border: 0px;vertical-align: middle;" src="'.$src.'" />';
		}
		elseif ($this->output_style == "bb")
		{
			$symbolpath = "http://peq.pe.ohost.de/GuiParserPics/";
			if ($src == $symbolpath."joinminus.gif")
			{
				return "  &#9547; ";
			}
			else if ($src == $symbolpath."line.gif")
			{
				return "  &#9475; ";
			}
			else if ($src == $symbolpath."join.gif")
			{
				return "  &#9504; ";
			}
			else if ($src == $symbolpath."joinbottomminus.gif")
			{
				return "  &#9547; ";
			}
			else if ($src == $symbolpath."joinbottom.gif")
			{
				return "  &#9495; ";
			}
			else if ($src == $symbolpath."joinbottomminus.gif")
			{
				return "  &#9547; ";
			}
			else if ($src == $symbolpath."joinminus.gif")
			{
				return "  &#9547; ";
			}

			else if ($src == $symbolpath."empty.gif")
			{
				return "&nbsp; &nbsp; ";
			}
			
		
			return "[img]".$src."[/img]"; 
		}
		else
		{
			return '';
		}
	}
	
	
	
	function make_finish_line($line)
	{
		if ($this->output_style == "html")
		{
			return "<span>$line</span>";
		}
		elseif ($this->output_style == "bb")
		{
			return trim($line).'<br />
'; 
		}
		else
		{
			return $line;
		}
	}
	
	function make_linebreak()
	{
		if ($this->output_style == "html")
		{
			return '<br />
';
		}
		else
		{
			return '';
		}
	}
	
	function make_aufklapp_picture($div_id,$src1,$src2)
	{
		if ($this->output_style == "html")
		{
			$result= '<img alt="+" style="border: 0px;vertical-align: middle;" src="'.$src1.'"
			onclick = \'
			my_node = document.getElementById("'.$div_id.'");
			if ( my_node.style.visibility=="hidden" )
			{
				joinminus = new Image(); 
				joinminus.src = "'.$src1.'"; 
				this.src = joinminus.src;
				my_node.style.visibility="inherit";
				my_node.style.position = "static";
			} else {
				joinplus = new Image(); 
				joinplus.src = "'.$src2.'"; 
				this.src = joinplus.src;
				my_node.style.visibility="hidden";
				my_node.style.position = "absolute";
			}
			\'
			/>';
			return $result;
		}
		elseif ($this->output_style == "bb")
		{
			return $this->make_picture($src1);
			//return "[img]".$src1."[/img]"; 
		}
		else
		{
			return '';
		}
		
		
	}
	
	function make_block($div_id="")
	{
		if ($this->output_style == "html")
		{
			if ($div_id == "")
			{
				return '<div>';
			}
			else
			{
				return '<div id="'.$div_id.'">';
			}
		}
		else
		{
			return '';
		}
	}
	
	function make_endblock()
	{
		if ($this->output_style == "html")
		{
			return '</div>';
		}
		else
		{
			return '';
		}
	}
		
	function make_end_text($args, $scroll, $height, $ausgabe)
	{
		$ausgabe2 = '';
		if ($this->output_style == "html")
		{
			$ausgabe2.=	'<div style="margin: 5px 20px 20px;">';
			if (isset($args['text'])) 
			{
				if ($args['text']!='false'){
					$ausgabe2.='<div style="font: 11px verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif; margin-bottom: 2px;">
									Trigger:
								</div>';
				}
			}
			$ausgabe2.='<div style="font-family:Tahoma,Arial;font-size:11px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999;white-space: nowrap; width: 97%;overflow:'.$scroll.'; line-height:10px; height:'.$height.'px;">';
			$ausgabe2.=$ausgabe;
			$ausgabe2.='</div>
						</div>';
		}
		elseif ($this->output_style == "bb")
		{
			$ausgabe2.=	'<div style="margin: 5px 20px 20px;">';
			if (isset($args['text'])) 
			{
				if ($args['text']!='false'){
				$ausgabe2.='<div style="font: 11px verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif; margin-bottom: 2px;">Trigger:</div>';
				}
			}
			$ausgabe2.='<textarea style="font-family:Tahoma,Arial;font-size:12px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999;white-space: nowrap; width: 97%;overflow:'.$scroll.'; height:'.$height.'px;">
			[code]';
			$ausgabe2.=str_replace("<br />", "
", $ausgabe);
			$ausgabe2.='
			[/code]</textarea></div>';
		}		
		else
		{
			$ausgabe2=$ausgabe;
		}
		return $ausgabe2;
	}
	
	var $text_line_array;
	var $line_tabs;
	
	function GuiParser()
	{
		$this->text_line_array = array();
		$this->line_tabs = array();
	}
	
	function ParseGui($input, $argv = array(), $relativepics = true, $output = "html")
	{
		$this->output_style = $output;
		
		$picpath = $relativepics ? "GuiParserPics/" : "http://peq.pe.ohost.de/GuiParserPics/";
	
		return $this->convert_gui($input, $picpath, $argv, "auto");
		
	}
	
	//obsolete
	function ParseTrigger($input, $argv)
	{

		return $this->convert_gui($input, "./extensions/GuiParserPics/", $argv = array() , "auto");
		
	}
	


	##--------real code--------


	function fill_line_array($_text)
	{
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
		for ($i=0;$i<=$line+10;$i++)
		{
			if ($line > $i)
			{
				if ($i > 0)
					$this->text_line_array[$i] = rtrim(substr($_text, $line_start[$i], $line_end[$i] - $line_start[$i]));
				else
					$this->text_line_array[$i] = rtrim(substr($_text, $line_start[$i], $line_end[$i] - $line_start[$i]));
			}
			else
				$this->text_line_array[$i] = 0;	
		}
	}

	function get_tabs($_text)
	{
		//echo "get_tabs( $_text )<br>";
		$text = $_text;
		$pos = 0;
		$tabs = 0;
		while (substr($text,$pos,4) == "    ")
		{
		 $pos+=4;
		 $tabs++;
		}
		return $tabs;
	}
	function get_line_tabs($_text_line, $line)
	{
		//echo "get_line_tabs( $line )<br>";
		if ( ! isset($this->line_tabs[$line]))
		{
			//$line_tabs[$line] = get_tabs(get_line($_text,$line));
			$this->line_tabs[$line] = $this->get_tabs($_text_line[$line]);
		}	
		return $this->line_tabs[$line];
	}


	function get_intended($_text_line,$linenr,$offset)
	{
		//echo "get_intended( $linenr, $offset)<br>";
		return $this->get_line_tabs($_text_line,$linenr) - $this->get_line_tabs($_text_line,$linenr + $offset);
	}

	function get_type($_text)
	{
		//echo "get_type ( $_text )<br>";
		$text = str_replace(" ","",$_text);
		//echo $text."<br>";
		//echo 'get_type( '.$text." )<br>"; 
		if ((substr($text,0,10) == "Ereignisse") || (substr($text,0,6) == "Events"))
		{
				return 1;
		} 
		else if ((substr($text,0,11) == "Bedingungen") || (substr($text,0,10) == "Conditions"))
		{
			return 2;
		}
		else if ((substr($text,0,8) == "Aktionen") || (substr($text,0,7) == "Actions"))
		{
			return 3;
		}
		else if (substr($text,0,7) == "Foreach") 
		{
			return 4;
		}
		else if ((substr($text,0,18) == "Schleifen-Aktionen") || (substr($text,0,12) == "Loop-Actions"))
		{
			return 5;
		}
		else if ((substr($text,0,4) == "'IF'") || (substr($text,0,13) == "If-Conditions"))
		{
			return 7;
		}
		else if ((substr($text,0,6) == "'THEN'") || (substr($text,0,12) == "Then-Actions"))
		{
			return 8;
		}
		else if ((substr($text,0,6) == "'ELSE'") || (substr($text,0,12) == "Else-Actions"))
		{
			return 9;
		}
		else if (substr($text,0,2) == "If") 
		{
			return 6;
		}
		else if ((substr($text,0,13) == "Spielergruppe") || (substr($text,0,11) == "PlayerGroup"))
		{
			return 10;
		}
		else if ((substr($text,0,15) == "Einheitengruppe") || (substr($text,0,9) == "UnitGroup"))
		{
			return 11;
		}
		else 
		{
			return 0;
		}
	}

	function get_symbol($_text)
	{
		$text = str_replace(" ","",$_text);
		$result = "page";
		
		foreach (array_keys($this->symbols) as $symbol_key)
		{
			if ((substr($text,0,strlen($symbol_key)) == $symbol_key ))
			{
				$result = $this->symbols[$symbol_key];
				break;
			}
		}

	
		
			
	
		return $result;

	}

	


	function convert_gui($_trigger, $symbolpath, $args = array(), $arg_noheader = "auto" )
	{
		
		//Hier die maximale Höhe eintragen :
		$max_height = 400;
		
		$trigger = nl2br(htmlspecialchars(trim($_trigger)))."<br />";
		$trigger = str_replace("\'","'",$trigger);
		$ausgabe = '';
		$source = '';
		
		
		$noheader = (isset($args['noheader'])) ? 2 : $arg_noheader;
		$header = ($noheader==0) ? 1 : 0;
		$open_divs = 0;
		$bedingungen = -1;
		$blocks2close = 0;
		$nextlinecode = '';
		$trigger_name = "";
		$intend_line = array();
		//$line_tabs = array();
		//$text_line_array = array();
		$this->fill_line_array($trigger);
		
		if ($arg_noheader = "auto")
		{
			if ((trim($this->text_line_array[1]) == 'Ereignisse') || (trim($this->text_line_array[1]) == 'Events')) 
			{
				$noheader = 2;
				
			}
			else
			{
				$noheader = 0;
			}	
			$header = ($noheader==0) ? 1 : 0;			
		}
		
		
		for ($i=0;$i<=10;$i++)	$intend_line[$i]=0;
		
		$line_nr = 0;	
		while ($line = $this->text_line_array[$line_nr])
		{
			//echo $line;
			if ($nextlinecode != '')
			{
				$ausgabe.=$nextlinecode;
				$nextlinecode='';
			}
			
			//$ausgabe.=$this->make_begin_line();//'<span>';
			$ausgabe_line = '';
			
			$tabs = $this->get_line_tabs($this->text_line_array,$line_nr);
			//echo $tabs;
			if ($bedingungen != -1)
			{
				if ($this->get_line_tabs($this->text_line_array,$line_nr) <= $bedingungen)
				{
					$bedingungen = -1;
				}
			}
			
			
			if (($tabs == 0) && ($header == 0)  )
			{
				if (($line != "Ereignisse") && ($line != "Bedingungen") && ($line != "Aktionen") && ($line != "no_header"))
				{
					$ausgabe_line.= $this->make_picture($symbolpath.'base.gif'); //'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'base.gif">';
					$ausgabe_line.=$line;
					//$ausgabe_line.='<br>';
					$header ++;
					$trigger_name = $line;
				}
				else
				{
					if ($line == "Bedingungen")
					{
						$bedingungen=$tabs;
						
					}
					if ($line != "no_header")
						$line_nr--;
					else
						$noheader = 1;
					$header++;
				}			
			} else {
				for ($i=1+($trigger_name != "" ? 1 : 0 );$i<=$this->get_line_tabs($this->text_line_array,$line_nr);$i++)	
				{
					//Einrückungen
					if ($intend_line[$i])
					{
						$ausgabe_line.= $this->make_picture($symbolpath.'line.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'line.gif">';
					}
					else
					{
						$ausgabe_line.= $this->make_picture($symbolpath.'empty.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'empty.gif">';
					}
				}	
				
				
				
				if ($this->get_intended($this->text_line_array,$line_nr,1) == 0)
				{
					//keine Einrückungen
					$ausgabe_line.=$this->make_picture($symbolpath.'join.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'join.gif">';
				} 
				else if ($this->get_intended($this->text_line_array,$line_nr,1) == -1)
				{
					//Einrüclung nach rechts
					$a=1;
					$intended_lines = 0;
					while ($this->get_intended($this->text_line_array,$line_nr,$a)<0) $a++;
					
					if (($this->get_intended($this->text_line_array,$line_nr,$a)==0) && ($this->text_line_array[$a]!="") )
					{
						$intended_lines++;
						$intend_line[$tabs+1]=1;
					}
					else
					{
						$intend_line[$tabs+1]=0;
					}
					if ($intended_lines > 0)
					{
						//$ausgabe_line.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinminus.gif">';
						$div_id = uniqid("block_") ;
						$src1 = ''.$symbolpath.'joinminus.gif';
						$src2 = ''.$symbolpath.'joinplus.gif';
						$ausgabe_line.=$this->make_aufklapp_picture($div_id,$src1,$src2);
						$nextlinecode.=$this->make_block($div_id);//'<div id="'.$div_id.'">';
						$open_divs++;
					}
					else
					{
						//$ausgabe_line.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinbottomminus.gif">';
						$div_id = uniqid("block_") ;
						$src1 = ''.$symbolpath.'joinbottomminus.gif';
						$src2 = ''.$symbolpath.'joinbottomplus.gif';
						$ausgabe_line.=$this->make_aufklapp_picture($div_id,$src1,$src2);
						$nextlinecode.=$this->make_block($div_id);//'<div id="'.$div_id.'">';
						$open_divs++;
					}
				} 
				else
				{
					//Ende einer Einrückung
					$ausgabe_line.=$this->make_picture($symbolpath.'joinbottom.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinbottom.gif">';
					$intend_line[$tabs]=0;
					$blocks2close = $this->get_intended($this->text_line_array,$line_nr,1);				
					//$ausgabe_line.=$blocks2close;
				}
				
				$line_type = $this->get_type(trim($line));

				if ($line_type == 2 )
				{
					$ausgabe_line.=$this->make_picture($symbolpath.'cond.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'cond.gif">';
					if ($bedingungen == -1)
					{
						$bedingungen=$tabs;
					}
				}
				else if ($line_type == 7 )
				{
					$ausgabe_line.=$this->make_picture($symbolpath.'cond.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'cond.gif">';
					if ($bedingungen == -1)
					{
						$bedingungen=$tabs;
					}
				}
				else 
				{
					//Aktion
					if ($bedingungen == -1)
					{
						$ausgabe_line.=$this->make_picture($symbolpath.$this->get_symbol(trim($line)).'.gif');//'<img style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-bottom:0px;border: 0px;vertical-align: middle;" src="'.$symbolpath.$this->get_symbol(trim($line)).'.gif">';
					} 
					else
					{
						$ausgabe_line.=$this->make_picture($symbolpath.'struct.gif');//'<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'struct.gif">';
					}				
				}
				$ausgabe_line.=trim($line);
				//$ausgabe_line.='<br>';
			}
			//$ausgabe.=$this->make_end_line();
			$ausgabe.=$this->make_finish_line($ausgabe_line);
			
			if ((($line_nr != 0) && ($noheader==1)) || ($noheader!=1))
			{
				$ausgabe.=$this->make_linebreak();//"<br />";
			}
			
			
			$ausgabe.='
';
			for ($c=0;$c<$blocks2close;$c++)
			{
				if ($open_divs > 0)
				{
					//$ausgabe.="\r\n</div>";
					$ausgabe.=$this->make_endblock();//"</div>";
					$open_divs--;
				}
			}
			$blocks2close = 0;
			
			$line_nr++;
		}	
		
		#fixed the Unicode-Bug with german letters
		//egal, was ich mache - wenn ich einen Auslöser aus dem Editor irgendwo hin kopiere werden die Sonderzeichen falsch angezeigt
		//ich nehm den Teil deshalb wieder rein, damit man nicht jedes mal von Hand die Umlaute ändern muss
		//da wohl kaum einer in nem Trigger "Ã„" schreibt, wird es auch keinen stören
		//Außerdem denk ich, dass das Problem nicht nur bei mir auftritt, da man auch im inWarcraft-Forum immer wirder diese Zeichen sieht.
		// mfg peq
		
		
		$ausgabe = str_replace("ä","&auml;",$ausgabe);
		$ausgabe = str_replace("ö","&ouml;",$ausgabe);
		$ausgabe = str_replace("ü","&uuml;",$ausgabe);

		$ausgabe = str_replace("�&amp;#8222;","&Auml;",$ausgabe);
		$ausgabe = str_replace("�&amp;#8211;","&Ouml;",$ausgabe);
		$ausgabe = str_replace("�&amp;#339;","&Uuml;",$ausgabe);
		$ausgabe = str_replace("�&amp;#376;","&szlig;",$ausgabe);
		
		$ausgabe = str_replace("Ä","&Auml;",$ausgabe);
		$ausgabe = str_replace("Ö","&Ouml;",$ausgabe);
		$ausgabe = str_replace("Ü","&Uuml;",$ausgabe);
		$ausgabe = str_replace("ß","&szlig;",$ausgabe);
		
		$ausgabe = str_replace("\r","",$ausgabe);
		$ausgabe = str_replace("\n","",$ausgabe);
		
		//Höhe :
		$height = 16*($line_nr - (($noheader==0) ? 0 : 1));
		//für den Internet-Explorer:
		$height += 20; 
		if ($height>$max_height)
		{
			$height = $max_height;
			$scroll = 'auto';
		}
		else
		{
			//$scroll='auto';
			$scroll = 'auto';
		}
		
			
		$ausgabe2 = $this->make_end_text($args, $scroll, $height, $ausgabe);
		
		
		return $ausgabe2;
	}

}

?>
