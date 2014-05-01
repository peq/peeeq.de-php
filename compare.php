<?

function escape_string($s)
{
	return str_replace('"', '\"', $s);
}

function unescape_string($s)
{
	$r = $s;
	$r = str_replace('&lt;', '<', $r);
	$r = str_replace('&gt;', '>', $r);
	$r = str_replace('&', '&amp;', $r);
	$r = str_replace('<', '&lt;', $r);
	$r = str_replace('>', '&gt;', $r);
	
	
	$r = str_replace('\\"', '"', $r);
	$r = str_replace("\\'", "'", $r);
	$r = str_replace('\\\\', '\\', $r);
	
	//$r = str_replace('\\"', '\\"', $r);
	
	return $r;
}

function fill_line_array($s)
{
	return explode("\n",$s);
}

class linearraycomparer
{
	var $L;
	var $A;
	var $B;
	var $diff;
	function linearraycomparer($A, $B)
	{
		$this->A = $A;
		$this->B = $B;
	}
	
	function lcs_length()
	{
		$L = $this->lcs_tree();
		if (isset($L[0][0]))
			return $L[0][0];
		else
			return 0;
	}
	
	function string_match_percent()
	{
		$A = $this->A;
		$B = $this->B;
		$n = max(sizeof($A),sizeof($B));
		if ($n > 0)
			return $this->lcs_length($A,$B) / $n;
		else
			return 1;
	}
		
	function remove_space($text)
	{
		$r = str_replace(" ","",$text);
		$r = str_replace("	","",$r);
		return $r;
	}
	
	function lcs_tree()
	{
		if ($this->L)
		{
			return $this->L;
		}
		else
		{
			$A = $this->A;
			$B = $this->B;
			$L = array();
			for ($i = sizeof($A)-1; $i >= 0; $i--)
			{
			    for ($j = sizeof($B)-1; $j >= 0; $j--)
			    {
					if (!$A[$i] || !$B[$j])
					{
						$L[$i][$j] = 0;
					}
					elseif ($this->remove_space($A[$i]) == $this->remove_space($B[$j]))
					{
						if (!isset($L[$i+1][$j+1])) $L[$i+1][$j+1] = 0;
						$L[$i][$j] = 1 + $L[$i+1][$j+1];
					}
					else
					{
						if (!isset($L[$i+1][$j])) $L[$i+1][$j] = 0;
						if (!isset($L[$i][$j+1])) $L[$i][$j+1] = 0;
						$L[$i][$j] = max($L[$i+1][$j], $L[$i][$j+1]);
					}
					//echo "$i, $j = ".$L[$i][$j]."<br />";
			    }
			}
			$this->L = $L;
			return $L;
		}
	}
	
	function get_string_difference()
	{
		if ($this->diff)
		{
			return $this->diff;
		}
		else
		{
			$A = $this->A;
			$B = $this->B;
			$L = $this->lcs_tree();
			$i = 0;
		    $j = 0;
			$result = array();
			$result[0][0] = 0;
			$result[1][0] = 0;
		    while ($i < sizeof($A) && $j < sizeof($B))
		    {
				if ($this->remove_space($A[$i])==$this->remove_space($B[$j]))
				{
				    $result[0][$i] = 1;
					$result[1][$j] = 1;
				    $i++; $j++;
				}
				else
				{
					$result[0][$i] = 0;
					$result[1][$j] = 0;
					
					if (!isset($L[$i+1][$j])) $L[$i+1][$j] = 0;
					if (!isset($L[$i][$j+1])) $L[$i][$j+1] = 0;
					
					if ($L[$i+1][$j] >= $L[$i][$j+1]) $i++;
					else $j++;
				}
		    }
			$this->diff = $result;
			return $result;
		}
	}
	
	function make_same_lines_same_height($whichtext)
	{
		$A = $this->A;
		$B = $this->B;
		if ($whichtext)
		{
			$A = $this->B;
			$B = $this->A;
		}
		$diff = $this->get_string_difference();
		$diff0 = $diff[$whichtext];
		$diff1 = $diff[1-$whichtext];
		
		$result = array();
		$j=0;
		$i=0;
		while ($i < sizeof($A)) //&& ($j < sizeof($B)))
		{
			
			if (!isset($diff0[$i])) $diff0[$i] = 0;
			if (!isset($diff1[$j])) $diff1[$j] = 1;
			
			
			
			if ($diff1[$j] == 0)
			{
				if ($diff0[$i] == 0)
				{
					$result [] = $A[$i];
					//$j++;
					$i++;
				}
				else
				{
					$result [] = "////////////////";
					$j++;
				}
			}
			else
			{
				if ($diff0[$i] == 0)
				{
					//$result [] = "C#".$debug."";
					$result [] = $A[$i];
					//$j++;
					$i++;
				}
				else
				{
					$result [] = $A[$i];
					$j++;
					$i++;
				}
			}			
		}

		return $result;
	}
}

