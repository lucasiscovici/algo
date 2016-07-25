<?php
include 'base.php';
if (isset($_POST["q"])){
$arr=$_POST["q"];

foreach ($arr as $key => $value) {
	save2($value);
}
echo 1;
}


?>