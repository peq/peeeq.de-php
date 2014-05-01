<?
require_once('enable_gzip.php');
require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');


require_once('code_css.php'); 
require_once("codehighlighter.php");


//main template
$smarty->assign('main_template', 'code.tpl');
//title
$smarty->assign('title', 'Code');

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);

$additional_headers = array();

$ausgabe = "";

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}

$allowed = array("graph.php","drawgraph.php","templates/drawgraph.tpl","format_jass.php","index.php","add_smarty.php","code_css.php","code.php","codehighlighter.php","comments.php","compare.php","comparer.php","create_thumbnail.php","download.php","enable_gzip.php","example.php","format_jass.php","gui.php","GuiParser.php","GuiParser2.php","html.php","index.php","pbar.php","session.php","source.php","text.php","upload.php","templates/code.tpl","templates/comments.tpl","templates/comparer.tpl","templates/gui.tpl","templates/html.tpl","templates/index.tpl","templates/login.tpl","templates/pbar.tpl","templates/site.tpl","templates/text.tpl","templates/upload.tpl");
$f = null; 
if (isset($_GET['f']))
	$f = $_GET['f'];
if (in_array($f,$allowed))
{
	$additional_headers[] = '<script type="text/javascript" src="codehandling.js"></script>';

	
	$ausgabe.=  "last update: ". date('r', filemtime($f)) . "\n";
	
	$language_id = 5;
	$style_id = 1;
	$format_output = (isset($_GET['f'])) ?  intval($_GET['f']) : false;
	
	
	

	
	
	$code = file_get_contents($f);
	$default_lang = 5;
	
	$ech = new easycodehighlighter($code, $default_lang, $language_id, $style_id, $format_output);
	
	if ($ech->format_script == null)
	{
		$smarty->assign('format_script', 0);
	}
	else
	{
		$smarty->assign('format_script', (($format_output) ? 2 : 1));
	}
	
	$output = $ech->output;
	
	foreach ($allowed as $row)
	{
		$output =  str_replace('"'.basename($row).'"','"<a href="source.php?f='.$row.'">'.basename($row).'</a>"', $output);
		$output =  str_replace('\''.basename($row).'\'','\'<a href="source.php?f='.$row.'">'.basename($row).'</a>\'', $output);
	}
	
	
	$smarty->assign('output', $output);
	$smarty->assign('jass_code', strip_markup(htmlspecialchars($ech->code)));
	$additional_headers[] = $ech->code_css;
	
}
else
{
	$ausgabe.=  "Der Quellcode dieser Datei ist aus Sicherheitsgründen und/oder Faulheit von peq verboten, frag peq, ob er ihn freigibt.<br />\n";
	$f = null;
}
if ($f == null)
{
	$ausgabe.=  "Datei auswählen:<br />\n
	<ul>\n";

	foreach ($allowed as $row)
	{
		$ausgabe.=  "	<li><a href=\"source.php?f=$row\">$row</a></li>\n";
	}
	$ausgabe.=  "</ul>\n";

}
$smarty->assign('ausgabe', $ausgabe);
$smarty->assign('additional_headers', $additional_headers);

$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');

?>
