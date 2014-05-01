<?php


class GuiParser
{
	
	var $text_line_array;
	var $line_tabs;
	
	function GuiParser()
	{
		$this->text_line_array = array();
		$this->line_tabs = array();
	}
	
	function ParseGui($input, $argv)
	{

		return convert_gui($input, "./extensions/GuiParserPics/", $argv, 0);
		
	}

	function ParseTrigger($input, $argv)
	{

		return convert_gui($input, "./extensions/GuiParserPics/", $argv , 2);
		
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
		//echo "get_symbol( $_text )<br>";
		$text = str_replace(" ","",$_text);
		//echo $text."<br>";
		if (substr($text,0,4) == "Wait")
		{
				return "wait";
		} 
		else if (substr($text,0,3) == "Set")
		{
			return "set";
		} 
		else if ((substr($text,0,2) == "KI") || (substr($text,0,2) == "AI"))
		{
			return "ki";
		} 
		else if (substr($text,0,8) == "--------")
		{
			return "comment";
		} 
		else if (substr($text,0,9) == "Animation")
		{
			return "animation";
		} 
		else if ((substr($text,0,6) == "Kamera") || (substr($text,0,6) == "Camera"))
		{
			return "cam";
		} 
		else if ((substr($text,0,5) == "Video") || (substr($text,0,9) == "Cinematic"))
		{
			return "cam";
		} 
		else if ((substr($text,0,15) == "Countdown-Timer") || (substr($text,0,14) == "CountdownTimer") || (substr($text,0,4) == "Time") || (substr($text,0,4) == "Zeit") )
		{
			return "timer";
		} 
		else if ((substr($text,0,11) == "Zerstörbar") || (substr($text,0,12) == "Destructible"))
		{
			return "destructable";
		} 
		else if (substr($text,0,6) == "Zerst�rbar")
		{
			return "destructable";
		} 
		else if (substr($text,0,6) == "Dialog")
		{
			return "dialog";
		} 
		else if ((substr($text,0,8) == "Umgebung") || (substr($text,0,11) == "Environment"))
		{
			return "enviroment";
		} 
		else if ((substr($text,0,11) == "Spiel-Cache") || (substr($text,0,9) == "GameCache"))
		{
			return "set";
		} 
		 
		else if ((substr($text,0,4) == "Held") || (substr($text,0,4) == "Hero"))
		{
			return "hero";
		}  
		else if ((substr($text,0,10) == "Gegenstand") || (substr($text,0,4) == "Item"))
		{
			return "item";
		}  
		else if ((substr($text,0,11) == "Bestenliste") || (substr($text,0,11) == "Leaderboard"))
		{
			return "quest";
		}  
		else if ((substr($text,0,8) == "Nahkampf") || (substr($text,0,5) == "Melee"))
		{
			return "mellee";
		}  
		else if (substr($text,0,10) == "Multiboard")
		{
			return "quest";
		}  
		else if (substr($text,0,7) == "Neutral")
		{
			return "neutral";
		}  
		else if ((substr($text,0,7) == "Spieler") || (substr($text,0,6) == "Player"))
		{
			return "player";
		} 
		else if ((substr($text,0,5) == "Spiel") || (substr($text,0,4) == "Game"))
		{
			return "game";
		}  
		else if (substr($text,0,4) == "Quest")
		{
			return "quest";
		}   
		else if ((substr($text,0,6) == "Gebiet") || (substr($text,0,4) == "Rect"))
		{
			return "rect";
		}   
		else if ((substr($text,0,7) == "Auswahl") || (substr($text,0,9) == "Selection"))
		{
			return "selection";
		}   
		else if (substr($text,0,5) == "Sound")
		{
			return "sound";
		}   
		else if ((substr($text,0,13) == "Spezialeffekt") || (substr($text,0,13) == "SpecialEffect"))
		{
			return "animation";
		}   
		else if ((substr($text,0,7) == "Einheit") || (substr($text,0,4) == "Unit"))
		{
			return "unit";
		}   
		else if ((substr($text,0,12) == "Sichtbarkeit") || (substr($text,0,10) == "Visibility"))
		{
			return "visibility";
		} 
		else
			return "page";
		
	}

	function make_aufklapp_picture($div_id,$src1,$src2)
	{
		$result= '<img style="border: 0px;vertical-align: middle;" src="'.$src1.'"
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
		>';
		
		return $result;
	}


