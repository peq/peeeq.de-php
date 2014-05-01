<?
//@ TODO : unkink thumbs when deleting files.




require_once('common.php');

require_once('uploader.class.php');
require_once('create_thumbnail.php');



function getMimeType($filename) 
{ 
    $mime = "unknown";
	if (extension_loaded('Fileinfo')) 
    { 
        $finfo = finfo_open(FILEINFO_MIME); 
        $mimetype = finfo_file($finfo, $filename); 
        finfo_close($finfo); 
        return $mimetype; 
    } 
    else 
    { 
        $filetype = strtolower(strrchr($filename, ".")); 

        switch ($filetype) 
        { 
   case ".zip": $mime="application/zip"; break; 
   case ".ez":  $mime="application/andrew-inset"; break; 
   case ".hqx": $mime="application/mac-binhex40"; break; 
   case ".cpt": $mime="application/mac-compactpro"; break; 
   case ".doc": $mime="application/msword"; break; 
   case ".bin": $mime="application/octet-stream"; break; 
   case ".dms": $mime="application/octet-stream"; break; 
   case ".lha": $mime="application/octet-stream"; break; 
   case ".lzh": $mime="application/octet-stream"; break; 
   case ".exe": $mime="application/octet-stream"; break; 
   case ".class": $mime="application/octet-stream"; break; 
   case ".so":  $mime="application/octet-stream"; break; 
   case ".dll": $mime="application/octet-stream"; break; 
   case ".oda": $mime="application/oda"; break; 
   case ".pdf": $mime="application/pdf"; break; 
   case ".ai":  $mime="application/postscript"; break; 
   case ".eps": $mime="application/postscript"; break; 
   case ".ps":  $mime="application/postscript"; break; 
   case ".smi": $mime="application/smil"; break; 
   case ".smil": $mime="application/smil"; break; 
   case ".xls": $mime="application/vnd.ms-excel"; break; 
   case ".ppt": $mime="application/vnd.ms-powerpoint"; break; 
   case ".wbxml": $mime="application/vnd.wap.wbxml"; break; 
   case ".wmlc": $mime="application/vnd.wap.wmlc"; break; 
   case ".wmlsc": $mime="application/vnd.wap.wmlscriptc"; break; 
   case ".bcpio": $mime="application/x-bcpio"; break; 
   case ".vcd": $mime="application/x-cdlink"; break; 
   case ".pgn": $mime="application/x-chess-pgn"; break; 
   case ".cpio": $mime="application/x-cpio"; break; 
   case ".csh": $mime="application/x-csh"; break; 
   case ".dcr": $mime="application/x-director"; break; 
   case ".dir": $mime="application/x-director"; break; 
   case ".dxr": $mime="application/x-director"; break; 
   case ".dvi": $mime="application/x-dvi"; break; 
   case ".spl": $mime="application/x-futuresplash"; break; 
   case ".gtar": $mime="application/x-gtar"; break; 
   case ".hdf": $mime="application/x-hdf"; break; 
   case ".js":  $mime="application/x-javascript"; break; 
   case ".skp": $mime="application/x-koan"; break; 
   case ".skd": $mime="application/x-koan"; break; 
   case ".skt": $mime="application/x-koan"; break; 
   case ".skm": $mime="application/x-koan"; break; 
   case ".latex": $mime="application/x-latex"; break; 
   case ".nc":  $mime="application/x-netcdf"; break; 
   case ".cdf": $mime="application/x-netcdf"; break; 
   case ".sh":  $mime="application/x-sh"; break; 
   case ".shar": $mime="application/x-shar"; break; 
   case ".swf": $mime="application/x-shockwave-flash"; break; 
   case ".sit": $mime="application/x-stuffit"; break; 
   case ".sv4cpio": $mime="application/x-sv4cpio"; break; 
   case ".sv4crc": $mime="application/x-sv4crc"; break; 
   case ".tar": $mime="application/x-tar"; break; 
   case ".tcl": $mime="application/x-tcl"; break; 
   case ".tex": $mime="application/x-tex"; break; 
   case ".texinfo": $mime="application/x-texinfo"; break; 
   case ".texi": $mime="application/x-texinfo"; break; 
   case ".t":   $mime="application/x-troff"; break; 
   case ".tr":  $mime="application/x-troff"; break; 
   case ".roff": $mime="application/x-troff"; break; 
   case ".man": $mime="application/x-troff-man"; break; 
   case ".me":  $mime="application/x-troff-me"; break; 
   case ".ms":  $mime="application/x-troff-ms"; break; 
   case ".ustar": $mime="application/x-ustar"; break; 
   case ".src": $mime="application/x-wais-source"; break; 
   case ".xhtml": $mime="application/xhtml+xml"; break; 
   case ".xht": $mime="application/xhtml+xml"; break; 
   case ".zip": $mime="application/zip"; break; 
   case ".au":  $mime="audio/basic"; break; 
   case ".snd": $mime="audio/basic"; break; 
   case ".mid": $mime="audio/midi"; break; 
   case ".midi": $mime="audio/midi"; break; 
   case ".kar": $mime="audio/midi"; break; 
   case ".mpga": $mime="audio/mpeg"; break; 
   case ".mp2": $mime="audio/mpeg"; break; 
   case ".mp3": $mime="audio/mpeg"; break; 
   case ".aif": $mime="audio/x-aiff"; break; 
   case ".aiff": $mime="audio/x-aiff"; break; 
   case ".aifc": $mime="audio/x-aiff"; break; 
   case ".m3u": $mime="audio/x-mpegurl"; break; 
   case ".ram": $mime="audio/x-pn-realaudio"; break; 
   case ".rm":  $mime="audio/x-pn-realaudio"; break; 
   case ".rpm": $mime="audio/x-pn-realaudio-plugin"; break; 
   case ".ra":  $mime="audio/x-realaudio"; break; 
   case ".wav": $mime="audio/x-wav"; break; 
   case ".pdb": $mime="chemical/x-pdb"; break; 
   case ".xyz": $mime="chemical/x-xyz"; break; 
   case ".bmp": $mime="image/bmp"; break; 
   case ".gif": $mime="image/gif"; break; 
   case ".ief": $mime="image/ief"; break; 
   case ".jpeg": $mime="image/jpeg"; break; 
   case ".jpg": $mime="image/jpeg"; break; 
   case ".jpe": $mime="image/jpeg"; break; 
   case ".png": $mime="image/png"; break; 
   case ".tiff": $mime="image/tiff"; break; 
   case ".tif": $mime="image/tiff"; break; 
   case ".djvu": $mime="image/vnd.djvu"; break; 
   case ".djv": $mime="image/vnd.djvu"; break; 
   case ".wbmp": $mime="image/vnd.wap.wbmp"; break; 
   case ".ras": $mime="image/x-cmu-raster"; break; 
   case ".pnm": $mime="image/x-portable-anymap"; break; 
   case ".pbm": $mime="image/x-portable-bitmap"; break; 
   case ".pgm": $mime="image/x-portable-graymap"; break; 
   case ".ppm": $mime="image/x-portable-pixmap"; break; 
   case ".rgb": $mime="image/x-rgb"; break; 
   case ".xbm": $mime="image/x-xbitmap"; break; 
   case ".xpm": $mime="image/x-xpixmap"; break; 
   case ".xwd": $mime="image/x-xwindowdump"; break; 
   case ".igs": $mime="model/iges"; break; 
   case ".iges": $mime="model/iges"; break; 
   case ".msh": $mime="model/mesh"; break; 
   case ".mesh": $mime="model/mesh"; break; 
   case ".silo": $mime="model/mesh"; break; 
   case ".wrl": $mime="model/vrml"; break; 
   case ".vrml": $mime="model/vrml"; break; 
   case ".css": $mime="text/css"; break; 
   case ".html": $mime="text/html"; break; 
   case ".htm": $mime="text/html"; break; 
   case ".asc": $mime="text/plain"; break; 
   case ".txt": $mime="text/plain"; break; 
   case ".rtx": $mime="text/richtext"; break; 
   case ".rtf": $mime="text/rtf"; break; 
   case ".sgml": $mime="text/sgml"; break; 
   case ".sgm": $mime="text/sgml"; break; 
   case ".tsv": $mime="text/tab-separated-values"; break; 
   case ".wml": $mime="text/vnd.wap.wml"; break; 
   case ".wmls": $mime="text/vnd.wap.wmlscript"; break; 
   case ".etx": $mime="text/x-setext"; break; 
   case ".xml": $mime="text/xml"; break; 
   case ".xsl": $mime="text/xml"; break; 
   case ".mpeg": $mime="video/mpeg"; break; 
   case ".mpg": $mime="video/mpeg"; break; 
   case ".mpe": $mime="video/mpeg"; break; 
   case ".qt":  $mime="video/quicktime"; break; 
   case ".mov": $mime="video/quicktime"; break; 
   case ".mxu": $mime="video/vnd.mpegurl"; break; 
   case ".avi": $mime="video/x-msvideo"; break; 
   case ".movie": $mime="video/x-sgi-movie"; break; 
   case ".asf": $mime="video/x-ms-asf"; break; 
   case ".asx": $mime="video/x-ms-asf"; break; 
   case ".wm":  $mime="video/x-ms-wm"; break; 
   case ".wmv": $mime="video/x-ms-wmv"; break; 
   case ".wvx": $mime="video/x-ms-wvx"; break; 
   case ".ice": $mime="x-conference/x-cooltalk"; break; 
   case ".w3x": $mime="application/w3x"; break; 
   case ".w3m": $mime="application/w3m"; break; 
   case ".w3g": $mime="application/w3g"; break; 
        } 

        return $mime; 
    } 
} 


