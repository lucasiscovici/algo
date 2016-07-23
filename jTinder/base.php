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
function pt_real($movie){
	$pt=$value;
	$inf=$GLOBALS["TMDB"]->info($type,$movie);
	$info=$GLOBALS["TMDB"]->info_genres($inf,-1);
	// $genres=
}
function genre_pt($id,$note,$gl){
	global $type;
	$pt=0;
		$inf=$GLOBALS["TMDB"]->info_genres($type,$id);
		// print_r($inf);
		foreach ($inf as $key => $value) {
			// print_r($value);

			$pt+=(array_key_exists($value->id, $gl))?$gl[$value->id]:0;
		}
return $note+$pt;
}

$pt_film=array();

function pref($us){
	$d = array(
		"reals",
		"genres",
		"cast"
		);
	global $gl;
	global $user;
	$user=$us;
// print_r($d);
getb($d);
		// $inf=$GLOBALS["TMDB"]->people_crew("person",240);
// print_r($inf);
getcinq($d);
// print_r($gl);
$dg=[];		
		$count= 0;			// print_r($gl);

foreach ($gl["reals"] as $key => $value) {
// 	# code...

	$dgs=real_film($key);
	foreach ($dgs as $key2 => $value2) {
// if ($count == 0) {

	// $count++;
				// print_r($value2["tmdb_id"]);

		$dg[$value2["tmdb_id"]]=$value;
					// print_r($dg);

		$dg[$value2["tmdb_id"]]=genre_pt($value2,$dg[$value2["tmdb_id"]],$gl["genres"]);
// }else{
// 	break;
// 	}
}
}
arsort($dg);
	return $dg;
}
function movie_pref($e){
	global $type;
$movie=pref($e);
// print_r($movie);
$res=array();
foreach ($movie as $key => $value) {
	$tmdb=getAll("SELECT `titre` as 'title',`product_id` as 'id',`affiche` as 'href' FROM products WHERE product_id =".$key." ");	
	if (count($tmdb)==0){
		$val=$key;
	$tb="`products`";
	$v="tmdb_id=".$val."";
	$num=$GLOBALS["TMDB"]->info($type,$val);
	$last=eraklion($tb,$v,"tmdb_id",$val,$num);

	$sd["id"]=$key;
	$sd["title"]=$num->title;
	$sd["href"]=$num->poster_path;
	$sd["reals"]=reals_name($key);
	// print_r($sd["reals"]);
	$sd["genres"]=genres_name($key);
	// $sd["video"]=video_url($key);

			$sd["rate"]=$value;

		

}else{
	$sd=$tmdb;
	$sd["rate"]=$value;
$sd["reals"]=reals_name($tmdb["id"]);
$sd["genres"]=genres_name($tmdb["id"]);
	// $sd["video"]=video_url($key);

}
	$res[]=$sd;
}
$res=up_href($res);

return $res;
}
$timestart=microtime(true);

// $movie=movie_pref(1);

// print_r($movie);
$timeend=microtime(true);
$time=$timeend-$timestart;
 
//Afficher le temps d'éxecution
$page_load_time = number_format($time, 3);
// echo "Debut du script: ".date("H:i:s", $timestart);
// echo "<br>Fin du script: ".date("H:i:s", $timeend);
// echo "<br>Script execute en " . $page_load_time . " sec";