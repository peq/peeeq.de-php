<?

require_once('common.php');

function session_is_logged_in() //not secure
{
	$user = wp_get_current_user();
	return $user->id > 0;
}


function session_get_username() //not secure
{ 
	$user = wp_get_current_user();
	return $user->user_nicename;
}

function session_get_userid() //not secure
{
	$user = wp_get_current_user();
	return $user->id;
}

function session_get_userid_secure()
{
	$user = wp_get_current_user();
	return $user->id;
}

function session_is_admin()
{
	$user = wp_get_current_user();
	return isset($user->wp_capabilities['administrator']) && $user->wp_capabilities['administrator'] == 1;
}

function get_save_link_key($key)
{
	if (isset($_SESSION['sessionkey']))
		return md5($_SESSION['sessionkey'].$key);
	return '';
}


//set vars for smarty:
if (isset($smarty))
{
	$smarty->assign('session_is_logged_in', session_is_logged_in());
	$smarty->assign('session_username', session_get_username());
	$smarty->assign('session_userid', session_get_userid());
	$smarty->assign('session_admin', session_is_admin());
}

?>
