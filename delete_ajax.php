<?php
	include 'database.php';
	if(isset($_POST['id'])) {
		$id = trim($_POST['id']);
		$sql = "DELETE FROM crud WHERE id in ($id)";
		if(mysqli_query($conn, $sql)){
			echo $id;
		}
	}
?>