//main template
$smarty->assign('main_template', 'upload.tpl');
//title
$pageTitle =  'Uploads';

//set default = nothing




$errors = array();
$notices = array();

$ordner= 0;
$download = false;
$sort=0;
$folderexists = true;

if (isset($_GET['path']))
{
	$pageTitle = 'uploads/'.htmlspecialchars($_GET['path']);
	
	$folders = explode("/",$_GET['path']);
	$ordner = 0;
	foreach ($folders as $folder)
	{
		if ($folder == "")
		{
			echo $folder;
			continue;
		}
		$query = 'SELECT * 
		FROM mapping_files 
		WHERE ordner = "'.$ordner.'"
		AND name = "'.mysql_real_escape_string($folder).'";';
		$data = mysql_query($query);
		
		echo mysql_error();
		if ($row = mysql_fetch_array($data))
		{
			if ($row['istordner'])
			{
				$ordner = $row['id'];
				$folderexists = true;
			}
			else
			{
				$ordner = $row['id'];
				$folderexists = true;
				$download = $row;
			}
		}
		else
		{
			header("Status: 404 Not Found");
			$errors[] ='Ordner "'.htmlspecialchars($folder).'" existiert nicht';
			$folderexists = false;
			//$ordner = 0;
			break;
		}
	}
	if (($_GET['path'] == "/") or ($_GET['path'] == ""))
		$ordner = 0;
}


