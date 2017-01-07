<?php
require_once("models/class.php");

$connect = new DB_connect();


echo "<pre>";
print_r($connect->show());
echo "</pre>";

echo "helo <br>";

//$connect->getId("owner", "tony", "hi8", "");
$connect->add(1001, $connect->getId('owner', 'tony', 'h13', ''), $connect->getId('realtor', 'holy', 'nova', ''));

$connect->edit(5, 500, 11, 2);
$connect->show();

 