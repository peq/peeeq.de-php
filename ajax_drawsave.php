<?
require_once("session.php"); 
require_once('mysql_cfg.php');
require_once('filterhtml.php');

function unescape_string($s)
{
	$result = $s;
	$result =  str_replace('\"', '"', $result);
	$result =  str_replace('\\\'', "'", $result);
	return $result;
}


if (isset($_POST['html']))
{
	$data = unescape_string($_POST['html']);
	
	$data = FilterHTML($data);
	$data = mysql_real_escape_string($data);
	
	//check if picture already exists
	$query = 'SELECT `id` FROM drawings WHERE data="'.$data.'";';
	if ($row=mysql_fetch_array(mysql_query($query)))
	{
		$id = $row['id'];
		echo "Bild gespeichert. 
		Hier ist der Link zum Bild:<br />
		<a href=\"draw.php?id=$id\">http://peeeq.de/draw.php?id=$id</a>
		<br /><br />
		Oder als JPG-Grafik:<br />
		<a href=\"zeichnung$id.jpg\">http://peeeq.de/zeichnung$id.jpg</a>
		";
	}
	else
	{
		$parent = intval($_POST['parent']);
		$viewport_x = intval($_POST['viewport_x']);
		$viewport_y = intval($_POST['viewport_y']);
		$viewport_width = intval($_POST['viewport_width']);
		$viewport_height = intval($_POST['viewport_height']);
		$query = 'SELECT `id` FROM drawings ORDER BY `id` DESC LIMIT 1;';
		$row = mysql_fetch_array(mysql_query($query));
		$id = $row['id'] + 1;
		$userid = session_get_userid_secure();
		
		$query =  'INSERT INTO drawings(`id`,`userid`,`time`,`data`,`parent`,`viewbox_x`,`viewbox_y`,`viewbox_width`,`viewbox_height`)
					VALUES('.$id.', '.$userid.', NOW(), "'.$data.'","'.$parent.'","'.$viewport_x.'","'.$viewport_y.'","'.$viewport_width.'","'.$viewport_height.'");';
		$data = mysql_query($query);
		if (mysql_error())
		{
			echo "Fehler! <br />".mysql_error();
		}
		else
		{
			echo "Bild gespeichert. 
		Hier ist der Link zum Bild:<br />
		<a href=\"draw.php?id=$id\">http://peeeq.de/draw.php?id=$id</a>
		<br /><br />
		Oder als JPG-Grafik:<br />
		<a href=\"zeichnung$id.jpg\">http://peeeq.de/zeichnung$id.jpg</a>";
		}
	}
}

if (isset($_POST['id']))
{
	$id = intval($_POST['id']);
	
	if (session_is_admin())
	{
		if ($_POST['mode'] == '1')
		{
			$query = 'UPDATE drawings SET controlled = "ok" WHERE `id` = '.$id.';';
			echo "Bild #$id freigegeben.";
		}
		elseif ($_POST['mode'] == '2')
		{
			$query = 'UPDATE drawings SET controlled = "banned" WHERE `id` = '.$id.';';
			echo "Bild #$id geloescht.";
		}
		$data  = mysql_query($query);
		echo mysql_error();
		
	}
	else
	{
		echo "keine Rechte.";
	}
}

?>
