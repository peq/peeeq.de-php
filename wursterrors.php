<?php
require_once 'mysql_cfg.php';
if (isset($_POST['version'])) {
	$version = mysql_real_escape_string($_POST['version']);
	$errormessage = mysql_real_escape_string($_POST['errormessage']);
	$stacktrace = mysql_real_escape_string($_POST['stacktrace']);
	$source ="";
	if (isset($_POST['source'])) {
		$source = mysql_real_escape_string($_POST['source']);
	}

	$stacktrace .= "\n\n\n\n" . $source;

	$qry = 'INSERT INTO wurst_reports (`version`,`errormessage`,`stacktrace`)
		VALUES ("'.$version.'","'.$errormessage.'","'.$stacktrace.'")';

	mysql_query($qry);
	echo mysql_error();
	echo "Success";
	// TODO send mail?
} else if (isset($_GET['id'])) {
	$id = intval($_GET['id']);


	$qry = 'SELECT * FROM wurst_reports WHERE id = '.$id.'';
	$data = mysql_query($qry);
	$row = mysql_fetch_array($data);

	echo '<p>'.nl2br(htmlentities($row['errormessage'])).'</p>';
	echo '<p>Version: '.htmlentities($row['version']).'</p>';
	echo '<pre>'.htmlentities($row['stacktrace']).'</pre>';
} else {
	

	$qry = 'SELECT * FROM wurst_reports ORDER BY `id` DESC';
	$data = mysql_query($qry);
	echo '<table>';
	while ($row = mysql_fetch_array($data)) {
		if ($row['id'] % 2) {
			echo '<tr style="background-color: #eee; border-bottom:1px solid #aaa;">';
		} else {
			echo '<tr style="background-color: #ccc; border-bottom:1px solid #aaa;">';
		}
		echo '<td><a href="wursterrors.php?id='.$row['id'].'">'.($row['time']).'</a></td>';
		echo '<td>'.nl2br(htmlentities($row['errormessage'])).'</td>';
		echo '</tr>';
	}
	echo '</table>';



}

///print_r($_POST);


