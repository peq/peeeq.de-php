<?php
require_once('mysql_cfg.php');


function debug_print ($ar) {
	foreach ($ar as $a) {
		echo "$a --- ";
	}
	echo "<br \>\n";
}

function debug_print2 ($ar, $fh) {
	foreach ($ar as $a) {
		fwrite($fh, "$a --- ");
	}
	fwrite($fh, "<br \>\n");
}

function makeGraph($text, $options) {
	$text = trim($text)."\n";
	$pos = 0;
	$len = strlen($text);
	
	/*$debug =  "<pre>== Text ==\n$text</pre>
		<pre>== Options ==\n$options</pre>";
	$fh = fopen("svgtemp/debug.html", 'w');
	fwrite($fh, $debug);*/
	
	
	
	$state = 0;
	$parents = array();
	$tabs = 0;
	$word = "";
	
	/*$output = "digraph G {
	splines=true;
	overlap=false;
	edge [len=0.1];
	edge [weight=3.0];

	";*/
	$output = 'digraph G {
	';
	$output.=$options."\n";
	
	$shapes = array();
	
	while ($pos < $len) {
		$c = $text[$pos];
		switch ($state) {
			case 0:
				//start of line / reading tabs
				switch ($c) {
					case "\n":
						//skip
						break;
					case "	":
						//tab
						$tabs++;
						break;
					case " ":
						//space
						//$tabs++;
						break;
					default:
						$word.=$c;
						$state = 1;
				}
				break;
			case 1:
				//reading the word
				switch ($c) {
					case "\n":
						//word finished
						$word = trim($word);
						if (strlen($word) > 0) {
							$parent = null;
							if ($tabs >= count($parents)) {
								//mehr tabs -> parent ist oberstes element
								if (count($parents) > 0) {
									$parent = $parents[count($parents)-1];
								}
							} else {
								//weniger tabs -> vom parentsstapel werfen
								while ($tabs <= count($parents)) {
									$parent = array_pop($parents);
									if ($parent == null) {
										break;
									}
								}
								if ($parent != null) {
									$parents[] = $parent;
								}
							}
							
							if ($parent != null) {
								
								$colPos = strpos($word, ":");
								$shape = false;
								if ($colPos > 0) {
									
									$newword = trim(substr($word, 0, $colPos));
									$shape = trim(substr($word, $colPos+1));
									$word = $newword;
								}
								
								$gtPos = strpos($word, ">");
								
								if ($gtPos) {
									$label =  trim(substr($word, 0, $gtPos));
									$word = trim(substr($word, $gtPos+1));
									
									
									$output .= "\"$parent\" -> \"$word\" [label = \"$label\"];\n";	
											
								} else {
									$output .= "\"$parent\" -> \"$word\";\n";	
								}
								if ($shape) {
									$shapes[$word] = $shape;
								}
								
							} else {
								//no parent
								$colPos = strpos($word, ":");
								$shape = false;
								if ($colPos > 0) {
									
									$newword = trim(substr($word, 0, $colPos));
									$shape = trim(substr($word, $colPos+1));
									$word = $newword;
									$shapes[$word] = $shape;
								}
							}
							$parents[] = $word;
						}
						$word = "";
						$state = 0;
						$tabs = 0;						
						break;
					default:
						$word.=$c;
				}
				break;
		}
		
		
		$pos++;
	}
	
	foreach ($shapes as $word => $shape) {
		if (in_array($shape, array('ellipse', 'box', 'circle', 'doublecircle', 'diamond','plaintext'))) {
			$output .= "\"$word\" [shape = $shape];\n";
		}
	}
	

	$output .= "}";
	
	return $output;
}

if (!isset($_GET['id'])) {
	die('ungültige Adresse');
} else {
	$id = intval($_GET['id']);
	$format = "png";
	if (isset($_GET['format'])) {
		if (in_array($_GET['format'], array("jpg", "png", "svg"))) {
			$format = $_GET['format'];
		}
	}
	$outfile = "svgtemp/graph$id.$format";
	if (!file_exists($outfile)) {
		//file does not exist, create it
		$qry = 'SELECT * FROM graph WHERE `id` = "'.$id.'"';
		$data  = mysql_query($qry);
		if ($row = mysql_fetch_array($data)) {
			$text = $row['text'];
			$options = $row['options'];
			$engine = $row['engine'];
			$debug =  "<pre>== Row ==\n".print_r($row, true)."</pre>";
					
				$fh = fopen("svgtemp/debug.html", 'w');
				fwrite($fh, $debug);
				fclose($fh);
					
					
			$filename = "svgtemp/graph$id.dot";
			$graph = makeGraph($text, $options);

			
			$fh = fopen($filename, 'w');
			fwrite($fh, $graph);
			fclose($fh);

			$output = array();
			exec("$engine -T$format $filename -o $outfile -Gcharset=latin1", &$output);

			if (count($output) > 0 ) {
				print_r($output);
				die();
			}
			
		} else {
			die('Bild existiert nicht.');
		}
	}
	
	if (!file_exists($outfile)) {
		die('Graph konnte nicht erstellt werden.');	
	}
/*	
	if (!preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT']))
	{
		//echo "no firefox";
		header( 'Content-disposition: atachment;filename="'.basename($outfile).'"');
	}
	else
	{*/
		header( 'filename="'.basename($outfile).'"');
	//}


	//header( 'Content-disposition: atachment');

	//header("Expires: 0");
	header("Expires: " + gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Transfer-Encoding: binary");



	header( 'Content-Length: ' . filesize( $outfile ) );
	header( 'Connection: close');
	$imageFormat = $format;
	if ($imageFormat == "svg") {
		$imageFormat = "svg+xml";
	}
	header( 'Content-Type: image/'.$imageFormat);


	readfile($outfile);
	
}

/*
$text = "
inWarcraft
	Esport
		News
		Coverage
		Szene-Forum
		Replays
			Downloads
			Forum
		Audiocomments
			Downloads
			Forum

	Movies
		Downloads
		Tutorials (im Forum)
		Forum


	Das Spiel
		WarCraft I
		WarCraft II
		WC3 alpha/beta
		Reign of Chaos
		The Frozen Throne
			Strategien
				Orc
				Human
				Nightelf
				Undead
			Walkthrough


	Dota
		Heros
		Items
		Map-Download
		Replays
		Audiocomments

	Maps
		News
		Tutorials
		Map-Datenbank



	Downloads
		Audiocomments
		Movies
		Tools
		Replays
		Maps

";*/

/*
$id = uniqid();
$filename = "svgtemp/$id.dot";
$outfile = "svgtemp/$id.png";

$graph = makeGraph($text);

//echo $graph;
//die();

$fh = fopen($filename, 'w');
fwrite($fh, $graph);
fclose($fh);

$output = array();
exec("fdp -Tpng $filename -o $outfile", &$output);

if (count($output) > 0 ) {
	print_r($output);
	die();
}
*/

?>
