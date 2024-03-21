<?php
	//Inicia a Sessão Global
	session_start();
	//Declaração de Variaveis
	$Email = $_SESSION['EmailRecupera'];
	$ChaveBanco	= "";
	//Numerico
	$nCont = 0;
	//Array
	$Senha = [$_POST['Senha'], $_POST['ConfirmeSenha']];
	$Linha = [];
	$Nova_Linha = [];
	//Constantes
	define("BD_USUARIOS", "../BDs/bd_usuarios.txt");

	//Verifica se as senhas são iguais
	if($Senha[0] != $Senha[1]){
		$_SESSION['Erro'] = "Senha";
		header('Location: ../trocaSenha.php');
		exit(0);//Encerra o Programa
	}

	//Abre um novo arquivo
	$ChaveBanco = fopen(BD_USUARIOS, 'r');
	//Lê o bando de dados
	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}

		if($Linha[1] === $Email){
			$Linha[2] = $Senha[0];
			$Nova_Linha[$nCont] = implode(';', $Linha);
			$nCont++;
			continue;
		}

		$Nova_Linha[$nCont] = implode(';', $Linha);
		$nCont++;
	}
	//Fecha Conexão com Arquivo
	fclose($ChaveBanco);
	//Deleta o Arquivo
	unlink(BD_USUARIOS);

	//Cria um Novo banco ao qual ira adicionar o email com a nova senha
	$ChaveBanco = fopen(BD_USUARIOS, 'x+');	
	//Escreve a nova senha do Usuário
	for ($nCont =0; $nCont  <= count($Nova_Linha) -1 ; $nCont ++) { 
		fwrite($ChaveBanco, $Nova_Linha[$nCont]);
	}
	//Fecha Conexão com Arquivo
	fclose($ChaveBanco);

	//Apaga os Índices que não serão mais necessarios
	unset($_SESSION['DataCodigo']);
	unset($_SESSION['EmailRecupera']);

	//Redireciona para o Login
	$_SESSION['Validacao'] = 'Login';
	header('Location: ../trocaSenha.php');
?>