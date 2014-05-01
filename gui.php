<?
require_once("common.php");

function escape_string($s)
{
	return str_replace('"', '\"', $s);
}

function unescape_string($s)
{
	return str_replace('\"', '"', $s);
}

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}


function get_firtst_line ($_text)
{
	$text = nl2br(trim($_text));
	$pos = strpos($text,"<br />");
	if ($pos)
	{
		return strip_markup(substr($text,0, $pos));
	}
	else
	{
		return strip_markup($text);
	}	
}

$additional_headers = array();
if (isset($_GET['oldparser']))
{
require_once("GuiParser2.php");
}
else
{
require_once("GuiParser3.php");
}


//main template
$smarty->assign('main_template', 'gui.tpl');

//Title
$pageTitle = 'GUI Trigger';

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);

$game = "wc3";
if ($_GET['game'] == "sc2") {
	$game = "sc2";
}


if (isset($_POST['trigger']))
{
	//neuen Trigger Posten (Verarbeitung)
	$query = 'SELECT `id` as x FROM `mapping_nopaste_gui` ORDER BY `id` DESC;';
	$count = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	
	$id = $count['x'] + 1;


	$gui_code = unescape_string($_POST['trigger']);
	$game = "wc3";
	if ($_POST['game'] == "sc2") {
		$game = "sc2";
	}

        //check if code contains url:
        if (strpos($gui_code, "http://") !== false) {
                if (session_get_userid_secure() <= 0) {
                        die('Um Spam zu vermeiden dürfen Posts, die Internet-Addressen enthalten nur von angemeldeten Benutzerstellt werden.');
                }
        }
	
	
	//Gui-Parser Objekt erstellen
	$gui_parser = new GuiParser;
		
	//Aufruf 
	// 1. Parameter = Code der umgewandelt wird
	//2. Parameter = Pfad zu den Bildern
	//$html_code = $gui_parser->convert_gui($gui_code, "GuiParserPics/" );
	//$html_code = $gui_parser->ParseGui($gui_code, array(), true, "html");
	$html_code = $gui_parser->ParseGui($gui_code, array(), false, "html");
	
	$smarty->assign('html_code', $html_code);
	$smarty->assign('id', $id);
	
	
	$query = 'INSERT INTO 
			  `mapping_nopaste_gui` (`id`, `gui_code`, `datum`, `userid`, `game`)
			  VALUES ("'.$id.'", "'.escape_string($gui_code).'", NOW(), "'.session_get_userid_secure().'", "'.$game.'")
			  ';
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$additional_headers[] ='<script>document.location="gui.php?id='.$id.'";</script>';
	
}
elseif (isset($_GET['id']))
{
	//Trigger anzeigen
	
	$id = intval($_GET['id']);
	
	$query = 'SELECT * FROM `mapping_nopaste_gui` WHERE `id` LIKE "'.$id.'";';
	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	
	$html_code = "";
	if (isset ($_GET['bb']))
	{
		//Gui-Parser Objekt erstellen
		$gui_parser = new GuiParser;
		$html_code = $gui_parser->ParseGui($row['gui_code'], array(), false, "bb");
	} 
	elseif (isset ($_GET['text']))
	{
		$html_code = "<pre>{$row['gui_code']}</pre>";
	}
	else
	{
		if ($row['game'] == "sc2" ) {
			$code = nl2br(htmlspecialchars($row['gui_code']));
            $html_code = '<pre class="GuiCode">'.$code.'</pre>
			<script type="text/javascript" src="./js/jquery-1.3.2.min.js"></script> 
			<script type="text/javascript" src="./js/GuiParser.js"></script>';
		} else { // wc3
			$gui_parser = new GuiParser;
			$html_code = $gui_parser->ParseGui($row['gui_code'], array(), false, "html");
		}
	}
	
	$pageTitle = 'GUI Trigger #'.$id.' '.get_firtst_line($row['gui_code']);

	
	$smarty->assign('html_code', $html_code);
	$smarty->assign('id', $id);

}


$smarty->assign('game', htmlspecialchars($game));

finish($smarty, "gui.tpl", $additional_headers);

?>
