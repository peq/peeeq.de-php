<?
if (isset($_POST['data']))
{
	$query = 'SELECT `id` as x FROM `mapping_nopaste_html` ORDER BY `id` DESC;';
	$count = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	
	$id = $count['x'] + 1;
	//$html = "<pre>".htmlspecialchars($_POST['html'])."</pre>";


	
	
	
	$query = 'INSERT INTO 
			  `mapping_nopaste_html` (`id`, `html`, `datum` )
			  VALUES ("'.$id.'", "<h1>Security Problem:</h1>\n'.mysql_real_escape_string($_POST['data']).'", NOW())
			  ';
	
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	if (mysql_error())
	{
		echo "<pre>$query</pre><br />";
	}
}

?>