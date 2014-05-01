<?
require_once('common.php');
require_once('compare2.php');
require_once('codehighlighter.php');
require_once('code_css.php');

//main template
$smarty->assign('main_template', 'comparer.tpl');
//title
$pageTitle = 'Compare Code: Online Diff Tool';


$additional_headers = array();

$additional_headers[] = '<script>
function update_a()
{
	var a = document.getElementById("a");
	var b = document.getElementById("b");
	b.scrollTop = a.scrollTop;
	b.scrollLeft = a.scrollLeft;
}

function update_b()
{
	var a = document.getElementById("a");
	var b = document.getElementById("b");
	a.scrollTop = b.scrollTop;
	a.scrollLeft = b.scrollLeft;
}
</script>';

function strip_markup($s)
{
	return str_replace('##', '', str_replace('@@', '', $s));
}

$s1 = null;
$s2 = null;
$default_lang1 = null;
$default_lang2 = null;

if ((isset($_GET['id1'])) && (isset($_GET['id2'])))
{
	//echo code_css();
	
	$id1 = intval($_GET['id1']);
	$id2 = intval($_GET['id2']);
	$orderby = ($id1 > $id2) ? 'ORDER BY `id` DESC' : 'ORDER BY `id` ASC';
	$query = 'SELECT * 
		FROM `mapping_nopaste_jass` 
		WHERE `key` LIKE "" 
		AND (`id` = "'.$id1.'" OR `id` = "'.$id2.'") 
		'.$orderby.';';
	$data = mysql_query($query, $mysqlconnection);
	echo mysql_error();
	$row = mysql_fetch_array($data);
	$s1 = strip_markup($row['jass_code']);
	$default_lang1 = $row['codetype'];
	$row = mysql_fetch_array($data);
	$s2 = strip_markup($row['jass_code']);
	$default_lang2 = $row['codetype'];
	
	
	
	
		
}
else if ((isset($_POST['code1'])) && (isset($_POST['code2'])))
{
	$s1 = $_POST['code1'];
	$s2 = $_POST['code2'];
	$default_lang1 = $default_lang2 = $_POST['lang'];
	
	if ($_POST['save'])
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
		
		$code = unescape_string($s1);
		$code = str_replace("<", "&lt;", $code);
		$code = str_replace(">", "&gt;", $code);
		
		$query = 'INSERT INTO 
			  `mapping_nopaste_jass` (`id`, `jass_code`, `datum`, `userid`, `codetype` )
			  VALUES ("'.$id.'", "'.escape_string($code).'", NOW(), "'.session_get_userid_secure().'", "'.$code_type.'")
			  ';
		$temp = mysql_query($query, $mysqlconnection);
		echo mysql_error();
		
		$id++;		
		$code = unescape_string($s2);
		$code = str_replace("<", "&lt;", $code);
		$code = str_replace(">", "&gt;", $code);
		
		$query = 'INSERT INTO 
			  `mapping_nopaste_jass` (`id`, `jass_code`, `datum`, `userid`, `codetype` )
			  VALUES ("'.$id.'", "'.escape_string($code).'", NOW(), "'.session_get_userid_secure().'", "'.$code_type.'")
			  ';
		$temp = mysql_query($query, $mysqlconnection);
		echo mysql_error();
		
		$additional_headers[] ='<script>document.location="comparer.php?id1='.($id-1).'&id2='.$id.'";</script>';
		$s1 = $s2 = null;
		
		$smarty->assign('id1', $id -1);
		$smarty->assign('id2', $id);
	}	
}
else
{
	$query = 'SELECT name FROM languages;';
	$data = mysql_query($query);
	$languages = array();
	while ($row = mysql_fetch_array($data))
	{
		$languages[] = $row['name'];
	}
	$smarty->assign('languages', $languages);
}
	
