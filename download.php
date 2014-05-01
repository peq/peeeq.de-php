<?
	require_once("mysql_cfg.php");
	
	$id = intval($_GET['id']);
	
	$query = 'SELECT * FROM mapping_files WHERE `id` = "'.$id.'";';
	$data = mysql_query($query, $mysqlconnection);
	$row = mysql_fetch_array($data);
	
	
	$datei = $row['file'];
	$filetype = $row['filetype'];
	
	$dotpos = strrpos($datei,".");
	$data_type = strtolower(substr($datei,$dotpos,strlen($datei)));
	
	$images = array(".jpg", ".png", ".gif", ".bmp", ".jpeg");
	
	//heades:
	if (in_array($data_type,$images))
	{
		//image
		//echo $_SERVER['HTTP_USER_AGENT'];
		if (!preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT']))
		{
			//echo "no firefox";
			header( 'Content-disposition: atachment;filename='.urlencode($row['name']));
		}
		else
		{
			header( 'filename='.$row['name']);
		}
	}
	else
	{
		//no image
		header( 'Content-disposition: atachment;filename='.($row['name']));
	}
	
	//header( 'Content-disposition: atachment');
	
	header( 'Content-Length: ' . filesize( $datei ) );
	header( 'Connection: close');
	header( 'Content-Type: '.$filetype);
	
	//header("Content-Disposition: attachment; filename=".basename(@$datei));
	echo file_get_contents($datei);
	
	
	$query = 'UPDATE mapping_files SET downloads = downloads + 1 WHERE `id` = "'.$id.'";';
	$data = mysql_query($query, $mysqlconnection);
?>