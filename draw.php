<?

require_once('common.php');
require_once('filterhtml.php');

$smarty->assign('IE',false);


function unescape_string($s)
{
	$r = $s;
	//$r = str_replace('&', '&amp;', $r);
	//$r = str_replace('<', '&lt;', $r);
	//$r = str_replace('>', '&gt;', $r);
	
	
	$r = str_replace('\\"', '"', $r);
	$r = str_replace("\\'", "'", $r);
	$r = str_replace('\\\\', '\\', $r);
	
	//$r = str_replace('\\"', '\\"', $r);
	
	return $r;
}

//main template
$smarty->assign('main_template', 'draw2.tpl');
//title
$pageTitle = 'Online Paint and Draw Tool';

$smarty->assign('xml',true);

$smarty->assign('additional_onload','');

//set default = nothing
$smarty->assign('svg', '');



$additional_headers = array();
$additional_headers[] = '<style type="text/css">@import "jquery.svg.css";</style>';
$additional_headers[] = '<link rel="stylesheet" type="text/css" href="jquery/ui/themes/default/ui.all.css" />';

$footer_scripts[] = '<script type="text/javascript" src="jquery/jquery.js"></script>';

$footer_scripts[] = '<script type="text/javascript" src="jquery/jquery-ui-personalized-1.6b.min.js"></script>';


$footer_scripts[] = '<script type="text/javascript" src="jquery/svg/jquery.svg.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="jquery/ui/ui.magnifier.min.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="jquery/jQuery.colorBlend.js"></script>';

$footer_scripts[] = '<script type="text/javascript" src="jquery/jquery.event.wheel.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="jquery/jquery.dimensions.js"></script>';

$additional_headers[] = '<link rel="stylesheet" media="screen" type="text/css" href="jquery/colorpicker/css/colorpicker.css" />';
$footer_scripts[] = '<script type="text/javascript" src="jquery/colorpicker/js/colorpicker.js"></script>';

$footer_scripts[] = '<script type="text/javascript" src="algorithmen.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="draw3.js"></script>';


$id=0;
if (isset($_GET['id']))
{
	//load image
	$id = intval($_GET['id']);
	$pageTitle = 'Drawing #'.$id;
	$smarty->assign('id', $id);
	/*
	$query = 'SELECT * FROM drawings WHERE `id` = '.$id.';';
	$data = mysql_query($query);
	if ($row = mysql_fetch_array($data))
	{
		$svg = $row['data'];
		$svg = unescape_string($svg);
		//$svg = FilterHTML($svg);
		if ($row['controlled'] != 'banned')
		{
			
			//$svg = str_replace("<","<svg:",$svg);
			//$svg = str_replace("<svg:/","</svg:",$svg);
			$svg = str_replace('a0:href="','href=',$svg);
			$svg = str_replace('NS1:href="','href=',$svg);
			$smarty->assign('svg', $svg);
			$smarty->assign('viewbox', "
			viewport.x = {$row['viewbox_x']};
			viewport.y = {$row['viewbox_y']};
			viewport.width = {$row['viewbox_width']};
			viewport.height = {$row['viewbox_height']};			
			zoom = ".($row['viewbox_width']/600.)."
			");
		}
		else
		{
			$smarty->assign('svg', '<text x="100" y="100" font-size="20px">Diese Skizze wurde von einem Administrator gel&ouml;scht.</text>');
			
		}
	}
	*/
}

$smarty->assign('id', $id);

$smarty->assign('additional_headers', $additional_headers);
$smarty->assign('footer_scripts', $footer_scripts);
$smarty->assign('admin', session_is_admin());


$GLOBALS['footer_scripts'] = $footer_scripts;
finish($smarty, 'draw2.tpl', $additional_headers);
?>
