<?php
(@include'connect.php') or die('<span style="color: red;"><b>ERROR:</b> unable to open a file<br>Please inform the developer</span>');

// get basic info
$rqst = $connect -> query("SELECT var, val FROM basic");
$basic = $rqst -> fetchAll(PDO::FETCH_KEY_PAIR);
$rqst -> closeCursor();


function getData($wdata, PDO $connect) {
	switch ($wdata) {
		case 'series':
			$sql = "SELECT 'kurtlar vadisi' as title";
			break;

		case 'seasons':
			$sql = "SELECT season AS s FROM episodes GROUP BY season";
			break;

		case 'episodes':		// get all episodes // applicable only on Episodes page
			$s = preg_match('#^[0-9]+$#', @$_GET['s'])? $_GET['s'] : '1';

			switch (@$_GET['o']) {
				case 'number': $o = $_GET['o'];
					break;
				case 'views': $o = $_GET['o'].' DESC';
					break;
				case 'latest': $o = 'date_add';
					break;
				default: $o = 'id';
					break;
			}

			$sql = "SELECT id, number, url, season FROM episodes WHERE season=".$s." ORDER BY ".$o;
			break;

		case 'watch':			// get an episode only
			$e = preg_match('#^[0-9]+$#', @$_GET['e'])? $_GET['e'] : 1;
			$sql = "SELECT LPAD(number, 2,0) as number, LPAD(season, 2, 0) as season, url, description, comments FROM episodes WHERE id = ".$e.";
					UPDATE episodes SET views=views+1 WHERE id=".$e."";
			break;

		case 'comments':		// get comments
			$e = preg_match('#^[0-9]+$#', @$_GET['e'])? $_GET['e'] : null;
			$n = isset($_GET['n'])? $_GET['n']*10: 0;
			$sql = "SELECT u.name, u.website, u.avatar, c.comment_txt, c.date_add FROM comments c LEFT JOIN users u ON c.user_id=u.id WHERE ep_id='$e' ORDER BY date_add LIMIT 10 OFFSET $n";
			break;

		case 'user':			// get a user info
			$who = isset($_GET['who'])? $_GET['who'] : $_SESSION['username'];
			$sql = "SELECT id, class, name, avatar, website FROM users WHERE name = '".$who."'";

			break;

		default:
			echo "default case";
			exit();
			break;
	}

		$rst = $connect -> query($sql) -> fetchAll(PDO::FETCH_ASSOC);
		return $rst;
}


?>