if (isset($_GET["o"])) {
	$ordner = intval($_GET["o"]);
	$o = $ordner;
	$path = "";
	//calc path
	while ($o > 0) {
		$query = '
		SELECT name, ordner FROM mapping_files
		WHERE `id` = "'.$o.'" 
		;
		';
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$o = $row['ordner'];
		$path = $row['name']."/$path";
	}
	
	// Permanent redirection
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://peeeq.de/uploads/".$path);
	exit();
}
if (isset($_POST["o"]))
	$ordner = intval($_POST["o"]);
if (isset($_GET["s"]))
	$sort = intval($_GET["s"]);



	
$sortby="name";
if ($sort==0)
{
	$sortby="name";
}
elseif ($sort==2)
{

}

/*
id
ordner
name
istordner
filesize
filetype
file
*/

error_reporting(9999);
if (isset($_POST['c']))
{
	
	$command = $_POST['c'];
	if ($command=="upload")
	{
		
		$uploader = new Uploader();
		$uploadresult = $uploader->upload($_FILES['userfile'], $ordner);
		if ($uploadresult < 0) {
			$errors[] = $uploader->errorMessage($uploadresult);			
		} else {
			$notices[] ='<br>Datei wurde gespeichert!';
		}
		
		
		/*
		if (session_get_userid_secure() > 0) {
				
			
			//$not_allowed=array(".php",".cgi",".php3",".php4",".php5");
			$not_allowed=array();
			$change_ext=array(".php",".cgi",".php3",".php4",".php5");
			
			$dotpos = strrpos($_FILES['userfile']['name'],".");
			$data_type = substr($_FILES['userfile']['name'],$dotpos,strlen($_FILES['userfile']['name']));
			
			
			if (preg_match('/^[a-zA-Z0-9_\-\ \(\)\.\!\§\$\%\&]+$/', $_FILES['userfile']['name'])) {
				if ( ! in_array($data_type, $not_allowed))
				{
				  
					//echo substr($_FILES['userfile']['type'],0,11);
					//check if folder exists:
					$uploadfolderexists = false;
					$query = 'SELECT istordner FROM mapping_files WHERE `id` = '.$ordner.';';
					$data = mysql_query($query);
					if ($row = mysql_fetch_array($data)) {
						$uploadfolderexists = $row['istordner'];
					} 
					
					if (($uploadfolderexists)&&($ordner > 0)) {
				  
						if ($_FILES['userfile']['name']!='')
						{
						  $key = md5 (uniqid (rand()));
						  $destination='uploads/'.$key.basename($_FILES['userfile']['name']);
						  if (  in_array($data_type, $change_ext))
						  {
							$destination.=".txt";
						  }
						  if (! move_uploaded_file($_FILES['userfile']['tmp_name'], $destination) ) 
						  {
								$temperror ="Beim uploaden der Datei ist ein Fehler aufgetreten... <br />";
								if ($_FILES['userfile']['error'] == 0)
								{
									$temperror .= 'Die Datei wurde erfolgreich hochgeladen, aber konnte nicht richtig gespeichert werden.';
								}
								elseif ($_FILES['userfile']['error'] == 1)
								{
									$temperror .= 'Die hochgeladene Datei überschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Größe.';
								}
								elseif ($_FILES['userfile']['error'] == 2)
								{
									$temperror .= 'Die hochgeladene Datei überschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigröße.';
								}
								elseif ($_FILES['userfile']['error'] == 3)
								{
									$temperror .= 'Die Datei wurde nur teilweise hochgeladen.';
								}
								elseif ($_FILES['userfile']['error'] == 4)
								{
									$temperror .= 'Es wurde keine Datei hochgeladen.';
								}

								 $errors[] = $temperror; //"Beim uploaden der Datei ist ein Fehler aufgetreten. ".$_FILES['userfile']['error']."...<br>".$_FILES['userfile']['type']."<br>".$_FILES['userfile']['size']."<br>".$_FILES['userfile']['tmp_name']."<br>".$_FILES['userfile']['name'];
								 
								 
								 //$hreftarget='no';
						  }
						  else
						  {
							  $notices[] ='<br>Datei wurde gespeichert!';
							  $name=$_FILES['userfile']['name'];
							  $filesize=intval($_FILES['userfile']['size']/1024);
							  //$filetype=$_FILES['userfile']['type'];
							  $filetype=getMimeType($destination);
							  //$filetype=mime_content_type($destination);
							  $owner = session_get_userid_secure();
							  
							  $query='
							  INSERT INTO
							  mapping_files(`ordner`,`istordner`,`name`,`filesize`,`filetype`,`file`,`datum`, `owner`)
							  VALUES ("'.$ordner.'",false,"'.$name.'","'.$filesize.'","'.$filetype.'","'.$destination.'", NOW(), "'.$owner.'")
							  ;
							  ';
							  //make unexecutable
							  chmod ($destination, 0750);
							  
							  $data=mysql_query($query,$mysqlconnection);
							  echo mysql_error();
							  
							  if (in_array($data_type, array(".jpg",".bmp",".gif",".png",".jpeg")))
							  {
								//create thumb:
								$thumbpath = $destination.'thumb';
								createthumb($destination, $thumbpath, 21, 21);
								//create bigthumb:
								$thumbpath = $destination.'bigthumb';
								createthumb($destination, $thumbpath, 100, 100);
							  }
							  
							  
							  //update filesizes and dates of parent-folders.
							  $parentfolderIDs = array();
							  $currenordner = $ordner;
							  while ($currentordner != 0) {		
								$parenfolderIDs[] = $currentordner;
								$query='SELECT `folder` FROM mapping_files WHERE `id` = '.$currentordner.';';
								$data = mysql_query($query);
								if (mysql_error()) {
									echo "<pre>".mysql_error()."
									$query
									</pre>";
								}
								$row = mysql_fetch_array($data);
								$currenordner = $row['folder'];
							  }
							  
							  $query = 'UPDATE mapping_files SET filesize = filesize + '.$filesize.'
										, datum = NOW()
										WHERE `id` in ('.implode(",",$parenfolderIDs).');';
								$data=mysql_query($query);
								if (mysql_error()) {
									echo "<pre>".mysql_error()."
									$query
									</pre>";
								}
						  }
						}
					} else {
						$errors[] ="Beim uploaden der Datei ist ein Fehler aufgetreten.<br>Der Ordner, in dem die Datei gespeichert werden sollte exisiert nicht, oder es wurde versucht eine Datei ins Hauptverzeichnis hochzuladen.";
					}
				} 
				else 
				{
					 $errors[] ="Beim uploaden der Datei ist ein Fehler aufgetreten.<br> Der Dateityp $data_type (".$_FILES['userfile']['type'].") ist nicht erlaubt!<br>Wenn der Type erlaubt werden soll, dann sag peq (<a href=\"mailto:peq88@aol.com\">peq88@aol.com</a>) bescheid!";
				}
			}
			else {
				$errors[] = "Der Dateiname enthält nicht erlaubte Zeichen.";
			}
		} else {
			$errors[] = "Als Gast darf man keine Dateien hochladen.";
		}		
		*/
    
	}
	elseif ($command=="newfolder")
	{	
		if (session_get_userid_secure() > 0) {
			$name = htmlspecialchars($_POST['folder']);
			$owner = session_get_userid_secure();
			
			if (preg_match('/^[a-zA-Z0-9_\-\ \(\)\.]+$/', $name)) {
			
				$query='
					  INSERT INTO
					  mapping_files(`ordner`,`istordner`,`name`,`filesize`,`filetype`,`file`,`datum`, `owner`)
					  VALUES ("'.$ordner.'",true,"'.$name.'","-","Ordner","", NOW(), "'.$owner.'")
					  ;
					  ';
				$data=mysql_query($query,$mysqlconnection);
				echo mysql_error();
				$notices[] ='Ordner erstellt';
			} else {
				$errors[] = "\"<i>$name</i>\" ist ein ungültiger Ordnername. Erlaubte Zeichen sind Buchstaben, Zahlen, Bindestriche, Punkte, Unterstriche und Klammern.";
			}
		}
		else {
			$errors[] = "Als Gast darf man keine Ordner erstellen.";
		}
	}
}

