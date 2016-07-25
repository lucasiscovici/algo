<?php
include 'base.php';
	// echo "fsfs";
if (!isset($_SESSION["id"])) {
header('Location: recherche.php');
  exit();
}else{
if($_POST["role"]==1){
	$tmdb_id=$_POST["tmdb_id"];
	$info=genres_name($tmdb_id);
		// echo $info;

	$d="";
	$c=0;
	foreach ($info as $key => $value) {
		if ($c>0) $d=$d.", ";
		$d=$d.$value;
		$c++;
	}
	echo $d;
}elseif ($_POST["role"]==2) {
	$tmdb_id=$_POST["tmdb_id"];
	$info=synop($tmdb_id);
	echo $info;
}
}
