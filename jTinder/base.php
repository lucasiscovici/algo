<?php 
//base chercher
$type="movie";
$user=1;
$debug=false;
$gl=array();
$nb=20;
$min=1.0;
include "config.php";


$f=array(
			"il était une fois en Amérique",
			"barry lyndon",
			"le nom des gens",
			"interstellar",
			"Le Parrain - 2ème partie"
		);
save_begin($f);
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
function cast_pt($id,$note,$gl){
global $type;
	$pt=0;
		$inf=$GLOBALS["TMDB"]->info_cast($type,$id);
		// print_r($inf);
		foreach ($inf as $key => $value) {
			// print_r($value);

			$pt+=(array_key_exists($value->id, $gl))?$gl[$value->id]:0;
		}
return $note+$pt;
}
function real_pt($id,$note,$gl){
global $type;
	$pt=0;
		$inf=reals_list(array($id));
		// print_r($inf);
		foreach ($inf as $key => $value) {
			// print_r($value);

			$pt+=(array_key_exists($value, $gl))?$gl[$value]:0;
		}
return $note+$pt;
}
$pt_film=array();
function dod($a,$b){
	// print_r($a);
	// print_r($b);
	$result = array();
foreach($a as $arr){
   if(!in_array($arr["tmdb_id"], $b)){
      $result[] = $arr;
   }
}
// $result=array_reverse($result);
// print_r($result);
return $result;
}
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

	// print_r(get_tmdb2($user));

// foreach ($gl["reals"] as $key => $value) {
// // 	# code...

// 	$dgs=real_film($key);
// 	// print_r("dgs ".$dgs);
// 	$dgs=dod($dgs,get_tmdb2($user));
// 	// print_r($dgs);
// 	foreach ($dgs as $key2 => $value2) {
// // if ($count <= 3) {

// 	// $count++;
// 				// print_r($value2["tmdb_id"]);
// if (!(array_key_exists($value2["tmdb_id"], $dg))){
// 		$dg[$value2["tmdb_id"]]=$value;
// 					// print_r($dg);

// 		$dg[$value2["tmdb_id"]]=genre_pt($value2,$dg[$value2["tmdb_id"]],$gl["genres"]);
// 				$dg[$value2["tmdb_id"]]=cast_pt($value2,$dg[$value2["tmdb_id"]],$gl["cast"]);
// }
// // }else{
// // 	break;
// // 	}
// }

// }
foreach ($gl["cast"] as $key => $value) {
// 	# code...
if ($value > 0.2){


	$dgs=cast_film($key);
	// print_r("dgs ".$dgs);
	$dgs=dod($dgs,get_tmdb2($user));
	// print_r($dgs);
	foreach ($dgs as $key2 => $value2) {
// if ($count <= 3) {

	// $count++;
				// print_r($value2["tmdb_id"]);
if (!(array_key_exists($value2["tmdb_id"], $dg))){
		$dg[$value2["tmdb_id"]]=$value;
					// print_r($dg);

		$dg[$value2["tmdb_id"]]=genre_pt($value2,$dg[$value2["tmdb_id"]],$gl["genres"]);
				// $dg[$value2["tmdb_id"]]=real_pt($value2,$dg[$value2["tmdb_id"]],$gl["reals"]);
}
// }else{
// 	break;
// 	}
}
}

}

	asort($dg);
	return $dg;
}

function get_array_nb($arr,$nb){
	$d=array();
	$arr=array_reverse($arr, true);
$count=0;
	foreach ($arr as $key => $value) {
		if ($count == $nb) return $d;
		$d[$key]=$value;
		$count++;
	}

	return $d;
}

function movie_pref($e){
	global $type;
	global $nb;
	global $min;
$movie=pref($e);
$res=array();
$count=0;
$movie = get_array_nb($movie, $nb); 
$movie = array_filter($movie, function($k,$v) {
    return $v >= $min;
}, ARRAY_FILTER_USE_BOTH); 
	$movie=array_reverse($movie, true);

foreach ($movie as $key => $value) {
	// if ($count<30){
		// $count++;
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
	$sd["video_url"]=video_url($key);

			$sd["rate"]=$value;

		

}else{
	$sd=$tmdb;
	$sd["rate"]=$value;
$sd["reals"]=reals_name($tmdb["id"]);
$sd["genres"]=genres_name($tmdb["id"]);
	$sd["video_url"]=video_url($key);


}
	$res[]=$sd;
// }else{
// 	break;
// }
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