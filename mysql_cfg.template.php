<?
	$host='localhost';
	$user='peqnet';
	$passwort='password here';
	
	
	if (! @($mysqlconnection=mysql_connect($host,$user,$passwort)))	{	
		die ('Es gibt momentan einen technischen Fehler mit der Datenbank. Bitte versuchen sie es später noch einmal. <br />' . mysql_error());
	}
	mysql_select_db('peqnet');
