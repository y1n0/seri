<?php
session_start();
$_SESSION['token'] = md5(openssl_random_pseudo_bytes(10).uniqid());
setcookie('token', $_SESSION['token'], time()+3600*24*3);
(@include 'lang.php') or (@include 'files/en.php') or exit('no language file found');
include 'system/get.php';
if (!$basic['statu']) {
	exit($basic['close_txt']);
}

$series = getData('series', $connect);
switch (@$_GET['page']) {
	case '':
	case 'watch':
		if (isset($_GET['moco'])) {
			header("Content-Type: text/json");
			echo json_encode(getData('comments', $connect));
			exit();
		}
		
		include 'system/emb_code_gen.php';

		$watch = getdata('watch', $connect);
		$code = url_treat($watch[0]['url'], 'emb_code');
		$comments = getData('comments', $connect);
		include 'templates/watch.html';
		break;

	case 'episodes':
		include 'system/emb_code_gen.php';
		$eps = getData('episodes', $connect);
		$seasons = getdata('seasons', $connect);
		@include 'templates/episodes.html';
		break;

	case 'about':
		@include 'templates/about.html';
		break;

	case 'login':
		include 'templates/lr.html';
		break;

	case 'user':
		$user = getData('user', $connect);
		include 'templates/user.html';
		break;

	case 'CP' && @$_SESSION['class']==1:
		$seasons = getdata('seasons', $connect);
		include 'templates/CP.html';
		break;
	
	default:
		echo '<div style="width: 400px; height: 400px; margin: 200px auto; text-align: center;">
	<h1 style="color: red; font-size: x-large; font-family: Raleway, Helvetica, Helvetica, sans-serif">ERROR 404!</h1>
	<p style="font-family: Helvetica;">page not found :(<br><a style="color: #AA23CF; text-decoration: none;" href=".">Go back to home</a></p>
</div>';
		break;
}
?>