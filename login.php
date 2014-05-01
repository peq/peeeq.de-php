<?
//redirect:
$target = 'http://peeeq.de/blog/wp-login.php';
if (isset($_REQUEST['backto'])) {
	$target.='?redirect_to='.$_REQUEST['backto'];
}
header( 'Location: '.$target ) ;


require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');


require_once('code_css.php'); 



//main template
$smarty->assign('main_template', 'login.tpl');
//title
$smarty->assign('title', 'Login');

//set default = nothing
$smarty->assign('error', array());
$smarty->assign('name', false);
$smarty->assign('password', false);
$smarty->assign('email', false);
$smarty->assign('nachname', false);
$smarty->assign('vorname', false);
$smarty->assign('icq', false);
$additional_headers = array();
/*
CREATE TABLE `user` (
`id` INT NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 200 ) NOT NULL ,
`nachname` VARCHAR( 200 ) NOT NULL ,
`vorname` VARCHAR( 200 ) NOT NULL ,
`joindate` DATETIME NOT NULL ,
`email` VARCHAR( 200 ) NOT NULL ,
`icq` VARCHAR( 200 ) NOT NULL ,
PRIMARY KEY ( `id` ) 
) TYPE = innodb; 
*/

$smarty->assign('referer',htmlspecialchars($_SERVER['HTTP_REFERER']));

if (isset($_POST['a']))
{
	if ($_POST['a'] == 'register')
	{
		$name = htmlspecialchars($_POST['name']);
		$password1 = htmlspecialchars($_POST['password1']);
		$password2 = htmlspecialchars($_POST['password2']);
		$email = htmlspecialchars($_POST['email']);
		$nachname = htmlspecialchars($_POST['nachname']);
		$vorname = htmlspecialchars($_POST['vorname']);
		$icq = htmlspecialchars($_POST['icq']);
		
		$smarty->assign('name', $name);
		//$smarty->assign('password', $password1);
		$smarty->assign('email', $email);
		$smarty->assign('nachname', $nachname);
		$smarty->assign('vorname', $vorname);
		$smarty->assign('icq', $icq);
		
		$error = array();
		//Eingaben validieren....
		if (strlen($name) <= 2)
		{
			//$error.='<br />Name zu kurz. (mindestens 3 Stellen)';
			$error['name'] =  'Name zu kurz. (mindestens 3 Stellen)';
		}
		if (strlen($password1) <= 3)
		{
			$error['password1'] ='Passwort zu kurz. (mindestens 4 Stellen)';
		}
		if ($password1 !=  $password2)
		{
			$error['password2'] .='Die Passwörter stimmen nicht überein.';
		}
		
		if (! preg_match('/[\.a-z0-9_-]+@[\.a-z0-9-]+.[\.a-z]/i',$email))
		{
			$error['email'] ='Keine g&uuml;ltige email-Adresse angegeben.';
		}
		
		if (! preg_match('/^[\,0-9-]*$/i',$icq))
		{
			$error['icq'] ='Keine g&uuml;ltige ICQ-Nummer angegeben.';
		}
		
		if (! preg_match('/^[a-zA-Z0-9-_\.\]\[]*$/i',$name))
		{
			$error['name'] ='Der Name enthält unerlaubte Zeichen.';
		}
		if (! preg_match('/^[a-zA-Z]*$/i',$vorname))
		{
			$error['nachname'] ='Der Name enthält nicht erlaubte Zeichen.';
		}
		if (! preg_match('/^[a-zA-Z]*$/i',$nachname))
		{
			$error['vorname'] ='Der Name enthält nicht erlaubte Zeichen.';
		}
		
		
		//name and email must be unique
		$query = 'SELECT * FROM user WHERE name = "'.mysql_real_escape_string($name).'";';
		
		if (mysql_num_rows(mysql_query($query)))
		{
			$error['name'] = "Dieser Name wird bereits verwendet.";
		}
		if (mysql_error()) echo mysql_error().'<pre>'.$query.'</pre>';
		$query = 'SELECT * FROM user WHERE email = "'.mysql_real_escape_string($email).'";';
		if (mysql_num_rows(mysql_query($query)))
		{
			$error['email'] = "Diese Email wird bereits verwendet.";
		}
		if (mysql_error()) echo mysql_error().'<pre>'.$query.'</pre>';
		
		if (count($error) > 0)
		{
			$smarty->assign('action', 'register_formular');

			$smarty->assign('error', $error);
		}
		else
		{
			$password1 = mysql_real_escape_string($password1);
			$query =  "INSERT INTO 
			user(`name`, `password`, `nachname`, `vorname`, `joindate`, `email`, `icq`)
			VALUES (\"$name\", PASSWORD(\"$password1\"), \"$nachname\", \"$vorname\", NOW(), \"$email\", \"$icq\");";
			$data = mysql_query($query, $mysqlconnection);
			echo mysql_error();
			$smarty->assign('action', 'register_complete');
			
			$query = "SELECT * FROM user WHERE `name` LIKE \"$name\" AND `email` LIKE \"$email\" ORDER BY `id` DESC;";
			$data = mysql_query($query, $mysqlconnection);
			$row = mysql_fetch_array($data);
			$_SESSION['username'] = $name;
			$_SESSION['userid'] = $row['id'];
			//update smarty
			$smarty->assign('session_is_logged_in', session_is_logged_in());
			$smarty->assign('session_username', session_get_username());		
			//..
			session_login($name,$password1);
			
		}
	}
	elseif ($_POST['a'] == 'login')
	{
		if (session_login($_POST['name'],$_POST['password']))
		{
			$target = htmlspecialchars($_POST['backto']);
			
			$additional_headers[] ='<script>document.location="'.$target.'";</script>';
			$smarty->assign('action', 'login_complete');
		}
		else
		{
			$smarty->assign('action', 'login_failed');
			$smarty->assign('name', $_POST['name']);
		}
	}
}
elseif (isset($_GET['a']))
{
	if ($_GET['a'] == 'register')
	{
		
		$smarty->assign('action', 'register_formular');
	}
	elseif ($_GET['a'] == 'logout')
	{
		session_logout();
		$smarty->assign('action', 'login_screen');
	}
}
elseif (!session_is_logged_in())
{
	$smarty->assign('action', 'login_screen');
}

$smarty->assign('additional_headers', $additional_headers);
$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
 ?>

