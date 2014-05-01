<?
require_once('mysql_cfg.php');
session_set_cookie_params(60*60*24*7); //eine woche login
session_start();



/*
CREATE TABLE `sessions` (
`id` INT NOT NULL AUTO_INCREMENT ,
`key` VARCHAR( 200 ) NOT NULL ,
`userid` INT NOT NULL ,
`time` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) 
) TYPE = innodb;
*/

/*
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nachname` varchar(200) NOT NULL,
  `vorname` varchar(200) NOT NULL,
  `joindate` datetime NOT NULL,
  `email` varchar(200) NOT NULL,
  `icq` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;
*/


function session_switch_key()
{
	$current_key = $_SESSION['sessionkey'];
	session_regenerate_id();
	$new_key = generate_key();
	
	$query = 'UPDATE sessions SET `key` = "'.$new_key.'" WHERE `key` = "'.mysql_escape_string($current_key).'";';
	mysql_query($query);
	echo mysql_error();
	$_SESSION['sessionkey'] = $new_key;
	setcookie ( "session_id", "", time() - 3600, "/");
	setcookie ( "session_id", $new_key, time()+60*60*24*30, "/");
	session_id($new_key);
}


function session_init($key, $row, $autologin = true)
{
	session_regenerate_id();
	$_SESSION['userid'] = $row['id'];
	$_SESSION['username'] = $row['name'];
	$_SESSION['uservorname'] = $row['vorname'];
	$_SESSION['usernachname'] = $row['nachname'];
	$_SESSION['sessionkey'] = $key;
	$_SESSION['sessionkey'] = $key;
	$_SESSION['lastcheck'] = time();
	//session_id($key);
	//echo "key = $key <br />";
	
	//set vars for smarty:
	global $smarty;
	if (isset($smarty))
	{
		$smarty->assign('session_is_logged_in', true);
		$smarty->assign('session_username', $row['name']);
	}
	
	if ($autologin)
	{
		//dauerhaftes cookie setzen (30 Tage)
		setcookie ( "session_id", $key, time()+60*60*24*30, "/");
	}
}

function session_reactivate($key)
{
	$query = 'SELECT * FROM sessions WHERE `key` = "'.mysql_escape_string($key).'";';
	echo mysql_error();
	$row = mysql_fetch_array(mysql_query($query));
	if ($row)
	{
		$query = 'SELECT * FROM user WHERE `id` = "'.$row['userid'].'";';
		$userdata = mysql_fetch_array(mysql_query($query));
		
		session_init($key, $userdata);
		session_switch_key();
	}
}

function generate_key()
{
	$key = false;
	$unique = false;
	while (!$unique)
	{
		$key = md5 (uniqid (rand()));
		//check if this key is really unique....
		$query = 'SELECT * FROM sessions WHERE `key` = "'.$key.'";';
		$row2 = mysql_fetch_array(mysql_query($query));
		if (!$row2)
		{
			$unique = true;
		}
	}
	return $key;
}

function session_login($_username, $_password)
{
	$username = mysql_real_escape_string($_username);
	$password = mysql_real_escape_string($_password);
	
	$query = 'SELECT * FROM user WHERE `name` = "'.$username.'" AND PASSWORD("'.$password.'") = `password`;';
	$data = mysql_query($query);
	echo mysql_error();
	
	$row = mysql_fetch_array($data);
	if ($row)
	{
		//Anmeldung erfolgreich
		
		//generate an unique key which should be hard to guess
		/*$unique = false;
		while (!$unique)
		{
			$key = md5 (uniqid (rand()));
			//check if this key is really unique....
			$query = 'SELECT * FROM sessions WHERE `key` = "'.$key.'";';
			$row2 = mysql_fetch_array(mysql_query($query));
			if (!$row2)
			{
				$unique = true;
			}
		}*/
		$key = generate_key();
		
		$query = 'INSERT INTO sessions( `key`, `userid`, `time`)
			VALUES("'.$key.'", '.$row['id'].', NOW());
		';
		$data = mysql_query($query);
		
		session_init($key, $row);
		
		return true;
	}
	else
	{	
		//Passwort oder Name falsch
		return false;
		
	}
	
}