	function convert_gui($_trigger, $symbolpath, $args = 0, $arg_noheader = 2 )
	{
		
		//Hier die maximale Höhe eintragen :
		$max_height = 400;
		
		$trigger = nl2br(htmlspecialchars(trim($_trigger)))."<br />";
		$trigger = str_replace("\'","'",$trigger);
		$ausgabe = '';
		$source = '';
		
		
		$noheader = (isset($args['noheader'])) ? 2 : $arg_noheader;
		$header = ($noheader==0) ? 1 : 0;;
		$open_divs = 0;
		$bedingungen = -1;
		$blocks2close = 0;
		$nextlinecode = '';
		$trigger_name = "";
		$intend_line = array();
		//$line_tabs = array();
		//$text_line_array = array();
		$this->fill_line_array($trigger);
		
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
			
			$ausgabe.='<span>';
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
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'base.gif">';
					$ausgabe.=$line;
					//$ausgabe.='<br>';
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
						$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'line.gif">';
					}
					else
					{
						$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'empty.gif">';
					}
				}	
				
				
				
				if ($this->get_intended($this->text_line_array,$line_nr,1) == 0)
				{
					//keine Einrückungen
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'join.gif">';
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
						//$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinminus.gif">';
						$div_id = uniqid("block_") ;
						$src1 = ''.$symbolpath.'joinminus.gif';
						$src2 = ''.$symbolpath.'joinplus.gif';
						$ausgabe.=$this->make_aufklapp_picture($div_id,$src1,$src2);
						$nextlinecode.='<div id="'.$div_id.'">';
						$open_divs++;
					}
					else
					{
						//$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinbottomminus.gif">';
						$div_id = uniqid("block_") ;
						$src1 = ''.$symbolpath.'joinbottomminus.gif';
						$src2 = ''.$symbolpath.'joinbottomplus.gif';
						$ausgabe.=$this->make_aufklapp_picture($div_id,$src1,$src2);
						$nextlinecode.='<div id="'.$div_id.'">';
						$open_divs++;
					}
				} 
				else
				{
					//Ende einer Einrückung
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'joinbottom.gif">';
					$intend_line[$tabs]=0;
					$blocks2close = $this->get_intended($this->text_line_array,$line_nr,1);				
					//$ausgabe.=$blocks2close;
				}
				
				$line_type = $this->get_type(trim($line));
				if ($line_type == 1 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'events.gif">';
				}
				else if ($line_type == 2 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'cond.gif">';
					if ($bedingungen == -1)
					{
						$bedingungen=$tabs;
					}
				}
				else if ($line_type == 3 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'actions.gif">';
				}
				else if ($line_type == 4 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'struct.gif">';
				}
				else if ($line_type == 5 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'actions.gif">';
				}
				else if ($line_type == 6 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'struct.gif">';
				}
				else if ($line_type == 7 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'cond.gif">';
					if ($bedingungen == -1)
					{
						$bedingungen=$tabs;
					}
				}
				else if ($line_type == 8 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'actions.gif">';
				}
				else if ($line_type == 9 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'actions.gif">';
				}
				else if ($line_type == 10 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'force.gif">';
				}
				else if ($line_type == 11 )
				{
					$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'group.gif">';
				} else 
				{
					//Aktion
					if ($bedingungen == -1)
					{
						$ausgabe.='<img style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-bottom:0px;border: 0px;vertical-align: middle;" src="'.$symbolpath.$this->get_symbol(trim($line)).'.gif">';
					} 
					else
					{
						$ausgabe.='<img style="border: 0px;vertical-align: middle;" src="'.$symbolpath.'struct.gif">';
					}				
				}
				$ausgabe.=$line;
				//$ausgabe.='<br>';
			}
			$ausgabe.="</span>";
			
			if ((($line_nr != 0) && ($noheader==1)) || ($noheader!=1))
			{
				$ausgabe.="<br />";
			}
			
			
			$ausgabe.='
			';
			for ($c=0;$c<$blocks2close;$c++)
			{
				if ($open_divs > 0)
				{
					//$ausgabe.="\r\n</div>";
					$ausgabe.="</div>";
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
		$ausgabe = str_replace("Ã„","Ä",$ausgabe);
		$ausgabe = str_replace("Ãœ","Ü",$ausgabe);
		$ausgabe = str_replace("Ã–","Ö",$ausgabe);
		$ausgabe = str_replace("Ã¤","ä",$ausgabe);
		$ausgabe = str_replace("Ã¼","ü",$ausgabe);
		$ausgabe = str_replace("Ã¶","ö",$ausgabe);
		$ausgabe = str_replace("ÃŸ","ß",$ausgabe);

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
		
		#this is strange... it's interpreted by the wikiparser. But it works atm. Better not touch this string!
		$ausgabe2 = '';
		$ausgabe2.=	'<nowiki><div style="margin: 5px 20px 20px;">';
		if (isset($args['text'])) 
		{
			if ($args['text']!='false'){
			$ausgabe2.='<div style="font: 11px verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif; margin-bottom: 2px;">Trigger:</div>';
			}
		}
		$ausgabe2.='<div style="font-family:Tahoma,Arial;font-size:11px;color:#000000; background-color:#FFFFFF; margin-top:0px; margin-bottom:0px; border:1px solid #999999;white-space: nowrap; width: 97%;overflow:'.$scroll.'; line-height:10px; height:'.$height.'px;">';
		$ausgabe2.=$ausgabe;
		$ausgabe2.='</div></div></nowiki>';
		
		
		return $ausgabe2;
	}

}

?>
