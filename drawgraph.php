<?
/*
CREATE TABLE `languages` (
`id` INT NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`owner` INT DEFAULT '0' NOT NULL ,
`data` LONGTEXT NOT NULL
) TYPE = innodb;

CREATE TABLE `styles` (
`id` INT NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`owner` INT NOT NULL ,
`data` LONGTEXT NOT NULL ,
`hidden` BOOL DEFAULT '1' NOT NULL ,
`public` BOOL DEFAULT '0' NOT NULL ,
PRIMARY KEY ( `id` )
) TYPE = innodb;

*/

require_once('common.php');


require_once('code_css.php'); 
require_once('codetitles.php');


//main template
$smarty->assign('main_template', 'drawgraph.tpl');
//title
$pageTitle = "Online Graph Tool";

//set default = nothing
$smarty->assign('text', false);
$smarty->assign('id', false);

$additional_headers = array();


function escape_string($s)
{
	
	return str_replace('"', '\"', $s);
}

function unescape_string($s)
{
	//return $s;
	return stripslashes($s);
	//return str_replace('\"', '"', $s);
}






if (isset($_POST['text']))
{
	
	
	$text = unescape_string($_POST['text']);
	$engine = $_POST['engine'];
	$rankdir = $_POST['rankdir'];
	
	if (!in_array($engine, array("dot", "neato", "fdp", "twopi", "circo"))) {
		die('Hack Versuch? Diese Anfrage wurde geloggt.');
	}
	if (!in_array($rankdir, array("LR", "RL", "TB", "BT"))) {
		die('Hack Versuch? Diese Anfrage wurde geloggt.');
	}
	
	
	
	//todo
	// ranksep=0.5, nodesep=0.1, 
	$options = '
		graph [overlap=false, start=1, splines=true]
	    edge  [len=1.5, weight=2.0]';
	if ($engine == "dot") {
		$options.= 'rankdir = '.$rankdir.';';
	}
		
	
	
	$text = mysql_real_escape_string($text);
	$options = mysql_real_escape_string($options);
	$engine = mysql_real_escape_string($engine);
	
	$query = 'INSERT INTO `graph` (
		`time` ,
		`userid` ,
		`text` ,
		`options`,
		`engine`
		)
	VALUES (NOW(), "'.session_get_userid_secure().'", "'.$text.'", "'.$options.'", "'.$engine.'" )';
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$id = mysql_insert_id();
	/*
	$smarty->assign('output', $output);
	$smarty->assign('jass_code', strip_markup($code));
	*/
	$additional_headers[] ='<script>document.location="drawgraph.php?id='.$id.'";</script>';
	$smarty->assign('id', $id);
	
	
	
}
elseif (isset($_GET['id']))
{
	
    $id = intval($_GET['id']);
	;

	
	
	
	$query = 'SELECT * FROM `graph` WHERE `id` LIKE "'.$id.'";';

	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	$text = $row['text'];
	
	
	$smarty->assign('id', $id);
	$smarty->assign('text', $text);	
	

}
else
{
				
	
}
	$additional_headers[] = '<script language="Javascript" type="text/javascript" src="./jquery/jquery.js"></script>';
	$additional_headers[] = '<script language="Javascript" type="text/javascript" src="./jquery/jquery.textarea.js"></script>';
	$additional_headers[] = 
	'<script language="Javascript" type="text/javascript">
		jQuery(document).ready(function () {
			 $("textarea").tabby();
		});
	</script>';


finish($smarty, 'drawgraph.tpl', $additional_headers);
?>
