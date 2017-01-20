<?php


/* vars declaration */
$host = 'localhost';		// enter between quotes the host name
$dbname = 'seri';	// enter between quotes the database name
$dbuser = 'root';	// enter between quotes the database user name
$dbpass = '';	// enter between quotes the database user password
/* thanks, now you can leave this page */


try {
	$connect = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	die('<span style="color: red;"><b>ERROR :</b> '.$e->getMessage().'</span>');
}
?>