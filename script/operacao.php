<?php
	//Liga a Sessão Atual
	session_start();
	//Declaração de Variaveis
	//String
	$email = $_GET['Email'];
	$op = $_GET['opc'];
	//Constantes
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_BLOQUEADO', '../BDs/bd_bloqueado.csv');

	switch ($op) {
		case 'Deletar':
			deletarUser($_SESSION['Email'], $email);
			break;
		case 'Bloquear':
			bloquearUser($_SESSION['Email'], $email);
			break;
		case 'Silenciar':
			silenciarUser($_SESSION['Email'], $email, 'S');
			break;		
		case 'Reativar':
			silenciarUser($_SESSION['Email'], $email, 'A');
			break;								
		default:
			// code...
			break;
	}

	//=============================Função===================
	function deletarUser($user, $user1){
		$Linhas = file(BD_AMIGO);
		$Linha = [];
		$DeletaIndice = [];
		$nCont = 0;
		$nCont2 = 0;

		for($nCont = 0; $nCont <= count($Linhas) -1; $nCont++){
			$Linha = explode(';', $Linhas[$nCont]);
			if(isset($Linha[1]) === false){
				continue;
			}
			if(($Linha[0] === $user and $Linha[1] === $user1) or ($user1 === $Linha[0] and $user === $Linha[1])){
				$DeletaIndice[$nCont2] = $nCont;
				$nCont2++;

				if($nCont2 === 2){
					break;
				}
			}
		}
		//Deleta as Duas Contas Amigas
		unset($Linhas[$DeletaIndice[0]]);
		unset($Linhas[$DeletaIndice[1]]);
		//Reorganiza o Indice do Array Novamente
		$Linhas = array_values($Linhas);
		//Escreve os novos dados
		file_put_contents(BD_AMIGO, $Linhas);
	}

	function bloquearUser($user, $user1){
		$Linhas = file(BD_BLOQUEADO);
		$nCont = 0;	

		$nCont = count($Linhas) -1;
		$nCont++;
		$Linhas[$nCont] = $user . ';' . $user1 . PHP_EOL;
		//Escreve os novos dados
		file_put_contents(BD_BLOQUEADO, $Linhas);		
	}

	function silenciarUser($user, $user1, $Opc){
		$Linhas = file(BD_AMIGO);
		$nCont = 0;	
		$Silenciar = '';
		$Linha = [];

		foreach($Linhas as $indice => $Valor){
			$Linha = explode(';', $Valor);
			if($Linha[0] === $user and $Linha[1] === $user1){
				$Linha[5] = $Opc . PHP_EOL;
				$Silenciar = implode(';', $Linha);
				$nCont = $indice;
				break;
			}
		}
		$Linhas[$nCont] = $Silenciar;
		//Escreve os novos dados
		file_put_contents(BD_AMIGO, $Linhas);		
	}		
?>