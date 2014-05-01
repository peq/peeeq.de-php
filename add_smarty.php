<?

$sript_start_time = microtime(true);
//enable gzip compression
require_once('enable_gzip.php');
require_once('mysql_cfg.php');


require_once('files.php');



function lol_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

if (isset($_SERVER['DOCUMENT_ROOT']))
{
	define( 'DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
}
else
{
	define( 'DOCUMENT_ROOT', 'E:/web');
}

define('SMARTY_DIR', DOCUMENT_ROOT.'/Smarty/libs/');



require_once(SMARTY_DIR.'Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = '/templates/';
if (DOCUMENT_ROOT == "D:/web")
	$smarty->compile_dir = DOCUMENT_ROOT . '/peq/templates/compiled/';
else
	$smarty->compile_dir = DOCUMENT_ROOT . '/templates/compiled/';
$smarty->config_dir = '/templates/';
$smarty->cache_dir = '/templates/cache/'; 

//defaults:
$additional_headers = array();
$smarty->assign('additional_headers', $additional_headers);

$footer_scripts = array();
$smarty->assign('footer_scripts', $footer_scripts);

$smarty->assign('title', '^-^');
$smarty->assign('backpath','');

$smarty->assign('InternetExplorer',lol_detect_ie());


$smarty->assign('peqdevu_css',$_FILE_peqdevu_css);
/*echo "<!--";
print_r($_SERVER);
echo "-->";*/

//stats

$url 		= mysql_real_escape_string(@$_SERVER['REQUEST_URI']);
$USER_AGENT = mysql_real_escape_string(@$_SERVER['HTTP_USER_AGENT']);
$REFERER 	= mysql_real_escape_string(@$_SERVER['HTTP_REFERER']);
$ip 		= mysql_real_escape_string(@$_SERVER['REMOTE_ADDR']);

$reload = false;
$query = 'SELECT * FROM stats_details WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`time`) < 60*60 AND URL = "'.($url).'" AND ip = "'.$ip.'";';
$data = mysql_query($query);
echo mysql_error();
if ($row = mysql_fetch_array($data))
{
	$reload=true;
}

$query = 'SELECT * FROM stats_counter WHERE URL = "'.($url).'";';
$data = mysql_query($query);
if ($row = mysql_fetch_array($data))
{
	$smarty->assign('counter',$row['counter']);
	if (!$reload)
	{
		$query = 'UPDATE stats_counter SET counter = counter + 1 WHERE URL = "'.($url).'";';
		$data = mysql_query($query);
	}
}
else
{
	$smarty->assign('counter',0);
	if (!$reload)
	{
		$query = 'INSERT INTO stats_counter (`URL`, `counter`) VALUES ("'.($url).'", 1);';
		$data = mysql_query($query);
	}
}

$query = 'INSERT INTO stats_details (`URL`, `REFERER`, `ip`, `USERAGENT`, `time`) 
				VALUES  ("'.$url.'", "'.$REFERER.'", "'.$ip.'", "'.$USER_AGENT.'", NOW());';
$data = mysql_query($query);



?>