class linecomparer
{
	var $L;
	var $A;
	var $B;
	var $diff;
	function linecomparer($A, $B)
	{
		$this->A = $A;
		$this->B = $B;
	}
	
	function lcs_length()
	{
		$L = $this->lcs_tree();
		if (isset($L[0][0]))
			return $L[0][0];
		else
			return 0;
	}

	function string_match_percent()
	{
		$A = $this->A;
		$B = $this->B;
		$n = max(strlen($A),strlen($B));
		if ($n > 0)
			return $this->lcs_length($A,$B) / $n;
		else
			return 1;
	}

	function lcs_tree()
	{
		if ($this->L)
		{
			return $this->L;
		}
		else
		{
			$A = $this->A;
			$B = $this->B;
			$L = array();
			for ($i = strlen($A)-1; $i >= 0; $i--)
			{
			    for ($j = strlen($B)-1; $j >= 0; $j--)
			    {
					if (!$A[$i] || !$B[$j])
					{
						$L[$i][$j] = 0;
					}
					elseif ($A[$i] == $B[$j])
					{
						if (!isset($L[$i+1][$j+1])) $L[$i+1][$j+1] = 0;
						$L[$i][$j] = 1 + $L[$i+1][$j+1];
					}
					else
					{
						if (!isset($L[$i+1][$j])) $L[$i+1][$j] = 0;
						if (!isset($L[$i][$j+1])) $L[$i][$j+1] = 0;
						$L[$i][$j] = max($L[$i+1][$j], $L[$i][$j+1]);
					}
					//echo "$i, $j = ".$L[$i][$j]."<br />";
			    }
			}
			$this->L = $L;
			return $L;
		}
	}


	function get_lcs()
	{
		$A = $this->A;
		$B = $this->B;
		$L = $this->lcs_tree();
		$i = 0;
	    $j = 0;
		$result = "";
	    while ($i < strlen($A) && $j < strlen($B))
	    {
			if ($A[$i]==$B[$j])
			{
			    $result.=$A[$i]; //add A[i] to end of S;
			    $i++; $j++;
			}
			else
			{
				if ($L[$i+1][$j] >= $L[$i][$j+1]) $i++;
				else $j++;
			}
	    }
		return $result;
	}


	function get_string_difference()
	{
		if ($this->diff)
		{
			return $this->diff;
		}
		else
		{
			$A = $this->A;
			$B = $this->B;
			$L = $this->lcs_tree();
			$i = 0;
		    $j = 0;
			$result = array();
			$result[0][0] = 0;
			$result[1][0] = 0;
		    while ($i < strlen($A) && $j < strlen($B))
		    {
				if ($A[$i]==$B[$j])
				{
				    $result[0][$i] = 1;
					$result[1][$j] = 1;
				    $i++; $j++;
				}
				else
				{
					$result[0][$i] = 0;
					$result[1][$j] = 0;
					if (!isset($L[$i+1][$j])) $L[$i+1][$j] = 0;
					if (!isset($L[$i][$j+1])) $L[$i][$j+1] = 0;
					
					if ($L[$i+1][$j] >= $L[$i][$j+1]) $i++;
					else $j++;
				}
		    }
			$this->diff = $result;
			return $result;
		}
	}

	function markup_string_difference($whichstring,$start="<font color=\"red\">",$end="</font>")
	{
		$A = $this->A;
		if ($whichstring)
		{
			$A = $this->B;
		}
		$diff = $this->get_string_difference();
		$diff = $diff[$whichstring];
		
		$result = "";
		$d = 1;
		for ($i=0; $i < strlen($A); ++$i)
		{
			if (!isset($diff[$i])) $diff[$i] = 0;
			if ($diff[$i] != $d)
			{
				if ($d == 1)
				{
					$result.=$start;
				}
				else
				{
					$result.=$end;
				}
				$d = 1 - $d;
			}
			$result.=$A[$i];
			
		}
		if ($d == 0)
		{
			$result.=$end;
		}
		return $result;
	}
} //end of class linecomparer




?>


