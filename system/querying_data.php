<?php
require 'connect.php';

$aa = $connect -> query("SELECT var, val FROM basic");
$basic = $aa -> fetchAll(PDO::FETCH_KEY_PAIR);


echo "<pre>";
print_r($basic);


?>