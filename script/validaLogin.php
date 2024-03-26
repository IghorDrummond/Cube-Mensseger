<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Email = $_POST['Email'];
	$Senha = $_POST['Senha'];
	$lRet = "";
	$ChaveBanco = "";
	//Array
	$Linha = [];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.txt');

	try{
		//Abre o Banco de Usuarios para leitura
		$ChaveBanco = fopen(BD_USUARIO, 'r');

		//Procura pelo Usuario no Registro
		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if(isset($Linha[1]) === false){
				$_SESSION['Erro'] = 'Email';
				$lRet = '../login.php';
				continue;
			}

			if($Linha[1] === $Email){
				if($Linha[2] === $Senha){	
					$_SESSION['Login'] = true;
					$_SESSION['Nome'] = $Linha[5];
					$_SESSION['Email'] = $Linha[1];
					$_SESSION['FotoPerfil'] = $Linha[7];
					$_SESSION['Disponibilidade'] = $Linha[6];
					$lRet = '../home.php';
				}	
				else{
					$_SESSION['Erro'] = 'Senha';
					$lRet = '../login.php';
					break;
				}
			}
		}
		//Fecha o Banco
		fclose($ChaveBanco);
		//Direciona para página correspondente
		header('Location: ' . $lRet);
	}catch(Exception $e){
		echo('Houve um problema Interno ao Tentar Logar na Sua Conta, Tente Novamente ou Mais Tarde');
	}
?>