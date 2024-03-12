<?php
	session_start();
	$_SESSION['Login'] = false;
	if(isset($_SESSION['Login'])){
		if($_SESSION['Login']){
			header('Location: home.php');
		}
	}

?>