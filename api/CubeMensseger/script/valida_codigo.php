<?php
	//Inicia a Sessão
	session_start();
	//Declaração de Variavel Global
	//String
	$Codigo = $_POST['Codigo'];
	$Email = $_POST['Email'];
	$ChaveBanco = "";
	//Array
	$Linha = [];
	//Booleano
	$lTem = false;
	//Constante
	define("BD_CODIGO", '../../CubeMensseger/BDs/bd_codigos.txt');

	//Abre o arquivo para leitura
	$ChaveBanco = fopen(BD_CODIGO, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}		

		if($Linha[0] === $Email and $Linha[1] === $Codigo){
			$lTem = true;
			break;
		}
	}
	//Fecha Conexão com o Banco
	fclose($ChaveBanco);

	//Valida se existe o email com o código gerado
	switch ($lTem) {
		case false:
			$_SESSION['Erro'] = 'Codigo';
			header('Location: ../codigo.php?Email=' . $Email);
			break;
		
		default:
			validaCodigo($Linha);
			break;
	}

#-------------------------------------Funções--------------------------------------

	function validaCodigo($Info){
		//Valida se a Data que foi gerado o Código é maior ou igual a um dia
		if(calculaData(str_replace(PHP_EOL, '', $Info[2]))){
			$_SESSION['Erro'] = 'Data';
			header('Location: ../codigo.php?Email='. $Info[0]);
			return '';
		}
		//Redireciona para Página de troca de Senha
		$_SESSION['DataCodigo'] = $Info[2];
		$_SESSION['EmailRecupera'] = $Info[0];
		header('Location: ../trocaSenha.php');
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