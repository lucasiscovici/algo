<?php 
session_start();
include "db.class.php";
include "tmdb.class.php";
function last(){
	return $GLOBALS["DB"]->lastId();
}
function res($res){

	$GLOBALS["DB"]->res($res,$debug);
}
function start_chrono(){

	return microtime(true);

}
function end_chrono(){

	return start_chrono();
}
function res_chrono($st,$end){
$time=$end-$st;
$page_load_time = number_format($time, 3);

	return $page_load_time;
}
function getAll($s){
	return $GLOBALS["DB"]->getAll($s);
}
function search($array)

{
	return $GLOBALS["TMDB"]->search("movie",$array); 
}
function escape($a){
	$b=$GLOBALS["DB"]->escape($a);
	return $b;
}
function search_query($name,$page=1)
{
	return search(array("query"=>$name,"page"=>$page)); 
}
function eraklion($tb,$v,$l,$vs,$al){
$sqls="SELECT `product_id`";
$sqls=$sqls." FROM ".$tb."";
$sqls=$sqls." WHERE ".$v."";
	$d=$GLOBALS["DB"]->getOne($sqls);
	if (!$d || count($d)==0) {
		try {
			if (isset($titre) && isset($affiche)) {
				# code...
			
			$sql="INSERT INTO ".$tb."($l) VALUES (".$vs.")";
		res($sql);
		$last=last();
		$titre=$al->title;
		$affiche=$al->poster_path;
		$sf="UPDATE `products` SET `titre`='".$titre."',`affiche`='".$affiche."' WHERE `product_id`={$last}";
				res($sf);
				// print_r($sf);
}
		} catch (Exception $e) {
			
		}
		

	}else{
		$last=$d;
	}
	return $last;
}
function eraklion2($tb,$v,$l,$vs,$al){
$sqls="SELECT `product_id`";
$sqls=$sqls." FROM ".$tb."";
$sqls=$sqls." WHERE ".$v."";
	$d=$GLOBALS["DB"]->getOne($sqls);
	if (!$d || count($d)==0) {
		try {
			$sql="INSERT INTO ".$tb."($l) VALUES (".$vs.")";
		res($sql);
		$last=last();
		$titre=$al["title"];
		$affiche=$al["img"];
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
function save($num,$note=5.0,$nu=1,$img="",$title=""){
	global $user;
	$val=(Type($num)=='number')?$num:$GLOBALS["DB"]->escape($num->id);
	$tb="`products`";
	$v="tmdb_id=".$val."";
	if (Type($num)=='number'){
		$nump=array("title"=>$title,"img"=>$img);
	}
	$last=(Type($num)=='number')?eraklion2($tb,$GLOBALS["DB"]->escape($v),"tmdb_id",$val,$nump):eraklion($tb,$GLOBALS["DB"]->escape($v),"tmdb_id",$val,$num);

	try {
$sql2="INSERT INTO `usersproducts`(user_id,product_id,type) VALUES (".$user.",".$last.", {$nu})";
echo $sql2;
			res($sql2);
	$ls=last();
		try {

		$sql2="UPDATE`usersproducts`SET `note`= {$note} WHERE `id`={$ls}";

		res($sql2);
		}catch (Exception $e) {

}
}catch (Exception $e) {

}
}
function save3($num,$note=5.0,$nu=1){
	global $user;
	$last=$num;
	try {
$sql2="INSERT INTO `usersproducts`(user_id,product_id,type) VALUES (".$user.",".$last.", {$nu})";
echo $sql2;
			res($sql2);
	$ls=last();
		try {

		$sql2="UPDATE`usersproducts`SET `note`= {$note} WHERE `id`={$ls}";

		res($sql2);
		}catch (Exception $e) {

}
}catch (Exception $e) {

}
}
function save2($num,$note=5.0){
	global $user;
	$val=$GLOBALS["DB"]->escape($num["id"]);
	$tb="`products`";
	$v="tmdb_id=".$val."";
	$last=eraklion2($tb,$GLOBALS["DB"]->escape($v),"tmdb_id",$val,$num);

	try {
$sql2="INSERT INTO `usersproducts`(user_id,product_id,type) VALUES (".$user.",".$last.", 1)";

			res($sql2);
	$ls=last();
		try {

		$sql2="UPDATE`usersproducts`SET `note`= {$note} WHERE `id`={$ls}";

		res($sql2);
		}catch (Exception $e) {

}
}catch (Exception $e) {

}
}
function test_string(){

}
function fop($f){
$d="";
$c=0;
foreach ($f as $key => $value) {
	# code...
	if ($c > 0) $d.=", ";
	$d.=$value;
	$c++;

}

	return $d;
}
function fo($f){
	$d=array();
	$c=0;
	foreach ($f->data->results as $key => $value) {
		if ($c==5) {
			break;
		}
		$c++;
		$reals=reals_name($value->id);
		$reals=fop($reals);
		array_push($d,array("title"=>$value->title,"id"=>$value->id,"reals"=>$reals,"img"=>$value->poster_path));
	}
	return $d;
}
function save_begin($d){
	foreach ($d as $key => $value) {
		$f = search_query($value);
		$c=0;
		$obj = $f->data->results[$c];
		print_r($value." ".$obj->title);
		while (strtolower($value) != strtolower($obj->title)){
			$c+=1;
$obj = $f->data->results[$c];
		}
		
		save($obj);
	}

}
function get_tmdb($user){
	$s="SELECT `tmdb_id` FROM `products` NATURAL JOIN `usersproducts` WHERE `user_id`=".$user."";
$r=getAll($s);
return $r;
}
function get_tmdb3($user){
	$s="SELECT `tmdb_id`,`note` FROM `products` NATURAL JOIN `usersproducts` WHERE `user_id`=".$user." AND type=1 ";
$r=getAll($s);
return $r;
}

function bb($f){
	$fd=array();
	foreach ($f as $key => $value) {
		$fd[]=$value["tmdb_id"];
	}
	return $fd;
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
function findoo($list,$field,$text){
	// print_r($list);
	$d=array();
	foreach ($list as $key => $value) {
				// print_r($key."\n");
	
		if ($value->job==$text) {
			
			array_push($d,$value); 
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

function add_in_array2($k,$j,$arr){
	if (array_key_exists($k, $arr)) {$arr[$k]["f"]=$arr[$k]["f"] + 1;
	}else {$arr[$k]["f"]=1;$arr[$k]["note"]=$j; }
	return $arr;

}
function add_list_in_array($list,$arr,$ty="name"){
	foreach ($list as $key => $value) {
		$arr=add_in_array($value->$ty,$arr);
	}
	return $arr;
}
function listp($a,$b,$c){
	global $list_name;
if (!(array_key_exists($a, $list_name[$c]))) {$list_name[$c][$a]=$b;}

}
function add_list_in_array2($note,$list,$arr,$ty="name",$tyy="ico"){
	foreach ($list as $key => $value) {
		$arr=add_in_array2($value->$ty,$note,$arr);
			listp($value->id,$value->name,$tyy);

	}
	return $arr;
}
function add_list2_in_array($list,$arr){
	foreach ($list as $key => $value) {
		$arr=add_in_array($value,$arr);
	}
	return $arr;
}
function add_list2_in_array2($list,$arr){
	foreach ($list as $key => $value) {
		$arr=add_in_array2($key,$value,$arr);

	}
	return $arr;
}
function reals_list($list){
		global $type;

$reals=array();
	foreach ($list as $key => $value) {

		$inf=$GLOBALS["TMDB"]->info_credits($type,$value);
		$sk=findoo($inf->crew,"job","Director");

for ($i=0; $i < count($sk) ; $i++) { 
				# code...
			# code...
		
array_push($reals, $sk[$i]["id"]);
listp($sk[$i]["id"],$sk[$i]["name"],"real");
}			

	}
	return $reals;
}
function reals_list2($list){
		global $type;

$reals=array();
	foreach ($list as $key => $value) {

		$inf=$GLOBALS["TMDB"]->info_credits($type,$value["tmdb_id"]);
		$sk=find($inf->crew,"job","Director","id");

for ($i=0; $i < count($sk) ; $i++) { 
				# code...
			# code...
		
$reals[$sk[$i]]=$value["note"];
}			

	}
	return $reals;
}
function reals($user,$tmdb){
	global $type;
	$reals=reals_list2($tmdb);
		// print_r($reals);

	$reals_f=add_list2_in_array2($reals,[]);
	// print_r($reals_f);
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
function genres_list2($list){
		global $type;

	$genres=array();
	foreach ($list as $key => $value) {
		$inf=$GLOBALS["TMDB"]->info_genres($type,$value["tmdb_id"]);
$genres=add_list_in_array2($value["note"],$inf,$genres,"id","genres");


	}

	return $genres;
}
function genres($user,$tmdb){
	global $type;
	

	return genres_list2($tmdb);
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
function cast_list2($list){
		global $type;

	$genres=array();
	foreach ($list as $key => $value) {
		$inf=$GLOBALS["TMDB"]->info_cast($type,$value["tmdb_id"]);
$genres=add_list_in_array2($value["note"],$inf,$genres,"id","cast");
	}
	return $genres;
}
function cast($user,$tmdb){
	global $type;


	return cast_list2($tmdb);
}
function cinq($f){
	global $base_num;
	global $base_rate;
foreach ($f as $key => $value) {
	$f[$key]=$value["f"]/$base_num*$value["note"]/$base_rate;
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
function cast_film($id){
	// print_r($id);
		$genres=array();

	$sk=$GLOBALS["TMDB"]->people_cast("person",$id);
	// print_r($GLOBALS["TMDB"]->info("person",$id)->name);
	$sk=findo($sk[0],"id");
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
$in=$GLOBALS["TMDB"]->info("movie",$l,"videos");

if (count($in)==0 || count($in->results)==0) {
	return "fail";
}else{
	$val=$in->results[0];
	return $val->key;
}
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