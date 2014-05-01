<?
require_once('mysql_cfg.php');
require_once('create_thumbnail.php');

define("Uploader_NotLoggedInError", -1);
define("Uploader_InvalidFilenameError", -2);
define("Uploader_InvalidFolderError", -3);
define("Uploader_MoveError", -4);
define("Uploader_FileToBigError", -5);
define("Uploader_FractionalError", -6);
define("Uploader_UnkownError", -7);


class Uploader {

	var $fileId = 0;

	function getMimeType($filename) { 
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

	
	function errorMessage($error) {
		switch ($error) {
			case Uploader_NotLoggedInError:
				return "G&auml;ste d&uuml;rfen keiene Dateien hochladen.";
			break;
			case Uploader_InvalidFilenameError:
				return "Der Dateiname ist zu lang oder enth&auml;lt unzul&auml;ssige Zeichen.";
			break;
			case Uploader_InvalidFolderError:
				return "Der Ordner, in den die Datei hochgeladen werden sollte existiert nicht mehr.";
			break;
			case Uploader_MoveError:
				return "Die Datei wurde richtig hochgeladen, aber der Server konnte sie nicht ins richtige Verzeichnis verschieben";
			break;
			case Uploader_FileToBigError:
				return "Die hochgeladene Datei &uuml;berschreitet die maximale Dateigr&ouml;ße.";
			break;
			case Uploader_FractionalError:
				return "Die Datei wurde nur teilweise hochgeladen.";
			break;
			case Uploader_UnkownError:
				return "Es ist ein unbekannter Fehler aufgetreten.";
			break;
			default:
				return "Es ist ein unerwarteter, unbekannter Fehler aufgetreten.";
		}
	}
	
	
	function upload($filedata, $ordner, $owner=0) {
		if ($owner <= 0) {
			$owner = session_get_userid_secure();
		}
		
		if ($owner <= 0) {
			return Uploader_NotLoggedInError; //
		}
				
		$change_ext=array(".php",".cgi",".php3",".php4",".php5");
		
		$dotpos = strrpos($filedata['name'],".");
		$data_type = substr($filedata['name'],$dotpos,strlen($filedata['name']));
			
			
		if ((strlen($filedata['name']) <= 100)&&(!preg_match('/^[a-zA-Z0-9_\-\ \(\)\.\!\§\$\%\&\[\]]+$/', $filedata['name']))) {
			return Uploader_InvalidFilenameError;
		} 
			

		//check if folder exists:
		$uploadfolderexists = false;
		$query = 'SELECT istordner FROM mapping_files WHERE `id` = '.$ordner.';';
		$data = mysql_query($query);
		if ($row = mysql_fetch_array($data)) {
			$uploadfolderexists = $row['istordner'];
		} 
		
		if ((!$uploadfolderexists)||($ordner <= 0)) {
			return Uploader_InvalidFolderError;
		}
				  

		$key = md5 (uniqid (rand()));
		$destination='uploads/'.$key.basename($filedata['name']);
		if (  in_array($data_type, $change_ext)) {
			$destination.=".txt";
		}
		
		
		if (! move_uploaded_file($filedata['tmp_name'], $destination) ) 	{
			if ($filedata['error'] == 0) {
				return Uploader_MoveError;
				//$temperror .= 'Die Datei wurde erfolgreich hochgeladen, aber konnte nicht richtig gespeichert werden.';
			} elseif ($filedata['error'] == 1) {
				return Uploader_FileToBigError;
				//$temperror .= 'Die hochgeladene Datei &uuml;berschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Gr&ouml;ße.';
			} elseif ($filedata['error'] == 2) {
				return Uploader_FileToBigError;
				//$temperror .= 'Die hochgeladene Datei &uuml;berschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigr&ouml;ße.';
			} elseif ($filedata['error'] == 3) {
				return Uploader_FractionalError;
				//$temperror .= 'Die Datei wurde nur teilweise hochgeladen.';
			} elseif ($filedata['error'] == 4) {
				return Uploader_NoFileError;
				//$temperror .= 'Es wurde keine Datei hochgeladen.';
			} else {
				return Uploader_UnkownError;
			}
		}
				
		$name = $filedata['name'];
		$filesize = intval($filedata['size']/1024);
		$filetype = $this->getMimeType($destination);
		

		$query='
		INSERT INTO
		mapping_files(`ordner`,`istordner`,`name`,`filesize`,`filetype`,`file`,`datum`, `owner`)
		VALUES ("'.$ordner.'",false,"'.$name.'","'.$filesize.'","'.$filetype.'","'.$destination.'", NOW(), "'.$owner.'")
		;
		';
		//make unexecutable
		chmod ($destination, 0755);

		$data=mysql_query($query);
		echo mysql_error();
		$this->fileId = mysql_insert_id();
		
		
		if (in_array($data_type, array(".jpg",".bmp",".gif",".png",".jpeg"))) {
			//create thumb:
			$thumbpath = $destination.'thumb';
			createthumb($destination, $thumbpath, 21, 21);
			//create bigthumb:
			$thumbpath = $destination.'bigthumb';
			createthumb($destination, $thumbpath, 100, 100);
		}


		//update filesizes and dates of parent-folders.
		$parentfolderIDs = array();
		$currentordner = $ordner;
		$maxiterations = 10;
		while (($currentordner != 0)&&($maxiterations-- > 0)) {		
			$parentfolderIDs[] = $currentordner;
			$query='SELECT `ordner` FROM mapping_files WHERE `id` = '.$currentordner.';';
			$data = mysql_query($query);
			if (mysql_error()) {
				echo "<pre>".mysql_error()."
				$query
				</pre>";
			}
			$row = mysql_fetch_array($data);
			$currentordner = $row['ordner'];
		}

		$query = 'UPDATE mapping_files SET filesize = filesize + '.$filesize.'
				, datum = NOW()
				WHERE `id` in ('.implode(",",$parentfolderIDs).');';
		$data=mysql_query($query);
		if (mysql_error()) {
			echo "<pre>".mysql_error()."
			$query
			</pre>";
		}
		/*echo "<pre>
			$query
			</pre>";
			*/			  
		//return the filename
		return  $destination;
	
	
	}
	
	function deleteFile($fileID, $savekey) {
	
	}
}

?>
