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

require_once('enable_gzip.php');
require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');


require_once('code_css.php'); 
require_once('codetitles.php');


//main template
$smarty->assign('main_template', 'code.tpl');
//title
$smarty->assign('title', 'Code');

//set default = nothing
$smarty->assign('html_code', false);
$smarty->assign('id', false);

$additional_headers = array();

$editor_languages = array
(
"jass" => "jass",
"pascal" => "pas",
"delphi" => "pas",
"java" => "js"
);

$editor_start_lang = "jass";
if ((isset($_GET['l'])) && (isset($editor_languages[$_GET['l']])))
{
	$smarty->assign('title', htmlspecialchars($_GET['l']).'-Code posten');
	$editor_start_lang = $editor_languages[$_GET['l']];
}

$editor_lang_change_script = '';
foreach ($editor_languages as $key => $val)
{
	if ($editor_lang_change_script != '')
		$editor_lang_change_script.="\nelse";
	
	$editor_lang_change_script.='
	if (o.value == "'.$key.'")
	{
		editAreaLoader.execCommand("code", "change_syntax", "'.$val.'");
	}
	';
}



 



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

function fill_line_array($s)
{
	return explode("\n",$s);
}

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}


require_once("codehighlighter.php");




if (isset($_POST['code']))
{
	$query = 'SELECT `id` as x FROM `mapping_nopaste_jass` ORDER BY `id` DESC;';
	$count = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	
	$id = $count['x'] + 1;
	
	$code_type = mysql_real_escape_string($_POST['lang']);
	//remember to check this value later
	//check value
	$query = 'SELECT name FROM languages WHERE `name` = "'.$code_type.'";';
	$row = mysql_fetch_array(mysql_query($query));
	if (isset($row['name']) && ($row['name'] != $code_type))
	{
		die('unbekannte Sprache.');
	}
	
	
	$code = unescape_string($_POST['code']);
	$code = str_replace("<", "&lt;", $code);
	$code = str_replace(">", "&gt;", $code);

	//check if code contains url:
	if (strpos($code, "http://") !== false) {
		if (session_get_userid_secure() <= 0) {
			die('Um Spam zu vermeiden d�rfen Posts, die Internet-Addressen enthalten nur von angemeldeten Benutzern erstellt werden.');
		}
	}
		
	/*
	include('language_data_jass.php');
	$ld = new languagedata();
	$ld->load_array($language_data);
	
	include('style_data_html.php');
	$hs = new highlightstyle();
	$hs->load_array($style_data);
	
	$code_lines = fill_line_array($code);
	$ch = new codehighlighter($code_lines);
	
	
	$output = $ch->parse_code($ld, $hs);
	*/
		
	
	$query = 'INSERT INTO 
			  `mapping_nopaste_jass` (`id`, `jass_code`, `datum`, `userid`, `codetype` )
			  VALUES ("'.$id.'", "'.mysql_real_escape_string($code).'", NOW(), "'.session_get_userid_secure().'", "'.$code_type.'")
			  ';
	$temp = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	/*
	$smarty->assign('output', $output);
	$smarty->assign('jass_code', strip_markup($code));
	*/
	if ($id == 1000)
	{
		$additional_headers[] ='<script>document.location="code.php?id='.$id.'&showpic=1";</script>';
	}
	else
	{
		$additional_headers[] ='<script>document.location="code.php?id='.$id.'";</script>';
	}
	$smarty->assign('id', $id);
	
	
	
}
elseif (isset($_GET['id']))
{
	
    $additional_headers[] = '<script type="text/javascript" src="codehandling.js"></script>';
	$id = intval($_GET['id']);
	$language_id = (isset($_GET['language'])) ?  intval($_GET['language']) : 0;
	$style_id = (isset($_GET['style'])) ?  intval($_GET['style']) : 0;
	$format_output = (isset($_GET['f'])) ?  intval($_GET['f']) : false;
	
	
	$query = 'SELECT * FROM `mapping_nopaste_jass` WHERE `id` LIKE "'.$id.'";';

	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	
	$code = $row['jass_code'] ;
	$default_lang = $row['codetype'];
	
	$ech = new easycodehighlighter($code, $default_lang, $language_id, $style_id, $format_output);
	
	if ($ech->format_script == null)
	{
		$smarty->assign('format_script', 0);
	}
	else
	{
		$smarty->assign('format_script', (($format_output) ? 2 : 1));
	}
	$smarty->assign('language_id', $ech->language_id);
	$smarty->assign('style_id', $ech->style_id);
	
	$smarty->assign('output', $ech->output);
	$smarty->assign('jass_code', strip_markup($ech->code));
	$additional_headers[] = $ech->code_css;
	
	$smarty->assign('id', $id);
	
	
	
	/*
	$output_lines = '';
	
	$language = false;
	if (isset($_GET['language']))
	{
		$language_id = intval($_GET['language']);
		$query = 'SELECT data, defaultstyle, `id`, `name` FROM languages WHERE `id` = "'.$language_id.'";';
		$language = mysql_fetch_array(mysql_query($query));
	}
	if (!$language)
	{
		$query = 'SELECT data, defaultstyle, `id`, `name` FROM languages WHERE `name` = "'.$row['codetype'].'";';
		$language = mysql_fetch_array(mysql_query($query));
	}	
	
	if ($language)
	{
		$format_script = 'format_'.$language['name'].'.php';
		
		
		if (file_exists($format_script) != '')
		{
			if (isset($_GET['f']))
			{
				require_once('format_'.$language['name'].'.php');
				//$my_jass_formater = new jass_formater();
				eval('$my_formater = new '.$language['name'].'_formater();');
				
				$code = $my_formater->format(strip_markup($code),true,true);
				$smarty->assign('format_script', 2);
			}
			else
			{
				$smarty->assign('format_script', 1);
			}
		}
		else
		{
			$smarty->assign('format_script', 0);
		}
		
		$code_lines = fill_line_array($code);
		
		$smarty->assign('language_id', $language['id']);
		
		eval('$language_data = array('.$language['data'].');');
		$ld = new languagedata();
		$ld->load_array($language_data);
		//$ld->debug_print();
		
		$style_id = 0;
		$cssdata = null;
		if (isset($_GET['style']))
		{
			$style_id = intval($_GET['style']);
			$query = 'SELECT data, cssdata FROM styles WHERE `id` = "'.$style_id.'";';
			$style = mysql_fetch_array(mysql_query($query));
			if (!$style)
			{
				$style_id = 0;
			}
			$cssdata = $style['cssdata'];
			$style = $style['data'];
		}
		
		if ($style_id == 0)			
		{
			//load default value of language
			$style_id = $language['defaultstyle'];
			$query = 'SELECT data, cssdata FROM styles WHERE `id` = "'.$style_id.'";';
			$style = mysql_fetch_array(mysql_query($query));
			$cssdata = $style['cssdata'];
			$style = $style['data'];
			
		}
		//echo "<pre>".code_css($cssdata)."</pre>";
		$additional_headers[] = code_css($cssdata);
		
		
		$smarty->assign('style_id', $style_id);
		
		eval('$style_data = array('.$style.');');
		$hs = new highlightstyle();
		$hs->load_array($style_data);
		
		
		$ch = new codehighlighter($code_lines);
		
		$output = $ch->parse_code($ld, $hs);
	}
	else
	{  //no language definend
		$code_lines = fill_line_array($code);
		$output='<textarea>';
		for($i=0;$i<sizeof($code_lines);$i++)
		{
			$output_lines[$i] = "".$code_lines[$i]."\n";
		}
		$output='</textarea>';
	}
		*/
		
	$language_name = "X";	
	
	//load languages
	$query = 'SELECT `id`, name FROM languages;';
	$data = mysql_query($query);
	$languages = array();
	while ($row = mysql_fetch_array($data))
	{
		$languages[] =  array("id" => $row['id'],"name" => $row['name']);
		if ($row['id'] == $ech->language_id)
			$language_name = $row['name'];	
	}
	$smarty->assign('languages', $languages);
	
	//load styles
	$query = 'SELECT `id`, name FROM styles;';
	$data = mysql_query($query);
	$styles = array();
	while ($row = mysql_fetch_array($data))
	{
		$styles[] = array("id" => $row['id'],"name" => $row['name']);
	}
	$smarty->assign('styles', $styles);
	
	
	
	$smarty->assign('title', $language_name.'-Code #'.$id.' '.getCodeTitle($code));

}
else
{
	//load editor
	$additional_headers[] = 
'<script language="Javascript" type="text/javascript">
	//<!--
	function init_editarea()
	{
		//initialisation
		editAreaLoader.init({
			id: "code"	// id of the textarea to transform		
			,start_highlight: "true"	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,language: "de"
			,syntax: "'.$editor_start_lang.'"	
			,display: "later"
			,replace_tab_by_spaces: "false"
			,toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight, |, help"
			,syntax_selection_allow: "jass,css,html,js,php,python,vb,xml,c,cpp,basic,pas,brainfuck"
		});
		
		//alert("done");
	}
	
	function onSyntaxChange(o)
	{
		'.$editor_lang_change_script.
		/*if (o.value == "jass")
		{
			//alert(o.value);
			editAreaLoader.execCommand("code", "change_syntax", "jass");
			//alert("done");
		}
		else if (o.value == "pascal")
		{
			editAreaLoader.execCommand("code", "change_syntax", "pas");
		}
		else if (o.value == "delphi")
		{
			editAreaLoader.execCommand("code", "change_syntax", "pas");
		}
		else if (o.value == "java")
		{
			editAreaLoader.execCommand("code", "change_syntax", "js");
		}*/
		'
	}	
	
	
	
	
	
	//Drop-Down lists:
	startList = function() 
	{
		if (document.all && document.getElementById) 
		{
			cssdropdownRoot = document.getElementById("cssdropdown");
			for (x=0; x<cssdropdownRoot.childNodes.length; x++) 
			{
				node = cssdropdownRoot.childNodes[x];
				if (node.nodeName=="LI") 
				{
					node.onmouseover=function() 
					{
						this.className+=" over";
					}
					node.onmouseout=function() 
					{
						this.className=this.className.replace(" over", "");
					}
				}
			}
		}
	}

	if (window.attachEvent)
		window.attachEvent("onload", startList)
	else
		window.onload=startList;
	
	//-->
	</script>';
	$additional_headers[] = '<script language="Javascript" type="text/javascript" src="./editarea/edit_area/edit_area_full.js"></script>';
	
	$smarty->assign('addtional_onloads', array("init_editarea()"));
	
	$query = 'SELECT name FROM languages;';
	$data = mysql_query($query);
	$languages = array();
	while ($row = mysql_fetch_array($data))
	{
		$languages[] = $row['name'];
	}
	$smarty->assign('languages', $languages);
	
	
}



$smarty->assign('additional_headers', $additional_headers);

$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
?>
