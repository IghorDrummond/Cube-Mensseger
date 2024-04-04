<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Nome = isset($_GET['Nome']) ? $_GET['Nome']: $_POST['Adicionar'] ;
	$ChaveBanco = "";
	//Constante
	define('BD_ADD', '../BDs/bd_addamigo.txt');

	if(verificaAmigo($Nome) === false){
		$ChaveBanco = fopen(BD_ADD, 'a+');
		//Primeiro Email é o que recebeu o convite, o segundo é o que enviou, terceiro é o nome de quem enviou
		fwrite($ChaveBanco, $Nome . ';' . $_SESSION['Email'] . ';' . $_SESSION['Nome'] . PHP_EOL );
		fclose($ChaveBanco);
		
	}else{
		$_SESSION['Validacao'] = 'Add';
	}		

	$_SESSION['Pagina'] = 'Amigos';
	header('Location: ../home.php');
//=================================Funções========================	
	function verificaAmigo($Nome){
		$Ret = false;

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if($Nome === $Linha[0]){
				$Ret = true;
				break;
			}
		}

		fclose($ChaveBanco);

		return $Ret;
	}

?>