if (($s1) && ($s2))
{

	$lines1 = fill_line_array($s1);
	$lines2 = fill_line_array($s2);
	
	
	$linearray_comparer = new linearraycomparer($lines1, $lines2);
	
	$Alines1 = $linearray_comparer->make_same_lines_same_height(0);
	$Alines2 = $linearray_comparer->make_same_lines_same_height(1);
	
	$Blines1 = array();
	$Blines1_pos = 0;
	$Blines2 = array();
	$Blines2_pos = 0;
	
	$lineComparerInvocations = 0;
	

	
	for ($i = 0; $i < max(sizeof($Alines1),sizeof($Alines2)); ++$i)
	{
		
		if (!isset($Alines1[$i])) $Alines1[$i] = "";
		if (!isset($Alines2[$i])) $Alines2[$i] = "";
		$line1 = unescape_string(($Alines1[$i]));
		$line2 = unescape_string(($Alines2[$i]));
		
		//$bg1 = ' bgcolor="#90ff60"';
		//$bg2 = ' bgcolor="#90ff60"';
		++$Blines1_pos;
		++$Blines2_pos;
		
		if ($line1 != $line2)
		{
			
			if ($line1 == "////////////////")
			{
				//$bg1 = ' bgcolor="#CCccCC"';
				--$Blines1_pos;
				if (!(isset($Blines1[$Blines1_pos]))) {
					if ($Blines1_pos > 0) {
						$Blines1[$Blines1_pos] = '';
					} else {
						// dirty hack, i hat me for doing it^^
						$Blines1[$Blines1_pos] = '!!!FIRSTLINE-SKIPTHIS!!!';
					}
				}
				$line1 = $Blines1[$Blines1_pos]."\n";
				$line2 = "##".$line2; // mark added line yellow
				//$Blines1[$Blines1_pos].="\n";
			}
			elseif ($line2 == "////////////////")
			{
				//$bg2 = ' bgcolor="#CCccCC"';
				--$Blines2_pos;
				if (!(isset($Blines2[$Blines2_pos]))) {
					if ($Blines2_pos > 0) {
						$Blines2[$Blines2_pos] = '';
					} else {
						// dirty hack, i hat me for doing it^^
						$Blines2[$Blines2_pos] = '!!!FIRSTLINE-SKIPTHIS!!!';
					}
				}
				$line2 = $Blines2[$Blines2_pos]."\n";
				$line1 = "##".$line1; // mark added line yellow
				//$Blines2[$Blines2_pos].="\n";
			}
			else
			{
				//$bg1 = ' bgcolor="#ffff66"';
				//$bg2 = ' bgcolor="#ffff66"';
				
				if ($lineComparerInvocations < 100) {
					$line_comparer = new linecomparer($line1, $line2);
					$line1 = "##".$line_comparer->markup_string_difference(0, "@@", "@@");
					$line2 = "##".$line_comparer->markup_string_difference(1, "@@", "@@");
					
					$lineComparerInvocations ++;
				} else {
					// TOO many differences, just highlight the lines
					$line1 = "##".$line1;
					$line2 = "##".$line2;
				}
			}
		}
		
		//if (!(($line1 == $line2) && ($line1 == "////////////////")))
		if (($line1 != $line2) || ($line1 != "////////////////"))
		{
	
			$Blines1[$Blines1_pos] = $line1;
			$Blines2[$Blines2_pos] = $line2;
		}
	}
	
	

	
	/*
	include('language_data_jass.php');
	$ld = new languagedata();
	$ld->load_array($language_data);
	
	include('style_data_html.php');
	$hs = new highlightstyle();
	$hs->load_array($style_data);
	
	
	$ch1 = new codehighlighter($Blines1);
	$ch2 = new codehighlighter($Blines2);
	
	$output_lines1 = $ch1->parse_code($ld, $hs);
	$output_lines2 = $ch2->parse_code($ld, $hs);
	*/
	
	$ech1 = new easycodehighlighter($Blines1, $default_lang1);
	$ech2 = new easycodehighlighter($Blines2, $default_lang2);
	
	$additional_headers[] = $ech1->code_css;
	
	$output_lines1 = $ech1->output;
	$output_lines2 = $ech2->output;
	
	$output_lines1 = str_replace('class="codebox"', 'class="codebox" style="position:absolute;width:49%;left:0px;margin-left:5px;height:500px;" id="a" onscroll="update_a();"', $output_lines1);
	$output_lines2 = str_replace('class="codebox"', 'class="codebox" style="position:absolute;width:49%;right:0px;margin-right:5px;height:500px;" id="b" onscroll="update_b();"', $output_lines2);
	
	$smarty->assign('output_lines1', $output_lines1);
	$smarty->assign('output_lines2', $output_lines2);
	
	
}

finish($smarty, "comparer.tpl", $additional_headers)
	
?>