if (isset($_GET['c']))
{
	if ($_GET['c'] == "delete")
	{
		$id = intval($_GET['id']);
		$userid = session_get_userid_secure();
		if ($_GET['savekey'] == get_save_link_key($id))
		{
			if ($userid > 0)
			{
				$query = 'SELECT * FROM mapping_files WHERE `id` = "'.$id.'" AND ( owner = "'.$userid.'" OR owner = 0);';
				$data = mysql_query($query, $mysqlconnection);
				$row = mysql_fetch_array($data);
				
				if ($row['istordner']) {
					$query = 'SELECT * FROM mapping_files WHERE `ordner` = "'.$id.'"';
					$data = mysql_query($query, $mysqlconnection);
					if (mysql_affected_rows() > 0) {
						$notices[] = 'Der Ordner ist nicht leer und kann deshalb nicht gelöscht werden.';
					} else {					
						$query = '  DELETE 
									FROM mapping_files
									WHERE `id` = "'.$id.'" AND (( owner = "'.$userid.'" OR owner = 0) OR '.intval(session_is_admin()).') 
									;		';
						$data=mysql_query($query,$mysqlconnection);
						
						echo mysql_error();	
						if (mysql_affected_rows() > 0) {
							$notices[] = 'Ordner gelöscht.';
						} else {
							$notices[] = '<pre>'.$query.'</pre>Keine Rechte, um Ordner zu löschen.';
						}
					}
				} else {				
					//delete file:
					if (file_exists($row['file']))
					{
						unlink($row['file']);
					}
					if (file_exists($row['file'].'thumb'))
					{
						unlink($row['file'].'thumb');
					}			
					
					$query = '  DELETE 
								FROM mapping_files
								WHERE `id` = "'.$id.'" AND (( owner = "'.$userid.'" OR owner = 0) OR '.(session_is_admin() ? 'TRUE' : 'FALSE') .') 
								;		';
					$data=mysql_query($query,$mysqlconnection);
					if (mysql_error()) {
						error_log ("Error in Line ".__LINE__."\n"
						. $query
						. mysql_error()	
						. "\n");
					} 
					if (mysql_affected_rows() > 0) {
						$notices[] = 'Datei gelöscht.';
					} else {
						$notices[] = 'Keine Rechte, um Datei zu löschen.';
					}
				}
			}
			else
			{
				$notices[] = 'Nicht angemeldet.';
			}
		}
		else
		{
			$notices[] = 'Ungültiger Lösch-Link.';
		}
	}
}

