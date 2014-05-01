<?
require_once('add_smarty.php');
require_once("session.php"); 
require_once('mysql_cfg.php');
require_once('bbcode.php');

/*
CREATE TABLE `comments` (
`id` INT NOT NULL AUTO_INCREMENT ,
`topicid` INT NOT NULL,
`userid` INT NOT NULL ,
`username` VARCHAR( 100 ) NOT NULL ,
`datum` DATETIME NOT NULL ,
`text` LONGTEXT NOT NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `datum` ) 
) TYPE = innodb;
*/

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

function getip() 
{
	if (isSet($_SERVER)) 
	{
		if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) 
		{
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} 
		elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) 
		{
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} 
		else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} 
	else 
	{
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) 
		{
			$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} 
		elseif ( getenv( 'HTTP_CLIENT_IP' ) ) 
		{
			$realip = getenv( 'HTTP_CLIENT_IP' );
		} 
		else {
			$realip = getenv( 'REMOTE_ADDR' );
		}
	}
	return $realip;
}


function make_ago_timer2 ($_seconds)
{
	$seconds =intval($_seconds);
	if ($seconds > (60*60*24) )
	{
		$i = intval($seconds / (60*60*24));
		return ($i > 1) ? "$i Tagen" : "einem Tag";
	}
	elseif ($seconds > (60*60) )
	{
		$i = intval($seconds / (60*60));
		return ($i > 1) ? "$i Stunden" : "einer Stunde";
	}
	elseif ($seconds > (60) )
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

function get_topic_comment_count($topic)
{
	$query = 'SELECT count(*) as c FROM comments WHERE topicid = '.$topic.';';
	$row = mysql_fetch_array(mysql_query($query));
	return $row['c'];
}

function add_page_switcher($topic, $cur_from, $posts_per_page = 10)
{
	
	$count = get_topic_comment_count($topic);
	$i = 0;
	$comment_pages = array();
	while ($i*$posts_per_page < $count)
	{
		$i++;
		$comment_pages[] = array("i" => $i, "from" => ($i-1)*$posts_per_page, "count" => $posts_per_page, "current" => (($i-1)*$posts_per_page == $cur_from));
	}
	global $smarty;
	$smarty->assign('comment_pages', $comment_pages);
}


function add_comments($topic, $from = 0, $count = 10)
{
	$query = 'SELECT *, UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(datum) as diff_datum FROM comments WHERE topicid = '.$topic.' ORDER BY datum DESC LIMIT '.$from.', '.$count.';';
	$data = mysql_query($query);
	$comments = array();
	while ($row = mysql_fetch_array($data))
	{
		$comments[] = array_merge($row,array(
			"ago_time"    => make_ago_timer2($row['diff_datum']), 
			"parsed_text" => bbcode_parse(unescape_string($row['text']))));
		//$comments[] = array_merge($row,array("ago_time" => make_ago_timer2($row['diff_datum']), "parsed_text" => "<pre>".htmlspecialchars($row['text'])."</pre>"));
	}
	global $smarty;
	$smarty->assign('comments', $comments);
	
	add_page_switcher($topic, $from);
}

if (isset($_POST['ajax']))
{
	$action = $_POST['ajax'];

	
	if ($action == "addcomments")
	{

		$topic = intval($_POST['topic']);
		$from = intval($_POST['from']);
		$count = intval($_POST['count']);
		
		
/*
CREATE TABLE `comments` (
`id` INT NOT NULL AUTO_INCREMENT ,
`topicid` INT NOT NULL,
`userid` INT NOT NULL ,
`username` VARCHAR( 100 ) NOT NULL ,
`datum` DATETIME NOT NULL ,
`text` LONGTEXT NOT NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `datum` ) 
) TYPE = innodb;
*/
		$user = session_get_user_secure();
		$userid = 0;
		$username = "";
		$ip = "";
		$hostname = "";
		$time_left = 0;
		$guest_comment_delay = 60*3;
		$guest_comment_delay = 0;
		$captchacorrect = true;
		if ($user)
		{
			$userid = $user['id'];
			$username = $user['name'];
		}
		else
		{
		die("Gast-Kommentare sind wegen Spam-Problemen momentan deaktiviert.");	$username = "Gast ( ".mysql_escape_string(htmlspecialchars($_POST['username']))." )";
			$ip = mysql_real_escape_string(getip());
			$hostname = gethostbyaddr($ip);
			$query = 'SELECT (UNIX_TIMESTAMP(`datum`)+'.$guest_comment_delay.' - UNIX_TIMESTAMP(NOW())) as time FROM comments WHERE `ip` = "'.$ip.'" AND UNIX_TIMESTAMP(`datum`) > UNIX_TIMESTAMP(NOW())-'.$guest_comment_delay.' ORDER BY `datum` DESC;';
			$row = mysql_fetch_array(mysql_query($query));
			echo mysql_error();
			if ($row)
			{
				$time_left = $row['time'];
				
			}
			
			//captcha
			$captcha = "";
			if (isset($_POST['captcha']))
			{
				$captcha = $_POST['captcha'];
			}
			if (strtolower($captcha) != strtolower($_SESSION['captcha']))
			{
				$captchacorrect = false;
			}
			else
			{
				$_SESSION['captcha'] = "";
			}
		}
		
		
		
		//$text = mysql_escape_string(nl2br(htmlspecialchars($_POST['text'])));
		
		$text = mysql_escape_string($_POST['text']);
		$text = trim($text);
		$text = str_replace("Â"," ",$text);
		
		
		if ($time_left > 0)
		{
			if ($_POST['method'] == "ajax")
			{
				echo "<span class=\"error\">Du darfst als Gast nicht so schnell Kommentare posten. Bitte warte noch $time_left Skeunden</span>";
				add_comments($topic, 0, $count);
				$smarty->assign('draw_comments_form', false);
				$smarty->display('comments.tpl');
			}
		}
		elseif (!$captchacorrect)
		{
			if ($_POST['method'] == "ajax")
			{
				echo "<span class=\"error\">Der eingegebene Captcha-Code war falsch.</span>";
				add_comments($topic, 0, $count);
				$smarty->assign('draw_comments_form', false);
				$smarty->display('comments.tpl');
			}		
		}
		else
		{
			if (!$text)
			{
				if ($_POST['method'] == "ajax")
				{
					echo '<span class="error">Kein Text eingegeben.</span>';
					add_comments($topic, 0, $count);
					$smarty->assign('draw_comments_form', false);
					$smarty->display('comments.tpl');
				}
			}
			else
			{
				//check for spam
				/*
				require_once("add_akismet.php");
				#
				$akismet->setCommentAuthor($username);
				$akismet->setCommentContent($text);
				$akismet->setPermalink('http://peq.bplaced.de/');
				//$akismet->setUserIP($ip); 
				$akismet->setCommentType("comment");
				$is_spam = 0;
				
				
				
				if($akismet->isCommentSpam())
				{
					$is_spam = 1;
				}
				*/
				$is_spam = 0;				
				//
				
				$query = 'INSERT INTO comments (`topicid`, `userid`, `username`, `datum`, `text`, `ip`, `host`, `spam`)
				VALUES("'.$topic.'", "'.$userid.'", "'.$username.'", NOW(), "'.$text.'", "'.$ip.'", "'.$hostname.'","'.($is_spam*100).'")
				;';
				$data = mysql_query($query);
				echo mysql_error();
				
				if ($_POST['method'] == "ajax")
				{
					add_comments($topic, 0, $count);
					
					$smarty->assign('draw_comments_form', false);
					$smarty->display('comments.tpl');
				}
			}			
		}
		
	}
}
if (isset($_GET['ajax']))
{
	$action = $_GET['ajax'];
	if ($action == "changepage")
	{
		$from  = isset($_GET['from'] ) ? intval($_GET['from'])  : 0;
		$count = isset($_GET['count']) ? intval($_GET['count']) : 10;
		$topic = isset($_GET['topic']) ? intval($_GET['topic']) : 0;
		add_comments($topic, $from, $count);
		$smarty->assign('draw_comments_form', false);
		$smarty->display('comments.tpl');
	}
}

$additional_headers[] = '<link rel="stylesheet" type="text/css" href="bbcode.css" />';
$smarty->assign('additional_headers', $additional_headers);

?>
