<?php
session_start();

require "base.php";
if (isset($_POST["role"])) {
	if ($_POST["role"] == 1) {
		$p=$_POST["pseudo"];
		$p=escape($p);
		$d=getAll("SELECT `user_id` FROM `users` WHERE `pseudo`='".$p."' ");
		if (count($d)>0) {
			echo -1;
		}else{
			res("INSERT INTO `users`(pseudo) VALUES ('".$p."') ");
			echo last();
		}
	
	}else{
		$p=$_POST["id"];
		$d=getAll("SELECT `user_id` FROM `users` WHERE `pseudo`='".$p."' ");
		if (count($d)>0) {
			session_id($_POST['idd']);
			$_SESSION["id"]=$d[0]["user_id"];
			$dd=array("id"=>$d[0]["user_id"],"pseudo"=>$p);
			echo json_encode($dd);
		}else{
			echo -1;
		}
	}
	


}
?>