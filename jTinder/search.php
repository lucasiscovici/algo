<?php
session_start();

require "base.php";
if (isset($_POST["q"])) {

	$f = search_query($_POST["q"]);
	

$d=json_encode(fo($f));

	echo $d;


}
?>