<?
/*require_once('enable_gzip.php');*/
//die('not available');

require( './common.php' );







//main template
$smarty->assign('main_template', '9peq.tpl');
//title
$pageTitle = "9peq";

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);

$additional_headers = array();

$count = 25;
$page = isset($_GET['p']) ? intval($_GET['p']) : 0;
$start = $page*25;

$query = 'SELECT `id` FROM `drawings` WHERE controlled IN ("ok","unknown") ORDER BY `id` DESC 
	LIMIT '.$start.','.$count.';';
$data = mysql_query($query, $mysqlconnection);
$pictureIds = array();
while ($row = mysql_fetch_array($data)) {
	$pictureIds[] = $row['id'];
}

$smarty->assign('pictureIds', $pictureIds);
$smarty->assign('page', $page);

$smarty->assign('additional_headers', $additional_headers);

$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); 


$GLOBALS['USE_PEEEQ_STYLE'] = true;
$GLOBALS['NO_HEADER_IMAGE'] = true;
$GLOBALS['additional_headers'] = $additional_headers;

finish($smarty, "9peq.tpl", $additional_headers);



