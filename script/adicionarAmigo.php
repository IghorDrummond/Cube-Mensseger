<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Email = $_POST['Amigo'];
	$ChaveBanco = "";
	//Constante
	define('BD_ADD', '../BDs/bd_addamigo.txt');

	if(verificaAmigo($Email) === false){
		$ChaveBanco = fopen(BD_ADD, 'a+');
		//Primeiro Email é o que recebeu o convite, o segundo é o que enviou, terceiro é o nome de quem enviou
		fwrite($ChaveBanco, $Email . ';' . $_SESSION['Email'] . ';' . $_SESSION['Nome'] . PHP_EOL );
		fclose($ChaveBanco);
	}


	function verificaAmigo($Email){
		$Ret = false;

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if($Email === $Linha[0]){
				$Ret = true;
				break;
			}
		}

		fclose($ChaveBanco);

		return $Ret;
	}

?>