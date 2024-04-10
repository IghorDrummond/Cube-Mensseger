<?php
	session_start();	

	if(isset($_SESSION['Login'])){
		if($_SESSION['Login'] === false){
			header('Location: login.php');
		}else if($_SESSION['Login']){
			verificaOnline($_SESSION['Email']) === false ? header('Location: login.php') : '';
		}
	}

	//==================Funções==========================
	function verificaOnline($Email){
		$Dir = 'BDs/bd_usuarios.csv';
		$lRet = true;

		$ChaveBanco = fopen($Dir, 'r');
		
		while(!feof($ChaveBanco)){
			$Linha = explode(';', fgets($ChaveBanco));

			if(isset($Linha[1]) === false){
				continue;
			}
			
			if($Linha[1] === $Email){
				if($Linha[4] === 'Off'){
					$lRet = false;
					$_SESSION['Login'] = false;
				}
				break;
			}
		}
		//Fecha o Arquivo 
		fclose($ChaveBanco);
		//Retorna Booleano
		return $lRet;
	}

?>