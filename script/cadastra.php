<?php
	//Inicia a Sessão Global
	session_start();
	//Declaração das Variaveis Globais
	//Strings
	$Email = $_POST['Email'];
	$Nome = $_POST['Nome'] . " " . $_POST['Sobrenome'];
	//Array
	$Senhas = [$_POST['Senha'],$_POST['ConfirmeSenha']];
	//Numerico
	$Id = 0;
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');

	//Verifica se já existe o Email
	if(verificaExistencia($Email) === false){
		if($Senhas[0] != $Senhas[1]){
			ErroPag("Senha");
		}

		//Recupera o Ultimo Id 
		$Id = recuperaId();
		//Abre banco para leitura e escrita
		$ChaveBanco3 = fopen(BD_USUARIO, 'a+');
		//Escreve o Novo usuário no banco
		$Linha = $Id . ';' . $Email . ';' . $Senhas[0] . ';' . $Nome . ';' . 'Off' . ';' . 'BDs/BD_FOTOS/novo-usuario.png' . ';' . 'Ultimo Acesso' . PHP_EOL;
		fwrite($ChaveBanco3, $Linha);
		//Fecha Conexão com Banco
		fclose($ChaveBanco3);

		$ChaveBanco3 = fopen(BD_AMIGO, 'a+');
		//Define a Data do Sistema
		date_default_timezone_set('America/Sao_Paulo');
		fwrite($ChaveBanco3, $Email . ';admin@email.com;Administrador do Sistema;0;'. Date('d/m/Y') . PHP_EOL);
		fwrite($ChaveBanco3, 'admin@email.com;'. $Email .';'. $Nome .';0;'. Date('d/m/Y') . PHP_EOL);
		fclose($ChaveBanco3);
		//Concluí o Cadastro do Usuário
		$_SESSION['Validacao'] = 'Cadastrado';
	}else{
		//Volta para página de Cadastro por já exitir o email
		ErroPag("Email");
	}
	//Rediriciona para página
	header('Location: ../cadastrar.php');

//===============================Função==========================

	function verificaExistencia($Email){
		$lRet = false;
		//Abre o Banco para leitura
		$ChaveBanco = fopen(BD_USUARIO, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));
			
			if(isset($Linha[1]) === false){
				$lRet = false;
				continue;
			}

			if($Linha[1] === $Email){
				$lRet = true;
				break;
			}
		}	
		//Fecha Banco de Dados
		fclose($ChaveBanco);
		//Retorna para If
		return $lRet;	
	}

	function recuperaId(){
		$ChaveBanco2 = fopen(BD_USUARIO, 'r');
		$nRet = 0;

		while(!feof($ChaveBanco2)){
			$Linha =  explode(';', fgets($ChaveBanco2));

			if(isset($Linha[1]) === false){
				continue;
			}

			$nRet = strval($Linha[0]) + 1;
		}

		fclose($ChaveBanco2);
		return $nRet;
	}

	function ErroPag($Erro){
		$_SESSION['Erro'] = $Erro;
	}

?>