$backpath = "";
$path = ""; 
//$notices[] = "if $folderexists";
if ($folderexists) {

	$nav_ordner = array();
	$nav_count = 0;
	$nav_ordner[0]["id"] = $ordner;

	while ($nav_ordner[$nav_count]["id"] != 0)
	{
		
		$query = '
		SELECT name, ordner FROM mapping_files
		WHERE `id` = "'.$nav_ordner[$nav_count]["id"].'" 
		;
		';
		$row = mysql_fetch_array(mysql_query($query, $mysqlconnection));
		if (mysql_error()) echo "a<br><pre>$query</pre><br><br><pre>".mysql_error()."</pre>";
		if ($row["name"] != "")
		{
			$nav_ordner[$nav_count]["name"] = $row["name"];
		}
		else
		{
			$nav_ordner[$nav_count]["name"] = "???";
		}
		$nav_count++;
		$nav_ordner[$nav_count]["id"] = $row["ordner"];	
	}

	$nav_ordner = array_reverse($nav_ordner);



	$query = '
	SELECT name FROM mapping_files
	WHERE `id` = "'.$nav_ordner[$nav_count]["id"].'" 
	;
	';
	$row = mysql_fetch_array(mysql_query($query, $mysqlconnection));
	if (mysql_error()) echo "b<br><pre>$query</pre><br><br><pre>".mysql_error()."</pre>";
	$nav_ordner[$nav_count]["name"] = $row["name"];

	
	for ($pos = sizeof($nav_ordner)-1; $pos >= 0 ; $pos--)
	{
		$nav_ordner[$pos]['path'] = $backpath;
		$backpath.="../";
	}

	$smarty->assign('nav_ordner', $nav_ordner);
	$smarty->assign('ordner', $ordner);


	$path = "";
	$backpath = "..";
	for ($pos = 1; $pos < sizeof($nav_ordner); $pos++)
	{
		if ($pos > 1)
		{
			$path.= "/";
			
		}
		$backpath.="/..";
		$path.= $nav_ordner[$pos]['name'];
	}
	$backpath.="/";


	/*$ausgabe.= '<a href="upload.php">uploads</a>';
	for ($i=$nav_count-1;$i>=0;$i--)
	{
		$ausgabe.=' -> <a href="upload.php?o='.$nav_ordner[$i]["id"].'">'.$nav_ordner[$i]["name"].'</a>';
	}$ausgabe.= '<a href="upload.php">uploads</a>';
	*/




	/*
	$query = '
	SELECT ordner FROM mapping_files
	WHERE `id` = '.$ordner.' 
	;
	';
	$data = mysql_query($query, $mysqlconnection);	
	$row = mysql_fetch_array($data);
	$ausgabe.='<td><img src="ordner.gif"></td>';
	$ausgabe.='<td><a href="upload.php?o='. $row['ordner'] .'">..</a></td>';
	$ausgabe.='<td>Ordner</td>';
	$ausgabe.='<td></td>';*/



	$sortby = "istordner DESC";
	if (!isset($_GET['sortby']))
	{
		$smarty->assign('sortby', '');
		
		$sortby .= ",mapping_files.`id` DESC ";
		$smarty->assign('sort_parameters',array() );
	}
	else
	{
		$smarty->assign('sortby', "&amp;sortby=".$_GET['sortby']);
		
		$allowed_sort_parameters = array("id", "ordner", "istordner", "name", "filesize", "filetype", "file", "datum", "owner", "downloads", "id DESC", "ordner DESC", "istordner DESC", "name DESC", "filesize DESC", "filetype DESC", "file DESC", "datum DESC", "owner DESC", "downloads DESC");
		$sort_parameters = split(",", $_GET['sortby']);
		$smarty->assign('sort_parameters',$sort_parameters );
		foreach ($sort_parameters as $sort_parameter)
		{
			if (in_array($sort_parameter, $allowed_sort_parameters))
			{
				if ($sort_parameter == "owner") 
					$sortby .= ",wp_users.display_name";
				elseif ($sort_parameter == "owner DESC") 
					$sortby .= ",wp_users.display_name DESC";
				else
					$sortby .= ",mapping_files.$sort_parameter";
			}
			else {echo "$sort_parameter is not an allowed parameter for searching."; }
		}
		
	}
	$query = '
	SELECT mapping_files.*, wp_users.display_name as username, wp_users.`ID` as userid FROM mapping_files LEFT JOIN wp_users ON mapping_files.owner=wp_users.`ID`
	WHERE  mapping_files.ordner = '.$ordner.' AND mapping_files.`name` != ""
	ORDER BY '.$sortby.'
	;
	';
	$data = mysql_query($query, $mysqlconnection);	
	echo mysql_error();

	$row_hl_type=1;
	$ordnerinhalt = array();
	while ($row = mysql_fetch_array($data))
	{
			$thumb= 'thumbs/'.$row['file'].'thumb';
			$thumb= str_replace("uploads/","",$thumb);
			$dotpos = strrpos($row['file'],".");
			$data_type = substr($row['file'],$dotpos,strlen($row['file']));
			$thumb = "$thumb.$data_type";
			if (!file_exists($thumb))
			{
				//$thumb = '';
				//create thumb
			  
			  if (in_array(strtolower($data_type), array(".jpg",".bmp",".gif",".png",".jpeg")))
			  {
				
				//create thumb:
				//if (!createthumb($row['file'], $thumb, 21, 21))
				//{
					//$notices[] = "Could not create thumb for ".htmlspecialchars($row['name'] . "<br />".$row['file']);
					$thumb = '';
				//}	
//if (isset($_GET['debug'])) { print_r($smarty);die('alive'); }
				/*else
				{
					//create bigthumb:
					$thumbpath = str_replace("thumb","bigthumb",$thumb);
					$thumbpath = str_replace("bigthumbs/","thumbs/",$thumbpath);
					createthumb($row['file'], $thumbpath, 100, 100);
				}*/
			  }
			  else
			  {
				//$notices[] = htmlspecialchars($row['name'])." is no picture";
				$thumb = '';
			  }
			}
			
			// User Avatar
			$avatar = get_avatar( $row['userid'] , 16 );
			
			$ordnerinhalt[] = array(	"istordner" => $row['istordner'] , 
								"id" => $row['id'],
								"name" => htmlspecialchars($row['name']),
								"file" => $row['file'],
								"filetype" => $row['filetype'],
								"filesize" => $row['filesize'],
								"datum" => $row['datum'],
								"ownerid" => $row['userid'],
								"avatar" => $avatar,
								"ownername" => $row['username'],
								"downloads" => $row['downloads'],
								"thumb" => $thumb,
								"savekey" => get_save_link_key($row['id'])
							 );
					 

	};


	$smarty->assign('ordnerinhalt',$ordnerinhalt);
		
}
else {
	$smarty->assign('ordnerinhalt',"");
	$path = $_GET['path'];
	$backpath = "../";
	//$notices[] = "$path -> count = ".substr_count($path,"/");
	for ($i = 0; $i < substr_count($path,"/");$i++) {
		$backpath .="../";
	}
}
$smarty->assign('folderexists',$folderexists);


