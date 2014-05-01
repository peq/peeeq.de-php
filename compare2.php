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

	var $A;
	var $B;
	var $offsets = array();
	var $blankLines = array(array(),array());
	
	function linearraycomparer($A, $B)
	{
		$this->A = $A;
		$this->B = $B;
		
		
		$tempfile1 = "./svgtemp/text1.txt";
		$tempfile2 = "./svgtemp/text2.txt";
		
		file_put_contents($tempfile1, implode("\n", $A)."\n");
		file_put_contents($tempfile2, implode("\n", $B)."\n");
		
		//$difffile =  "svgtemp/diff.txt";
		$diffOutputAr = array();
		$result = 1337;
		$r = exec("/usr/bin/diff $tempfile1 $tempfile2", $diffOutputAr, $result); 
		
		if ($result < 0) {
			die('Konnte Programm diff nicht ausfuehren. Fehler-Code: '.$result);
		}
		
		$diffOutput = implode("\n", $diffOutputAr);
		// debug
		//$diffOutput = file_get_contents("diff.txt");
		
		
		$this->parseDiffOutput($diffOutput);
		
		
	}
	
	function parseDiffOutput($diffOutput) {
		$matches = array();
		$changes = preg_match_all("@\n(([0-9]+)(,([0-9]+))?)(a|c|d)(([0-9]+)(,([0-9]+))?)@",  "\n".$diffOutput, $matches, PREG_SET_ORDER);
		foreach ($matches as $match ) {

			$this->offsets[] = array($match[2], $match[7]);
			if (!$match[4]) {
				$match[4] = $match[2];
			}
			if (!$match[9]) {
				$match[9] = $match[7];
			}			
			
			$this->offsets[] = array($match[4], $match[9]);
		
		}
		
		// guardian entry
		$this->offsets[] = array(1 + max(count($this->A), count($this->B)), 1 + max(count($this->A), count($this->B)));
		
		
		
		$balance = 0; // how much lines has b been forwarded - how many lines has a been forwarded
		foreach ($this->offsets as $offset) {
			$a = $offset[0];
			$b = $offset[1];
			$gap = $balance + $b - $a;
			if ($gap < 0) {
				// add blank lines to b:
				$this->blankLines[1][] = array($b, -$gap);
			} elseif ($gap > 0) {
				// add blank lines to a:
				$this->blankLines[0][] = array($a, $gap);
			}
			$balance -= $gap;			
		}
		
		
		
	}
	
	
	function make_same_lines_same_height($whichtext) {
		$lines = "";
		if ($whichtext) {
			$lines = $this->B;
		} else {
			$lines = $this->A;
		}		
		$result = array();
		
		
		
		$blankAddPos = 0;
		for ($lineNr=0; $lineNr < count($lines); $lineNr++) {
			while (($blankAddPos < count($this->blankLines[$whichtext])) && ($this->blankLines[$whichtext][$blankAddPos][0] == $lineNr)) {
				// add blank lines
				for ($i=0; $i < $this->blankLines[$whichtext][$blankAddPos][1]; $i++) {
					$result [] = "////////////////";	
				}
				$blankAddPos++;
			}
			$result [] = $lines[$lineNr];	
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


