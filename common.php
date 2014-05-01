<?php

require_once( 'blog/wp-load.php' );

require_once("add_smarty.php");
require_once('mysql_cfg.php');
require_once('session.php');

$pageTitle = "peeeq.de";

// Change the page title: 
function assignPageTitle(){
	global $pageTitle;
	return $pageTitle;
}
add_filter('wp_title', 'assignPageTitle');


function finish($smarty, $template, $additional_headers, $noHeaderImage = true) {
	$GLOBALS['USE_PEEEQ_STYLE'] = true;
	$GLOBALS['NO_HEADER_IMAGE'] = $noHeaderImage;
	$GLOBALS['additional_headers'] = $additional_headers;

	get_header();
	$smarty->display($template);
	get_footer();
}