//JQUERY
$footer_scripts[] = '<script src="'.$backpath.'jquery/jquery.js" type="text/javascript"></script>';

//jcUpload

function createRandomKey() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $count = 100;
    $key = '' ;

    for ($i = 0;$i < $count; $i++) {
        $num = rand() % 33;
        $key.= substr($chars, $num, 1);
    }
    return $key;
}
$uploadID = "";
do {
	$uploadID = createRandomKey();
	$query = 'INSERT INTO mapping_files_upload_keys(`id`,`userid`,`folder`,`expires`)
			VALUES("'.$uploadID.'","'.session_get_userid_secure().'", "'.$ordner.'", DATE_ADD( NOW() , INTERVAL 5 HOUR ));';
	mysql_query($query);
} while (mysql_error());


if (rand(0,100) <= 1) {
	//delete old entries every now and then
	$query = 'DELETE FROM mapping_files_upload_keys WHERE `expires` < NOW();';
	mysql_query($query);
	echo mysql_error();
}

$additional_headers[] = '<link rel="stylesheet" href="'.$backpath.'jcUpload/jquery.jcuploadUI.css" />';
$footer_scripts[] = '<script type="text/javascript" src="'.$backpath.'jcUpload/jquery.jcupload.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="'.$backpath.'jcUpload/jquery.jcuploadUI.config.js"></script>';
$footer_scripts[] = '<script type="text/javascript" src="'.$backpath.'jcUpload/jquery.jcuploadUI.js"></script>';
$footer_scripts[] = '<script type="text/javascript">
                        var jcu;
                        $(document).ready(function() {
                                var conf= {
										//url: "'.$backpath.'uploadajax.php?uploadID='.$uploadID.'",
										url: "uploadajax.php?uploadID='.$uploadID.'",
										flash_file: "'.$backpath.'jcuploadflash.swf",
										flash_background: "'.$backpath.'jcUpload/button.png",
										box_height: 100, // UI height

										file_icon_ready: "'.$backpath.'jcUpload/file_ready.gif", // absolute path to image for file in queue
										file_icon_uploading: "'.$backpath.'jcUpload/file_uploading.gif", // absolute path to image for current uploading file
										file_icon_finished: "'.$backpath.'jcUpload/file_finished.gif", // absolute path to image for uploaded file

										hide_file_after_finish: true, // option if you want to hide finished files
										hide_file_after_finish_timeout: 5000, // hide timeout (in miliseconds)

										error_timeout: -1, // error hide timeout (in miliseconds)
										
										max_file_size: 5242880, // maximum size per file limit - 0=disabled
										max_queue_count: 10, // maximum queue file count - 0=disabled
										max_queue_size: 0, // maximum queue file size sum - 0=disabled
										
										extensions: ["All files (*)|*"], 
										
                                        callback: {
												init: function(uo, jcu_version, flash_version) {
													$("#olduploadform").fadeOut("fast");
												},
												queue_upload_end: function(uo) {
													$.get(
														"'.$backpath.'jcUpload/uploadajaxquery.php",
														{uploadID:"'.$uploadID.'"},
														function(xml) {
															if (xml.length > 0) {
																$("#jcupload_messages").attr("innerHTML",xml).fadeIn("slow");
															} else {
																$("#jcupload_messages").attr("innerHTML","Fehler beim uploaden.").fadeIn("slow");
															}
														}
													
													);	
												},
												error_file_size: function(uo, file_name, file_type, file_size) {
														$("<div class=\"error\">Die Datei " +file_name +" ist zu groß!</div>")
															.appendTo("#jcupload_messages")
															.fadeIn("slow");
												},
												error_queue_count: function(uo, file_name, file_type, file_size) {
														$("<div class=\"error\">Die Datei " +file_name +" kann nicht hochgeladen werden. Es werden zu viele Dateien auf einmal hochgeladen.</div>")
															.appendTo("#jcupload_messages")
															.fadeIn("slow");
									
												},
												error_queue_size: function(uo, file_name, file_type, file_size) {
														$("<div class=\"error\">Die Datei " +file_name +" kann nicht hochgeladen werden. Es werden zu viele und zu große Dateien auf einmal hochgeladen.</div>")
															.appendTo("#jcupload_messages")
															.fadeIn("slow");
													
												}
												// other callbacks...
										}
                                };

                                jcu= $.jcuploadUI(conf);
                                jcu.append_to("#jcupload_content");
                        });
                //-->
                </script>';


