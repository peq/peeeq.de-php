<?
require_once('mysql_cfg.php');

function unescape_string($s)
{
	$r = $s;
	//$r = str_replace('&', '&amp;', $r);
	//$r = str_replace('<', '&lt;', $r);
	//$r = str_replace('>', '&gt;', $r);
	
	
	$r = str_replace('\\"', '"', $r);
	$r = str_replace("\\'", "'", $r);
	$r = str_replace('\\\\', '\\', $r);
	
	//$r = str_replace('\\"', '\\"', $r);
	
	return $r;
}

function TNG_execute($command,$timeout=6,$sleep=0.2) {
	$PID = trim(shell_exec("$command > /dev/null & echo $!"));
	$proc_file='/proc/'.$PID.'/stat';
	$cur = 0;
	$stillrunning=1;
	$return_value=true;

	$handle = fopen($proc_file, "r");
	if ($handle) {
		while ($cur<$timeout) {
			list($proc_pid, $proc_name, $proc_status) = fscanf($handle, "%d %s %c");
			// Status is stored in $proc_status, current runtime in $cur

			if (!file_exists($proc_file) || $proc_status!='R') {
				// No more running, exit this loop!
				$stillrunning=0;
				break;
			}
			$cur += $sleep;
			usleep(floor($sleep*1000000));
			rewind($handle);
		}
		fclose($handle);
	}

	if ($stillrunning==1 && file_exists($proc_file)) {
		// Time exhausted KILLING!!
		$return_value=false;
		exec("kill $PID");
	}

	return $return_value;
}

$id = 0;

if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

$jpgfilename = "svgtemp/temp$id.jpg";
$svgfilename = "svgtemp/temp$id.svg";
$lockfilename = "svgtemp/temp$id.lock";

if (!file_exists($jpgfilename)) {

	if (file_exists($lockfilename)) {
		$locktime = time() - filemtime($lockfilename);
		if ($locktime < 60) {
			die('<br/>Image is currently being rendered. Try again in '. (60-$locktime) . ' seconds.');
		}
	}
	if (!file_exists($svgfilename)) {
	
		$query = 'SELECT * FROM drawings WHERE `id` = '.$id.';';
		$data = mysql_query($query);
		
		
		if ($row = mysql_fetch_array($data)) {
			$temp = '<?xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" 
	 "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">  
	<svg width="800" height="600" 
		xmlns="http://www.w3.org/2000/svg" 
		xmlns:xlink="http://www.w3.org/1999/xlink" 
		xml:space="preserve"
		viewBox="'.$row['viewbox_x'].' '.$row['viewbox_y'].' '.$row['viewbox_width'].' '.$row['viewbox_height'].'">
	 <title>SVG</title>
	';
			$svg = $row['data'];
			$svg = unescape_string($svg);
			$svg = str_replace('a0:href="','href="',$svg);
			$svg = str_replace('NS1:href="','href="',$svg);
			$svg = str_replace('href="','xlink:href="',$svg);
			$svg = str_replace('xmlns:a0="http://www.w3.org/1999/xlink"',"",$svg);
			$svg = str_replace('<','
				<',$svg);
			//$svg = FilterHTML($svg);
			if ($row['controlled'] != 'banned')
			{
				$temp.= $svg;
			}
			else
			{
				$temp.= '<text x="100" y="100" font-size="20px">Diese Skizze wurde von einem Administrator geloescht.</text>';
			}
			$temp.= "</svg>";
			
			
			$fh = fopen($svgfilename, 'w');
			fwrite($fh, $temp);
			fclose($fh);
		} else {
			//Fehler
		}
	}

	$cmd = "convert $svgfilename $jpgfilename";
	//$cmd = "/usr/local/bin/convert $svgfilename $jpgfilename";
	//$cmd = "touch $jpgfilename";
	//passthru($cmd);

	// create lock file:
	touch($lockfilename);
	
	if (!TNG_execute($cmd)) {
		die('<br />Timeout when converting image.<br />');
	}
	//$output = array();
	//exec($cmd, $output);
	if (!file_exists($jpgfilename)) {
		die('<br />Konnte Bild nicht umwandeln...<br />'.$cmd);
	}
}
		
//heades:

//image
//echo $_SERVER['HTTP_USER_AGENT'];
if (!preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT']))
{
	//echo "no firefox";
	header( 'Content-disposition: atachment;filename="bild$id.jpg"');
}
else
{
	header( 'filename="bild$id.jpg"');
}


//header( 'Content-disposition: atachment');

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Transfer-Encoding:­ binary");



header( 'Content-Length: ' . filesize( $jpgfilename ) );
header( 'Connection: close');
header( 'Content-Type: image/jpeg');

//header("Content-Disposition: attachment; filename=".basename(@$datei));

//echo file_get_contents($datei);
readfile($jpgfilename);

//passthru("./exec/convert $svgfilename");

?>
