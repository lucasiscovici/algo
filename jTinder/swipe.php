<?php
include 'base.php';
if(isset($_POST["role"])){
	$id=$_POST["id"];
	switch ($_POST["role"]) {
		case 1:
					$note=$_POST["note"];

			$s=save3($id,$note);
			echo $id;
			break;
		case 2:
			save3($id,-1,2);
			echo $id;
			break;
		case 3:
			save3($id,-1,3);
			echo $id;
			break;
		default:
					echo -1;

			break;
	}

}else{
						echo -1;

}

?>