//tablesorter
$footer_scripts[] = '<script src="'.$backpath.'jquery/jquery.tablesorter.min.js" type="text/javascript"></script>';
$footer_scripts[] = '<script type="text/javascript">

$.tablesorter.addParser({ 
        // set a unique id 
        id: "my_date", 
        is: function(s) { 
            // return false so this parser is not auto detected 
            return false; 
        }, 
        format: function(s) { 
            // format your data for normalization 

			

			var Tag = s.substr(0,2);
			var Monat = s.substr(3,2);
			var Jahr = s.substr(6,4);
			var Stunden = s.substr(11,2);
			var Minuten = s.substr(14,2);
			var Sekunden = s.substr(17,2);
			var thisdate = new Date(Jahr, Monat, Tag, Stunden, Minuten, Sekunden);
			
			
			return thisdate; 
        }, 
        // set type, either numeric or text 
        type: "numeric" 
    }); 

$.tablesorter.addParser({ 
        // set a unique id 
        id: "my_num", 
        is: function(s) { 
            // return false so this parser is not auto detected 
            return false; 
        }, 
        format: function(s) { 
			return parseInt(s); 
        }, 
        // set type, either numeric or text 
        type: "numeric" 
    }); 
	
$(document).ready(function() 
{
	$("table").tablesorter({
			widgets: ["zebra"], 	
            headers: { 
			    2: {
					sorter:"my_num"
				} 
                ,3: { 
                    sorter:"my_date" 
                } 
				,6: {
					sorter:false
				}
            } 
        } );
});
</script>';


