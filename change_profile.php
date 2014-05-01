<?
require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');

//main template
$smarty->assign('main_template', 'change_profile.tpl');
//title
$smarty->assign('title', 'Profil');

//set default = nothing
$smarty->assign('error', array());
$smarty->assign('name', false);
$smarty->assign('oldpassword', false);
$smarty->assign('password', false);
$smarty->assign('email', false);
$smarty->assign('nachname', false);
$smarty->assign('vorname', false);
$smarty->assign('icq', false);

if (!session_is_logged_in())
	die ('Du musst dich anmelden um diese Seite zu sehen.');

if (isset($_POST['a']))
{
	if ($_POST['a'] == 'update')
	{
		$name      = $_POST['name'];
		$password0 = $_POST['password0'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		$email     = $_POST['email'];
		$nachname  = $_POST['nachname'];
		$vorname   = $_POST['vorname'];
		$icq       = $_POST['icq'];
		
		$smarty->assign('name', $name);
		//$smarty->assign('password', $password1);
		$smarty->assign('email', $email);
		$smarty->assign('nachname', $nachname);
		$smarty->assign('vorname', $vorname);
		$smarty->assign('icq', $icq);
		$error = array();
		
		$user = session_get_user_secure();
		
		//Eingaben validieren....
		if (strlen($name) <= 2)
		{
			//$error.='<br />Name zu kurz. (mindestens 3 Stellen)';
			$error['name'] =  'Name zu kurz. (mindestens 3 Stellen)';
		}
		if (($password1 != '') && (strlen($password1) <= 3))
		{
			$error['password1'] ='Passwort zu kurz. (mindestens 4 Stellen)';
		}
		if (($password1 != '') && (!session_check_password($password0)))
		{
			$error['password2'] .='Das alte Passwort stimmt nicht.';
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
		$query = 'SELECT * FROM user WHERE `id` != '.$user['id'].' AND name = "'.mysql_real_escape_string($name).'";';
		
		if (mysql_num_rows(mysql_query($query)))
		{
			$error['name'] = "Dieser Name wird bereits verwendet.";
		}
		if (mysql_error()) echo mysql_error().'<pre>'.$query.'</pre>';
		$query = 'SELECT * FROM user WHERE `id` != '.$user['id'].' AND email = "'.mysql_real_escape_string($email).'";';
		if (mysql_num_rows(mysql_query($query)))
		{
			$error['email'] = "Diese Email wird bereits verwendet.";
		}
		if (mysql_error()) echo mysql_error().'<pre>'.$query.'</pre>';
		
		
		
		if (soundex($name) != soundex($user['name']))
		{
			$error['name'] = "Dein neuer Name muss so ähnlich klingen, wie dein alter Name. Das Ändern des Names dient nur zur Beseitigung von Tippfehlern.";
		}
		if (($user['vorname'] != '') && (soundex($vorname) != soundex($user['vorname'])))
		{
			$error['vorname'] = "Dein neuer Name muss so ähnlich klingen, wie dein alter Name. Das Ändern des Names dient nur zur Beseitigung von Tippfehlern.";
		}
		if (($user['nachname'] != '') && (soundex($nachname) != soundex($user['nachname'])))
		{
			$error['nachname'] = "Dein neuer Name muss so ähnlich klingen, wie dein alter Name. Das Ändern des Names dient nur zur Beseitigung von Tippfehlern.";
		}
		
		if (count($error) > 0)
		{
			$smarty->assign('error', $error);
		}
		else
		{
			$query =  "UPDATE user SET
			`name` = \"$name\",";
			if ($password1 != '')
			{
				$query .= 'password = PASSWORD("'.mysql_real_escape_string($password1).'") , ';
			}
			$query.= "
			`nachname` = \"$nachname\", 
			`vorname` = \"$vorname\", 
			`email` = \"$email\", 
			`icq` = \"$icq\"
			WHERE `id` = ".session_get_userid_secure().";";
			$data = mysql_query($query, $mysqlconnection);
			echo mysql_error();
			
			
			
			
			$smarty->assign('session_is_logged_in', session_is_logged_in());
			$smarty->assign('session_username', $name);		
			
			
		}
	}	
}
else
{
	$user = session_get_user_secure();
	$smarty->assign('name', $user['name']);
	$smarty->assign('password', '');
	$smarty->assign('email',  $user['email']);
	$smarty->assign('nachname',  $user['nachname']);
	$smarty->assign('vorname',  $user['vorname']);
	$smarty->assign('icq',  $user['icq']);
}

$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
?>
