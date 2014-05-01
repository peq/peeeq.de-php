<?
require_once('session.php');
require_once('mysql_cfg.php');

if (!session_is_admin()) {
	die('Verboden!</pre>');
}
echo "Starting..
<pre>";



//clean:
$qry = 'UPDATE mapping_files SET `filesize` = 0 WHERE istordner = 1;';
$data = mysql_query($qry);


$foldersizes = array();




$qry = 'SELECT * FROM mapping_files ORDER BY `id` DESC;';
$data = mysql_query($qry);

while ($row = mysql_fetch_array($data)) {
	$id  = $row['id'];
	$oid = $row['ordner'];
	
	if (isset($foldersizes[$oid])) {
		$foldersizes[$oid]+= $row['filesize'];
	} else {
		$foldersizes[$oid] = $row['filesize'];
	}
	
	if ($row['istordner']) {
		$foldersizes[$oid] += $foldersizes[$id];
	}
}

print_r($foldersizes);

foreach ($foldersizes as $id => $size) {
	$qry = 'UPDATE mapping_files 
		SET filesize = '.$size.'
		WHERE `id` = '.$id.';
		';
	echo $qry;
	$data = mysql_query($qry);
}

?>
</pre>