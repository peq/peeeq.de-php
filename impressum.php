<?
require_once("add_smarty.php"); 
require_once("session.php"); 
require_once("mysql_cfg.php"); 


//title
$smarty->assign('title', 'Impressum');

//main template
$smarty->assign('main_template', 'impressum.tpl');

//display everything
$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');

?>