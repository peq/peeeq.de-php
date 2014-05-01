<?

require_once("add_smarty.php"); 

require_once("session.php"); 

require_once("mysql_cfg.php"); 


//title
$smarty->assign('title', 'Startseite');

//main template
$smarty->assign('main_template', 'index.tpl');

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}

function get_firtst_line ($_text)
{
	$text = $_text;

	
	$regexps = array(
		"library" => '/library\s+(\w*)/',
		"scope" => '/scope\s+(\w*)/',
		"class" => '/class\s+(\w*)/',
		"struct" => '/struct\s+(\w*)/',		
		"function" => '/function\s+(\w*)/',
		"method" => '/method\s+(\w*)/'
		);
	foreach ($regexps as $key => $regexp) {
		preg_match($regexp, $text, $treffer);
		if ($treffer != null) {
			return "$key ".$treffer[1];
		}
	}

	

	
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

function make_ago_timer ($_seconds)
{
	$seconds =intval($_seconds);
	if ($seconds >= (60*60*24) )
	{
		$i = intval($seconds / (60*60*24));
		return ($i > 1) ? "$i Tagen" : "einem Tag";
	}
	elseif ($seconds >= (60*60) )
	{
		$i = intval($seconds / (60*60));
		return ($i > 1) ? "$i Stunden" : "einer Stunde";
	}
	elseif ($seconds >= (60) )
	{
		$i = intval($seconds / (60));
		return ($i > 1) ? "$i Minuten" : "einer Minute";
	}
	else
	{
		$i = intval($seconds);
		return ($i > 1) ? "$i Sekunden" : "einer Sekunde";
	}
}



//load latest code
$query = 'SELECT *, UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(datum) as diff_datum FROM mapping_nopaste_jass ORDER BY `id` DESC LIMIT 5;';
$data = mysql_query($query);
echo mysql_error();
$latest_code = array();
$i = 0;
while ($row = mysql_fetch_array($data))
{
	$i++;
	$latest_code[$i] = array_merge($row, array("short" => htmlspecialchars(get_firtst_line($row['jass_code'])), "ago_time" => make_ago_timer($row['diff_datum'])));
	$latest_code[$i]['codetype']= str_replace("+","p",$latest_code[$i]['codetype']);
}


$smarty->assign('latest_code', $latest_code);


//load latest gui
$query = 'SELECT *, UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(datum) as diff_datum  FROM mapping_nopaste_gui ORDER BY `id` DESC LIMIT 5;';
$data = mysql_query($query);
echo mysql_error();
$latest_gui = array();
while ($row = mysql_fetch_array($data))
{
	
	$latest_gui[] = array_merge($row, array("short" => htmlspecialchars(get_firtst_line($row['gui_code'])), "ago_time" => make_ago_timer($row['diff_datum'])));
}


$smarty->assign('latest_gui', $latest_gui);

//load comments
require_once("comments.php");
$from = (isset($_GET['from'])) ? intval($_GET['from']) : 0;
$count = (isset($_GET['count'])) ? intval($_GET['count']) : 10;
add_comments(0,$from,$count);
$smarty->assign('draw_comments_form', true);

//we need additional headers to do ajax:

$footer_scripts[] = '<script src="jquery/jquery.js" type="text/javascript"></script>';
//$smarty->assign('additional_headers', $additional_headers);

//we also need additional headers for tinymce editor:
$footer_scripts[] ='<script type="text/javascript" src="tinymce/tiny_mce/tiny_mce_gzip.js"></script>';

$footer_scripts[] ='<script src="comments001.js" type="text/javascript"></script>';

//aus frame raus springen:
$additional_headers[]='<script type="text/javascript">
if (top != self)
  top.location = self.location;
</script>';


$smarty->assign('additional_headers', $additional_headers);
$smarty->assign('footer_scripts', $footer_scripts);
//display everything
$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); 
$smarty->display('site.tpl');

?>



