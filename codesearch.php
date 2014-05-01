<?
require_once('common.php');

require_once('code_css.php'); 
require_once('codetitles.php');


//main template
$smarty->assign('main_template', 'codesearch.tpl');
//title
$pageTitle = 'Code Search';

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);

$additional_headers = array();


$additional_headers[] = '<script type="text/javascript" src="codehandling.js"></script>';
 



function escape_string($s)
{
	
	return str_replace('"', '\"', $s);
}

function unescape_string($s)
{
	return str_replace('\"', '"', $s);
}

function fill_line_array($s)
{
	return explode("\n",$s);
}

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}

function get_first_line ($_text)
{
	return getCodeTitle($_text);
}




require_once("codehighlighter.php");

function getSearchOccurences($code, $search) {
	$searchwords = preg_split("/[^a-zA-Z0-9]+/", $search);
	$lines = preg_split("/\n|\n\r|\r\n|\r/", $code);
	$searchPattern = "/(".implode(")|(", $searchwords).")/";
	$replaceString = "";
	for ($i=1; $i<=count($searchwords); $i++) {
		$replaceString .= '$'.$i;
	}
	$out = "";
	$count = 0;
	foreach ($lines as $line) {
		if (preg_match($searchPattern, $line)) {
			$out .= '<p>'.preg_replace($searchPattern, "<strong>$replaceString</strong>", trim($line))."</p>";
			$count ++;
			if ($count > 5) {
				break;
			}
		}
	}
	return $out;
}


//################
//load languages
$query = 'SELECT `id`, name FROM languages;';
$data = mysql_query($query);
$languages = array();
while ($row = mysql_fetch_array($data))
{
	$languages[] =  array("id" => $row['id'],"name" => $row['name']);

}
$smarty->assign('languages', $languages);


if (isset($_GET['q']))
{
	$q = mysql_real_escape_string($_GET['q']);
	
	$result_per_page = 50;
	$page = 0;
	if (isset($_GET['page']))
	{
		$page = intval($_GET['page']);
	}
	
	$query = 'SELECT *,
	MATCH (jass_code)	AGAINST (	\''.$q.'\'	IN BOOLEAN	MODE	) as score
	FROM `mapping_nopaste_jass`
	WHERE MATCH (
	jass_code
	)
	AGAINST (
	\''.$q.'\'
	IN BOOLEAN
	MODE
	)
	AND `key` LIKE ""
	ORDER BY score DESC, id DESC
	LIMIT '.($page*$result_per_page).' , '.$result_per_page.';';
	
	$searchresults = array();
	
	$data = mysql_query($query);
	while ($row = mysql_fetch_array($data))
	{
		$searchresult = array();
		$searchresult['id'] = $row['id'];
		$searchresult['score'] = intval($row['score']*100);
		$searchresult['lang'] = $row['codetype'];
		$searchresult['title'] = get_first_line($row['jass_code']);
		$searchresult['text'] = getSearchOccurences($row['jass_code'], $q);
		$searchresults[] = $searchresult;
	}
	
	$smarty->assign('q', htmlspecialchars(unescape_string($_GET['q'])));
	$smarty->assign('searchresults', $searchresults);
}
//#####################


finish($smarty, "codesearch.tpl", $additional_headers);
?>
