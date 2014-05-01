<?
/*
 CREATE TABLE `peq`.`mapping_files_upload_keys` (
`id` VARCHAR( 100 ) NOT NULL ,
`userid` INT NOT NULL ,
`expires` DATETIME NOT NULL ,
UNIQUE (
`id`
)
) ENGINE = MYISAM 

*/

/*
 CREATE TABLE `peq`.`mapping_files_upload_messages` (
`id` INT NOT NULL ,
`uploadkey` VARCHAR( 100 ) NOT NULL ,
`name` TEXT NOT NULL ,
`fileid` INT NOT NULL ,
`message` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM 

*/

require_once('mysql_cfg.php');
require_once('create_thumbnail.php');
require_once('uploader.class.php');


		$key = mysql_real_escape_string($_GET['uploadID']);
		$query = 'SELECT * FROM mapping_files_upload_keys WHERE `id` = "'.$key.'";';
		$data = mysql_query($query);
		if ($row = mysql_fetch_array($data)) {
			$userid = $row['userid'];
			$ordner = $row['folder'];
			
			$error = "";
			
			$uploader = new Uploader();
			$uploadresult = $uploader->upload($_FILES['Filedata'], $ordner, $userid);
			if ($uploadresult < 0) {
				$error = $uploader->errorMessage($uploadresult);			
			} else {
				$ausgabe.= 'Datei wurde gespeichert!';
			}
			
			$query='
			  INSERT INTO
			  mapping_files_upload_messages(`uploadkey`,`name`,`fileid`,`message`)
			  VALUES ("'.$key.'","'.mysql_real_escape_string($_FILES['Filedata']['name']).'","'.$uploader->fileId.'","'.mysql_real_escape_string($error).'")
			  ;
			  ';
			mysql_query($query);
			
		}
