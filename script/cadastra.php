<?php
	//Inicia a Sessão Global
	session_start();

	var_dump($_POST);
	//Declaração das Variaveis Globais
	//Strings
	$Email = $_POST['Email'];
	$Senhas = [$_POST['Senha'],$_POST['ConfirmeSenha']];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.txt');

	//Verifica se já existe o Email
	if(verificaExistencia($Email) === false){
		echo('Foi');
	}else{
		//Volta para página de Cadastro por já exitir o email
		$_SESSION['Erro'] = 'Email';
		header('Location: ../cadastrar.php');
	}

//===============================Função==========================

	function verificaExistencia($Email){
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

?>