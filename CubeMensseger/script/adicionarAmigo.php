<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Email = $_GET['Email'];
	$ChaveBanco = "";
	$Validacao = "";
	//Constante
	define('BD_ADD', '../../CubeMensseger/BDs/bd_addamigo.csv');
	define('BD_AMIGO', '../../CubeMensseger/BDs/bd_listamigos.csv');
	define('BD_NUM', '../../CubeMensseger/BDs/bd_num.csv');
	define('BD_CONVERSA', '../../CubeMensseger/BDs/BD_CONVERSA');

	$Email = str_replace('*', ' ', $Email);
	#Valida se é um pedido de aceitação ou Recusa
	if (strpos($Email, 'Adicionar') === 0 or strpos($Email, 'Recusar') === 0) {
		$Vld = substr($Email, 0, strpos($Email, ' '));#Recebe a Validação da Operação
		$Email = substr($Email, (strpos($Email, ' ') + 1), (strlen($Email)));#Recebe o Nome do Usuário
		switch ($Vld) {
			case 'Adicionar':
				$Validacao = adicionaAmigo($Email);
				break;
			default:
				$Validacao = removeAmigo($Email);
				break;
		}
	}#Valida se o Usuário já enviou esta mesma solicitação
	else if (verificaAmigo($Email)) {
		$ChaveBanco = fopen(BD_ADD, 'a+');

		//Email da pessoa Convidada/Email de quem convidou/nome de quem convidou
		fwrite($ChaveBanco, $Email . ';' . $_SESSION['Email'] . ';' . $_SESSION['Nome'] . PHP_EOL);
		fclose($ChaveBanco);
		$Validacao = 'Envio';
	} else {
		//Caso a solicitação já foi enviada para o usuário, será retornado que o envio já foi feito
		$Validacao = 'Add';
	}
	//=================================Funções========================	
	function verificaAmigo($Email)
	{
		$Ret = true;

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));
			
			if(isset($Linha[1]) === false){
				continue;
			}
			//Valida se já tem um convite existente para convidado do mesmo convidante 
			if ($Email === $Linha[0] and $Linha[1] === $_SESSION['Email']) {
				$Ret = false;
				break;
			//Valida se já tem um convite enviado pelo usuário convidado ao convidante
			}else if($Email === $Linha[1] and $Linha[0] === $_SESSION['Email']){
				$Ret = false;
				break;				
			}
		}

		fclose($ChaveBanco);

		//Valida se já não tem como amigo 
		if($Ret){
			$ChaveBanco = fopen(BD_AMIGO, 'r');

			while (!feof($ChaveBanco)) {
				$Linha = explode(';', fgets($ChaveBanco));
				
				if(isset($Linha[1]) === false){
					continue;
				}
	
				if ($Linha[0] === $_SESSION['Email'] and $Linha[1] === $Email) {
					$Ret = false;
					break;
				}
			}
	
			fclose($ChaveBanco);			
		}

		return $Ret;
	}
	function adicionaAmigo($Nome)
	{
		//Declaração de Variaveis
		//String
		$NumC = '';
		//Array
		$Novo = [];
		$Linha = [];
		$Nova_Linha = [''];
		$ChaveBanco = "";
		//Numerico
		$nCont = 0;
		//Data
		$Data = null;

		#Procura Convite enviado pelo Usuário
		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false) {
				continue;
			}

			$Linha[2] = str_replace(PHP_EOL, '', $Linha[2]);
			if ($Linha[0] === $_SESSION['Email'] and $Linha[1] === $Nome) {
				$Novo[0] = $Linha[1];
				$Novo[1] = $_SESSION['Email'];
				$Novo[2] = $Linha[2];
			} else {
				$Nova_Linha[$nCont] = implode(';', $Linha);
				$nCont++;
			}
		}
		fclose($ChaveBanco);

		//Escreve todos os dados deletando o convite anterior
		$ChaveBanco = fopen(BD_ADD, 'w+');
		for ($nCont = 0; $nCont <= count($Nova_Linha) - 1; $nCont++) {
			fwrite($ChaveBanco, $Nova_Linha[$nCont] . PHP_EOL);
		}
		fclose($ChaveBanco);

		//Define a Data do Sistema
		date_default_timezone_set('America/Sao_Paulo');
		$Data = date('d/m/Y');

		$chat = $Novo[1] . '_' . $Novo[0] . '.csv';
		if(file_exists(BD_CONVERSA . "/". $chat) === false){
			$chat = $Novo[0] . '_' . $Novo[1].'.csv';
			if(file_exists(BD_CONVERSA . "/". $chat) === false){
				//Criar o Banco de Conversa
				$ChaveBanco = fopen(BD_CONVERSA . "/". $chat, 'x');
				//Fecha arquivo 
				fclose($ChaveBanco);
			}
		}

		//Criar Amizade no arquivo lista de amigos
		$Novo[3] = $Novo[0] . ';' . $Novo[1] . ';' . $_SESSION['Nome'] . ';' . $chat . ';' . $Data . ';' . 'A' . PHP_EOL;
		$Novo[4] = $Novo[1] . ';' . $Novo[0] . ';' . $Novo[2] . ';' . $chat . ';' . $Data . ';' . 'A' . PHP_EOL;
		//Escreve a nova Amizade na Lista
		$ChaveBanco = fopen(BD_AMIGO, 'a+');
		fwrite($ChaveBanco, $Novo[3]);
		fwrite($ChaveBanco, $Novo[4]);
		//Fecha arquivo 
		fclose($ChaveBanco);
		return 'Aceito';
	}

	function removeAmigo($Email)
	{
		$ChaveBanco = fopen(BD_ADD, 'r');
		$nCont = 0;
		$Nova_Linha = [];
		$Aux = [];
		$Linha = [];

		#Procura Convite enviado pelo Usuário
		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false) {
				continue;
			}

			$Linha[2] = str_replace(PHP_EOL, '', $Linha[2]);
			if ($Linha[0] === $_SESSION['Email'] and $Linha[1] === $Email) {
				continue;
			} else {
				$Nova_Linha[$nCont] = implode(';', $Linha);
				$nCont++;
			}
		}
		fclose($ChaveBanco);

		//Escreve todos os dados deletando o convite anterior
		$ChaveBanco = fopen(BD_ADD, 'w+');
		for ($nCont = 0; $nCont <= count($Nova_Linha) - 1; $nCont++) {
			fwrite($ChaveBanco, $Nova_Linha[$nCont] . PHP_EOL);
		}
		fclose($ChaveBanco);


		return 'Deletado';
	}
?>


<?php
	if ($Validacao === 'Envio') {
?>
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Pedido Enviado!</strong> Pedido de Amizade Enviado com Sucesso!</a>
		</div>
<?php
	}
	if ($Validacao === 'Add') {
?>
		<div class="alert alert-danger alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Pedido não Enviado!</strong> Pedido de Amizade já foi enviado para este usuário.</a>
		</div>
<?php
	}
	if ($Validacao === 'Aceito') {
?>
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Pedido Aceito!</strong> Pedido de Amizade foi Aceito com Sucesso!</a>
		</div>
<?php
	}
	if ($Validacao === 'Deletado') {
?>
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Pedido Recusado!</strong> Pedido de Amizade foi Recusado!</a>
		</div>
<?php
	}
	if ($Validacao === 'Duplicado') {
?>
		<div class="alert alert-warning alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Pedido Duplicado!</strong> Usuário Convidado já enviou um Pedido de Amizade para você.</a>
		</div>		
<?php
	}
?>