/*		
		$myFile = "uploadlog ".date("d.m.Y H i s").".txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, "=== ".date("l dS of F Y H:i:s")." ====\r\n");
		fwrite($fh, "--------\r\n");
		fwrite($fh, print_r($_Files, true));
		fwrite($fh, "--------\r\n");
		fwrite($fh, print_r($_Files['Filedata'], true));
		fwrite($fh, "--------\r\n");
		fwrite($fh, $ausgabe);
		fwrite($fh, "--------\r\n");
		fwrite($fh, $error);
		fwrite($fh, "--------\r\n");
		fclose($fh);
		

	$key = mysql_real_escape_string($_GET['uploadID']);
	$query = 'SELECT * FROM mapping_files_upload_keys WHERE `id` = "'.$key.'";';
	
	$name_secure = htmlspecialchars($_FILES['Filedata']['name']);
	
	
	$error = "";
	$fileid = 0;
	
	$data = mysql_query($query);
	if ($row = mysql_fetch_array($data)) {
				
			$userid = $row['userid'];
			$ordner = $row['folder'];
			
				if ($userid > 0) {
				
				//$not_allowed=array(".php",".cgi",".php3",".php4",".php5");
				$not_allowed=array();
				$change_ext=array(".php",".cgi",".php3",".php4",".php5");
				
				$dotpos = strrpos($_FILES['Filedata']['name'],".");
				$data_type = substr($_FILES['Filedata']['name'],$dotpos,strlen($_FILES['Filedata']['name']));
				
				
				if (preg_match('/^[a-zA-Z0-9_\-\ \(\)\.\!\§\$\%\&]+$/', $_FILES['Filedata']['name'])) {
					if ( ! in_array($data_type, $not_allowed))
					{
					  
						//$ausgabe.= substr($_FILES['userfile']['type'],0,11);
						//check if folder exists:
						$uploadfolderexists = false;
						$query = 'SELECT istordner FROM mapping_files WHERE `id` = '.$ordner.';';
						$data = mysql_query($query);
						if ($row = mysql_fetch_array($data)) {
							$uploadfolderexists = $row['istordner'];
						} 
						
						if (($uploadfolderexists)&&($ordner > 0)) {
					  
							if ($_FILES['Filedata']['name']!='')
							{
								$query = 'SELECT * FROM mapping_files WHERE ordner = '.$ordner.' AND `name` = "'.$_FILES['Filedata']['name'].'";';

								$data = mysql_query($query);
								$doublename = mysql_fetch_array($data);

								if (!$doublename) {				
								
									$tkey = md5 (uniqid (rand()));
									$destination='uploads/'.$tkey.basename($_FILES['Filedata']['name']);
									if (  in_array($data_type, $change_ext))
									{
										$destination.=".txt";
									}
									if (! move_uploaded_file($_FILES['Filedata']['tmp_name'], "../".$destination) ) 
									{
										$temperror ="Beim uploaden der Datei $name_secure ist ein Fehler aufgetreten... <br />";
										if ($_FILES['Filedata']['error'] == 0)
										{
											$temperror .= 'Die Datei '.$name_secure.' wurde erfolgreich hochgeladen, aber konnte nicht richtig gespeichert werden.';
										}
										elseif ($_FILES['Filedata']['error'] == 1)
										{
											$temperror .= 'Die hochgeladene Datei '.$name_secure.' überschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Größe.';
										}
										elseif ($_FILES['Filedata']['error'] == 2)
										{
											$temperror .= 'Die hochgeladene Datei '.$name_secure.' überschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigröße.';
										}
										elseif ($_FILES['Filedata']['error'] == 3)
										{
											$temperror .= 'Die Datei '.$name_secure.' wurde nur teilweise hochgeladen.';
										}
										elseif ($_FILES['Filedata']['error'] == 4)
										{
											$temperror .= 'Es wurde keine Datei '.$name_secure.' hochgeladen.';
										}

										 $error.= $temperror; //"Beim uploaden der Datei ist ein Fehler aufgetreten. ".$_FILES['userfile']['error']."...<br>".$_FILES['userfile']['type']."<br>".$_FILES['userfile']['size']."<br>".$_FILES['userfile']['tmp_name']."<br>".$_FILES['userfile']['name'];
										 
										 
										 //$hreftarget='no';
									}
									else
									{
									  //$notices[] ='<br>Datei wurde gespeichert!';
									  $name=$_FILES['Filedata']['name'];
									  $filesize=intval($_FILES['Filedata']['size']/1024);
									  //$filetype=$_FILES['userfile']['type'];
									  $filetype=getMimeType($destination);
									  //$filetype=mime_content_type($destination);
									  $owner = $userid;
									  
									  $query='
									  INSERT INTO
									  mapping_files(`ordner`,`istordner`,`name`,`filesize`,`filetype`,`file`,`datum`, `owner`)
									  VALUES ("'.$ordner.'",false,"'.$name.'","'.$filesize.'","'.$filetype.'","'.$destination.'", NOW(), "'.$owner.'")
									  ;
									  ';
									  //make unexecutable
									  chmod ($destination, 0750);
									  
									  $data=mysql_query($query,$mysqlconnection);
	
									  
									  
									  $fileid = mysql_insert_id();
									  
		  
									  
									  
									  
									  if (in_array($data_type, array(".jpg",".bmp",".gif",".png",".jpeg")))
									  {
										//create thumb:
										$thumbpath = $destination.'thumb';
										createthumb($destination, $thumbpath, 21, 21);
										//create bigthumb:
										$thumbpath = $destination.'bigthumb';
										createthumb($destination, $thumbpath, 100, 100);
									  }
									}
								} else {
									$error.= "Beim uploaden der Datei $name_secure ist ein Fehler aufgetreten.<br>Eine Datei mit dem Namen existiert bereits.";
								}
								
							}
						} else {
							$error.= "Beim uploaden der Datei $name_secure ist ein Fehler aufgetreten.<br>Der Ordner, in dem die Datei gespeichert werden sollte exisiert nicht, oder es wurde versucht eine Datei ins Hauptverzeichnis hochzuladen.";
						}
					} 
					else 
					{
						 $error.= "Beim uploaden der Datei $name_secure ist ein Fehler aufgetreten.<br> Der Dateityp $data_type (".$_FILES['Filedata']['type'].") ist nicht erlaubt!<br>Wenn der Type erlaubt werden soll, dann sag peq (<a href=\"mailto:peq88@aol.com\">peq88@aol.com</a>) bescheid!";
					}
				}
				else {
					$error.= "Der Dateiname $name_secure enthält nicht erlaubte Zeichen.";
				}
			} else {
				$error.= "Als Gast darf man keine Dateien hochladen!";
			}			
		} else {
			$error.= "Ung&uuml;ltiger Upload-Schl&uuml;ssel!";
		}		

		
		$query='
		  INSERT INTO
		  mapping_files_upload_messages(`uploadkey`,`name`,`fileid`,`message`)
		  VALUES ("'.$key.'","'.mysql_real_escape_string($_FILES['Filedata']['name']).'","'.$fileid.'","'.mysql_real_escape_string($error).'")
		  ;
		  ';
		mysql_query($query);
*/

									 
/*
echo $ausgabe;


$myFile = "uploadlog ".date("d.m.Y H i s").".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, "=== ".date("l dS of F Y H:i:s")." ====\r\n");
fwrite($fh, $ausgabe);
fwrite($fh, $error);
fclose($fh);
*/
		
?>