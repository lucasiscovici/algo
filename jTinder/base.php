<?php 
//base chercher
$type="movie";
$user=1;
$debug=false;
$gl=array();
include "config.php";


// $f=array(
// 			"il était une fois en Amérique",
// 			"barry lyndon",
// 			"le nom des gens",
// 			"interstellar",
// 			"Le Parrain - 2ème partie"
// 		);
// save_begin($f);
function getb($t){
	global $user;
		global $gl;

	foreach ($t as $key => $value) {
		$gl[$value]=$value($user);
arsort($gl[$value]);

	}
}
function getcinq($t){
	global $gl;
		foreach ($t as $key => $value) {
$gl[$value]=cinq($gl[$value]);

// print_r($gl[$value]);
}
}
$d = array(
		"reals",
		"genres",
		"cast"
		);
$timestart=microtime(true);
getb($d);
// 		$inf=$GLOBALS["TMDB"]->people_crew("person",240);
// print_r($inf);
getcinq($d);
foreach ($gl["reals"] as $key => $value) {
	# code...
	real_film($key);

}
$timeend=microtime(true);
$time=$timeend-$timestart;
 
//Afficher le temps d'éxecution
$page_load_time = number_format($time, 3);
echo "Debut du script: ".date("H:i:s", $timestart);
echo "<br>Fin du script: ".date("H:i:s", $timeend);
echo "<br>Script execute en " . $page_load_time . " sec";