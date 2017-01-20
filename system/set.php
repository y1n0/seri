<?php
(@include'connect.php') or die('<span style="color: red;"><b>ERROR:</b> unable to open a file<br>Please inform the developer</span>');

// register members
if (isset($_POST['Uname']) or isset($_POST['Umail']) or isset($_POST['Upass'])) {
	if (!empty($_POST['Uname']) or !empty($_POST['Umail']) or !empty($_POST['Upass'])) {
		
		// username verification
		if (!preg_match('#^[\P{Arabic}a-z0-9._-]{4,20}$#i', $_POST['Uname']))
			die('the name contains characters invalid or it is too short (min 5 chars)');
		$ndexis = $connect -> query("SELECT CASE WHEN name IS NULL THEN 0 WHEN name IS NOT NULL THEN 1 END AS r FROM users WHERE name='".$_POST['Uname']."' GROUP BY r") -> fetchColumn();
		if($ndexis)
			die('the username you chose is already in use.');

		// email verification
		if (!preg_match('#^[a-z0-9._-]{5,20}@[a-z0-9._-]{3,20}\.[a-z]{2,8}$#i', $_POST['Umail']))
			die('invalid email.');
		$edexis = $connect -> query("SELECT CASE WHEN email IS NULL THEN 0 WHEN email IS NOT NULL THEN 1 END AS r FROM users WHERE email='".$_POST['Umail']."' GROUP BY r") -> fetchColumn();
		if($edexis)
			die('the email you chose is already in use.');
		
		// password verification
		if (!preg_match('#^.{6,}$#', $_POST['Upass']))
			die('password too short.');


		$connect -> query("INSERT INTO users (name, email, password) VALUES ('".$_POST['Uname']."', '".$_POST['Umail']."', '".md5($_POST['Upass'])."') ");
		die("it's all OK!");
	} else {
		echo "please fill all the fields first";
	}
	exit();
}


// insert comments
if (isset($_POST['comment'])) {
	session_start();
	if (@!$_SESSION['access'])
		die('you\'re not a member, please register to comment');
	else
		$id = $_SESSION['id'];
	
	if (@$_POST['token']!==@$_SESSION['token'])
		die('error! token is invalid');

	if (!empty($_POST['comment'])) {
		if (!preg_match('#^[0-9*]$#', $_POST['ep']))
			die('episode\'s number is incorrect');
		else
			$ep = $_POST['ep'];
		$comment = htmlentities($_POST['comment'], ENT_QUOTES);
		$connect -> query("INSERT INTO comments (ep_id, user_id, comment_txt) VALUES('$ep', '$id', '$comment')");
		die('added');
	}
	else
		die("comment field is empty");

	exit();
}

// site option & setting
if (isset($_POST['setop'])) {
		if (isset($_POST['bas_name'])) {		// website name validity verification
			if (strlen($_POST['bas_name']) > 50 OR strlen($_POST['bas_name']) < 3)
				$errors[] = 'website name should contain less than 50 character and more than 3';
			else
				$toupdate = 'UPDATE basic SET val = \''.$_POST['bas_name'].'\', last_update = NOW() WHERE var = \'name\';';
		}

		if (isset($_POST['bas_logo'])) {		// logo ver
			if (!preg_match('#^(https?://)?(www\.)?[a-z0-9_.-]{4,}\.[a-z0-9_.-]{2,}/.+$#i', $_POST['bas_logo']))
				$errors[] = 'logo url is invalid';
			else
				$toupdate .= 'UPDATE basic SET val = \''.$_POST['bas_logo'].'\', last_update = NOW() WHERE var = \'logo\';';
		}

		if (isset($_POST['bas_caption'])) {
			if (strlen($_POST['bas_caption']) > 40)
				$errors[] = 'caption text should contain less than 40 character';
			else
				$toupdate .= 'UPDATE basic SET val = \''.$_POST['bas_caption'].'\', last_update = NOW() WHERE var = \'caption\';';
		}

		if (isset($_POST['sidesc'])) {		// description and closing text
			if (strlen($_POST['sidesc']) > 250)
				$errors[] = 'description text should contain less than 250 characters';
			else 
				$toupdate .= 'UPDATE basic SET val = \''.$_POST['sidesc'].'\', last_update = NOW() WHERE var = \'about\';';
		}

		if (isset($_POST['bas_colstxt'])) {
			if (strlen($_POST['bas_colstxt']) > 250)
				$errors[] = '';
			else
				$toupdate .= 'UPDATE basic SET val = \''.$_POST['bas_colstxt'].'\', last_update = NOW() WHERE var = \'close_txt\';';

		}

	if (!empty($errors)) {
		foreach ($errors as $error) {
			echo '·'.$error.'<br>';
		}
	}
	else {
		// echo '<pre>'.$toupdate.'<br>';
		$toupdate .= 'UPDATE basic SET val = \''.$_POST['bas_facebook'].'\', last_update = NOW() WHERE var = \'facebook\';
					UPDATE basic SET val = \''.$_POST['bas_twitter'].'\', last_update = NOW() WHERE var = \'twitter\';
					UPDATE basic SET val = 1 WHERE var = \'statu\' ';

		$connect -> query($toupdate);
		$done = "DONE, info updated!";
	}
	header('location: ../cp#Basic');
	exit();
}


// add episodes
if (isset($_POST['addep'])) {
	if (!empty($_POST['epnumber']) or !empty($_POST['epseason']) or !empty($_POST['epurl']) or !empty($_POST['desc'])) {
		if (!preg_match('#^\d+$#', $_POST['epseason']) OR !preg_match('#^\d+$#', $_POST['epnumber']))
			$adding_errors[] = 'episode number and/or season should contain just numbers.';
		if (!preg_match('#^(https?://)?(www\.)?[a-z0-9_.-]{4,}\.[a-z0-9_.-]{2,}/.+$#i', $_POST['epurl']))
			$adding_errors[] = 'url invalid';
		if (!preg_match('#youtube|vimeo#i', $_POST['epurl']))
			$adding_errors[] = 'video hosting service is not supported';
		if (strlen($_POST['desc']) > 500)
			$adding_errors[] = 'description should contain less than 500 characters.';
		if (@!is_null($adding_errors)) {
			foreach ($adding_errors as $adding_errors) {
				echo $adding_errors.'</br>';
			}
			exit();
		}
		$connect -> prepare("INSERT INTO episodes (number, season, url, comments) VALUES (:epnumber, :epseason, :epurl, :cmtst)")->execute(array(':epnumber'=>$_POST['epnumber'], ':epseason'=>$_POST['epseason'], ':epurl'=>$_POST['epurl'], ':cmtst'=>$_POST['cmtst']));

	}
	else {
		echo "please fill out all fields.";
	}

}

?>