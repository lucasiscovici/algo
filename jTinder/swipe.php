<?php
include 'base.php';
if(isset($_POST["role"])){
	$id=$_POST["id"];
	switch ($_POST["role"]) {
		case 1:
			save($id,$note);
			echo $id;
			break;
		case 2:
			$note=$_POST["note"];
			save($id,$note,2);
			echo $id;
			break;
		case 3:
			$note=$_POST["note"];
			save($id,$note,3);
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