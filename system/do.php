<?php
(@include'connect.php') or die('<span style="color: red;"><b>ERROR:</b> unable to open a file<br>Please inform the developer</span>');

if (isset($_POST['Uusername']) OR isset($_POST['Upassword'])) {
	sleep(1);
	if (empty($_POST['Uusername']) OR empty($_POST['Upassword']))
		die('both the username and password fields are required');
	$id = $connect -> query("SELECT CASE WHEN password = MD5('".$_POST['Upassword']."') THEN id ELSE null END FROM users WHERE name = '".$_POST['Uusername']."' OR email = '".$_POST['Uusername']."'")->fetchColumn();
	if (!$id)
		die('username and/or password are incorrect');
	session_start();
		$_SESSION['access'] = true;
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $_POST['Uusername'];
	echo "connection succeeded";
	exit();
}

if (isset($_GET['logout'])) {
		session_start();
	if ($_GET['logout'] === $_SESSION['token']) {
		session_destroy();
	} else {
		echo "ERROR: token invalide.";
	}
	exit();
}

?>