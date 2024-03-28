<?php
	session_start();

	if(calculaData($_SESSION['DataCodigo']) or isset($_SESSION['EmailRecupera']) === false){
		header('Location: login.php');
	}else if(isset($_SESSION['EmailRecupera']) and $_SESSION['EmailRecupera'] === 'DELETE'){
		//Remove Dados para Recuperação de Senha
		unset($_SESSION['EmailRecupera']);
		unset($_SESSION['DataCodigo']);
	}else if(isset($_SESSION['Login']) and $_SESSION['Login']){
		header('Location: home.php');
	}

	function calculaData($Data){
		//Declaração de Variaveis
		//Data
		$dataHora = null;
		$agora = null;
		$diferencaSegundos = null;

		// Converter a data/hora fornecida para um timestamp
		$dataHora = strtotime($Data);
		// Obter a data e a hora atual
	    $agora = time();
	    
	    // Calcular a diferença em segundos entre a data/hora fornecida e agora
	    $diferencaSegundos = $agora - $dataHora;
	    
	    // Se a diferença for maior ou igual a 1 dia (86400 segundos), retorna verdadeiro, caso contrário, retorna falso
	    return ($diferencaSegundos >= 86400 ? true : false);
	}
?>