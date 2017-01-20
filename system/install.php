
<form method="post" action="">
host: <input type="text" name="host" /><br/>
dbname: <input type="text" name="dbname" /><br/>
dbuser: <input type="text" name="dbuser" /><br/>
dbpass: <input type="text" name="dbpass" /><br/>

<hr>
adminName: <input type="text" name="adminName" /><br/>
adminMail: <input type="text" name="adminMail" /><br/>
adminPass: <input type="text" name="adminPass" /><br/>

<hr>
siteName: <input type="text" name="siteName" /><br/>
url: <input type="text" name="url" /><br/>
logo: <input type="text" name="logo" /><br/>
caption: <input type="text" name="caption" /><br/>
facebook: <input type="text" name="facebook" /><br/>
twitter: <input type="text" name="twitter" /><br/>
about: <input type="text" name="about" /><br/>
<input type="submit" />
</form>
<?php

if (!empty($_POST)) {
	include 'connect.php';

	$va = $connect->prepare(file_get_contents('setdb.sql'));
	$va -> execute(array(
	':siteName' => $_POST['siteName'],
	':url' => $_POST['url'],
	':logo' => $_POST['logo'],
	':caption' => $_POST['caption'],
	':facebook' => $_POST['facebook'],
	':twitter' => $_POST['twitter'],
	':about' => $_POST['about'],
	':adminName' => $_POST['adminName'],
	':adminMail' => $_POST['adminMail'],
	':adminPass' => $_POST['adminPass']
	));

}



?>