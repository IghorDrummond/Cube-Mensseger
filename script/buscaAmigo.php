<?php
	session_start();
	//Declaração de Variavel
	//String
	$Pesquisa = $_POST['Amigo'];
	$ChaveBanco = '';
	//Numerico
	$nCont = 0;
	//Array
	$Linha = [];
	$Amigo = [];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.txt');
	define('BD_AMIGO', '../BDs/bd_listamigos.txt');

	$ChaveBanco = fopen(BD_USUARIO, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}

		if(verificaAmigo($Linha[3], $Pesquisa)){
			$Amigo[$nCont][0] = $Linha[1];//Email
			$Amigo[$nCont][1] = $Linha[3];//Nome
			$Amigo[$nCont][2] = str_replace(PHP_EOL, '', $Linha[5]);//Foto
			$nCont++;
		}
	}
	//Fecha Leitura do Arquivo
	fclose($ChaveBanco);

	print_r($Amigo);

	//Valida se os amigos buscados já estão adicionados
	//Abre o arquivo para leitura
	$ChaveBanco = fopen(BD_AMIGO, 'r');
	//Percorre o arquivo aberto
	$nCont = 0;
	while(!feof($ChaveBanco)){
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}
		
		if($Linha[0] === $_SESSION['Email']){
			if($Linha[1] === $Amigo[$nCont][0]){
				//Caso o Amigo procurado já existir na lista de amigos com o mesmo usuário, ele deleta da busca
				unset($Amigo[$nCont]);
			}
		}
	}
	//Fecha Leitura do Arquivo
	fclose($ChaveBanco);

//============================Funções=================================
	function verificaAmigo($Nome, $Busca){
		//Declaração de variaveis
		//String
		$Len = 0;
		//Numerico
		$Acertos = 0;
		$nCont2 = 0;
		//Booleano
		$Ret = false;

		$Busca = strtoupper(str_replace(' ', '', $Busca));
		$Nome = strtoupper(str_replace(' ', '', $Nome));
		$Len = strlen($Busca);
		//Verifica se teve acertos
		for($nCont = 0; $nCont <= strlen($Nome)-1; $nCont++){

			//Caso tiver apenas uma letra na busca, só será valido aquele usuário que tiver a mesma letra inicial
			if(strlen($Busca) === 1 and $Acertos === 0 and $nCont === 1){
				break;
			}	

			if($Busca[$nCont2] === $Nome[$nCont]){
				$nCont2++;
				$Acertos++;
			}else{
				$nCont2 = 0;
				$Acertos = 0;
			}	

			//Valida os Acertos
			if($Acertos === $Len){
				$Ret = true;
				break;
			}
		}
		return $Ret;
	}
?>