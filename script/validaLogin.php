<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Email = "";
	$Senha = "";
	$Ret = "";
	$ChaveBanco = "";
	//Array
	$Linha = [];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.txt');

	//Define um retorno de página padrão
	$Ret = '../login.php';

	if(isset($_SESSION['Login']) and $_SESSION['Login'] === false){
		$Email = $_POST['Email'];
		$Senha = $_POST['Senha'];

		try{
			//Abre o Banco de Usuarios para leitura
			$ChaveBanco = fopen(BD_USUARIO, 'r');
	
			//Procura pelo Usuario no Registro
			while (!feof($ChaveBanco)) {
				$Linha = explode(';', fgets($ChaveBanco));
	
				if(isset($Linha[1]) === false){
					$_SESSION['Erro'] = 'Email';
					continue;
				}
	
				if($Linha[1] === $Email){
					if($Linha[2] === $Senha){	
						$_SESSION['Login'] = true;
						$_SESSION['Nome'] = $Linha[3];
						$_SESSION['Email'] = $Linha[1];
						$_SESSION['FotoPerfil'] = str_replace(PHP_EOL, '', $Linha[5]);
						disponibilidade(true, $Linha[1]);//Coloca usuário como Online no banco de dados
						$Ret = '../home.php';
						break;
					}	
					else{
						$_SESSION['Erro'] = 'Senha';
						break;
					}
				}
			}
			//Fecha o Banco
			fclose($ChaveBanco);
		}catch(Exception $e){
			echo('Houve um problema Interno ao Tentar Logar na Sua Conta, Tente Novamente ou Mais Tarde <br>');
			echo('Você será redirecionado para a página Login em 5 segundos, aguarde.');
			sleep(5);//Redirecionar para página login depois do 5 segundos
		}
	}else if(isset($_SESSION['Login']) and $_SESSION['Login']){
		disponibilidade(false, $_SESSION['Email']);//Coloca usuário como Offline no banco de dados
		/*
		unset($_SESSION['Nome']);
		unset($_SESSION['Email']);
		unset($_SESSION['FotoPerfil']);
		*/
		session_destroy();
		$_SESSION['Login'] = false;
	}
	//Direciona para página correspondente
	header('Location: ' . $Ret);


	//=============================Funções===============================
	function disponibilidade($opc, $Email){
		$Linha2 = [];
		$Nova_Linha = [];
		$nCont = 0;

		//Abre o arquivo para leitura
		$ChaveBanco2 = fopen(BD_USUARIO, 'r');
		//Percorre o Arquivo
		while (!feof($ChaveBanco2)) {
			$Linha2 = explode(';', fgets($ChaveBanco2));

			if(isset($Linha2[1]) === false){
				continue;
			}

			if($Linha2[1] === $Email){
				switch ($opc) {
					case true:
						$Linha2[4] = 'On';
						break;
					default:
						$Linha2[4] = 'Off';
						break;
				}

			}
			//Salva os dados num array para escreve-los depois
			$Nova_Linha[$nCont] = implode(';', $Linha2);
			$nCont++;
		}
		//Fecha o Arquivo
		fclose($ChaveBanco2);
		//Abre o arquivo para escrever a disponibilidade do usuário
		$ChaveBanco2 = fopen(BD_USUARIO, 'r+');
		//Escreve os usuários
		foreach($Nova_Linha as $Valor){	
			fwrite($ChaveBanco2, $Valor);
		}

		//Fecha o Arquivo
		fclose($ChaveBanco2);
	}
?>