$smarty->assign('ordner',$ordner);
$smarty->assign('path',$path);
$smarty->assign('backpath',$backpath);
$smarty->assign('errors',$errors);
$smarty->assign('notices',$notices);
//echo $ausgabe;
if (!$download)
{
	/*$smarty->assign('additional_headers', $additional_headers);
	$smarty->assign('footer_scripts', $footer_scripts);
	$smarty->assign("compileTime",sprintf("%.4f",(microtime(true) - $sript_start_time))); $smarty->display('site.tpl');
	*/
	$GLOBALS['footer_scripts'] = $footer_scripts;
	finish($smarty, "upload.tpl", $additional_headers);
	
}
else
{
	$row = $download;
	//$row = mysql_fetch_array($data);
	
	
	$datei = $row['file'];
	$filetype = $row['filetype'];
	
	$dotpos = strrpos($datei,".");
	$data_type = strtolower(substr($datei,$dotpos,strlen($datei)));
	
	$images = array(".jpg", ".png", ".gif", ".bmp", ".jpeg");
	
	//heades:
	if (in_array($data_type,$images))
	{
		//image
		//echo $_SERVER['HTTP_USER_AGENT'];
/*
		if (!preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT']))
		{
			//echo "no firefox";
			header( 'Content-disposition: atachment;filename="'.($row['name']).'"');
		}
		else
		{
			header( 'filename="'.($row['name']).'"');
		}
*/
		header( 'filename="'.($row['name']).'"');
	}
	else
	{
		//no image
		header( 'Content-disposition: atachment;filename="'.($row['name']).'"');
	}
	
	//header( 'Content-disposition: atachment');
	
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Transfer-Encoding:­ binary");

	
	
	header( 'Content-Length: ' . filesize( $datei ) );
	header( 'Connection: close');
	header( 'Content-Type: '.$filetype);
	
	//ngingx-send
	$datei2 = str_replace("uploads","uploaddata",$datei);
	//echo $datei2;
	header('X-Accel-Redirect: /'.$datei2.'');
	
	//header("Content-Disposition: attachment; filename=".basename(@$datei));
	
	//echo file_get_contents($datei);
	readfile($datei);
	
	$query = 'UPDATE mapping_files SET downloads = downloads + 1 WHERE `id` = "'.$row['id'].'";';
	$data = mysql_query($query, $mysqlconnection);
}
