<?
require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');


require_once('code_css.php'); 
require_once('filterhtml.php');


//main template
$smarty->assign('main_template', 'html.tpl');
//title
$smarty->assign('title', 'Html-peqpaste');

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);



function escape_string($s)
{
	//$result = $s;
	//$result =  str_replace('\\', '\\\\', $result);
	//$result =  str_replace('"', '###anfuehrunszeichen###', $result);
	//return $result;
	return mysql_real_escape_string($s);
}

function unescape_string($s)
{
	$result = $s;
	$result =  str_replace('\"', '"', $result);
	$result =  str_replace('\\\'', "'", $result);
	return $result;
}



if (isset($_POST['html']))
{
	$query = 'SELECT `id` as x FROM `mapping_nopaste_html` ORDER BY `id` DESC;';
	$count = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	
	$id = $count['x'] + 1;
	//$html = "<pre>".htmlspecialchars($_POST['html'])."</pre>";


	
	
	
	$query = 'INSERT INTO 
			  `mapping_nopaste_html` (`id`, `html`, `datum` )
			  VALUES ("'.$id.'", "'.escape_string($_POST['html']).'", NOW())
			  ';
	
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	if (mysql_error())
	{
		echo "<pre>$query</pre><br />";
	}
	
	$smarty->assign('id', $id);
	

	$smarty->assign('html_code', FilterHTML(unescape_string($_POST['html'])));
	
	
}
elseif (isset($_GET['id']))
{
	$id = $_GET['id'];
	$smarty->assign('title', 'Html-peqpaste #'.$id);
	
	
	$query = 'SELECT * FROM `mapping_nopaste_html` WHERE `id` LIKE "'.$id.'";';
	//echo "$query<br>";
	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	
	if (isset($_GET['interface']))
	{
		$smarty->assign('id', $id);
		$smarty->assign('html_code', FilterHTML(unescape_string($row['html'])));
	}
	else
	{
		echo unescape_string(FilterHTML($row['html']));	
		unset($smarty);
	}

	
	

}


if (isset($smarty))
{
	$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
}
?>
