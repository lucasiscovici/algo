<?php 
include "db.class.php";
include "tmdb.class.php";
function last(){
	return $GLOBALS["DB"]->lastId();
}
function res($res){

	$GLOBALS["DB"]->res($res,$debug);
}
function getAll($s){
	return $GLOBALS["DB"]->getAll($s);
}
function search($array)

{
	return $GLOBALS["TMDB"]->search("movie",$array); 
}
function search_query($name)
{
	return search(array("query"=>$name)); 
}
function eraklion($tb,$v,$l,$vs,$al){
$sqls="SELECT `product_id`";
$sqls=$sqls." FROM ".$tb."";
$sqls=$sqls." WHERE ".$v."";
	$d=$GLOBALS["DB"]->getOne($sqls);
	if (!$d || count($d)==0) {
		try {
			$sql="INSERT INTO ".$tb."($l) VALUES (".$vs.")";
		res($sql);
		$last=last();
		$titre=$al->title;
		$affiche=$al->poster_path;
		$sf="UPDATE `products` SET `titre`='".$titre."',`affiche`='".$affiche."' WHERE `product_id`={$last}";
				res($sf);
				// print_r($sf);

		} catch (Exception $e) {
			
		}
		

	}else{
		$last=$d;
	}
	return $last;
}

function save($num){
	global $user;
	$val=$GLOBALS["DB"]->escape($num->id);
	$tb="`products`";
	$v="tmdb_id=".$val."";
	$last=eraklion($tb,$GLOBALS["DB"]->escape($v),"tmdb_id",$val,$num);

	try {
$sql2="INSERT INTO `usersproducts`(user_id,product_id,type) VALUES (".$user.",".$last.", 1)";

			res($sql2);
	$ls=last();
		try {

		$sql2="UPDATE`usersproducts`SET `note`= 5.0 WHERE `id`={$ls}";

		res($sql2);
		}catch (Exception $e) {

}
}catch (Exception $e) {

}
}
function save_begin($d){
	foreach ($d as $key => $value) {
		$f = search_query($value);
		$obj = $f->data->results[0];
		save($obj);
	}

}
function get_tmdb($user){
	$s="SELECT `tmdb_id` FROM `products` NATURAL JOIN `usersproducts` WHERE `user_id`=".$user."";
$r=getAll($s);
return $r;
}
function bb($f){
	$f=array();
	foreach ($f as $key => $value) {
		$f[]=$value["tmdb_id"];
	}
	return $f;
}
function get_tmdb2($user){
	$s="SELECT `tmdb_id` FROM `products` NATURAL JOIN `usersproducts` WHERE `user_id`=".$user."";
$r=getAll($s);
return bb($r);
}
function find($list,$field,$text,$n="name"){
	// print_r($list);
	$d=array();
	foreach ($list as $key => $value) {
				// print_r($key."\n");
	
		if ($value->job==$text) {
			
			array_push($d,$value->$n); 
		}

	}
	return $d;
}
function findo($list,$text="name"){
	// print_r($list);
	$d=array();
	foreach ($list as $key => $value) {
				// print_r($key."\n");
	
		if ($key==$text) {
			
			array_push($d,$value); 
		}

	}
	return $d;
}

function add_in_array($j,$arr){
	if (array_key_exists($j, $arr)) $arr[$j]=$arr[$j]+1;
	else $arr[$j]=1;
	return $arr;

}
function add_list_in_array($list,$arr,$ty="name"){
	foreach ($list as $key => $value) {
		$arr=add_in_array($value->$ty,$arr);
	}
	return $arr;
}
function add_list2_in_array($list,$arr){
	foreach ($list as $key => $value) {
		$arr=add_in_array($value,$arr);
	}
	return $arr;
}
function reals_list($list){
		global $type;

$reals=array();
	foreach ($list as $key => $value) {

		$inf=$GLOBALS["TMDB"]->info_credits($type,$value);
		$sk=find($inf->crew,"job","Director","id");
array_push($reals, $sk[0]);
	}
	return $reals;
}
function reals($user){
	global $type;
	$tmdb=get_tmdb($user);
	$reals=reals_list($tmdb);
	$reals_f=add_list2_in_array($reals,[]);
	return $reals_f;
}
function reals_name($value){
	global $type;
			// print_r($type." ".$value);

		$inf=$GLOBALS["TMDB"]->info_credits($type,$value);
		$sk=find($inf->crew,"job","Director","name");
	return $sk;
}
function genres_list($list){
		global $type;

	$genres=array();
	foreach ($list as $key => $value) {
		$inf=$GLOBALS["TMDB"]->info_genres($type,$value);
$genres=add_list_in_array($inf,$genres,"id");
	}

	return $genres;
}
function genres($user){
	global $type;
	$tmdb=get_tmdb($user);
	

	return genres_list($tmdb);
}
function genres_name($value){
	global $type;
	$inf=$GLOBALS["TMDB"]->info_genres($type,$value);
		$sk=findo($inf);
	return $sk;
}
function cast_list($list){
		global $type;

	$genres=array();
	foreach ($list as $key => $value) {
		$inf=$GLOBALS["TMDB"]->info_cast($type,$value);
$genres=add_list_in_array($inf,$genres,"id");
	}
	return $genres;
}
function cast($user){
	global $type;
	$tmdb=get_tmdb($user);


	return cast_list($tmdb);
}
function cinq($f){
foreach ($f as $key => $value) {
	$f[$key]=$value/5;
}
return $f;
}
function tmdb_mo($lo){
	$l=array();
	$mp="tmdb_id";
foreach ($lo as $key => $value) {
	array_push($l, array($mp=>$value));

}
return $l;
}

function real_film($id){
	// print_r($id);
		$genres=array();

	$inf=$GLOBALS["TMDB"]->people_crew("person",$id);
	$sk=find($inf,"job","Director","id");
	$sk=tmdb_mo($sk);
	// print_r($sk);
	// $sd=reals_list($sk);
	// print_r($sd);
	// 	$sdd=genres_list($sk);
	// 		print_r($sdd);

	// 	$sddd=cast_list($sk);
	// 		print_r($sddd);
return $sk;
	// print_r($sk);
}
function title_bd(){

}
function up_href($l){
		$url="http://image.tmdb.org/t/p/w780";

	foreach ($l as $key => $value) {
		$l[$key]["href"]=$url.$value["href"];
	}
	return $l;
}
function video_url($l){
			$inf=$GLOBALS["TMDB"]->people_crew("person",$id);

	return $l;
}
function movies($user){
	global $type;
	$tmdb=getAll("SELECT `titre` as 'title',`product_id` as 'id',`affiche` as 'href' FROM usersproducts up NATURAL JOIN products WHERE up.user_id =".$user." ");
	$listo=$tmdb;
	$listo=up_href($listo);
	// print_r($listo);

	// foreach ($tmdb as $key => $value) {
	// 	// $info=$GLOBALS["TMDB"]->info($type,$value["tmdb_id"]);
	// 		$list=array();

		
	// 	$list["title"]=$tmdb["titre"];
	// 	$list["id"]=$tmdb["id"];
	// 	$list["href"]=;
	// 	$listo[]=$list;
	// }
	return $listo;
}

?>