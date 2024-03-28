<?php
	session_start();
	
	if(isset($_SESSION['Login'])){
		if($_SESSION['Login']){
			header('Location: home.php');
		}
	}else{
		$_SESSION['Login'] = false;
	}

?>