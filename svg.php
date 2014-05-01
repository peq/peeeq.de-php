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


if (isset($_GET['id']))
{
	header('Content-Type: image/svg+xml');
	header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");

	
	$id = intval($_GET['id']);
	$query = 'SELECT * FROM drawings WHERE `id` = '.$id.';';
	$data = mysql_query($query);
	if ($row = mysql_fetch_array($data))
	{
		echo '<?xml version="1.0" encoding="utf-8" ?>
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
		//$svg = str_replace('a0:href="','href="',$svg);
		$svg = preg_replace('/a.:href="/','href="',$svg);
		//$svg = str_replace('NS1:href="','href="',$svg);
		$svg = preg_replace('/NS.:href="/','href="',$svg);
		$svg = str_replace('href="','xlink:href="',$svg);
		
		//$svg = str_replace('xmlns:a0="http://www.w3.org/1999/xlink"',"",$svg);
		$svg = preg_replace('/xmlns:a.="http:\/\/www.w3.org\/1999\/xlink"/',"",$svg);
		$svg = str_replace('<','
			<',$svg);
		//$svg = FilterHTML($svg);
		if ($row['controlled'] != 'banned')
		{
			echo $svg;
		}
		else
		{
			echo '<text x="100" y="100" font-size="20px">Diese Skizze wurde von einem Administrator geloescht.</text>';
		}
	}
	echo "</svg>";
}
else
{	
	echo "kein Bild";
}
?>
