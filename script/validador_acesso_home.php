<?php
	session_start();
	
	if(isset($_SESSION['Login'])){
		if($_SESSION['Login'] === false){
			header('Location: ../index.php');
		}
	}

?>