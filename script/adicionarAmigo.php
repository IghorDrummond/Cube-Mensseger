<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Nome = isset($_GET['Nome']) ? $_GET['Nome']: $_POST['Adicionar'] ;
	$ChaveBanco = "";
	//Constante
	define('BD_ADD', '../BDs/bd_addamigo.txt');
	define('BD_AMIGO', '../BDs/bd_listamigos.txt');
	define('BD_NUM', '../BDs/bd_num.txt');
	define('BD_CONVERSA', '../BDs/BD_CONVERSA');

	#Valida se é um pedido de aceitaçção pu Recusa
	if(strpos($Nome, 'Adicionar') === 0 or strpos($Nome, 'Recusar') === 0){
		$Vld = substr($Nome, 0, strpos($Nome, ' '));#Recebe a Validação da Operação
		$Nome = substr($Nome, (strpos($Nome, ' ') +1), (strlen($Nome)));#Recebe o Nome do Usuário
		switch($Vld){
			case 'Adicionar':
				adicionaAmigo($Nome);
				break;
			default:
				recusaAmigo($Nome);
				break;
		}
	}#Valida se o Usuário já enviou esta mesma solicitação
	else if(verificaAmigo($Nome) === false){
		$ChaveBanco = fopen(BD_ADD, 'a+');
		//Primeiro Email é o que recebeu o convite, o segundo é o que enviou, terceiro é o nome de quem enviou
		fwrite($ChaveBanco, $Nome . ';' . $_SESSION['Email'] . ';' . $_SESSION['Nome'] . PHP_EOL );
		fclose($ChaveBanco);
		$_SESSION['Validacao'] = 'Envio';
		
	}else{
		//Caso a solicitação já foi enviada para o usuário, será retornado que o envio já foi feito
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

			if($Nome === $Linha[0] and $Linha[1] === $_SESSION['Email']){
				$Ret = true;
				break;
			}
		}

		fclose($ChaveBanco);

		return $Ret;
	}
	function adicionaAmigo($Nome){
		//Declaração de Variaveis
		//String
		$NumC = '';
		//Array
		$Novo = [];
		$Linha = [];
		$Nova_Linha = [''];
		$ChaveBanco = "";
		//Data
		$Data = null;

		#Procura Convite enviado pelo Usuário
		$ChaveBanco = fopen(BD_ADD, 'r');

		while(!feof($ChaveBanco)){
			$Linha = explode(';', fgets($ChaveBanco));

			if(isset($Linha[1]) === false){
				continue;
			}

			$Linha[2] = str_replace(PHP_EOL, '', $Linha[2]);

			if($Linha[2] != $Nome){
				$Nova_Linha[$nCont] = implode(';', $Linha);
				$nCont++;
			}else{
				//Adiciona o usuário que enviou
				$Novo[0] = $Linha[1];//Email do Usuário que enviou o convite
				$Novo[1] = $_SESSION['Email'];//Email do Usuário que aceitou o convite
			}
		}
		fclose($ChaveBanco);

		//Escreve todos os dados deletando o convite anterior
		$ChaveBanco = fopen(BD_ADD, 'r+');
		for($nCont = 0; $nCont <= count($Nova_Linha) -1; $nCont++){
			fwrite($ChaveBanco, $Nova_Linha[$nCont]);
		}
		fclose($ChaveBanco);

		//Define a Data do Sistema
		date_default_timezone_set('America/Sao_Paulo');
		$Data = date('d/m/Y');
		$NumC = retornaNumero();
		//Criar Amizade no arquivo lista de amigos
		$Novo[2] = $Novo[0] . ';' . $Novo[1] . ';' . $_SESSION['Nome'] . ';' . $NumC . ';' . $Data . PHP_EOL;
		$Novo[3] = $Novo[1] . ';' . $Novo[0] . ';' . $Nome . ';' . $NumC . ';' . $Data . PHP_EOL;
		//Escreve a nova Amizade na Lista
		$ChaveBanco = fopen(BD_AMIGO, 'a+');
		fwrite($ChaveBanco, $Novo[2]);
		fwrite($ChaveBanco, $Novo[3]);
		//Fecha arquivo 
		fclose($ChaveBanco);

		//Criar o Banco de Conversa
		$ChaveBanco = fopen(BD_CONVERSA ."/$NumC.txt", 'x');
		//Fecha arquivo 
		fclose($ChaveBanco);
		$_SESSION['Validacao'] = 'Aceito';	
	}

	function retornaNumero(){
		$ChaveBanco = fopen(BD_NUM, 'r+');
    	// Move o ponteiro para a penúltima linha
    	fseek($ChaveBanco, -1, SEEK_END);
		$Ret = fgets($ChaveBanco);
		$Ret = strval((intval($Ret) + 1));
		fseek($ChaveBanco, 0, SEEK_END);
		fwrite($ChaveBanco, PHP_EOL. $Ret );
		fclose($ChaveBanco);
		return $Ret;
	}

?>