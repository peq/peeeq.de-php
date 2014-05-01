<?
require_once('add_smarty.php');
require_once('session.php'); 
require_once('mysql_cfg.php');


require_once('code_css.php'); 



//main template
$smarty->assign('main_template', 'text.tpl');
//title
$smarty->assign('title', 'Text');

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
	return $s;
}



if (isset($_POST['text']))
{
	$query = 'SELECT `id` as x FROM `mapping_nopaste_text` ORDER BY `id` DESC;';
	$count = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	
	$id = $count['x'] + 1;
	//$text = "<pre>".htmlspecialchars($_POST['text'])."</pre>";
	$text = htmlspecialchars(stripslashes($_POST['text']));
	$text = str_replace("	", "    ", $text);
	$text = str_replace("  ", "&nbsp; ", $text);
	$text = str_replace("\r\n", "\r\n<br />", $text); //remove double linebreak
	
	
        //check if code contains url:
        if (strpos($text, "http://") !== false) {
                if (session_get_userid_secure() <= 0) {
                        die('Um Spam zu vermeiden dürfen Posts, die Internet-Addressen enthalten nur von angemeldeten Benutzerstellt werden.');
                }
        }
	
	
	
	$query = 'INSERT INTO 
			  `mapping_nopaste_text` (`id`, `text`, `html_code`, `datum` )
			  VALUES ("'.$id.'", "'.escape_string($_POST['text']).'", "'.escape_string($text).'", NOW())
			  ';
	
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	if (mysql_error())
	{
		echo "<pre>$query</pre><br />";
	}
	
	$smarty->assign('html_code', $text);
	$smarty->assign('id', $id);
	

	
	
}
elseif (isset($_GET['id']))
{
	$id = $_GET['id'];
	
	$query = 'SELECT * FROM `mapping_nopaste_text` WHERE `id` LIKE "'.$id.'";';
	//echo "$query<br>";
	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	
	$smarty->assign('html_code', unescape_string($row['html_code']));
	$smarty->assign('id', $id);
		
	
	
	

}


$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
?>