function session_logout()
{
	$userid = session_get_userid_secure();
	$query = 'DELETE FROM sessions WHERE `userid` = "'.$userid.'";';
	$data = mysql_query($query);
	echo mysql_error();
	
	$query = 'DELETE FROM mapping_files_upload_keys WHERE `userid` = "'.$userid.'";';
	$data = mysql_query($query);
	echo mysql_error();
	
	session_destroy();
	
	//set vars for smarty:
	global $smarty;
	if (isset($smarty))
	{
		$smarty->assign('session_is_logged_in', false);
		$smarty->assign('session_username', false);
	}
	
	//delete cookie
	setcookie ( "session_id", "", time()-60*60*24*30, "/");
}



function session_is_logged_in() //not secure
{
	if (isset($_SESSION['userid']))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function session_get_username() //not secure
{ 
	if (isset($_SESSION['username']))
	{
		return $_SESSION['username'];
	}
	else
	{
		return '';
	}
}

function session_get_userid() //not secure
{
	if (isset($_SESSION['userid']))
	{
		return $_SESSION['userid'];
	}
	else
	{
		return 0;
	}
}

function session_get_userid_secure()
{
	static $useridCache = -1;
	if ($useridCache < 0) {
		if (isset($_SESSION['sessionkey']))
		{
			$query = 'SELECT * FROM sessions WHERE `key` = "'.$_SESSION['sessionkey'].'";';
			//echo "<pre>$query</pre><br>";
			//echo $_SESSION['sessionkey']."<br>";
			$data = mysql_query($query);
			$row = mysql_fetch_array($data);
			if ($row)
			{
				//echo 'key found, id = '.$row['userid'];
				$useridCache =  $row['userid'];
			}
			else
			{
				session_destroy();
				//echo 'key not found';
				$useridCache = 0;
			}
		}
		else
		{
			//echo 'key not set';
			$useridCache = 0;
		}
	}
	return $useridCache;
}

function session_get_user_secure()
{
	if (isset($_SESSION['sessionkey']))
	{
		$query = 'SELECT * FROM sessions WHERE `key` = "'.$_SESSION['sessionkey'].'";';
		//echo "<pre>$query</pre><br>";
		//echo $_SESSION['sessionkey']."<br>";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		if ($row)
		{
			//echo 'key found, id = '.$row['userid'];
			
			$query = 'SELECT * FROM user WHERE `id` = "'.$row['userid'].'";';
			$data = mysql_query($query);
			$row = mysql_fetch_array($data);
			return $row;
		}
		else
		{
			session_destroy();
			//echo 'key not found';
			return 0;
		}
	}
	else
	{
		//echo 'key not set';
		return 0;
	}
}

function session_is_admin()
{
	$user = session_get_user_secure();
	if ($user['admin'] > 0) {
		return true;
	} else {
		return false;
	}
}

function session_check_password($pw)
{
	if (isset($_SESSION['sessionkey']))
	{
		$password = mysql_real_escape_string($pw);
		$query = 'SELECT * FROM user, sessions WHERE sessions.key = "'.$_SESSION['sessionkey'].'" AND user.`id` = sessions.userid AND PASSWORD("'.$password.'") = user.`password`;';
		$row = mysql_fetch_array(mysql_query($query));
		if ($row)
		{
			//Anmeldung erfolgreich
			return true;
		}
	}
	return false;
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

if (session_is_logged_in())
{
	if ($_SESSION['lastcheck'] - time() < -60*5)
	{
		session_get_userid_secure();
		$_SESSION['lastcheck'] = time();
	}
}

if ((! session_is_logged_in()) && (isset($_COOKIE['session_id'])))
{
	//reactivate login
	session_reactivate($_COOKIE['session_id']);
}
/*
if (session_is_logged_in())
{
	//switch key for security reasons
	if (!isset($_GET['savekey']))
	{
		session_switch_key();
	}
}
*/

?>
